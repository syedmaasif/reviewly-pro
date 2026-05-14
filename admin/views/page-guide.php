<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="rvly-wrap">

    <div class="rvly-header">
        <div class="rvly-header-inner">
            <div class="rvly-logo">⭐ Reviewly Pro</div>
            <div class="rvly-version">v<?php echo esc_html( REVIEWLY_VERSION ); ?></div>
        </div>
    </div>

    <div class="rvly-page-title">
        <h1>📖 Plugin Guide</h1>
        <p>Everything you need to know about setting up and using Reviewly Pro.</p>
    </div>

    <!-- Quick Start -->
    <div class="rvly-guide-section">
        <h2>🚀 Quick Start (2 Minutes)</h2>
        <div class="rvly-steps">
            <div class="rvly-step">
                <div class="rvly-step-number">1</div>
                <div class="rvly-step-body">
                    <strong>Choose a UI Theme</strong>
                    <p>Go to <a href="<?php echo esc_url( admin_url('admin.php?page=reviewly-themes') ); ?>">UI Themes</a> and click <em>Activate</em> on whichever style matches your website.</p>
                </div>
            </div>
            <div class="rvly-step">
                <div class="rvly-step-number">2</div>
                <div class="rvly-step-body">
                    <strong>Set Your Fields</strong>
                    <p>Go to <a href="<?php echo esc_url( admin_url('admin.php?page=reviewly-fields') ); ?>">Custom Fields</a> and toggle on the fields you want to collect (name, email, phone, etc.).</p>
                </div>
            </div>
            <div class="rvly-step">
                <div class="rvly-step-number">3</div>
                <div class="rvly-step-body">
                    <strong>Place the Shortcodes</strong>
                    <p>Add <code>[reviewly_form]</code> on any page where you want visitors to submit a review. Add <code>[reviewly_reviews]</code> on the page where you want to display reviews.</p>
                </div>
            </div>
            <div class="rvly-step">
                <div class="rvly-step-number">4</div>
                <div class="rvly-step-body">
                    <strong>Done!</strong>
                    <p>Visit the front end to see the form. New reviews appear in your <a href="<?php echo esc_url( admin_url('admin.php?page=reviewly-pro') ); ?>">Dashboard</a>.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Shortcode Reference -->
    <div class="rvly-guide-section">
        <h2>📋 Shortcode Reference</h2>

        <div class="rvly-sc-block">
            <h3><code>[reviewly_form]</code></h3>
            <p>Displays the review submission form. Place this on your <em>service page</em>, <em>contact page</em>, or any page where you want visitors to leave a review.</p>
            <table class="rvly-guide-table">
                <tr><th>Attribute</th><th>Default</th><th>Description</th></tr>
                <tr><td>(none)</td><td>—</td><td>Uses all settings from the dashboard. No attributes needed.</td></tr>
            </table>
            <div class="rvly-sc-example">
                <label>Copy shortcode:</label>
                <div class="rvly-sc-copy" data-sc="[reviewly_form]">
                    <code>[reviewly_form]</code>
                    <button class="rvly-copy-btn">Copy</button>
                </div>
            </div>
        </div>

        <div class="rvly-sc-block">
            <h3><code>[reviewly_reviews]</code></h3>
            <p>Displays all published reviews in a responsive grid.</p>
            <table class="rvly-guide-table">
                <tr><th>Attribute</th><th>Default</th><th>Description</th></tr>
                <tr><td><code>per_page</code></td><td>12</td><td>How many reviews to show. Use <code>-1</code> for all.</td></tr>
                <tr><td><code>theme</code></td><td>active theme</td><td>Override the theme for this list only. Options: <code>modern</code>, <code>minimal</code>, <code>dark</code>, <code>rounded</code>, <code>corporate</code></td></tr>
                <tr><td><code>rating</code></td><td>0</td><td>Minimum star rating to show. E.g. <code>rating="4"</code> shows 4 and 5 star reviews only.</td></tr>
            </table>
            <div class="rvly-sc-examples-list">
                <div class="rvly-sc-copy" data-sc='[reviewly_reviews]'><code>[reviewly_reviews]</code><button class="rvly-copy-btn">Copy</button></div>
                <div class="rvly-sc-copy" data-sc='[reviewly_reviews per_page="6"]'><code>[reviewly_reviews per_page="6"]</code><button class="rvly-copy-btn">Copy</button></div>
                <div class="rvly-sc-copy" data-sc='[reviewly_reviews theme="dark" rating="4"]'><code>[reviewly_reviews theme="dark" rating="4"]</code><button class="rvly-copy-btn">Copy</button></div>
            </div>
        </div>
    </div>

    <!-- Placement Guide -->
    <div class="rvly-guide-section">
        <h2>📍 Where to Place Shortcodes</h2>
        <div class="rvly-use-cases">
            <div class="rvly-use-case">
                <div class="rvly-uc-icon">🏥</div>
                <div><strong>Hospital / Clinic</strong><br>Form on the <em>Appointment Confirmation</em> page. Display on <em>About Us</em> or <em>Testimonials</em>.</div>
            </div>
            <div class="rvly-use-case">
                <div class="rvly-uc-icon">🛒</div>
                <div><strong>WooCommerce Shop</strong><br>Form on <em>Order Complete</em> page or a dedicated <em>Leave a Review</em> page. Display on the homepage or product pages.</div>
            </div>
            <div class="rvly-use-case">
                <div class="rvly-uc-icon">🔧</div>
                <div><strong>Service Business</strong><br>Form on <em>Contact</em> or <em>After Service</em> page. Display on the <em>Reviews</em> page.</div>
            </div>
            <div class="rvly-use-case">
                <div class="rvly-uc-icon">📝</div>
                <div><strong>Blog</strong><br>Form at the bottom of blog posts using a text widget or block. Display on a <em>What Readers Say</em> page.</div>
            </div>
            <div class="rvly-use-case">
                <div class="rvly-uc-icon">🏨</div>
                <div><strong>Hotel / B&B</strong><br>Form in the <em>Booking Confirmation</em> email as a link. Display on the <em>Rooms</em> page.</div>
            </div>
        </div>
    </div>

    <!-- Elementor Usage -->
    <div class="rvly-guide-section">
        <h2>🧩 Using with Elementor</h2>
        <ol class="rvly-guide-ol">
            <li>Edit your page with Elementor.</li>
            <li>Search for the <strong>Shortcode</strong> widget in the Elementor panel.</li>
            <li>Drag it to where you want the form or reviews grid.</li>
            <li>Paste <code>[reviewly_form]</code> or <code>[reviewly_reviews]</code> into the widget.</li>
            <li>Click <strong>Update</strong>. The form will render correctly on the live page.</li>
        </ol>
        <div class="rvly-notice rvly-notice-info">💡 The plugin's CSS is scoped with unique class names (<code>.rvly-*</code>) so it will <strong>never conflict</strong> with Elementor or your theme styles.</div>
    </div>

    <!-- Privacy & GDPR -->
    <div class="rvly-guide-section">
        <h2>🔒 Privacy & GDPR Tips</h2>
        <ul class="rvly-guide-ul">
            <li>Email and phone fields are marked <strong>private</strong> by default — they are stored in your database but never shown publicly.</li>
            <li>Mention review collection in your <strong>Privacy Policy</strong>.</li>
            <li>Consider turning on <strong>Require Approval</strong> (in Settings) to moderate reviews before they go live.</li>
            <li>You can delete any individual review at any time from the <a href="<?php echo esc_url( admin_url('edit.php?post_type=rvly_review') ); ?>">All Reviews</a> page.</li>
        </ul>
    </div>

    <!-- FAQ -->
    <div class="rvly-guide-section">
        <h2>❓ FAQ</h2>
        <div class="rvly-faq">
            <div class="rvly-faq-item">
                <button class="rvly-faq-q">Can I show the form and reviews on the same page?</button>
                <div class="rvly-faq-a">Yes! Place both shortcodes on the same page — just put the form above or below the list.</div>
            </div>
            <div class="rvly-faq-item">
                <button class="rvly-faq-q">Can I use a different theme for the form and the reviews grid?</button>
                <div class="rvly-faq-a">Yes. The form uses the theme set in UI Themes. The reviews grid accepts a <code>theme=""</code> attribute to override it: <code>[reviewly_reviews theme="dark"]</code>.</div>
            </div>
            <div class="rvly-faq-item">
                <button class="rvly-faq-q">Are reviews stored in the WordPress database?</button>
                <div class="rvly-faq-a">Yes. Each review is a custom post of type <code>rvly_review</code>. You can also view, edit, and delete them from <em>All Reviews</em> in the admin.</div>
            </div>
            <div class="rvly-faq-item">
                <button class="rvly-faq-q">Will this slow down my site?</button>
                <div class="rvly-faq-a">No. CSS and JS only load on pages that actually contain a Reviewly shortcode. Everywhere else, no assets are loaded at all.</div>
            </div>
        </div>
    </div>

</div>
