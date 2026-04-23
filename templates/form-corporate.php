<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="rvly-form-wrap rvly-theme-corporate" style="--rvly-accent: <?php echo esc_attr( $accent ); ?>;">
    <div class="rvly-form-inner">
        <h3 class="rvly-form-title">Leave a Review</h3>
        <p class="rvly-form-subtitle">We'd love to hear about your experience.</p>

        <!-- Star Rating -->
        <div class="rvly-star-row" role="group" aria-label="Star rating">
            <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
            <button type="button" class="rvly-star" data-value="<?php echo $i; ?>" aria-label="<?php echo $i; ?> star">★</button>
            <?php endfor; ?>
        </div>

        <!-- Dynamic Fields -->
        <?php foreach ( $fields as $key => $field ) :
            if ( $key === 'review' ) continue; // review textarea rendered separately
            $label       = esc_html( $field['label'] );
            $placeholder = esc_attr( $field['placeholder'] );
        ?>
            <?php if ( $key === 'recommend' ) : ?>
            <div class="rvly-field-group">
                <label><?php echo $label; ?></label>
                <div class="rvly-radio-wrap">
                    <label class="rvly-radio-btn"><input type="radio" name="rvly_recommend" value="Yes"> 👍 Yes</label>
                    <label class="rvly-radio-btn"><input type="radio" name="rvly_recommend" value="No">  👎 No</label>
                </div>
            </div>
            <?php elseif ( $key === 'email' ) : ?>
            <div class="rvly-field-group">
                <label for="rvly_email"><?php echo $label; ?></label>
                <input type="email" id="rvly_email" name="rvly_email" placeholder="<?php echo $placeholder; ?>" autocomplete="email">
            </div>
            <?php elseif ( $key === 'phone' ) : ?>
            <div class="rvly-field-group">
                <label for="rvly_phone"><?php echo $label; ?></label>
                <input type="tel" id="rvly_phone" name="rvly_phone" placeholder="<?php echo $placeholder; ?>">
            </div>
            <?php elseif ( $key === 'website' ) : ?>
            <div class="rvly-field-group">
                <label for="rvly_website"><?php echo $label; ?></label>
                <input type="url" id="rvly_website" name="rvly_website" placeholder="<?php echo $placeholder; ?>">
            </div>
            <?php else : ?>
            <div class="rvly-field-group">
                <label for="rvly_<?php echo esc_attr($key); ?>"><?php echo $label; ?></label>
                <input type="text" id="rvly_<?php echo esc_attr($key); ?>" name="rvly_<?php echo esc_attr($key); ?>" placeholder="<?php echo $placeholder; ?>">
            </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- Review textarea -->
        <?php if ( isset( $fields['review'] ) ) : ?>
        <div class="rvly-field-group">
            <label for="rvly_review"><?php echo esc_html( $fields['review']['label'] ); ?></label>
            <textarea id="rvly_review" name="rvly_review" rows="4" placeholder="<?php echo esc_attr( $fields['review']['placeholder'] ); ?>"></textarea>
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
