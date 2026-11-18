<?php

namespace BPTL\Admin;

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( __NAMESPACE__ . '\BPTL_PromoBanner' ) ) {

    class BPTL_PromoBanner {
        const DISMISSED_KEY   = 'bptl_promo_banner_dismissed_permanent';
        const EXPIRATION_DATE = '2026-12-05 23:59:59';

        /** Target landing URL */
        const COUPON_URL      = 'https://bplugins.com/products/b-timeline/pricing/?utm_source=admin&utm_medium=dashboard&utm_campaign=bfcm2026';

        public function __construct() {
            add_action( 'admin_enqueue_scripts',             [ $this, 'enqueue_font' ] );
            add_action( 'admin_notices',                     [ $this, 'render' ] );
            add_action( 'admin_head',                        [ $this, 'enqueue_styles' ] );
            add_action( 'admin_footer',                      [ $this, 'enqueue_scripts' ] );
            add_action( 'wp_ajax_bptl_dismiss_promo_banner', [ $this, 'ajax_dismiss' ] );
        }

        /* ------------------------------------------------------------------ */
        /*  Screen, Expiration, Dismissal & Pro Helpers                       */
        /* ------------------------------------------------------------------ */

        /**
         * Check if the current admin screen is one of the allowed Timeline screens:
         * 1. Help & Demos dashboard (edit.php?post_type=btimeline&page=dashboard)
         * 2. All Timeline list      (edit.php?post_type=btimeline)
         * 3. Add New Timeline       (post-new.php?post_type=btimeline)
         * Nowhere else (strictly excluded on the edit screen post.php).
         */
        private function is_plugin_screen(): bool {
            global $pagenow;
            $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
            // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $page      = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';
            // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $post_type = isset( $_GET['post_type'] ) ? sanitize_key( wp_unslash( $_GET['post_type'] ) ) : '';

            if ( $screen && 'btimeline' === $screen->post_type ) {
                // Screen 1: Help & Demos dashboard
                if ( 'btimeline_page_dashboard' === $screen->id ) {
                    return true;
                }
                // Screen 2: All Timeline list table
                if ( 'edit' === $screen->base && empty( $page ) ) {
                    return true;
                }
                // Screen 3: Add New Timeline
                if ( 'post' === $screen->base && 'add' === $screen->action ) {
                    return true;
                }
                return false;
            }

            // Fallbacks when the screen object is not available
            if ( 'btimeline' !== $post_type ) {
                return false;
            }
            if ( 'edit.php' === $pagenow && ( empty( $page ) || 'dashboard' === $page ) ) {
                return true;
            }
            if ( 'post-new.php' === $pagenow ) {
                return true;
            }

            return false;
        }

        /**
         * Check if current date is past December 5, 2026
         */
        private function is_expired(): bool {
            $expiry_timestamp = strtotime( self::EXPIRATION_DATE );
            $current_time     = time();
            return ( $current_time > $expiry_timestamp );
        }

        /**
         * Check if current user has permanently dismissed the banner
         */
        private function is_dismissed(): bool {
            return (bool) get_user_meta( get_current_user_id(), self::DISMISSED_KEY, true );
        }

        /**
         * Determine if the banner should be omitted
         */
        private function should_skip(): bool {
            // 1. Only show inside allowed Timeline screens
            if ( ! $this->is_plugin_screen() ) {
                return true;
            }

            // 2. Automatically remove after Dec 5, 2026
            if ( $this->is_expired() ) {
                return true;
            }

            // 3. Never display again once dismissed by the user
            if ( $this->is_dismissed() ) {
                return true;
            }

            // 4. Hide when the separate Pro plugin is active (not this free plugin)
            if ( function_exists( 'tlgb_fs' ) && tlgb_fs()->can_use_premium_code() ) {
                return true;
            }
            if ( function_exists( 'is_plugin_active' ) && is_plugin_active( 'timeline-block-block-pro/plugin.php' ) ) {
                return true;
            }

            return false;
        }

        /* ------------------------------------------------------------------ */
        /*  Pro CSS Styles (Design 5)                                         */
        /* ------------------------------------------------------------------ */

        /**
         * Load Montserrat (Google Fonts) only where the banner is shown
         */
        public function enqueue_font(): void {
            if ( $this->should_skip() ) { return; }
            wp_enqueue_style(
                'bptl-promo-montserrat',
                'https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800;900&display=swap',
                [],
                null
            );
        }

        public function enqueue_styles(): void {
            if ( $this->should_skip() ) { return; }
            ?>
            <style id="bptl-promo-banner-css">
            #bptl-promo-banner,
            div#bptl-promo-banner.notice,
            div#bptl-promo-banner.bptl-promo-notice,
            div#bptl-promo-banner.bptl-promo-banner-wrap {
                --bpl-primary:        #146ef5;
                --bpl-primary-hover:  #0d5ecc;
                --bpl-secondary:      #ff7a00;
                --bpl-dark:           #070127;
                --bpl-text:           #1b2e4b;
                --bpl-muted:          #475569;

                background: #ffffff !important;
                border: 1px solid #cbd5e1 !important;
                border-radius: 8px !important;
                box-shadow: 0 3px 12px rgba(7, 1, 39, 0.05) !important;
                display: flex !important;
                align-items: stretch !important;
                min-height: 84px !important;
                overflow: hidden !important;
                position: relative !important;
                top: auto !important;
                left: auto !important;
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                opacity: 1 !important;
                visibility: visible !important;
                margin: 14px 0 20px 0 !important;
                padding: 0 !important;
                font-family: "Montserrat", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif !important;
                box-sizing: border-box !important;
                animation: bptlBannerSlide .3s ease both;
                z-index: 99 !important;
                clear: both !important;
                flex: 0 0 100% !important;
            }
            @keyframes bptlBannerSlide {
                from { opacity: 0; transform: translateY(-6px); }
                to   { opacity: 1; transform: translateY(0); }
            }

            /* Container specific widths and margins */
            #wpbody-content > #bptl-promo-banner {
                width: calc(100% - 20px) !important;
                margin: 14px 20px 16px 0 !important;
            }
            .wrap > #bptl-promo-banner {
                width: 100% !important;
                margin: 14px 0 20px 0 !important;
            }

            /* Left Brand Ribbon Block */
            #bptl-promo-banner * {
                font-family: inherit;
            }
            #bptl-promo-banner .bptl-brand-ribbon {
                position: relative;
                overflow: hidden;
                width: 140px;
                min-width: 140px;
                /* Warm espresso base + orange glow behind the icon */
                background:
                    radial-gradient(circle at 50% 40%, rgba(255, 140, 26, .55) 0%, rgba(255, 122, 0, .18) 32%, rgba(255, 122, 0, 0) 58%),
                    linear-gradient(160deg, #3a1a06 0%, #1f0d03 55%, #0f0601 100%);
                color: #ffffff;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 14px 10px 12px;
                gap: 8px;
                flex-shrink: 0;
                box-shadow: inset -1px 0 0 rgba(255, 122, 0, .35);
            }
            /* Moving light sheen */
            #bptl-promo-banner .bptl-brand-ribbon::after {
                content: "";
                position: absolute;
                top: -50%;
                left: -120%;
                width: 60%;
                height: 200%;
                background: linear-gradient(100deg, rgba(255, 255, 255, 0) 0%, rgba(255, 214, 160, .22) 50%, rgba(255, 255, 255, 0) 100%);
                transform: rotate(18deg);
                animation: bptlSheen 4.5s ease-in-out infinite;
                pointer-events: none;
            }
            @keyframes bptlSheen {
                0%, 55% { left: -120%; }
                100%    { left: 160%; }
            }
            #bptl-promo-banner .bptl-icon-halo {
                position: relative;
                z-index: 1;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 52px;
                height: 52px;
                border-radius: 14px;
            }
            /* Pulsing glow ring */
            #bptl-promo-banner .bptl-icon-halo::before {
                content: "";
                position: absolute;
                inset: -4px;
                border-radius: 16px;
                border: 1.5px solid rgba(255, 170, 80, .7);
                box-shadow: 0 0 14px rgba(255, 122, 0, .55);
                animation: bptlPulse 2.4s ease-out infinite;
            }
            @keyframes bptlPulse {
                0%   { transform: scale(.92); opacity: .95; }
                70%  { transform: scale(1.18); opacity: 0; }
                100% { transform: scale(1.18); opacity: 0; }
            }
            #bptl-promo-banner .bptl-brand-ribbon img {
                position: relative;
                width: 48px;
                height: 48px;
                object-fit: contain;
                filter: drop-shadow(0 0 10px rgba(255, 122, 0, .75)) drop-shadow(0 4px 8px rgba(0, 0, 0, .45));
                transition: transform .25s ease;
            }
            #bptl-promo-banner:hover .bptl-brand-ribbon img {
                transform: scale(1.08) rotate(-3deg);
            }
            #bptl-promo-banner .bptl-brand-ribbon .bptl-ribbon-title {
                position: relative;
                z-index: 1;
                font-family: "Montserrat", sans-serif;
                font-size: 12px;
                font-weight: 900;
                letter-spacing: 1.6px;
                text-transform: uppercase;
                text-align: center;
                line-height: 1.2;
                color: #ffb35c;
                background: linear-gradient(180deg, #fff3e0 0%, #ffc078 55%, #ff8a1f 100%);
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
                text-shadow: 0 0 12px rgba(255, 122, 0, .35);
            }
            @media (prefers-reduced-motion: reduce) {
                #bptl-promo-banner .bptl-brand-ribbon::after,
                #bptl-promo-banner .bptl-icon-halo::before {
                    animation: none;
                }
            }

            /* Main Content Zone */
            #bptl-promo-banner .bptl-content-zone {
                flex: 1;
                padding: 14px 22px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                flex-wrap: wrap;
                background: #ffffff;
            }

            /* Left Stack: Texts & Highlights */
            #bptl-promo-banner .bptl-text-stack {
                display: flex;
                flex-direction: column;
                gap: 5px;
                flex: 1;
                min-width: 290px;
            }

            /* Headline */
            #bptl-promo-banner .bptl-headline {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 10px;
                font-size: 16px;
                font-weight: 800;
                color: var(--bpl-dark);
                line-height: 1.25;
            }

            /* Subheadline */
            #bptl-promo-banner .bptl-subheadline {
                font-size: 12.5px;
                color: var(--bpl-muted);
                line-height: 1.45;
                max-width: 820px;
            }

            /* Micro Feature Chips */
            #bptl-promo-banner .bptl-feature-chips {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 12px;
                margin-top: 4px;
            }
            #bptl-promo-banner .bptl-feature-chips span {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                font-size: 11.5px;
                font-weight: 600;
                color: #334155;
            }
            #bptl-promo-banner .bptl-feature-chips .check-icon {
                color: #10b981;
                font-weight: 800;
            }

            /* Right Action Zone: CTA Button */
            #bptl-promo-banner .bptl-btn-cta {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                padding: 10px 22px;
                background: var(--bpl-primary);
                color: #ffffff !important;
                font-size: 13px;
                font-weight: 700;
                text-decoration: none !important;
                border-radius: 6px;
                white-space: nowrap;
                transition: all .2s ease;
                box-shadow: 0 2px 6px rgba(20, 110, 245, 0.25);
                flex-shrink: 0;
            }
            #bptl-promo-banner .bptl-btn-cta:hover {
                background: var(--bpl-primary-hover);
                transform: translateY(-1px);
                box-shadow: 0 4px 10px rgba(20, 110, 245, 0.35);
            }

            /* Dismiss Close Button */
            #bptl-promo-banner .bptl-banner-dismiss-btn {
                position: absolute;
                top: 8px;
                right: 8px;
                background: transparent;
                border: none;
                color: #94a3b8;
                cursor: pointer;
                font-size: 18px;
                line-height: 1;
                padding: 4px 6px;
                border-radius: 4px;
                transition: color .15s ease;
                z-index: 10;
            }
            #bptl-promo-banner .bptl-banner-dismiss-btn:hover {
                color: var(--bpl-dark);
            }

            /* Responsive */
            @media (max-width: 960px) {
                #bptl-promo-banner .bptl-brand-ribbon {
                    width: 110px;
                    min-width: 110px;
                }
            }
            @media (max-width: 782px) {
                #bptl-promo-banner {
                    flex-direction: column;
                    align-items: stretch;
                }
                #bptl-promo-banner .bptl-brand-ribbon {
                    width: 100%;
                    flex-direction: row;
                    justify-content: flex-start;
                    padding: 8px 16px;
                }
                #bptl-promo-banner .bptl-content-zone {
                    flex-direction: column;
                    align-items: flex-start;
                    padding: 14px 16px;
                }
            }
            </style>
            <?php
        }

        /* ------------------------------------------------------------------ */
        /*  Permanent Dismiss Script (AJAX + Animation)                       */
        /* ------------------------------------------------------------------ */

        public function enqueue_scripts(): void {
            if ( $this->should_skip() ) { return; }
            $dismiss_nonce = wp_create_nonce( 'bptl_dismiss_promo' );
            $ajax_url      = admin_url( 'admin-ajax.php' );
            ?>
            <script id="bptl-promo-banner-js">
            (function () {
                // Ensure banner is always placed at the very top of the content container
                function bptlPositionBannerTop() {
                    var banner = document.getElementById('bptl-promo-banner');
                    if (!banner) return;
                    var wrap = document.querySelector('.wrap') || document.getElementById('wpbody-content');
                    if (wrap && wrap.firstChild !== banner) {
                        wrap.insertBefore(banner, wrap.firstChild);
                    }
                }
                bptlPositionBannerTop();
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', bptlPositionBannerTop);
                }
                window.addEventListener('load', bptlPositionBannerTop);
                setTimeout(bptlPositionBannerTop, 100);
                setTimeout(bptlPositionBannerTop, 500);

                var btn = document.getElementById('bptl-banner-close');
                if (!btn) return;
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var banner = document.getElementById('bptl-promo-banner');
                    if (banner) {
                        banner.style.transition = 'opacity .25s ease, transform .25s ease';
                        banner.style.opacity    = '0';
                        banner.style.transform  = 'translateY(-6px)';
                        setTimeout(function() { banner.remove(); }, 260);
                    }
                    var fd = new FormData();
                    fd.append('action', 'bptl_dismiss_promo_banner');
                    fd.append('nonce',  '<?php echo esc_js( $dismiss_nonce ); ?>');
                    fetch('<?php echo esc_url( $ajax_url ); ?>', {
                        method: 'POST',
                        credentials: 'same-origin',
                        body: fd
                    });
                });
            })();
            </script>
            <?php
        }

        /* ------------------------------------------------------------------ */
        /*  Render Single Banner (Design 5)                                   */
        /* ------------------------------------------------------------------ */

        public function render(): void {
            if ( $this->should_skip() ) { return; }

            $coupon_url = esc_url( self::COUPON_URL );
            $icon_url   = esc_url( BPTL_PLUGIN_DIR . 'public/assets/images/pomo-icon.svg' );
            ?>
            <div id="bptl-promo-banner" class="notice bptl-promo-notice bptl-promo-banner-wrap">

                <!-- Left Asymmetric Brand Ribbon -->
                <div class="bptl-brand-ribbon">
                    <span class="bptl-icon-halo">
                        <img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php esc_attr_e( 'Timeline', 'b-timeline' ); ?>" />
                    </span>
                    <span class="bptl-ribbon-title">Timeline</span>
                </div>

                <!-- Main Content Zone -->
                <div class="bptl-content-zone">
                    <div class="bptl-text-stack">
                        <div class="bptl-headline">
                            <span><?php esc_html_e( 'Timeline Biggest Black Friday Sale is Live – Up to 45% OFF!', 'b-timeline' ); ?></span>
                        </div>
                        <div class="bptl-subheadline">
                            <span><?php esc_html_e( 'Upgrade to Timeline Pro at an exclusive Black Friday price! Unlock a powerful Gutenberg block, 9 extra themes, dynamic post timelines, custom icons, animations, and advanced styling!', 'b-timeline' ); ?></span>
                        </div>
                        <div class="bptl-feature-chips">
                            <span><strong class="check-icon">✓</strong> <?php esc_html_e( '9 Extra Timeline Themes', 'b-timeline' ); ?></span>
                            <span><strong class="check-icon">✓</strong> <?php esc_html_e( 'Dynamic Post & Accordion Timeline', 'b-timeline' ); ?></span>
                            <span><strong class="check-icon">✓</strong> <?php esc_html_e( 'Company History & Roadmap Blocks', 'b-timeline' ); ?></span>
                            <span><strong class="check-icon">✓</strong> <?php esc_html_e( 'Custom Icons & Animations', 'b-timeline' ); ?></span>
                            <span><strong class="check-icon">✓</strong> <?php esc_html_e( 'Advanced Styling & Layout Controls', 'b-timeline' ); ?></span>
                        </div>
                    </div>

                    <!-- CTA Button -->
                    <a href="<?php echo esc_url( $coupon_url ); ?>" target="_blank" rel="noopener noreferrer" class="bptl-btn-cta">
                        <?php esc_html_e( 'Unlock PRO Features →', 'b-timeline' ); ?>
                    </a>
                </div>

                <!-- Dismiss Button -->
                <button id="bptl-banner-close"
                        class="bptl-banner-dismiss-btn"
                        title="<?php esc_attr_e( 'Dismiss', 'b-timeline' ); ?>"
                        aria-label="<?php esc_attr_e( 'Dismiss banner', 'b-timeline' ); ?>">
                    &times;
                </button>

            </div>
            <?php
        }

        /* ------------------------------------------------------------------ */
        /*  AJAX Handler: Permanent Dismissal                                 */
        /* ------------------------------------------------------------------ */

        public function ajax_dismiss(): void {
            check_ajax_referer( 'bptl_dismiss_promo', 'nonce' );
            update_user_meta( get_current_user_id(), self::DISMISSED_KEY, 1 );
            wp_send_json_success();
        }
    }

    new BPTL_PromoBanner();
}
