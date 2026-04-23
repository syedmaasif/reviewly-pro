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

    /** Saves settings from $_POST (sanitised). */
    public static function save_from_post() {
        $settings = self::get();

        if ( isset( $_POST['active_theme'] ) )
            $settings['active_theme'] = sanitize_key( $_POST['active_theme'] );

        if ( isset( $_POST['require_approval'] ) )
            $settings['require_approval'] = $_POST['require_approval'] === '1' ? '1' : '0';

        if ( isset( $_POST['accent_color'] ) )
            $settings['accent_color'] = sanitize_hex_color( $_POST['accent_color'] ) ?: '#e91e63';

        if ( isset( $_POST['reviews_per_page'] ) )
            $settings['reviews_per_page'] = absint( $_POST['reviews_per_page'] ) ?: 12;

        if ( isset( $_POST['show_date'] ) )
            $settings['show_date'] = $_POST['show_date'] === '1' ? '1' : '0';

        if ( isset( $_POST['show_avatar'] ) )
            $settings['show_avatar'] = $_POST['show_avatar'] === '1' ? '1' : '0';

        if ( isset( $_POST['redirect_url'] ) )
            $settings['redirect_url'] = esc_url_raw( $_POST['redirect_url'] );

        // Fields
        if ( isset( $_POST['fields'] ) && is_array( $_POST['fields'] ) ) {
            foreach ( $_POST['fields'] as $key => $field ) {
                $settings['fields'][ sanitize_key( $key ) ] = [
                    'enabled'     => ! empty( $field['enabled'] ) ? '1' : '0',
                    'label'       => sanitize_text_field( $field['label'] ?? '' ),
                    'placeholder' => sanitize_text_field( $field['placeholder'] ?? '' ),
                    'private'     => ! empty( $field['private'] ) ? '1' : '0',
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
