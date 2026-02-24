<?php
if (!defined('ABSPATH')) { exit; }

if(!class_exists('BTimeline')){

    class BTimeline {

        public static $_instance = null;
    
        public static function instance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
    
        public function __construct() {
                add_action('init', [__CLASS__, 'init'], 0);
                add_action('plugins_loaded', [__CLASS__, 'load_dependencies']);
                add_action('wp_enqueue_scripts', [__CLASS__, 'btimeline_scripts']);
                add_shortcode('btimeline', [__CLASS__, 'bptl_shortcode']);
                add_action('admin_notices', [__CLASS__, 'upgrade_notice']);
        }
    
        public static function init() {
            if (!class_exists('CSF')) {
                require_once BPTL_PLUGIN_PATH . 'inc/codestar/csf-config.php';
            }
            require_once BPTL_PLUGIN_PATH . 'inc/class-bptl-options.php';
        }
    
        public static function load_dependencies() {
            require_once BPTL_PLUGIN_PATH . '/inc/class-bptl-admin.php';
        }
    
        public static function load_textdomain() {
            load_plugin_textdomain('b-timeline', false, dirname(__FILE__) . "/../languages");
        }
    
        public static function btimeline_scripts() {
            wp_register_script('bptl-timeline', BPTL_PLUGIN_DIR . '/public/assets/js/timeline.min.js', ['jquery'], BPTL_VER, true);
            wp_register_script('bptl-timeline-config', BPTL_PLUGIN_DIR . '/public/assets/js/public.js', ['jquery', 'bptl-timeline'], BPTL_VER, true);
            wp_register_style('timeline-style', BPTL_PLUGIN_DIR . '/public/assets/css/timeline.min.css', NULL, 'v0.0.2', 'all');
        }
    
        public static function bptl_shortcode($atts) {
            extract(shortcode_atts(array(
                'id' => null
            ), $atts));
            
            wp_enqueue_script('bptl-timeline');
            wp_enqueue_script('bptl-timeline-config');
            wp_enqueue_style('timeline-style');
    
    
            ob_start();
            ?>
        
            <!-- Timeline Meta Data -->
            <?php $bptl_datas = get_post_meta($id, '_bptimeline_', true); ?>
        
            <!-- Start Parent Container -->
            <div id="btimeline-<?php echo esc_attr($id); ?>">
                <div class="timeline bp_titleline" data-timeline='<?php echo esc_attr(wp_json_encode($bptl_datas)); ?>'>
                    <div class="timeline__wrap">
                        <div class="timeline__items">
        
                            <?php foreach ($bptl_datas['item_datas'] as $item_data):
        
                                $timeline_label = $item_data['date_label'] ?? 'January';
                                $timeline_desc = $item_data['item_details'] ?? 'Timeline Description';
                                $timeline_position = $item_data['item_position'] ?? '';
                                ?>
        
                                <div class="timeline__item <?php echo esc_attr($timeline_position); ?> fadeIn">
                                    <div class="timeline__item__inner">
                                        <div class="timeline__content__wrap">
                                            <div class="timeline__content">
                                                <p class="title"><?php echo esc_html($timeline_label) ?> </p>
                                                <p><?php echo wp_kses_post($timeline_desc) ?> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div> <!-- End Parent Container -->
            <style>
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline__content {
                    background:
                        <?php echo esc_attr($bptl_datas['item_bg']); ?>
                    ;
                    border:
                        <?php echo esc_attr($bptl_datas['item_border_size']); ?>
                        px solid
                        <?php echo esc_attr($bptl_datas['item_border_color']); ?>
                    ;
        
                }
        
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline__content .title{
                    font-size: <?php echo esc_attr($bptl_datas['item_fontSize']); ?>px;
                    color: <?php echo esc_attr($bptl_datas['item_color']); ?>;
                    font-style: <?php echo esc_attr($bptl_datas['item_fontStyle']); ?>;
                    font-weight: <?php echo esc_attr($bptl_datas['item_fontWeight']); ?>
                }
        
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline__content p {
                    font-size: <?php echo esc_attr($bptl_datas['label_fontSize']); ?> px;
                    color: <?php echo esc_attr($bptl_datas['label_color']); ?>;
                    font-style: <?php echo esc_attr($bptl_datas['label_fontStyle']); ?>;
                    font-weight: <?php echo esc_attr($bptl_datas['lebel_fontWeight']); ?>
                }
        
                /* Timeline Dot */
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline__item::after {
                    background-color: '#fff';
                    border: 5px solid <?php echo esc_attr($bptl_datas['bar_dot_color']); ?>;
                }
        
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline--horizontal .timeline-divider,
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline:not(.timeline--horizontal)::before {
                    background-color: <?php echo esc_attr($bptl_datas['bar_bg_color']); ?>;
                }
        
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline__item--left .timeline__content::before {
                    border-left: 11px solid
                        <?php echo esc_attr($bptl_datas['item_border_color']); ?>
                    ;
                }
        
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline__item--right .timeline__content::before {
                    border-right: 12px solid
                        <?php echo esc_attr($bptl_datas['item_border_color']); ?>
                    ;
                }
        
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline__item--left .timeline__content::after {
                    border-left: 11px solid
                        <?php echo esc_attr($bptl_datas['item_bg']); ?>
                    ;
                }
        
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline__item--right .timeline__content::after {
                    border-right: 12px solid
                        <?php echo esc_attr($bptl_datas['item_bg']); ?>
                    ;
                }
        
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline__item.timeline__item--top .timeline__content::before {
                    border-top: 14px solid
                        <?php echo esc_attr($bptl_datas['item_border_color']); ?>
                        !important;
                }
        
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline__item.timeline__item--bottom .timeline__content::before {
                    border-bottom: 14px solid
                        <?php echo esc_attr($bptl_datas['item_border_color']); ?>
                        !important;
                    border-top: none;
                }
        
                /* Horizontal view */
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline__item.timeline__item--top .timeline__content::after {
                    border-top: 12px solid
                        <?php echo esc_attr($bptl_datas['item_bg']); ?>
                    ;
                }
        
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline__item.timeline__item--bottom .timeline__content::after {
                    border-bottom: 12px solid
                        <?php echo esc_attr($bptl_datas['item_bg']); ?>
                    ;
                    border-top: none;
                }
        
                /* Mobaile view */
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline--mobile .timeline__wrap .timeline__items {
                    height: auto !important;
                }
    
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline--mobile .timeline__item .timeline__content::before {
                    border-left: none;
                    border-right: 12px solid
                        <?php echo esc_attr($bptl_datas['item_border_color']); ?>
                    ;
                }
        
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline--mobile .timeline__item .timeline__content::after {
                    border-left: none;
                    border-right: 12px solid
                        <?php echo esc_attr($bptl_datas['item_bg']); ?>
                    ;
                }
        
                <?php echo '#btimeline-' . esc_attr($id); ?>
                .timeline-nav-button {
                    background-color: #fff;
                    border: 2px solid
                        <?php echo esc_attr($bptl_datas['bar_bg_color']); ?>
                    ;
                }
            </style>
        
            <?php
            return ob_get_clean();
        
        }
    
        public static function activation_redirect() {
            add_option('bptl_do_activation_redirect', true);
        }
    
        public static function do_redirect_to_dashboard() {
            $isTimelineBlockPro = false;
            if (function_exists('tlgb_fs')) {
                $isTimelineBlockPro = tlgb_fs()->can_use_premium_code();
            }
            if (get_option('bptl_do_activation_redirect')) {
                delete_option('bptl_do_activation_redirect');
                if (!is_network_admin() && !isset($_GET['activate-multi'])) {
                    if((is_plugin_active('timeline-block-block/plugin.php') || is_plugin_active('timeline-block-block-pro/plugin.php')) && $isTimelineBlockPro) {
                        wp_safe_redirect(admin_url('edit.php?post_type=timeline_block&page=tlgb-dashboard#/welcome'));
                        exit;
                    }
                    wp_safe_redirect(admin_url('edit.php?post_type=btimeline&page=dashboard#/dashboard'));
                    exit;
                }
            }
        }

        public static function upgrade_notice() {
            $page = get_current_screen();
            $is_timeline_page = ($page->base == 'edit' && $page->post_type == 'btimeline');
            if (($is_timeline_page)) {
            ?>
            <div class="bptl_upgrade_notice <?php echo esc_attr($is_timeline_page ? 'btimeline' : 'settings') ?> ">
                <div class="flex">
                    <img src="<?php echo esc_url(BPTL_PLUGIN_DIR . 'public/assets/images/timeline.png') ?>" alt="Timeline" />
                    <h3>Timeline</h3>
                </div>
                <p>The Timeline Plugin for WordPress, Vertical and Horizontal Timeline Layouts.</p>
                <div>
                    <a href="<?php echo esc_url(admin_url('edit.php?post_type=btimeline&page=dashboard#/pricing')) ?>" class="button button-primary" target="_blank">Upgrade To Pro <svg enable-background="new 0 0 515.283 515.283" height="16" viewBox="0 0 515.283 515.283" width="16" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <g>
                                    <g>
                                        <g>
                                            <path d="m372.149 515.283h-286.268c-22.941 0-44.507-8.934-60.727-25.155s-25.153-37.788-25.153-60.726v-286.268c0-22.94 8.934-44.506 25.154-60.726s37.786-25.154 60.727-25.154h114.507c15.811 0 28.627 12.816 28.627 28.627s-12.816 28.627-28.627 28.627h-114.508c-7.647 0-14.835 2.978-20.241 8.384s-8.385 12.595-8.385 20.242v286.268c0 7.647 2.978 14.835 8.385 20.243 5.406 5.405 12.594 8.384 20.241 8.384h286.267c7.647 0 14.835-2.978 20.242-8.386 5.406-5.406 8.384-12.595 8.384-20.242v-114.506c0-15.811 12.817-28.626 28.628-28.626s28.628 12.816 28.628 28.626v114.507c0 22.94-8.934 44.505-25.155 60.727-16.221 16.22-37.788 25.154-60.726 25.154zm-171.76-171.762c-7.327 0-14.653-2.794-20.242-8.384-11.179-11.179-11.179-29.306 0-40.485l237.397-237.398h-102.648c-15.811 0-28.626-12.816-28.626-28.627s12.815-28.627 28.626-28.627h171.761c3.959 0 7.73.804 11.16 2.257 3.201 1.354 6.207 3.316 8.837 5.887.001.001.001.001.002.002.019.019.038.037.056.056.005.005.012.011.017.016.014.014.03.029.044.044.01.01.019.019.029.029.011.011.023.023.032.032.02.02.042.041.062.062.02.02.042.042.062.062.011.01.023.023.031.032.011.01.019.019.029.029.016.015.03.029.044.045.005.004.012.011.016.016.019.019.038.038.056.057 0 .001.001.001.002.002 2.57 2.632 4.533 5.638 5.886 8.838 1.453 3.43 2.258 7.2 2.258 11.16v171.761c0 15.811-12.817 28.627-28.628 28.627s-28.626-12.816-28.626-28.627v-102.648l-237.4 237.399c-5.585 5.59-12.911 8.383-20.237 8.383z" fill="rgba(255, 255, 255, 1)" />
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg></a>
                </div>
            </div>
        <?php
		}
	}
    }

}

