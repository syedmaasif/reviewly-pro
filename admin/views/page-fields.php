<?php if ( ! defined( 'ABSPATH' ) ) exit;

$all_fields = [
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
            <div class="rvly-version">v<?php echo REVIEWLY_VERSION; ?></div>
        </div>
    </div>

    <div class="rvly-page-title">
        <h1>🗂 Custom Fields</h1>
        <p>Choose which fields to show on your review form. Set labels, placeholders, and privacy settings for each.</p>
    </div>

    <div id="rvly-fields-saved" class="rvly-notice rvly-notice-success" style="display:none;">✔ Fields saved successfully!</div>

    <form id="rvly-fields-form">
        <div class="rvly-fields-list">
        <?php foreach ( $all_fields as $key => $meta ) :
            $saved       = $settings['fields'][ $key ] ?? [];
            $enabled     = ! empty( $saved['enabled'] ) && $saved['enabled'] == '1';
            $label       = $saved['label'] ?? '';
            $placeholder = $saved['placeholder'] ?? '';
            $private     = ! empty( $saved['private'] ) && $saved['private'] == '1';
        ?>
        <div class="rvly-field-row <?php echo $enabled ? 'rvly-field-enabled' : ''; ?>" data-field="<?php echo esc_attr( $key ); ?>">

            <div class="rvly-field-toggle-col">
                <label class="rvly-toggle">
                    <input type="checkbox" name="fields[<?php echo esc_attr($key); ?>][enabled]" value="1" <?php checked( $enabled ); ?>>
                    <span class="rvly-toggle-slider"></span>
                </label>
            </div>

            <div class="rvly-field-icon"><?php echo $meta['icon']; ?></div>

            <div class="rvly-field-details">
                <div class="rvly-field-title"><?php echo esc_html( $meta['title'] ); ?></div>
                <div class="rvly-field-note"><?php echo esc_html( $meta['note'] ); ?></div>

                <div class="rvly-field-inputs <?php echo $enabled ? '' : 'rvly-hidden'; ?>">
                    <div class="rvly-field-input-group">
                        <label>Label <span class="rvly-hint-sm">(shown above the input)</span></label>
                        <input type="text"
                               name="fields[<?php echo esc_attr($key); ?>][label]"
                               value="<?php echo esc_attr( $label ); ?>"
                               placeholder="<?php echo esc_attr( $meta['title'] ); ?>">
                    </div>
                    <?php if ( $meta['type'] !== 'radio' ) : ?>
                    <div class="rvly-field-input-group">
                        <label>Placeholder <span class="rvly-hint-sm">(inside the input)</span></label>
                        <input type="text"
                               name="fields[<?php echo esc_attr($key); ?>][placeholder]"
                               value="<?php echo esc_attr( $placeholder ); ?>"
                               placeholder="e.g. Enter your <?php echo strtolower( esc_attr( $meta['title'] ) ); ?>">
                    </div>
                    <?php endif; ?>
                    <div class="rvly-field-input-group rvly-field-inline">
                        <label class="rvly-checkbox-label">
                            <input type="checkbox"
                                   name="fields[<?php echo esc_attr($key); ?>][private]"
                                   value="1" <?php checked( $private ); ?>>
                            🔒 Keep private (only visible in your dashboard, never shown publicly)
                        </label>
                    </div>
                    <input type="hidden" name="fields[<?php echo esc_attr($key); ?>][type]" value="<?php echo esc_attr( $meta['type'] ); ?>">
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
