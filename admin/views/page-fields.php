<?php if ( ! defined( 'ABSPATH' ) ) exit;

$rvly_all_fields = [ // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    'name'       => [ 'icon' => '👤', 'title' => 'Reviewer Name',    'type' => 'text',     'note' => 'Shown publicly on the review card.' ],
    'email'      => [ 'icon' => '📧', 'title' => 'Email Address',     'type' => 'email',    'note' => 'Recommended: keep private. Never shown publicly by default.' ],
    'phone'      => [ 'icon' => '📞', 'title' => 'Phone Number',      'type' => 'tel',      'note' => 'Optional. Private by default — only visible in your dashboard.' ],
    'review'     => [ 'icon' => '💬', 'title' => 'Review / Message',  'type' => 'textarea', 'note' => 'The main review text. Shown publicly.' ],
    'website'    => [ 'icon' => '🌐', 'title' => 'Website URL',       'type' => 'url',      'note' => 'Optional. Shown as a link on the review card.' ],
    'occupation' => [ 'icon' => '💼', 'title' => 'Job / Occupation',  'type' => 'text',     'note' => 'e.g. "Nurse", "Developer". Shown publicly.' ],
    'location'   => [ 'icon' => '📍', 'title' => 'City / Location',   'type' => 'text',     'note' => 'e.g. "London, UK". Shown publicly.' ],
    'recommend'  => [ 'icon' => '👍', 'title' => 'Would Recommend?',  'type' => 'radio',    'note' => 'Yes / No choice. Shown publicly on the card.' ],
];
?>
<div class="rvly-wrap">

    <div class="rvly-header">
        <div class="rvly-header-inner">
            <div class="rvly-logo">⭐ Reviewly Pro</div>
            <div class="rvly-version">v<?php echo esc_html( REVIEWLY_VERSION ); ?></div>
        </div>
    </div>

    <div class="rvly-page-title">
        <h1>🗂 Custom Fields</h1>
        <p>Choose which fields to show on your review form. Set labels, placeholders, and privacy settings for each.</p>
    </div>

    <div id="rvly-fields-saved" class="rvly-notice rvly-notice-success" style="display:none;">✔ Fields saved successfully!</div>

    <form id="rvly-fields-form">
        <div class="rvly-fields-list">
        <?php foreach ( $rvly_all_fields as $rvly_key => $rvly_meta ) : // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
            $rvly_saved       = $rvly_settings['fields'][ $rvly_key ] ?? []; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
            $rvly_enabled     = ! empty( $rvly_saved['enabled'] ) && $rvly_saved['enabled'] == '1'; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
            $rvly_label       = $rvly_saved['label'] ?? ''; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
            $rvly_placeholder = $rvly_saved['placeholder'] ?? ''; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
            $rvly_private     = ! empty( $rvly_saved['private'] ) && $rvly_saved['private'] == '1'; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
        ?>
        <div class="rvly-field-row <?php echo $rvly_enabled ? 'rvly-field-enabled' : ''; ?>" data-field="<?php echo esc_attr( $rvly_key ); ?>">

            <div class="rvly-field-toggle-col">
                <label class="rvly-toggle">
                    <input type="checkbox" name="fields[<?php echo esc_attr($rvly_key); ?>][enabled]" value="1" <?php checked( $rvly_enabled ); ?>>
                    <span class="rvly-toggle-slider"></span>
                </label>
            </div>

            <div class="rvly-field-icon"><?php echo esc_html( $rvly_meta['icon'] ); ?></div>

            <div class="rvly-field-details">
                <div class="rvly-field-title"><?php echo esc_html( $rvly_meta['title'] ); ?></div>
                <div class="rvly-field-note"><?php echo esc_html( $rvly_meta['note'] ); ?></div>

                <div class="rvly-field-inputs <?php echo $rvly_enabled ? '' : 'rvly-hidden'; ?>">
                    <div class="rvly-field-input-group">
                        <label>Label <span class="rvly-hint-sm">(shown above the input)</span></label>
                        <input type="text"
                               name="fields[<?php echo esc_attr($rvly_key); ?>][label]"
                               value="<?php echo esc_attr( $rvly_label ); ?>"
                               placeholder="<?php echo esc_attr( $rvly_meta['title'] ); ?>">
                    </div>
                    <?php if ( $rvly_meta['type'] !== 'radio' ) : ?>
                    <div class="rvly-field-input-group">
                        <label>Placeholder <span class="rvly-hint-sm">(inside the input)</span></label>
                        <input type="text"
                               name="fields[<?php echo esc_attr($rvly_key); ?>][placeholder]"
                               value="<?php echo esc_attr( $rvly_placeholder ); ?>"
                               placeholder="e.g. Enter your <?php echo esc_attr( strtolower( $rvly_meta['title'] ) ); ?>">
                    </div>
                    <?php endif; ?>
                    <div class="rvly-field-input-group rvly-field-inline">
                        <label class="rvly-checkbox-label">
                            <input type="checkbox"
                                   name="fields[<?php echo esc_attr($rvly_key); ?>][private]"
                                   value="1" <?php checked( $rvly_private ); ?>>
                            🔒 Keep private (only visible in your dashboard, never shown publicly)
                        </label>
                    </div>
                    <input type="hidden" name="fields[<?php echo esc_attr($rvly_key); ?>][type]" value="<?php echo esc_attr( $rvly_meta['type'] ); ?>">
                </div>
            </div>

        </div>
        <?php endforeach; ?>
        </div>

        <div class="rvly-form-actions">
            <button type="submit" class="rvly-btn-primary" id="rvly-save-fields">💾 Save Fields</button>
        </div>
    </form>

</div>
