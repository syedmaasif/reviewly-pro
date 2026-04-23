=== Reviewly Pro ===
Contributors: yourusername
Tags: reviews, testimonials, star rating, review form, custom fields
Requires at least: 5.8
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A fully customizable review collection plugin with 5 UI themes, custom fields, and a powerful dashboard. Works on any WordPress site.

== Description ==

**Reviewly Pro** lets you collect, manage, and display customer reviews on any WordPress website with zero coding.

= Key Features =

* **5 beautiful UI themes** — Modern Card, Minimal Flat, Dark Glass, Soft Bubbly, Corporate Pro
* **Custom Fields builder** — toggle Name, Email, Phone, Website, Job, Location, Recommend fields on/off. Set your own labels and placeholders.
* **Privacy controls** — mark sensitive fields (phone, email) as private so they are saved in your dashboard but never shown publicly
* **Require approval** — moderate reviews before they go live
* **Accent colour picker** — match any brand colour
* **Shortcode-based** — works with Elementor, Gutenberg, Divi, and any page builder
* **Zero CSS conflicts** — all styles scoped to `.rvly-*` class names
* **Assets only load when needed** — no impact on page speed elsewhere
* **Full in-dashboard guide** — step-by-step instructions and shortcode reference

= Shortcodes =

`[reviewly_form]` — display the review submission form
`[reviewly_reviews]` — display the reviews grid

Optional attributes for the reviews shortcode:
* `per_page` — number of reviews to show (default 12, use -1 for all)
* `theme` — override theme: modern | minimal | dark | rounded | corporate
* `rating` — minimum star rating filter (e.g. rating="4")

= Use Cases =

Works on service businesses, hospitals & clinics, WooCommerce shops, hotels, blogs, portfolios, and more.

== Installation ==

1. Upload the `reviewly-pro` folder to `/wp-content/plugins/`
   **or** upload the ZIP directly via WordPress Admin → Plugins → Add New → Upload Plugin
2. Activate the plugin from the Plugins menu
3. Go to **Reviewly Pro** in your WordPress admin menu
4. Choose a UI theme, configure your fields, and paste the shortcodes on your pages

== Frequently Asked Questions ==

= Does this work with Elementor? =
Yes. Use the Elementor Shortcode widget and paste `[reviewly_form]` or `[reviewly_reviews]`.

= Does it conflict with my theme or Elementor? =
No. All CSS class names are prefixed with `.rvly-` and scripts only load on pages containing a Reviewly shortcode.

= Can I moderate reviews before they go live? =
Yes. Go to Reviewly Pro → Settings and enable "Require Approval".

= Are private fields ever shown publicly? =
No. Fields marked as private (e.g. email, phone) are stored in your database and visible only in your admin dashboard.

== Screenshots ==

1. Dashboard overview with stats and recent reviews
2. UI Themes selection page
3. Custom Fields builder
4. Front-end review form (Modern theme)
5. Front-end reviews grid (Dark theme)

== Changelog ==

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.0 =
Initial release.
