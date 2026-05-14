<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Reviewly_Admin {

    public static function init() {
        add_action( 'admin_menu',            [ __CLASS__, 'register_menus' ] );
        add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueue_assets' ] );
        add_filter( 'admin_footer_text',     [ __CLASS__, 'footer_text' ] );

        // Custom columns for rvly_review list
        add_filter( 'manage_rvly_review_posts_columns',       [ __CLASS__, 'set_columns' ] );
        add_action( 'manage_rvly_review_posts_custom_column', [ __CLASS__, 'render_column' ], 10, 2 );
    }

    public static function register_menus() {
        add_menu_page(
            'Reviewly Pro',
            'Reviewly Pro',
            'manage_options',
            'reviewly-pro',
            [ __CLASS__, 'page_dashboard' ],
            'dashicons-star-filled',
            30
        );
        add_submenu_page(
            'reviewly-pro',
            'Dashboard',
            'Dashboard',
            'manage_options',
            'reviewly-pro',
            [ __CLASS__, 'page_dashboard' ]
        );
        add_submenu_page(
            'reviewly-pro',
            'All Reviews',
            'All Reviews',
            'manage_options',
            'edit.php?post_type=rvly_review'
        );
        add_submenu_page(
            'reviewly-pro',
            'UI Themes',
            'UI Themes',
            'manage_options',
            'reviewly-themes',
            [ __CLASS__, 'page_themes' ]
        );
        add_submenu_page(
            'reviewly-pro',
            'Custom Fields',
            'Custom Fields',
            'manage_options',
            'reviewly-fields',
            [ __CLASS__, 'page_fields' ]
        );
        add_submenu_page(
            'reviewly-pro',
            'Settings',
            'Settings',
            'manage_options',
            'reviewly-settings',
            [ __CLASS__, 'page_settings' ]
        );
        add_submenu_page(
            'reviewly-pro',
            'Guide & Shortcodes',
            '📖 Guide',
            'manage_options',
            'reviewly-guide',
            [ __CLASS__, 'page_guide' ]
        );
    }

    public static function enqueue_assets( $hook ) {
        $pages = [
            'toplevel_page_reviewly-pro',
            'reviewly-pro_page_reviewly-themes',
            'reviewly-pro_page_reviewly-fields',
            'reviewly-pro_page_reviewly-settings',
            'reviewly-pro_page_reviewly-guide',
        ];
        if ( ! in_array( $hook, $pages ) ) return;

        wp_enqueue_style(
            'reviewly-admin',
            REVIEWLY_PLUGIN_URL . 'admin/css/reviewly-admin.css',
            [],
            REVIEWLY_VERSION
        );
        wp_enqueue_script(
            'reviewly-admin',
            REVIEWLY_PLUGIN_URL . 'admin/js/reviewly-admin.js',
            [ 'jquery' ],
            REVIEWLY_VERSION,
            true
        );
        wp_localize_script( 'reviewly-admin', 'rvlyAdmin', [
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'rvly_admin_nonce' ),
        ] );
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
    }

    /* ---- Dashboard ---- */
    public static function page_dashboard() {
        $total     = wp_count_posts( 'rvly_review' );
        $published = intval( $total->publish ?? 0 );
        $pending   = intval( $total->pending ?? 0 );

        // Average rating
        $posts = get_posts( [ 'post_type' => 'rvly_review', 'post_status' => 'publish', 'posts_per_page' => -1 ] );
        $ratings = array_map( fn($p) => intval( get_post_meta( $p->ID, 'rvly_rating', true ) ), $posts );
        $avg     = count( $ratings ) ? round( array_sum( $ratings ) / count( $ratings ), 1 ) : 0;

        // Recent reviews
        $recent = get_posts( [ 'post_type' => 'rvly_review', 'post_status' => [ 'publish', 'pending' ], 'posts_per_page' => 5 ] );

        $settings  = Reviewly_Settings::get();
        // Prefix vars for PrefixAllGlobals compliance in the view.
        $rvly_settings  = $settings;
        $rvly_published = $published;
        $rvly_pending   = $pending;
        $rvly_avg       = $avg;
        $rvly_recent    = $recent;
        include REVIEWLY_PLUGIN_DIR . 'admin/views/page-dashboard.php';
    }

    /* ---- Themes ---- */
    public static function page_themes() {
        $themes   = Reviewly_Settings::get_themes();
        $settings = Reviewly_Settings::get();
        // Prefix vars for PrefixAllGlobals compliance in the view.
        $rvly_themes   = $themes;
        $rvly_settings = $settings;
        include REVIEWLY_PLUGIN_DIR . 'admin/views/page-themes.php';
    }

    /* ---- Fields ---- */
    public static function page_fields() {
        $settings = Reviewly_Settings::get();
        // Prefix vars for PrefixAllGlobals compliance in the view.
        $rvly_settings = $settings;
        include REVIEWLY_PLUGIN_DIR . 'admin/views/page-fields.php';
    }

    /* ---- Settings ---- */
    public static function page_settings() {
        $settings = Reviewly_Settings::get();
        $rvly_settings = $settings;
        include REVIEWLY_PLUGIN_DIR . 'admin/views/page-settings.php';
    }

    /* ---- Guide ---- */
    public static function page_guide() {
        include REVIEWLY_PLUGIN_DIR . 'admin/views/page-guide.php';
    }

    /* ---- Custom columns ---- */
    public static function set_columns( $cols ) {
        return [
            'cb'         => $cols['cb'],
            'title'      => 'Reviewer',
            'rvly_rating'=> 'Rating',
            'rvly_email' => 'Email',
            'rvly_date'  => 'Date',
            'post_status'=> 'Status',
        ];
    }

    public static function render_column( $col, $post_id ) {
        switch ( $col ) {
            case 'rvly_rating':
                $r = intval( get_post_meta( $post_id, 'rvly_rating', true ) );
                echo '<span style="color:#ffc107;">' . esc_html( str_repeat( '★', $r ) ) . '</span>';
                break;
            case 'rvly_email':
                echo esc_html( get_post_meta( $post_id, 'rvly_email', true ) );
                break;
            case 'rvly_date':
                echo esc_html( get_post_meta( $post_id, 'rvly_date', true ) );
                break;
            case 'post_status':
                $s = get_post_status( $post_id );
                $label = $s === 'publish' ? '<span style="color:green;">✔ Published</span>' : '<span style="color:orange;">⏳ Pending</span>';
                echo wp_kses( $label, [ 'span' => [ 'style' => [] ] ] );
                break;
        }
    }

    public static function footer_text( $text ) {
        $screen = get_current_screen();
        if ( $screen && strpos( $screen->id, 'reviewly' ) !== false ) {
            return '⭐ Thank you for using <strong>Reviewly Pro</strong>. If you like it, consider sharing it!';
        }
        return $text;
    }
}
