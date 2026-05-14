<?php if ( ! defined( 'ABSPATH' ) ) exit;
$rvly_settings = Reviewly_Settings::get(); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<div class="rvly-reviews-wrap rvly-theme-<?php echo esc_attr( $rvly_theme ); ?>" style="--rvly-accent: <?php echo esc_attr( $rvly_accent ); ?>;">
    <?php if ( ! $rvly_query->have_posts() ) : ?>
        <p class="rvly-no-reviews">No reviews yet. Be the first to leave one!</p>
    <?php else : ?>
    <div class="rvly-grid">
        <?php while ( $rvly_query->have_posts() ) : $rvly_query->the_post();
            $rvly_rating    = intval( get_post_meta( get_the_ID(), 'rvly_rating', true ) ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
            $rvly_date      = esc_html( get_post_meta( get_the_ID(), 'rvly_date', true ) ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
            $rvly_recommend = get_post_meta( get_the_ID(), 'rvly_recommend', true ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
            $rvly_occupation= esc_html( get_post_meta( get_the_ID(), 'rvly_occupation', true ) ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
            $rvly_location  = esc_html( get_post_meta( get_the_ID(), 'rvly_location', true ) ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
            $rvly_initial   = strtoupper( substr( get_the_title(), 0, 1 ) ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
        ?>
        <div class="rvly-review-card">
            <div class="rvly-card-top">
                <?php if ( $rvly_settings['show_avatar'] ) : ?>
                <div class="rvly-avatar"><?php echo esc_html( $rvly_initial ); ?></div>
                <?php endif; ?>
                <div class="rvly-card-meta">
                    <h4 class="rvly-reviewer-name"><?php the_title(); ?></h4>
                    <?php if ( $rvly_occupation ) : ?>
                        <span class="rvly-occupation"><?php echo esc_html( $rvly_occupation ); ?></span>
                    <?php endif; ?>
                    <?php if ( $rvly_location ) : ?>
                        <span class="rvly-location">📍 <?php echo esc_html( $rvly_location ); ?></span>
                    <?php endif; ?>
                    <div class="rvly-card-stars">
                        <?php // phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound ?>
                        <?php for ( $rvly_i = 1; $rvly_i <= 5; $rvly_i++ ) : ?>
                        <span class="<?php echo esc_attr( $rvly_i <= $rvly_rating ? 'rvly-star-filled' : 'rvly-star-empty' ); ?>">★</span>
                        <?php endfor; ?>
                        <?php // phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound ?>
                    </div>
                    <?php if ( $rvly_settings['show_date'] && $rvly_date ) : ?>
                    <span class="rvly-card-date"><?php echo esc_html( $rvly_date ); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <p class="rvly-card-text"><?php the_content(); ?></p>
            <?php if ( $rvly_recommend ) : ?>
            <div class="rvly-recommend">
                <?php echo $rvly_recommend === 'Yes' ? '👍 <strong>Recommends</strong>' : '👎 Does not recommend'; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </div>
    <?php endif; ?>
</div>
