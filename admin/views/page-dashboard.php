<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="rvly-wrap">

    <div class="rvly-header">
        <div class="rvly-header-inner">
            <div class="rvly-logo">⭐ Reviewly Pro</div>
            <div class="rvly-version">v<?php echo esc_html( REVIEWLY_VERSION ); ?></div>
        </div>
    </div>

    <div class="rvly-page-title">
        <h1>Dashboard</h1>
        <p>Welcome! Here's an overview of your reviews.</p>
    </div>

    <!-- Stats -->
    <div class="rvly-stats-grid">
        <div class="rvly-stat-card">
            <div class="rvly-stat-icon" style="background:#e0f2fe;">💬</div>
            <div class="rvly-stat-info">
                <span class="rvly-stat-number"><?php echo absint( $rvly_published ); ?></span>
                <span class="rvly-stat-label">Published Reviews</span>
            </div>
        </div>
        <div class="rvly-stat-card">
            <div class="rvly-stat-icon" style="background:#fef9c3;">⏳</div>
            <div class="rvly-stat-info">
                <span class="rvly-stat-number"><?php echo absint( $rvly_pending ); ?></span>
                <span class="rvly-stat-label">Pending Approval</span>
            </div>
        </div>
        <div class="rvly-stat-card">
            <div class="rvly-stat-icon" style="background:#dcfce7;">⭐</div>
            <div class="rvly-stat-info">
                <span class="rvly-stat-number"><?php echo esc_html( $rvly_avg ); ?>/5</span>
                <span class="rvly-stat-label">Average Rating</span>
            </div>
        </div>
        <div class="rvly-stat-card">
            <div class="rvly-stat-icon" style="background:#fce7f3;">🎨</div>
            <div class="rvly-stat-info">
                <span class="rvly-stat-number"><?php echo esc_html( ucfirst( $rvly_settings["active_theme"] ) ); ?></span>
                <span class="rvly-stat-label">Active Theme</span>
            </div>
        </div>
    </div>

    <!-- Quick Shortcodes -->
    <div class="rvly-shortcode-banner">
        <h3>📋 Your Shortcodes</h3>
        <div class="rvly-shortcodes-row">
            <div class="rvly-sc-item">
                <label>Review Form</label>
                <div class="rvly-sc-copy" data-sc="[reviewly_form]">
                    <code>[reviewly_form]</code>
                    <button class="rvly-copy-btn">Copy</button>
                </div>
            </div>
            <div class="rvly-sc-item">
                <label>Reviews Display</label>
                <div class="rvly-sc-copy" data-sc="[reviewly_reviews]">
                    <code>[reviewly_reviews]</code>
                    <button class="rvly-copy-btn">Copy</button>
                </div>
            </div>
        </div>
        <p class="rvly-hint">👉 Go to <a href="<?php echo esc_url( admin_url('admin.php?page=reviewly-guide') ); ?>">📖 Guide</a> for full shortcode options and placement tips.</p>
    </div>

    <!-- Recent Reviews -->
    <div class="rvly-card">
        <div class="rvly-card-header">
            <h2>Recent Reviews</h2>
            <a href="<?php echo esc_url( admin_url('edit.php?post_type=rvly_review') ); ?>" class="rvly-btn-sm">View All</a>
        </div>
        <?php if ( empty( $rvly_recent ) ) : ?>
            <div class="rvly-empty">No reviews yet. Share the form shortcode with your visitors!</div>
        <?php else : ?>
        <table class="rvly-table">
            <thead>
                <tr>
                    <th>Reviewer</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ( $rvly_recent as $rvly_rev ) : // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
                $rvly_rating  = intval( get_post_meta( $rvly_rev->ID, 'rvly_rating', true ) ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
                $rvly_date    = esc_html( get_post_meta( $rvly_rev->ID, 'rvly_date', true ) ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
                $status  = get_post_status( $rvly_rev->ID ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
                $rvly_excerpt = wp_trim_words( $rvly_rev->post_content, 12 ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
            ?>
            <tr data-id="<?php echo absint( $rvly_rev->ID ); ?>">
                <td><strong><?php echo esc_html( $rvly_rev->post_title ); ?></strong></td>
                <td><span class="rvly-stars"><?php echo esc_html( str_repeat( '★', $rvly_rating ) ); ?></span></td>
                <td><?php echo esc_html( $rvly_excerpt ); ?></td>
                <td><?php echo esc_html( $rvly_date ); ?></td>
                <td>
                    <?php if ( $status === 'publish' ) : ?>
                        <span class="rvly-badge rvly-badge-green">Published</span>
                    <?php else : ?>
                        <span class="rvly-badge rvly-badge-yellow">Pending</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ( $status === 'pending' ) : ?>
                    <button class="rvly-btn-sm rvly-approve-btn" data-id="<?php echo absint( $rvly_rev->ID ); ?>">✔ Approve</button>
                    <?php endif; ?>
                    <button class="rvly-btn-sm rvly-danger rvly-delete-btn" data-id="<?php echo absint( $rvly_rev->ID ); ?>">🗑 Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

</div>
