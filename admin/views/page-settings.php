<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="rvly-wrap">

    <div class="rvly-header">
        <div class="rvly-header-inner">
            <div class="rvly-logo">⭐ Reviewly Pro</div>
            <div class="rvly-version">v<?php echo esc_html( REVIEWLY_VERSION ); ?></div>
        </div>
    </div>

    <div class="rvly-page-title">
        <h1>⚙️ Settings</h1>
        <p>Configure global options for Reviewly Pro.</p>
    </div>

    <div id="rvly-settings-saved" class="rvly-notice rvly-notice-success" style="display:none;">✔ Settings saved!</div>

    <form id="rvly-settings-form">
        <div class="rvly-settings-grid">

            <!-- General -->
            <div class="rvly-card">
                <h3>🔧 General</h3>

                <div class="rvly-setting-row">
                    <label>Require Admin Approval Before Publishing?</label>
                    <div class="rvly-radio-group">
                        <label><input type="radio" name="require_approval" value="0" <?php checked( $rvly_settings['require_approval'], '0' ); ?>> Auto-Publish</label>
                        <label><input type="radio" name="require_approval" value="1" <?php checked( $rvly_settings['require_approval'], '1' ); ?>> Require Approval</label>
                    </div>
                    <p class="rvly-hint">Auto-publish is great for trusted audiences. Use approval for public-facing forms.</p>
                </div>

                <div class="rvly-setting-row">
                    <label>Reviews Per Page <span class="rvly-hint-sm">(0 = show all)</span></label>
                    <input type="number" name="reviews_per_page" value="<?php echo esc_attr( $rvly_settings['reviews_per_page'] ); ?>" min="0" max="100" style="width:100px;">
                </div>

                <div class="rvly-setting-row">
                    <label>Redirect After Submission <span class="rvly-hint-sm">(leave blank to stay on page)</span></label>
                    <input type="url" name="redirect_url" value="<?php echo esc_attr( $rvly_settings['redirect_url'] ); ?>" placeholder="https://yoursite.com/thank-you" style="width:100%;">
                </div>
            </div>

            <!-- Display -->
            <div class="rvly-card">
                <h3>🖼 Display Options</h3>

                <div class="rvly-setting-row">
                    <label class="rvly-checkbox-label">
                        <input type="checkbox" name="show_date" value="1" <?php checked( $rvly_settings['show_date'], '1' ); ?>>
                        Show review date on cards
                    </label>
                </div>

                <div class="rvly-setting-row">
                    <label class="rvly-checkbox-label">
                        <input type="checkbox" name="show_avatar" value="1" <?php checked( $rvly_settings['show_avatar'], '1' ); ?>>
                        Show avatar (initial letter) on cards
                    </label>
                </div>

                <div class="rvly-setting-row">
                    <label>Accent Colour <span class="rvly-hint-sm">(applied across all themes)</span></label>
                    <input type="text" name="accent_color" value="<?php echo esc_attr( $rvly_settings['accent_color'] ); ?>" class="rvly-color-picker">
                </div>
            </div>

        </div>

        <div class="rvly-form-actions">
            <button type="submit" class="rvly-btn-primary" id="rvly-save-settings">💾 Save Settings</button>
        </div>
    </form>

</div>
