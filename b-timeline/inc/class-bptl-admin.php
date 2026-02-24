<?php
if(!defined('ABSPATH')) { exit; }

if(!class_exists('BTimelineAdmin')){

    class BTimelineAdmin {

        public function __construct() {
            add_action('init', [__CLASS__,  'register_post_type']);
            if (is_admin()) {
                add_filter('post_row_actions', [__CLASS__, 'remove_row_actions'], 10, 2);
            }
            add_filter('post_updated_messages', [__CLASS__, 'updated_messages']);
            add_action('admin_head-post.php', [__CLASS__, 'hide_publishing_actions']);
            add_action('admin_head-post-new.php', [__CLASS__, 'hide_publishing_actions']);
            add_filter('gettext', [__CLASS__, 'change_publish_button'], 10, 2);
            add_filter('manage_btimeline_posts_columns', [__CLASS__, 'columns_head_only'], 10);
            add_action('manage_btimeline_posts_custom_column', [__CLASS__, 'columns_content_only'], 10, 2);
            add_action('edit_form_after_title', [__CLASS__, 'shortcode_area']);
            
            add_filter('admin_footer_text', [__CLASS__, 'admin_footer']);
            add_action('admin_enqueue_scripts', [__CLASS__, 'admin_style']);
            add_action('admin_menu', [__CLASS__, 'add_help_pages']);
        }

        public static function register_post_type() {

            $isTimelineBlockPro = true;
            if (function_exists('tlgb_fs') && tlgb_fs()->can_use_premium_code()) {
                $isTimelineBlockPro = false;
            }


            $labels = array(
                'name' => __('Timeline', 'b-timeline') ,
                'menu_name' => ((is_plugin_active('timeline-block-block/plugin.php') || is_plugin_active('timeline-block-block-pro/plugin.php')) && $isTimelineBlockPro) ? __('Timeline  - Lagacy', 'b-timeline') : __('Timeline', 'b-timeline'),
                'name_admin_bar' => __('Timeline', 'b-timeline'),
                'add_new' => __('Add New', 'b-timeline'),
                'add_new_item' => __('Add New ', 'b-timeline'),
                'new_item' => __('New Timeline ', 'b-timeline'),
                'edit_item' => __('Edit Timeline ', 'b-timeline'),
                'view_item' => __('View Timeline ', 'b-timeline'),
                'all_items' =>__('All Timeline', 'b-timeline'),
                'not_found' => __('Sorry, we couldn\'t find the Feed you are looking for.')
            );
            $args = array(
                'labels' => $labels,
                'description' => __('Timeline Options.', 'b-timeline'),
                'public' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_icon' => BPTL_PLUGIN_DIR . '/public/assets/images/timeline.png',
                'query_var' => true,
                'rewrite' => array('slug' => 'b-timeline'),
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'menu_position' => 20,
                'supports' => array('title'),
            );
            register_post_type('btimeline', $args);
        }

        public static function remove_row_actions($idtions) {
            global $post;
            if ($post->post_type == 'btimeline') {
                unset($idtions['view']);
                unset($idtions['inline hide-if-no-js']);
            }
            return $idtions;
        }

        public static function hide_publishing_actions() {
            $my_post_type = 'btimeline';
            global $post;
            if ($post->post_type == $my_post_type) {
                echo '
                    <style type="text/css">
                        #misc-publishing-actions,
                        #minor-publishing-actions{
                            display:none;
                        }
                    </style>
                ';
            }
        }

        public static function updated_messages($messages) {
            $messages['btimeline'][1] = __('Timeline Item updated ', 'btimeline');
            return $messages;
        } 

        public static function change_publish_button($translation, $text) {
            if ('btimeline' == get_post_type())
                if ($text == 'Publish')
                    return 'Save';

            return $translation;
        }

        public static function shortcode_area() {
            global $post; 
            if ( $post->post_type === 'btimeline' ) : ?>
                <div class="bptl_shortcode">
                    <code 
                        class="shortcode_copy" 
                        data-code="[btimeline id='<?php echo esc_attr( $post->ID ); ?>']">
                        [btimeline id='<?php echo esc_attr( $post->ID ); ?>']
                    </code>

                    <p class="shortcode_desc">
                        <?php echo esc_html__( "Copy this shortcode and paste it into your post, page, or text widget content.", "bptl" ); ?>
                    </p>
                </div>

                <script>
                    document.addEventListener('click', function (e) {
                        var el = e.target.closest('.shortcode_copy');
                        if (!el) return;

                        navigator.clipboard.writeText(el.dataset.code).then(function () {
                            var original = el.textContent;
                            el.textContent = 'Copied!';

                            setTimeout(function () {
                                el.textContent = original;
                            }, 1000);
                        });
                    });
                </script>
            <?php endif;
        }

        public static function columns_head_only($defaults) {
            unset($defaults['date']);
            $defaults['directors_name'] = 'ShortCode';
            $defaults['date'] = 'Date';
            return $defaults;
        }

        public static function columns_content_only($column_name, $post_ID) {
            if ($column_name == 'directors_name') {
                echo '<div class="bptl_front_shortcode"><input onfocus="this.select();" style="text-align: center; border: none; outline: none; background-color: #1e8cbe; color: #fff; padding: 4px 10px; border-radius: 3px;" value="[btimeline  id=' . "'" . esc_attr($post_ID) . "'" . ']" ></div>';
            }
        }

        public static function admin_style($hook) {
            wp_register_style('bptl-admin-style', BPTL_PLUGIN_DIR . '/public/assets/css/admin-style.css');
            wp_enqueue_style('bptl-admin-style');
        
            if ("btimeline_page_dashboard" === $hook) {
                $asset_file = include BPTL_PLUGIN_PATH . 'build/admin-dashboard.asset.php'; 
                wp_enqueue_script('bptl-admin-dashboard', BPTL_PLUGIN_DIR . '/build/admin-dashboard.js', array_merge($asset_file['dependencies'], ['wp-util']), BPTL_VER, true);
                wp_enqueue_style('bptl-admin-dashboard', BPTL_PLUGIN_DIR . '/build/admin-dashboard.css', [], BPTL_VER);
                wp_set_script_translations('bptl-admin-dashboard', 'b-timeline', BPTL_PLUGIN_DIR . 'languages');
            }
        }

        public static function add_help_pages() {
            add_submenu_page(
                'edit.php?post_type=btimeline', 
                __('Help & Demos', 'b-timeline'), 
                __('Help & Demos', 'b-timeline'),  
                'manage_options',  
                'dashboard',   
                [__CLASS__, 'render_dashboard']   
            );
        }

        public static function render_dashboard() {
            ?>
            <div id="bptlAdminDashboardWrapper"
                data-info='<?php echo esc_attr( wp_json_encode( [
					'version' => BPTL_VER,
					'isPremium' => false,
					'hasPro' => false,
					// 'nonce' => wp_create_nonce( 'apbCreatePage' ),
					// 'licenseActiveNonce' => wp_create_nonce( 'bPlLicenseActivation' )
				] ) ); ?>'
            </div>
            <?php
        }
        
        public static function admin_footer($text) {
            if ('btimeline' === get_post_type()) {
                $url = 'https://wordpress.org/support/plugin/b-timeline/reviews/#new-post';
                $text = sprintf(__('If you like <strong> Timeline </strong> please leave us a <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. Your Review is very important to us as it helps us to grow more. ', 'b-timeline'), $url);
            }
            return $text;
        }


    }

    new BTimelineAdmin();
    
}