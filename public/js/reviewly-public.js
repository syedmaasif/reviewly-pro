/* Reviewly Pro — Public JS */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        initForms();
    });

    function initForms() {
        document.querySelectorAll('.rvly-form-wrap').forEach(function (wrap) {
            var rating = 0;
            var stars  = wrap.querySelectorAll('.rvly-star');

            /* ---- Star rating ---- */
            stars.forEach(function (star, idx) {
                star.addEventListener('mouseenter', function () {
                    highlightStars(stars, idx + 1);
                });
                star.addEventListener('mouseleave', function () {
                    highlightStars(stars, rating);
                });
                star.addEventListener('click', function () {
                    rating = parseInt(this.dataset.value, 10);
                    highlightStars(stars, rating);
                });
                star.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        rating = parseInt(this.dataset.value, 10);
                        highlightStars(stars, rating);
                    }
                });
            });

            /* ---- Submit ---- */
            var btn = wrap.querySelector('.rvly-submit-btn');
            if (!btn) return;

            btn.addEventListener('click', function () {
                var errorEl   = wrap.querySelector('.rvly-error-msg');
                var successEl = wrap.querySelector('.rvly-success-msg');
                var msgEl     = wrap.querySelector('.rvly-success-text');

                errorEl.style.display = 'none';

                // Collect fields
                var body = new URLSearchParams();
                body.append('action',     'rvly_submit_review');
                body.append('rvly_nonce', rvlyData.nonce);
                body.append('rvly_rating', String(rating));

                var fieldIds = ['rvly_name','rvly_email','rvly_phone','rvly_review','rvly_website','rvly_occupation','rvly_location'];
                fieldIds.forEach(function (id) {
                    var el = wrap.querySelector('#' + id);
                    if (el) body.append(id, el.value.trim());
                });

                var rec = wrap.querySelector('input[name="rvly_recommend"]:checked');
                if (rec) body.append('rvly_recommend', rec.value);

                // Validate
                var reviewEl = wrap.querySelector('#rvly_review');
                if (!rating) {
                    showError(errorEl, 'Please select a star rating.');
                    return;
                }
                if (reviewEl && !reviewEl.value.trim()) {
                    showError(errorEl, 'Please write your review.');
                    return;
                }

                // Send
                btn.disabled = true;
                btn.textContent = 'Submitting…';

                fetch(rvlyData.ajaxUrl, {
                    method:  'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body:    body.toString()
                })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    btn.disabled    = false;
                    btn.textContent = 'Submit Review';

                    if (data.success) {
                        // Hide form fields, show success
                        wrap.querySelectorAll('.rvly-star-row, .rvly-field-group, .rvly-submit-btn').forEach(function (el) {
                            el.style.display = 'none';
                        });
                        if (msgEl) msgEl.textContent = data.data.message || 'Thank you!';
                        successEl.style.display = 'block';

                        // Redirect if set
                        if (data.data.redirect) {
                            setTimeout(function () {
                                window.location.href = data.data.redirect;
                            }, 2000);
                        }
                    } else {
                        showError(errorEl, (data.data && data.data.message) ? data.data.message : 'Something went wrong. Please try again.');
                    }
                })
                .catch(function () {
                    btn.disabled    = false;
                    btn.textContent = 'Submit Review';
                    showError(errorEl, 'Connection error. Please check your network and try again.');
                });
            });
        });
    }

    function highlightStars(stars, count) {
        stars.forEach(function (star, idx) {
            if (idx < count) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
    }

    function showError(el, msg) {
        el.textContent    = msg;
        el.style.display  = 'block';
        el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

}());
