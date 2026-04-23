/* Reviewly Pro — Admin JS */
(function ($) {
    'use strict';

    /* ========== Colour Picker ========== */
    $(function () {
        $('.rvly-color-picker').wpColorPicker();
    });

    /* ========== Copy shortcode buttons ========== */
    $(document).on('click', '.rvly-copy-btn', function () {
        var sc = $(this).closest('.rvly-sc-copy').data('sc') ||
                 $(this).closest('.rvly-sc-copy').find('code').text();
        if (!sc) return;
        navigator.clipboard.writeText(sc).then(function () {
            /* nothing */ }).catch(function () {
            var el = document.createElement('textarea');
            el.value = sc;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
        });
        var btn = $(this);
        btn.text('Copied!');
        setTimeout(function () { btn.text('Copy'); }, 1500);
    });

    /* ========== Approve / Delete from dashboard ========== */
    $(document).on('click', '.rvly-approve-btn', function () {
        var btn = $(this), id = btn.data('id');
        if (!id) return;
        btn.prop('disabled', true).text('Approving…');
        $.post(rvlyAdmin.ajaxUrl, {
            action: 'rvly_approve_review',
            nonce:  rvlyAdmin.nonce,
            post_id: id
        }, function (res) {
            if (res.success) {
                btn.closest('tr').find('.rvly-badge').replaceWith('<span class="rvly-badge rvly-badge-green">Published</span>');
                btn.remove();
            } else {
                btn.prop('disabled', false).text('✔ Approve');
            }
        });
    });

    $(document).on('click', '.rvly-delete-btn', function () {
        if (!confirm('Delete this review? This cannot be undone.')) return;
        var btn = $(this), id = btn.data('id');
        btn.prop('disabled', true).text('Deleting…');
        $.post(rvlyAdmin.ajaxUrl, {
            action: 'rvly_delete_review',
            nonce:  rvlyAdmin.nonce,
            post_id: id
        }, function (res) {
            if (res.success) {
                btn.closest('tr').fadeOut(300, function () { $(this).remove(); });
            } else {
                btn.prop('disabled', false).text('🗑 Delete');
            }
        });
    });

    /* ========== Themes Page — Activate ========== */
    $(document).on('click', '.rvly-activate-theme', function () {
        var btn   = $(this);
        var theme = btn.data('theme');
        btn.prop('disabled', true).text('Activating…');

        $.post(rvlyAdmin.ajaxUrl, {
            action:        'rvly_save_settings',
            nonce:         rvlyAdmin.nonce,
            active_theme:  theme
        }, function (res) {
            if (res.success) {
                // Update UI
                $('.rvly-theme-card').removeClass('rvly-theme-active');
                $('.rvly-activate-theme').each(function () {
                    $(this).prop('disabled', false).show();
                });
                $('.rvly-active-badge').remove();

                btn.closest('.rvly-theme-card').addClass('rvly-theme-active');
                btn.replaceWith('<span class="rvly-active-badge">✔ Active</span>');

                $('#rvly-theme-saved').show();
                setTimeout(function () { $('#rvly-theme-saved').fadeOut(); }, 2500);
            } else {
                btn.prop('disabled', false).text('Activate');
            }
        });
    });

    /* ========== Fields Page — Toggle inputs ========== */
    $(document).on('change', '.rvly-field-row .rvly-toggle input[type="checkbox"]', function () {
        var row    = $(this).closest('.rvly-field-row');
        var inputs = row.find('.rvly-field-inputs');
        if ($(this).is(':checked')) {
            row.addClass('rvly-field-enabled');
            inputs.removeClass('rvly-hidden').show();
        } else {
            row.removeClass('rvly-field-enabled');
            inputs.addClass('rvly-hidden').hide();
        }
    });

    /* ========== Save Fields ========== */
    $('#rvly-fields-form').on('submit', function (e) {
        e.preventDefault();
        var btn = $('#rvly-save-fields').prop('disabled', true).text('Saving…');
        var formData = $(this).serialize();

        $.post(rvlyAdmin.ajaxUrl, formData + '&action=rvly_save_settings&nonce=' + rvlyAdmin.nonce,
            function (res) {
                btn.prop('disabled', false).text('💾 Save Fields');
                if (res.success) {
                    $('#rvly-fields-saved').show();
                    setTimeout(function () { $('#rvly-fields-saved').fadeOut(); }, 2500);
                }
            }
        );
    });

    /* ========== Save Settings ========== */
    $('#rvly-settings-form').on('submit', function (e) {
        e.preventDefault();
        var btn = $('#rvly-save-settings').prop('disabled', true).text('Saving…');

        // Collect color picker value
        var formData = $(this).serialize();
        var accentColor = $('.rvly-color-picker').val();
        if (accentColor) formData += '&accent_color=' + encodeURIComponent(accentColor);

        $.post(rvlyAdmin.ajaxUrl, formData + '&action=rvly_save_settings&nonce=' + rvlyAdmin.nonce,
            function (res) {
                btn.prop('disabled', false).text('💾 Save Settings');
                if (res.success) {
                    $('#rvly-settings-saved').show();
                    setTimeout(function () { $('#rvly-settings-saved').fadeOut(); }, 2500);
                }
            }
        );
    });

    /* ========== Guide FAQ Accordion ========== */
    $(document).on('click', '.rvly-faq-q', function () {
        var answer = $(this).next('.rvly-faq-a');
        var isOpen = $(this).hasClass('rvly-faq-open');

        // Close all
        $('.rvly-faq-q').removeClass('rvly-faq-open');
        $('.rvly-faq-a').hide();

        if (!isOpen) {
            $(this).addClass('rvly-faq-open');
            answer.slideDown(200);
        }
    });

}(jQuery));
