@php
    $flasher = app(\App\Support\Flasher::class);
    $envelopes = $flasher->getMessages();

    // Auto-detect Laravel validation errors if no explicit error notification exists
    $hasExplicitError = false;
    foreach ($envelopes as $env) {
        if (($env['type'] ?? '') === 'error') {
            $hasExplicitError = true;
            break;
        }
    }

    if (!$hasExplicitError && isset($errors) && $errors->any()) {
        $errorMessages = $errors->all();
        $envelopes[] = [
            'id' => 'flasher_err_' . uniqid(),
            'type' => 'error',
            'title' => count($errorMessages) > 1 ? 'Validation Errors (' . count($errorMessages) . ')' : 'Validation Error',
            'message' => count($errorMessages) > 1 ? implode('<br>', array_map('e', $errorMessages)) : e($errorMessages[0]),
            'options' => [
                'timeout' => 7000,
                'position' => 'top-right',
                'progressBar' => true,
                'ripple' => true,
            ],
            'theme' => 'theme.google',
            'is_html' => count($errorMessages) > 1,
        ];
    }

    // Final deduplication by normalized message content
    $cleanEnvelopes = [];
    $seen = [];
    foreach ($envelopes as $e) {
        $key = strtolower(trim(strip_tags($e['message'] ?? '')));
        if (!isset($seen[$key]) && $key !== '') {
            $cleanEnvelopes[] = $e;
            $seen[$key] = true;
        }
    }
    $envelopes = $cleanEnvelopes;
@endphp

<!-- PHPFlasher Google Material Design Theme Styles -->
<style id="flasher-material-styles">
    #flasher-material-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 999999;
        display: flex;
        flex-direction: column;
        gap: 12px;
        pointer-events: none;
        max-width: 440px;
        width: calc(100vw - 40px);
        font-family: 'Roboto', 'Google Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .flasher-material-card {
        pointer-events: auto;
        position: relative;
        overflow: hidden;
        background: #FFFFFF;
        border-radius: 16px;
        box-shadow: 0 1px 3px 0 rgba(60,64,67,.3), 0 4px 8px 3px rgba(60,64,67,.15);
        border: 1px solid rgba(0, 0, 0, 0.06);
        display: flex;
        flex-direction: column;
        padding: 0;
        transition: transform 0.25s cubic-bezier(0.4, 0.0, 0.2, 1), box-shadow 0.25s cubic-bezier(0.4, 0.0, 0.2, 1), opacity 0.3s ease, margin 0.3s ease, max-height 0.35s ease;
        animation: flasherGoogleSlideIn 0.35s cubic-bezier(0.0, 0.0, 0.2, 1) forwards;
        max-height: 250px;
    }

    .flasher-material-card:hover {
        box-shadow: 0 2px 6px 0 rgba(60,64,67,.3), 0 8px 16px 4px rgba(60,64,67,.15);
    }

    .flasher-material-card.flasher-dismissing {
        animation: flasherGoogleSlideOut 0.3s cubic-bezier(0.4, 0.0, 1, 1) forwards;
        max-height: 0 !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        opacity: 0 !important;
        pointer-events: none;
    }

    .flasher-material-body {
        display: flex;
        align-items: flex-start;
        padding: 14px 16px;
        gap: 12px;
    }

    .flasher-material-icon-wrap {
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 1px;
    }

    .flasher-material-icon-wrap svg {
        width: 22px;
        height: 22px;
    }

    /* Google Material Colors */
    /* Success: Google Green #0F9D58 */
    .flasher-theme-success .flasher-material-icon-wrap {
        background-color: #E6F4EA;
        color: #0F9D58;
    }
    .flasher-theme-success .flasher-material-progress {
        background: #0F9D58;
    }
    .flasher-theme-success .flasher-material-badge {
        color: #137333;
        background: #E6F4EA;
    }

    /* Error: Google Red #DB4437 */
    .flasher-theme-error .flasher-material-icon-wrap {
        background-color: #FCE8E6;
        color: #DB4437;
    }
    .flasher-theme-error .flasher-material-progress {
        background: #DB4437;
    }
    .flasher-theme-error .flasher-material-badge {
        color: #C5221F;
        background: #FCE8E6;
    }

    /* Warning: Google Amber #F4B400 / #E37400 */
    .flasher-theme-warning .flasher-material-icon-wrap {
        background-color: #FEF7E0;
        color: #E37400;
    }
    .flasher-theme-warning .flasher-material-progress {
        background: #F4B400;
    }
    .flasher-theme-warning .flasher-material-badge {
        color: #B06000;
        background: #FEF7E0;
    }

    /* Info: Google Blue #4285F4 */
    .flasher-theme-info .flasher-material-icon-wrap {
        background-color: #E8F0FE;
        color: #4285F4;
    }
    .flasher-theme-info .flasher-material-progress {
        background: #4285F4;
    }
    .flasher-theme-info .flasher-material-badge {
        color: #1A73E8;
        background: #E8F0FE;
    }

    .flasher-material-content {
        flex: 1;
        min-width: 0;
    }

    .flasher-material-header {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 3px;
    }

    .flasher-material-title {
        font-size: 13.5px;
        font-weight: 600;
        color: #202124;
        line-height: 1.3;
        margin: 0;
    }

    .flasher-material-badge {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 2px 7px;
        border-radius: 10px;
        display: inline-block;
    }


    .flasher-material-message {
        font-size: 12.5px;
        color: #3c4043;
        line-height: 1.45;
        margin: 0;
        word-break: break-word;
    }

    .flasher-material-close {
        flex-shrink: 0;
        background: transparent;
        border: none;
        cursor: pointer;
        color: #5f6368;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s, color 0.2s;
        margin-left: 4px;
        position: relative;
        overflow: hidden;
    }

    .flasher-material-close:hover {
        background-color: rgba(60,64,67,0.08);
        color: #202124;
    }

    .flasher-material-close:active::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(60,64,67,0.18);
        border-radius: 50%;
        animation: flasherRipple 0.3s ease-out;
    }

    .flasher-material-progress-track {
        width: 100%;
        height: 3.5px;
        background: rgba(0, 0, 0, 0.05);
        overflow: hidden;
        position: relative;
    }

    .flasher-material-progress {
        height: 100%;
        width: 100%;
        transform-origin: left;
        animation: flasherLinearProgress var(--flasher-timeout, 5000ms) linear forwards;
    }

    .flasher-material-card:hover .flasher-material-progress {
        animation-play-state: paused;
    }

    @keyframes flasherGoogleSlideIn {
        from {
            transform: translateX(110%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes flasherGoogleSlideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(110%);
            opacity: 0;
        }
    }

    @keyframes flasherLinearProgress {
        from {
            transform: scaleX(1);
        }
        to {
            transform: scaleX(0);
        }
    }

    @keyframes flasherRipple {
        0% { transform: scale(0); opacity: 0.6; }
        100% { transform: scale(1.5); opacity: 0; }
    }
</style>

<!-- Notification Container -->
<div id="flasher-material-container" aria-live="polite" aria-atomic="true"></div>

<script>
(function() {
    // Initial notifications passed from server (PHPFlasher envelopes)
    const serverEnvelopes = @json($envelopes ?? []);
    const activeNotificationKeys = new Set();

    // SVG Icons for Google Material Design
    const materialIcons = {
        success: `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>`,
        error: `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>`,
        warning: `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>`,
        info: `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>`
    };

    const defaultTitles = {
        success: 'Success',
        error: 'Error',
        warning: 'Warning',
        info: 'Information'
    };

    /**
     * Render a Google Material Design Flasher notification
     */
    function renderNotification(item) {
        const container = document.getElementById('flasher-material-container');
        if (!container) return;

        const type = (item.type || 'info').toLowerCase();
        const messageText = item.message || '';
        const rawText = String(messageText).replace(/<[^>]*>?/gm, '').trim().toLowerCase();
        const dedupeKey = `${type}:${rawText}`;

        // Deduplication safeguard: Never show duplicate notifications simultaneously
        if (dedupeKey && activeNotificationKeys.has(dedupeKey)) {
            return;
        }
        activeNotificationKeys.add(dedupeKey);

        const iconSvg = materialIcons[type] || materialIcons.info;
        const titleText = item.title || defaultTitles[type] || 'Notification';
        const isHtml = Boolean(item.is_html);
        const options = item.options || {};
        const timeout = parseInt(options.timeout || 5000, 10);
        const showProgress = options.progressBar !== false;

        const card = document.createElement('div');
        card.className = `flasher-material-card flasher-theme-${type}`;
        card.setAttribute('role', type === 'error' ? 'alert' : 'status');
        card.style.setProperty('--flasher-timeout', `${timeout}ms`);

        card.innerHTML = `
            <div class="flasher-material-body">
                <div class="flasher-material-icon-wrap" aria-hidden="true">
                    ${iconSvg}
                </div>
                <div class="flasher-material-content">
                    <div class="flasher-material-header">
                        <h4 class="flasher-material-title">${escapeHtml(titleText)}</h4>
                        <span class="flasher-material-badge">${escapeHtml(type)}</span>
                    </div>
                    <div class="flasher-material-message">
                        ${isHtml ? messageText : escapeHtml(messageText)}
                    </div>
                </div>
                <button type="button" class="flasher-material-close" aria-label="Close notification">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                </button>
            </div>
            ${showProgress ? `
                <div class="flasher-material-progress-track">
                    <div class="flasher-material-progress"></div>
                </div>
            ` : ''}
        `;

        // Dismiss action
        let dismissTimer = null;
        let remainingTime = timeout;
        let timerStart = Date.now();
        let isHovered = false;

        function dismiss() {
            if (card.classList.contains('flasher-dismissing')) return;
            card.classList.add('flasher-dismissing');
            activeNotificationKeys.delete(dedupeKey);
            setTimeout(() => {
                if (card.parentNode) {
                    card.parentNode.removeChild(card);
                }
            }, 320);
        }

        // Close button click
        const closeBtn = card.querySelector('.flasher-material-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                dismiss();
            });
        }

        // Auto dismiss timer with pause on hover
        if (timeout > 0) {
            function startTimer(duration) {
                timerStart = Date.now();
                dismissTimer = setTimeout(dismiss, duration);
            }

            card.addEventListener('mouseenter', () => {
                isHovered = true;
                clearTimeout(dismissTimer);
                remainingTime -= (Date.now() - timerStart);
            });

            card.addEventListener('mouseleave', () => {
                isHovered = false;
                if (remainingTime > 0) {
                    startTimer(remainingTime);
                } else {
                    dismiss();
                }
            });

            startTimer(timeout);
        }

        container.appendChild(card);
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // Expose client-side flasher API compatible with official PHPFlasher JS
    window.flasher = window.flasher || {};

    let activeTheme = 'theme.google';

    window.flasher.use = function(theme) {
        activeTheme = theme || 'theme.google';
        return window.flasher;
    };

    window.flasher.render = function(envelopes) {
        if (Array.isArray(envelopes)) {
            envelopes.forEach(renderNotification);
        }
    };

    window.flasher.flash = function(type, message, title, options) {
        renderNotification({
            type: type,
            message: message,
            title: title || defaultTitles[type],
            options: Object.assign({ timeout: 5000, theme: activeTheme }, options || {}),
            theme: activeTheme,
        });
    };

    window.flasher.success = function(message, title, options) {
        window.flasher.flash('success', message, title, options);
    };

    window.flasher.error = function(message, title, options) {
        window.flasher.flash('error', message, title, options);
    };

    window.flasher.warning = function(message, title, options) {
        window.flasher.flash('warning', message, title, options);
    };

    window.flasher.info = function(message, title, options) {
        window.flasher.flash('info', message, title, options);
    };

    // Render server envelopes when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            window.flasher.render(serverEnvelopes);
        });
    } else {
        window.flasher.render(serverEnvelopes);
    }
})();
</script>
