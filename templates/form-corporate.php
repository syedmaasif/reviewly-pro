<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="rvly-form-wrap rvly-theme-corporate" style="--rvly-accent: <?php echo esc_attr( $rvly_accent ); ?>;">
    <div class="rvly-form-inner">
        <h3 class="rvly-form-title">Leave a Review</h3>
        <p class="rvly-form-subtitle">We'd love to hear about your experience.</p>

        <!-- Star Rating -->
        <div class="rvly-star-row" role="group" aria-label="Star rating">
            <?php // phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound ?>
            <?php for ( $rvly_i = 1; $rvly_i <= 5; $rvly_i++ ) : ?>
            <button type="button" class="rvly-star" data-value="<?php echo absint( $rvly_i ); ?>" aria-label="<?php echo absint( $rvly_i ); ?> star">★</button>
            <?php endfor; ?>
            <?php // phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound ?>
        </div>

        <!-- Dynamic Fields -->
        <?php foreach ( $rvly_fields as $rvly_key => $rvly_field ) : // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
            if ( $rvly_key === 'review' ) continue; // review textarea rendered separately
            $rvly_label       = esc_html( $rvly_field['label'] ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
            $rvly_placeholder = esc_attr( $rvly_field['placeholder'] ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
        ?>
            <?php if ( $rvly_key === 'recommend' ) : ?>
            <div class="rvly-field-group">
                <label><?php echo esc_html( $rvly_label ); ?></label>
                <div class="rvly-radio-wrap">
                    <label class="rvly-radio-btn"><input type="radio" name="rvly_recommend" value="Yes"> 👍 Yes</label>
                    <label class="rvly-radio-btn"><input type="radio" name="rvly_recommend" value="No">  👎 No</label>
                </div>
            </div>
            <?php elseif ( $rvly_key === 'email' ) : ?>
            <div class="rvly-field-group">
                <label for="rvly_email"><?php echo esc_html( $rvly_label ); ?></label>
                <input type="email" id="rvly_email" name="rvly_email" placeholder="<?php echo esc_attr( $rvly_placeholder ); ?>" autocomplete="email">
            </div>
            <?php elseif ( $rvly_key === 'phone' ) : ?>
            <div class="rvly-field-group">
                <label for="rvly_phone"><?php echo esc_html( $rvly_label ); ?></label>
                <input type="tel" id="rvly_phone" name="rvly_phone" placeholder="<?php echo esc_attr( $rvly_placeholder ); ?>">
            </div>
            <?php elseif ( $rvly_key === 'website' ) : ?>
            <div class="rvly-field-group">
                <label for="rvly_website"><?php echo esc_html( $rvly_label ); ?></label>
                <input type="url" id="rvly_website" name="rvly_website" placeholder="<?php echo esc_attr( $rvly_placeholder ); ?>">
            </div>
            <?php else : ?>
            <div class="rvly-field-group">
                <label for="rvly_<?php echo esc_attr($rvly_key); ?>"><?php echo esc_html( $rvly_label ); ?></label>
                <input type="text" id="rvly_<?php echo esc_attr($rvly_key); ?>" name="rvly_<?php echo esc_attr($rvly_key); ?>" placeholder="<?php echo esc_attr( $rvly_placeholder ); ?>">
            </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- Review textarea -->
        <?php if ( isset( $rvly_fields['review'] ) ) : ?>
        <div class="rvly-field-group">
            <label for="rvly_review"><?php echo esc_html( $rvly_fields['review']['label'] ); ?></label>
            <textarea id="rvly_review" name="rvly_review" rows="4" placeholder="<?php echo esc_attr( $rvly_fields['review']['placeholder'] ); ?>"></textarea>
        </div>
        <?php endif; ?>

        <div class="rvly-error-msg" style="display:none;"></div>

        <button type="button" class="rvly-submit-btn">Submit Review</button>

        <div class="rvly-success-msg" style="display:none;">
            <span class="rvly-success-icon">🎉</span>
            <h4 class="rvly-success-title">Thank you!</h4>
            <p class="rvly-success-text"></p>
        </div>
    </div>
</div>
