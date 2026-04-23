<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Reviewly_Post_Type {

    public static function init() {
        add_action( 'init', [ __CLASS__, 'register_post_type' ] );
    }

    public static function register_post_type() {
        register_post_type( 'rvly_review', [
            'labels' => [
                'name'               => 'Reviews',
                'singular_name'      => 'Review',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Review',
                'edit_item'          => 'Edit Review',
                'view_item'          => 'View Review',
                'all_items'          => 'All Reviews',
                'search_items'       => 'Search Reviews',
                'not_found'          => 'No reviews found.',
                'not_found_in_trash' => 'No reviews found in Trash.',
            ],
            'public'       => false,
            'show_ui'      => true,
            'show_in_menu' => false, // We add our own menu
            'supports'     => [ 'title', 'editor' ],
            'menu_icon'    => 'dashicons-star-filled',
            'capabilities' => [
                'edit_post'          => 'manage_options',
                'read_post'          => 'manage_options',
                'delete_post'        => 'manage_options',
                'edit_posts'         => 'manage_options',
                'edit_others_posts'  => 'manage_options',
                'publish_posts'      => 'manage_options',
                'read_private_posts' => 'manage_options',
            ],
        ]);
    }

    public static function activate() {
        self::register_post_type();
        flush_rewrite_rules();

        // Set default options on first activation
        if ( ! get_option( 'reviewly_settings' ) ) {
            $defaults = [
                'active_theme'    => 'modern',
                'require_approval'=> '0',
                'fields'          => [
                    'name'        => [ 'enabled' => '1', 'label' => 'Your Name',    'placeholder' => 'John Smith',              'private' => '0' ],
                    'email'       => [ 'enabled' => '1', 'label' => 'Email Address','placeholder' => 'you@example.com',         'private' => '1' ],
                    'phone'       => [ 'enabled' => '0', 'label' => 'Phone Number', 'placeholder' => '+1 (555) 000-0000',       'private' => '1' ],
                    'review'      => [ 'enabled' => '1', 'label' => 'Your Review',  'placeholder' => 'Share your experience…',  'private' => '0' ],
                    'website'     => [ 'enabled' => '0', 'label' => 'Website',      'placeholder' => 'https://yoursite.com',    'private' => '0' ],
                    'occupation'  => [ 'enabled' => '0', 'label' => 'Job / Role',   'placeholder' => 'e.g. Nurse, Developer',   'private' => '0' ],
                    'location'    => [ 'enabled' => '0', 'label' => 'City / Area',  'placeholder' => 'e.g. London, UK',         'private' => '0' ],
                    'recommend'   => [ 'enabled' => '0', 'label' => 'Would you recommend us?', 'placeholder' => '',            'private' => '0' ],
                ],
                'accent_color'    => '#e91e63',
                'reviews_per_page'=> '12',
                'show_date'       => '1',
                'show_avatar'     => '1',
                'redirect_url'    => '',
            ];
            update_option( 'reviewly_settings', $defaults );
        }
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }
}
