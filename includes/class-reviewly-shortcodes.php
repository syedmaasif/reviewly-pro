<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Reviewly_Shortcodes {

    public static function init() {
        add_shortcode( 'reviewly_form',    [ __CLASS__, 'render_form' ] );
        add_shortcode( 'reviewly_reviews', [ __CLASS__, 'render_reviews' ] );

        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_assets' ] );
    }

    public static function enqueue_assets() {
        global $post;
        // Only load if the shortcode exists on this page
        if ( is_a( $post, 'WP_Post' ) && (
            has_shortcode( $post->post_content, 'reviewly_form' ) ||
            has_shortcode( $post->post_content, 'reviewly_reviews' )
        ) ) {
            wp_enqueue_style(
                'reviewly-public',
                REVIEWLY_PLUGIN_URL . 'public/css/reviewly-public.css',
                [],
                REVIEWLY_VERSION
            );
            wp_enqueue_script(
                'reviewly-public',
                REVIEWLY_PLUGIN_URL . 'public/js/reviewly-public.js',
                [ 'jquery' ],
                REVIEWLY_VERSION,
                true
            );
            wp_localize_script( 'reviewly-public', 'rvlyData', [
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'nonce'   => wp_create_nonce( 'rvly_submit' ),
            ] );
        }
    }

    /* ============================================================
       FORM SHORTCODE
       ============================================================ */
    public static function render_form( $atts = [] ) {
        $settings = Reviewly_Settings::get();
        $fields   = Reviewly_Settings::get_enabled_fields();
        $theme    = $settings['active_theme'] ?? 'modern';
        $accent   = $settings['accent_color'] ?? '#e91e63';

        // Rename to rvly_-prefixed vars so templates satisfy PrefixAllGlobals.
        $rvly_settings = $settings;
        $rvly_fields   = $fields;
        $rvly_theme    = $theme;
        $rvly_accent   = $accent;

        ob_start();
        $template = REVIEWLY_PLUGIN_DIR . 'templates/form-' . sanitize_key( $rvly_theme ) . '.php';
        if ( ! file_exists( $template ) ) {
            $template = REVIEWLY_PLUGIN_DIR . 'templates/form-modern.php';
        }
        include $template;
        return ob_get_clean();
    }

    /* ============================================================
       REVIEWS LIST SHORTCODE
       ============================================================ */
    public static function render_reviews( $atts = [] ) {
        $atts = shortcode_atts( [
            'per_page' => null,
            'theme'    => null,
            'rating'   => 0,   // Minimum rating filter (0 = all)
        ], $atts );

        $settings = Reviewly_Settings::get();
        $per_page = intval( $atts['per_page'] ?? $settings['reviews_per_page'] ?? 12 );
        $theme    = sanitize_key( $atts['theme'] ?? $settings['active_theme'] ?? 'modern' );
        $accent   = $settings['accent_color'] ?? '#e91e63';

        $args = [
            'post_type'      => 'rvly_review',
            'post_status'    => 'publish',
            'posts_per_page' => $per_page > 0 ? $per_page : -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ];

        if ( intval( $atts['rating'] ) > 0 ) {
            $args['meta_query'] = [ [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
                'key'     => 'rvly_rating',
                'value'   => intval( $atts['rating'] ),
                'compare' => '>=',
                'type'    => 'NUMERIC',
            ] ];
        }

        $query = new WP_Query( $args );

        // Rename to rvly_-prefixed vars so templates satisfy PrefixAllGlobals.
        $rvly_settings = $settings;
        $rvly_theme    = $theme;
        $rvly_accent   = $accent;
        $rvly_query    = $query;

        ob_start();
        $template = REVIEWLY_PLUGIN_DIR . 'templates/list-' . $rvly_theme . '.php';
        if ( ! file_exists( $template ) ) {
            $template = REVIEWLY_PLUGIN_DIR . 'templates/list-modern.php';
        }
        include $template;
        wp_reset_postdata();
        return ob_get_clean();
    }
}
