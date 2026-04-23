<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="rvly-wrap">

    <div class="rvly-header">
        <div class="rvly-header-inner">
            <div class="rvly-logo">⭐ Reviewly Pro</div>
            <div class="rvly-version">v<?php echo REVIEWLY_VERSION; ?></div>
        </div>
    </div>

    <div class="rvly-page-title">
        <h1>🎨 UI Themes</h1>
        <p>Choose how your review form and review cards look on the front end. Click a theme to activate it instantly.</p>
    </div>

    <div id="rvly-theme-saved" class="rvly-notice rvly-notice-success" style="display:none;">✔ Theme activated successfully!</div>

    <div class="rvly-themes-grid">
    <?php foreach ( $themes as $key => $theme ) :
        $active = ( $settings['active_theme'] === $key );
    ?>
        <div class="rvly-theme-card <?php echo $active ? 'rvly-theme-active' : ''; ?>"
             data-theme="<?php echo esc_attr( $key ); ?>"
             style="--theme-bg: <?php echo esc_attr( $theme['preview_bg'] ); ?>; --theme-accent: <?php echo esc_attr( $theme['accent'] ); ?>;">

            <!-- Preview mockup -->
            <div class="rvly-theme-preview" style="background: <?php echo esc_attr( $theme['preview_bg'] ); ?>;">
                <div class="rvly-mock-card" style="background: <?php echo ( $key === 'dark' ) ? 'rgba(255,255,255,0.07)' : '#fff'; ?>; border: <?php echo ( $key === 'corporate' ) ? '0 0 0 4px ' . $theme['accent'] : 'none'; ?>; border-left: <?php echo ( $key === 'corporate' ) ? '4px solid ' . $theme['accent'] : 'none'; ?>;">
                    <div class="rvly-mock-stars" style="color: <?php echo esc_attr( $theme['accent'] ); ?>;">★★★★★</div>
                    <div class="rvly-mock-name" style="color: <?php echo ( $key === 'dark' ) ? '#fff' : '#111'; ?>;">John Smith</div>
                    <div class="rvly-mock-text" style="color: <?php echo ( $key === 'dark' ) ? 'rgba(255,255,255,0.6)' : '#666'; ?>;">Amazing service, highly recommended!</div>
                    <div class="rvly-mock-btn" style="background: <?php echo esc_attr( $theme['accent'] ); ?>;">Submit Review</div>
                </div>
            </div>

            <div class="rvly-theme-info">
                <div class="rvly-theme-name"><?php echo esc_html( $theme['name'] ); ?></div>
                <div class="rvly-theme-desc"><?php echo esc_html( $theme['description'] ); ?></div>
                <?php if ( $active ) : ?>
                    <span class="rvly-active-badge">✔ Active</span>
                <?php else : ?>
                    <button class="rvly-activate-theme" data-theme="<?php echo esc_attr( $key ); ?>">Activate</button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    </div>

    <div class="rvly-card" style="margin-top:30px;">
        <h3>📌 Note on Themes</h3>
        <p>Switching a theme updates <strong>both</strong> the review submission form and the reviews display grid. The accent colour from your <a href="<?php echo admin_url('admin.php?page=reviewly-settings'); ?>">Settings</a> page is applied on top of the selected theme, so you can mix and match.</p>
    </div>

</div>
