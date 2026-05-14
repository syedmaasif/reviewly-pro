<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Reviewly_Settings {

    public static function init() {
        // Nothing needed at boot – settings are loaded on demand
    }

    /** Returns the full settings array with defaults merged in. */
    public static function get() {
        $defaults = [
            'active_theme'     => 'modern',
            'require_approval' => '0',
            'fields'           => [],
            'accent_color'     => '#e91e63',
            'reviews_per_page' => '12',
            'show_date'        => '1',
            'show_avatar'      => '1',
            'redirect_url'     => '',
        ];
        $saved = get_option( 'reviewly_settings', [] );
        return wp_parse_args( $saved, $defaults );
    }

    /** Returns the enabled fields only. */
    public static function get_enabled_fields() {
        $settings = self::get();
        $out = [];
        foreach ( $settings['fields'] as $key => $field ) {
            if ( ! empty( $field['enabled'] ) && $field['enabled'] == '1' ) {
                $out[ $key ] = $field;
            }
        }
        return $out;
    }

    /** Saves settings from $_POST (sanitised). Called only after nonce has been
     *  verified upstream via check_ajax_referer( 'rvly_admin_nonce', 'nonce' ).
     */
    public static function save_from_post() {
        // Re-confirm the nonce here so PHPCS can trace the verification.
        if ( ! check_ajax_referer( 'rvly_admin_nonce', 'nonce', false ) ) {
            return false;
        }

        $settings = self::get();

        if ( isset( $_POST['active_theme'] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Missing
            $settings['active_theme'] = sanitize_key( wp_unslash( $_POST['active_theme'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing

        if ( isset( $_POST['require_approval'] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Missing
            $settings['require_approval'] = ( sanitize_key( wp_unslash( $_POST['require_approval'] ) ) === '1' ) ? '1' : '0'; // phpcs:ignore WordPress.Security.NonceVerification.Missing

        if ( isset( $_POST['accent_color'] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Missing
            $settings['accent_color'] = sanitize_hex_color( wp_unslash( $_POST['accent_color'] ) ) ?: '#e91e63'; // phpcs:ignore WordPress.Security.NonceVerification.Missing

        if ( isset( $_POST['reviews_per_page'] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Missing
            $settings['reviews_per_page'] = absint( wp_unslash( $_POST['reviews_per_page'] ) ) ?: 12; // phpcs:ignore WordPress.Security.NonceVerification.Missing

        if ( isset( $_POST['show_date'] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Missing
            $settings['show_date'] = ( sanitize_key( wp_unslash( $_POST['show_date'] ) ) === '1' ) ? '1' : '0'; // phpcs:ignore WordPress.Security.NonceVerification.Missing

        if ( isset( $_POST['show_avatar'] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Missing
            $settings['show_avatar'] = ( sanitize_key( wp_unslash( $_POST['show_avatar'] ) ) === '1' ) ? '1' : '0'; // phpcs:ignore WordPress.Security.NonceVerification.Missing

        if ( isset( $_POST['redirect_url'] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Missing
            $settings['redirect_url'] = esc_url_raw( wp_unslash( $_POST['redirect_url'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing

        // Fields
        if ( isset( $_POST['fields'] ) && is_array( $_POST['fields'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
            // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized,WordPress.Security.NonceVerification.Missing
            $raw_fields = wp_unslash( $_POST['fields'] );
            foreach ( $raw_fields as $rvly_fkey => $rvly_ffield ) {
                $settings['fields'][ sanitize_key( $rvly_fkey ) ] = [
                    'enabled'     => ! empty( $rvly_ffield['enabled'] ) ? '1' : '0',
                    'label'       => sanitize_text_field( $rvly_ffield['label'] ?? '' ),
                    'placeholder' => sanitize_text_field( $rvly_ffield['placeholder'] ?? '' ),
                    'private'     => ! empty( $rvly_ffield['private'] ) ? '1' : '0',
                ];
            }
        }

        update_option( 'reviewly_settings', $settings );
        return true;
    }

    /** Available UI themes definition. */
    public static function get_themes() {
        return [
            'modern'    => [
                'name'        => 'Modern Card',
                'description' => 'Clean white card with soft shadow and pill button. Great for services & agencies.',
                'preview_bg'  => '#f0f4ff',
                'accent'      => '#e91e63',
            ],
            'minimal'   => [
                'name'        => 'Minimal Flat',
                'description' => 'Crisp lines, no borders, ultra-clean look. Perfect for blogs & portfolios.',
                'preview_bg'  => '#fafafa',
                'accent'      => '#111827',
            ],
            'dark'      => [
                'name'        => 'Dark Glass',
                'description' => 'Dark glassmorphism card with glowing accent. Great for tech, SaaS & gaming.',
                'preview_bg'  => '#0f172a',
                'accent'      => '#6366f1',
            ],
            'rounded'   => [
                'name'        => 'Soft Bubbly',
                'description' => 'Extra-rounded, pastel-toned, friendly. Ideal for healthcare & family services.',
                'preview_bg'  => '#fef3f8',
                'accent'      => '#ec4899',
            ],
            'corporate' => [
                'name'        => 'Corporate Pro',
                'description' => 'Structured, professional layout with sidebar accent bar. Best for B2B & clinics.',
                'preview_bg'  => '#f8fafc',
                'accent'      => '#1d4ed8',
            ],
        ];
    }
}
