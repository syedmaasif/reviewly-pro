<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Reviewly_Ajax {

    public static function init() {
        add_action( 'wp_ajax_rvly_submit_review',        [ __CLASS__, 'submit_review' ] );
        add_action( 'wp_ajax_nopriv_rvly_submit_review', [ __CLASS__, 'submit_review' ] );

        add_action( 'wp_ajax_rvly_save_settings',  [ __CLASS__, 'save_settings' ] );
        add_action( 'wp_ajax_rvly_delete_review',  [ __CLASS__, 'delete_review' ] );
        add_action( 'wp_ajax_rvly_approve_review', [ __CLASS__, 'approve_review' ] );
    }

    /* ---- Front-end: submit a review ---- */
    public static function submit_review() {

        // Basic nonce check
        if ( ! isset( $_POST['rvly_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rvly_nonce'] ) ), 'rvly_submit' ) ) {
            wp_send_json_error( [ 'message' => 'Security check failed. Please refresh the page.' ] );
        }

        $settings       = Reviewly_Settings::get();
        $enabled_fields = Reviewly_Settings::get_enabled_fields();

        // Validate required fields
        $errors = [];

        if ( ! empty( $enabled_fields['name'] ) ) {
            $name = sanitize_text_field( wp_unslash( $_POST['rvly_name'] ?? '' ) );
            if ( empty( $name ) ) $errors[] = 'Name is required.';
        } else {
            $name = 'Anonymous';
        }

        if ( ! empty( $enabled_fields['email'] ) ) {
            $email = sanitize_email( wp_unslash( $_POST['rvly_email'] ?? '' ) );
            if ( empty( $email ) || ! is_email( $email ) ) $errors[] = 'A valid email is required.';
        } else {
            $email = '';
        }

        $review_text = sanitize_textarea_field( wp_unslash( $_POST['rvly_review'] ?? '' ) );
        if ( empty( $review_text ) ) $errors[] = 'Review text is required.';

        $rating = intval( $_POST['rvly_rating'] ?? 0 );
        if ( $rating < 1 || $rating > 5 ) $errors[] = 'Please select a star rating.';

        if ( ! empty( $errors ) ) {
            wp_send_json_error( [ 'message' => implode( ' ', $errors ) ] );
        }

        // Determine publish status
        $status = ( $settings['require_approval'] === '1' ) ? 'pending' : 'publish';

        $post_id = wp_insert_post( [
            'post_type'    => 'rvly_review',
            'post_status'  => $status,
            'post_title'   => $name,
            'post_content' => $review_text,
        ] );

        if ( is_wp_error( $post_id ) ) {
            wp_send_json_error( [ 'message' => 'Could not save review. Please try again.' ] );
        }

        // Save meta
        update_post_meta( $post_id, 'rvly_rating',   $rating );
        update_post_meta( $post_id, 'rvly_email',    $email );
        update_post_meta( $post_id, 'rvly_date',     current_time( 'F j, Y' ) );
        update_post_meta( $post_id, 'rvly_date_raw', current_time( 'timestamp' ) );

        // Optional fields
        $optional = [ 'phone', 'website', 'occupation', 'location' ];
        foreach ( $optional as $field ) {
            if ( ! empty( $enabled_fields[ $field ] ) && isset( $_POST[ 'rvly_' . $field ] ) ) {
                update_post_meta( $post_id, 'rvly_' . $field, sanitize_text_field( wp_unslash( $_POST[ 'rvly_' . $field ] ) ) );
            }
        }

        // Recommend field (yes/no)
        if ( ! empty( $enabled_fields['recommend'] ) && isset( $_POST['rvly_recommend'] ) ) {
            update_post_meta( $post_id, 'rvly_recommend', sanitize_text_field( wp_unslash( $_POST['rvly_recommend'] ) ) );
        }

        $redirect = ! empty( $settings['redirect_url'] ) ? esc_url( $settings['redirect_url'] ) : '';

        wp_send_json_success( [
            'message'  => $status === 'pending'
                ? 'Thank you! Your review is awaiting approval.'
                : 'Thank you! Your review has been posted.',
            'pending'  => $status === 'pending',
            'redirect' => $redirect,
        ] );
    }

    /* ---- Admin: save plugin settings ---- */
    public static function save_settings() {
        if ( ! current_user_can( 'manage_options' ) ) wp_die( 'No permission.' );
        check_ajax_referer( 'rvly_admin_nonce', 'nonce' );

        Reviewly_Settings::save_from_post();
        wp_send_json_success( [ 'message' => 'Settings saved successfully.' ] );
    }

    /* ---- Admin: delete a review ---- */
    public static function delete_review() {
        if ( ! current_user_can( 'manage_options' ) ) wp_die( 'No permission.' );
        check_ajax_referer( 'rvly_admin_nonce', 'nonce' );

        $post_id = intval( $_POST['post_id'] ?? 0 );
        if ( $post_id && get_post_type( $post_id ) === 'rvly_review' ) {
            wp_delete_post( $post_id, true );
            wp_send_json_success();
        }
        wp_send_json_error();
    }

    /* ---- Admin: approve a pending review ---- */
    public static function approve_review() {
        if ( ! current_user_can( 'manage_options' ) ) wp_die( 'No permission.' );
        check_ajax_referer( 'rvly_admin_nonce', 'nonce' );

        $post_id = intval( $_POST['post_id'] ?? 0 );
        if ( $post_id && get_post_type( $post_id ) === 'rvly_review' ) {
            wp_update_post( [ 'ID' => $post_id, 'post_status' => 'publish' ] );
            wp_send_json_success();
        }
        wp_send_json_error();
    }
}
