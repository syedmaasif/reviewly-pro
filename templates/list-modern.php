<?php if ( ! defined( 'ABSPATH' ) ) exit;
$settings = Reviewly_Settings::get();
?>
<div class="rvly-reviews-wrap rvly-theme-<?php echo esc_attr( $theme ); ?>" style="--rvly-accent: <?php echo esc_attr( $accent ); ?>;">
    <?php if ( ! $query->have_posts() ) : ?>
        <p class="rvly-no-reviews">No reviews yet. Be the first to leave one!</p>
    <?php else : ?>
    <div class="rvly-grid">
        <?php while ( $query->have_posts() ) : $query->the_post();
            $rating    = intval( get_post_meta( get_the_ID(), 'rvly_rating', true ) );
            $date      = esc_html( get_post_meta( get_the_ID(), 'rvly_date', true ) );
            $recommend = get_post_meta( get_the_ID(), 'rvly_recommend', true );
            $occupation= esc_html( get_post_meta( get_the_ID(), 'rvly_occupation', true ) );
            $location  = esc_html( get_post_meta( get_the_ID(), 'rvly_location', true ) );
            $initial   = strtoupper( substr( get_the_title(), 0, 1 ) );
        ?>
        <div class="rvly-review-card">
            <div class="rvly-card-top">
                <?php if ( $settings['show_avatar'] ) : ?>
                <div class="rvly-avatar"><?php echo esc_html( $initial ); ?></div>
                <?php endif; ?>
                <div class="rvly-card-meta">
                    <h4 class="rvly-reviewer-name"><?php the_title(); ?></h4>
                    <?php if ( $occupation ) : ?>
                        <span class="rvly-occupation"><?php echo $occupation; ?></span>
                    <?php endif; ?>
                    <?php if ( $location ) : ?>
                        <span class="rvly-location">📍 <?php echo $location; ?></span>
                    <?php endif; ?>
                    <div class="rvly-card-stars">
                        <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                        <span class="<?php echo $i <= $rating ? 'rvly-star-filled' : 'rvly-star-empty'; ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    <?php if ( $settings['show_date'] && $date ) : ?>
                    <span class="rvly-card-date"><?php echo $date; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <p class="rvly-card-text"><?php the_content(); ?></p>
            <?php if ( $recommend ) : ?>
            <div class="rvly-recommend">
                <?php echo $recommend === 'Yes' ? '👍 <strong>Recommends</strong>' : '👎 Does not recommend'; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </div>
    <?php endif; ?>
</div>
