<?php if (!defined('ABSPATH')) {
  die;
} // Cannot access directly.

//
// Metabox of the PAGE
// Set a unique slug-like ID
//
$prefix = '_bptimeline_';

//
// Create a metabox
//
// The Live Preview metabox below has to sit under this one. WordPress renders
// the `normal` context before `advanced`, so both boxes are placed in the same
// context and ordered by priority instead.
CSF::createMetabox($prefix, array(
  'title' => 'Timeline Configuration',
  'post_type' => 'btimeline',
  'context'   => 'normal',
  'priority'  => 'high',
  'show_restore' => true,
  'theme' => 'light'
));
//
// Premium Templates & Features Sidebar Metabox
//
$premium_prefix = '_bptimeline_premium_';

CSF::createMetabox($premium_prefix, array(
  'title'    => 'What\'s New in PRO ',
  'post_type' => 'btimeline',
  'context'   => 'side',
  'priority'  => 'high',
  'theme'     => 'light'
));

CSF::createSection($premium_prefix, array(
  'fields' => array(
    array(
      'type'    => 'content',
      'content' => '
        <div class="bptl-premium-sidebar">
          <style>
            .bptl-premium-sidebar ul li.theme-preview {
              position: relative;
            }
            .bptl-premium-sidebar .li-flex {
              display: flex;
              align-items: center;
              justify-content: space-between;
              width: 100%;
            }
            .bptl-premium-sidebar .preview-icon {
              color: #2271b1;
              cursor: help;
              font-size: 14px;
              margin-left: 5px;
              transition: transform 0.2s;
            }
            .bptl-premium-sidebar .theme-preview:hover .preview-icon {
              transform: scale(1.2);
            }
            .bptl-premium-sidebar .preview-popup {
              display: none;
              position: absolute;
              right: 110%;
              top: -50px;
              width:  500px;
              background: #fff;
              border: 2px solid #2271b1;
              border-radius: 8px;
              padding: 5px;
              box-shadow: 0 10px 30px rgba(0,0,0,0.2);
              z-index: 99999;
              pointer-events: none;
              animation: bptlFadeIn 0.3s ease;
            }
            .bptl-premium-sidebar .preview-popup img {
              width: 100%;
              height: auto;
              border-radius: 4px;
              display: block;
            }
            .bptl-premium-sidebar .theme-preview:hover .preview-popup {
              display: block;
            }
            @keyframes bptlFadeIn {
              from { opacity: 0; transform: translateX(10px); }
              to { opacity: 1; transform: translateX(0); }
            }
              .bptl-premium-sidebar .image-hover-wrapper {
              position: relative;
              cursor: zoom-in;
            }
            .bptl-premium-sidebar .image-preview-popup {
              display: none;
              position: absolute;
              right: 110%;
              top: -100px;
              width: 1000px;
              background: #fff;
              border: 2px solid #2271b1;
              border-radius: 8px;
              padding: 5px;
              box-shadow: 0 10px 40px rgba(0,0,0,0.3);
              z-index: 999999;
              pointer-events: none;
              animation: bptlFadeIn 0.3s ease;
            }
            .bptl-premium-sidebar .image-preview-popup img {
              width: 100%;
              height: auto;
              border-radius: 4px;
              display: block;
            }
            .bptl-premium-sidebar .image-hover-wrapper:hover .image-preview-popup {
              display: block;
            }
            @keyframes bptlFadeIn {
              from { opacity: 0; transform: translateX(10px); }
              to { opacity: 1; transform: translateX(0); }
            }
          </style>
          <p style="font-size: 14px; font-weight: 500;">Upgrade to <strong style="color: #2271b1;">Timeline Pro</strong> for advanced features:</p>
         <div class="image-hover-wrapper">
            <img src="' . BPTL_PLUGIN_DIR . 'public/assets/images/all-templeted-image.webp" alt="Premium Features" class="parent-image" style="width: 100%; height: auto; border-radius: 8px; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: block;"/>
            <div class="image-preview-popup">
              <img src="' . BPTL_PLUGIN_DIR . 'public/assets/images/all-templeted-image.webp" alt="Premium Features Preview" />
            </div>
          </div>
          <ul style="list-style: disc; padding-left: 20px; margin-bottom: 15px; font-size: 13px; line-height: 1.6; font-weight: 500;">
            <li>Powerful Timeline Gutenberg Block</li>
            <li>
              9+ Extra Premium Themes
              <ul style="list-style: circle; padding-left: 20px; margin-top: 8px; margin-bottom: 10px;">
                <li class="theme-preview">
                  <div class="li-flex">
                    <span>Theme 2</span>
                    <span class="preview-icon"><i class="fas fa-eye"></i></span>
                  </div>
                  <div class="preview-popup">
                    <img src="https://ps.w.org/b-timeline/assets/screenshot-4.png" alt="Theme 2 Preview" />
                  </div>
                </li>
                <li class="theme-preview">
                  <div class="li-flex">
                    <span> Theme 3</span>
                    <span class="preview-icon"><i class="fas fa-eye"></i></span>
                  </div>
                  <div class="preview-popup">
                    <img src="https://ps.w.org/b-timeline/assets/screenshot-5.png" alt="Theme 3 Preview" />
                  </div>
                </li>
                <li class="theme-preview">
                  <div class="li-flex">
                    <span> Theme 4</span>
                    <span class="preview-icon"><i class="fas fa-eye"></i></span>
                  </div>
                  <div class="preview-popup">
                    <img src="https://ps.w.org/b-timeline/assets/screenshot-6.png" alt="Theme 4 Preview" />
                  </div>
                </li>
                <li class="theme-preview">
                  <div class="li-flex">
                    <span> Theme 5</span>
                    <span class="preview-icon"><i class="fas fa-eye"></i></span>
                  </div>
                  <div class="preview-popup">
                    <img src="https://ps.w.org/b-timeline/assets/screenshot-7.png" alt="Theme 5 Preview" />
                  </div>
                </li>
                <li class="theme-preview">
                  <div class="li-flex">
                    <span> Theme 6</span>
                    <span class="preview-icon"><i class="fas fa-eye"></i></span>
                  </div>
                  <div class="preview-popup">
                    <img src="https://ps.w.org/b-timeline/assets/screenshot-8.png" alt="Theme 6 Preview" />
                  </div>
                </li>
                <li class="theme-preview">
                  <div class="li-flex">
                    <span> Theme 7</span>
                    <span class="preview-icon"><i class="fas fa-eye"></i></span>
                  </div>
                  <div class="preview-popup">
                    <img src="https://ps.w.org/b-timeline/assets/screenshot-9.png" alt="Theme 7 Preview" />
                  </div>
                </li>
                <li class="theme-preview">
                  <div class="li-flex">
                    <span> Theme 8</span>
                    <span class="preview-icon"><i class="fas fa-eye"></i></span>
                  </div>
                  <div class="preview-popup">
                    <img src="https://ps.w.org/b-timeline/assets/screenshot-10.png" alt="Theme 8 Preview" />
                  </div>
                </li>
                <li class="theme-preview">
                  <div class="li-flex">
                    <span> Theme 9</span>
                    <span class="preview-icon"><i class="fas fa-eye"></i></span>
                  </div>
                  <div class="preview-popup">
                    <img src="https://ps.w.org/b-timeline/assets/screenshot-11.png" alt="Theme 9 Preview" />
                  </div>
                </li>
                <li class="theme-preview">
                  <div class="li-flex">
                    <span> Theme 10</span>
                    <span class="preview-icon"><i class="fas fa-eye"></i></span>
                  </div>
                  <div class="preview-popup">
                    <img src="https://ps.w.org/b-timeline/assets/screenshot-12.png" alt="Theme 10 Preview" />
                  </div>
                </li>
              </ul>
            </li>
            <li>Classic Editor for Descriptions</li>
            <li>Customizable Timeline Icons</li>
            <li>Advanced Styling, Colors & Typography</li>
            <li>Animations with speed, delay & direction control</li>
            <li>Paste the shortcode above into Elementor, Divi, Bricks, WPBakery, Beaver Builder, Oxygen, Breakdance or any other builder.</li>     
          </ul>
        </div> 
      '
    ),
    array(
      'type'    => 'content', 
      'content' => '
        <div class="bptl-premium-sidebar">
          <a href="edit.php?post_type=btimeline&page=dashboard#/demos" target="_blank" rel="noopener noreferrer" class="button button-primary button-large"  style="width: 100%; text-align: center; display: block; background: #2271b1; border-color: #2271b1;">View Demos</a>
          <a href="edit.php?post_type=btimeline&page=dashboard#/pricing" target="_blank" rel="noopener noreferrer" class="button button-primary button-large"  style="width: 100%; margin-top: 10px; text-align: center; display: block; background: #2271b1; border-color: #2271b1;">Upgrade to Pro Now</a>
        </div>
      '
    ),
  )
));


//
// Create a section
//
CSF::createSection($prefix, array(
  'title' => 'Timeline Settings',
  'icon' => 'fas fa-cog',
  'fields' => array(
    // Fields
    array(
      'id' => 'timeline_type',
      'title' => 'Timeline Type',
      'type' => 'button_set',
      'subtitle' => 'Determines the structure of the Timeline.',
      'desc' => 'Choose the Style of the Timeline.',
      'options' => array(
        'vertical' => 'Vertical',
        'horizontal' => 'Horizontal',
      ),
      'default' => 'vertical'
    ),
    array(
      'id' => 'content_position',
      'title' => 'Content Position',
      'type' => 'button_set',
      // 'subtitle' => 'Determines the structure of the Timeline.',
      'desc' => "Choose 'Start' to display the timeline at the top (horizontal) or left (vertical), and choose 'End' to display the timeline at the bottom (horizontal) or right (vertical).",
      'options' => array(
        'default' => 'Default',
        'start' => 'Start',
        'end' => 'End',
      ),
      'default' => 'start'
    ),
    array(
      'id' => 'date_location',
      'title' => 'Label / Date Location',
      'type' => 'button_set',
      'subtitle' => 'Sets the location of the timeline dates. Top and bottom are only used in horizontal position. Also left and right are only used vertical position',
      'desc' => 'Choose location of the timeline dates / Labels.',
      'options' => array(
        'bottom' => 'Bottom',
        'top' => 'Top',
        'left' => 'Left',
        'right' => 'Right'
      ),
      'default' => 'right',
    ),
    array(
      'id' => 'item_datas',
      'type' => 'group',
      'title' =>  'Timeline Data ', 
      'subtitle' => 'Input Your Timeline Data', 
      'button_title' => 'Add New Data',
      'fields' => array(
        array(
          'id' => 'date_label',
          'title' => 'Label',
          'type' => 'text',
          'desc' => 'Use Year, Month, Day etc Name As Label. Ex:- ( \'2020\', \'Jan\', \'sun\' )',
          'default' => 'Jan'
        ),
        array(
          'id' => 'item_details',
          'title' => 'Details',
          'type' => 'wp_editor',
          'desc' => 'Write / Input Details About Story Here',
          'tinymce' => true,
          'quicktags' => true,
          'media_buttons' => true,
          'height' => '100px',
        ),
      )
    ), // End of Timeline Data
    array(
      'id' => 'start_item',
      'title' => 'Startup Index',
      'type' => 'spinner',
      'subtitle' => 'When using the timeline in horizontal mode, define which item the timeline should start at.',
      'desc' => 'Choose Startup Item of the Timeline. Input Number ',
      'default' => '0',
      'dependency' => array(
        array('timeline_type', '==', 'horizontal'),
      ),
    ),
    array(
      'id' => 'move_item',
      'title' => 'Move Item',
      'type' => 'spinner',
      'subtitle' => 'When using the timeline in horizontal mode, define how many items to move when clicking a navigation button.',
      'desc' => 'Choose Move Item of the Timeline.',
      'default' => '1',
      'dependency' => array(
        array('timeline_type', '==', 'horizontal'),
      ),
    ),
    array(
      'id' => 'visible_items',
      'type' => 'spinner',
      'title' => 'Visible Items',
      'subtitle' => 'If using the timeline in horizontal mode, define how many items are visible in the viewport',
      'desc' => 'Choose Display items to show',
      'default' => '3',
      'dependency' => array(
        array('timeline_type', '==', 'horizontal'),
      ),
    ),
    array(
      'id' => 'vertica_trigger',
      'type' => 'spinner',
      'title' => 'Vertical Trigger',
      'subtitle' => 'When using the timeline in vertical mode, define the distance from the bottom of the screen, in percent or pixels, that the items slide into view',
      'desc' => 'Choose distance from the bottom of the screen,',
      'unit' => '%',
      'default' => '15',
      'dependency' => array(
        array('timeline_type', '==', 'vertical'),
      ),

    ),
    array(
      'id' => 'rtl_mode',
      'type' => 'switcher',
      'title' => 'RTL Mode',
      'subtitle' => 'When using the timeline in horizontal mode, RTL defines whether the timeline should start from the right. This overrides the startIndex setting.',
      'desc' => 'Do you want activate it ?',
      'text_on' => 'Yes',
      'text_off' => 'No',
      'default' => false,
      'dependency' => array(
        array('timeline_type', '==', 'horizontal'),
      ),
    )
  )

));
CSF::createSection($prefix, array(
  'title' => 'Styles & Typography',
  'icon' => 'fas fa-palette',
  'fields' => array(
    array(
      'type' => 'notice',
      'style' => 'success',
      'content' => 'Style & Typography Options : ',
      'class' => 'tm_option_title',
    ),
    array(
      'id' => 'bar_bg_color',
      'type' => 'color',
      'title' => 'Bar Background',
      'subtitle' => 'Set Timeline Bar Background Color',
      'desc' => 'Choose Bar Background Color',
      'default' => '#dddddd',
    ),
    array(
      'id' => 'bar_dot_color',
      'type' => 'color',
      'title' => 'Bar Dot Color',
      'subtitle' => 'Set Timeline Bar Dot Color',
      'desc' => 'Choose Dot Color',
      'default' => '#ddd',
    ),
    array(
      'id' => 'item_bg',
      'type' => 'color',
      'title' => 'Item Background',
      'subtitle' => 'Set Timeline Item Background Color',
      'desc' => 'Choose Background Color',
      'default' => '#ffffff'
    ),
    array(
      'id' => 'item_color',
      'type' => 'color',
      'title' => 'Item Color',
      'subtitle' => 'Set Timeline Item Content / Text Color',
      'desc' => 'Choose Font Color',
      'default' => '#333333'
    ),
    array(
      'id' => 'item_fontWeight',
      'type' => 'button_set',
      'title' => 'Font Weight',
      'subtitle' => 'Set Item Font Weight',
      'desc' => 'Choose Font Weight',
      'options' => array(
        'normal' => 'Normal',
        'bold' => 'Bold',
      ),
      'default' => 'normal',
    ),
    array(
      'id' => 'item_fontStyle',
      'type' => 'button_set',
      'title' => 'Font Style',
      'subtitle' => 'Set Content Font Style',
      'desc' => 'Choose Font Style',
      'options' => array(
        'normal' => 'Normal',
        'italic' => 'Italic',
      ),
      'default' => 'normal',
    ),
    array(
      'id' => 'item_fontSize',
      'type' => 'spinner',
      'title' => 'Font-Size',
      'subtitle' => 'Set Content Font-Size',
      'desc' => 'Choose Font Size',
      'unit' => 'PX',
      'default' => '14'
    ),
    array(
      'id' => 'item_border_size',
      'type' => 'spinner',
      'title' => 'Item Border',
      'subtitle' => 'Set Timeline Item Border Size',
      'desc' => 'Choose Border Size',
      'unit' => 'PX',
      'default' => '1',
    ),
    array(
      'id' => 'item_border_color',
      'type' => 'color',
      'title' => 'Item Border Color',
      'subtitle' => 'Set Timeline Item Border Color',
      'desc' => 'Choose Border Color',
      'default' => '#cccccc',
    ),
    array(
      'id' => 'label_fontSize',
      'type' => 'spinner',
      'title' => 'label / Title Font-Size',
      'subtitle' => 'Set Label Font-Size',
      'desc' => 'Choose Label Font Size',
      'unit' => 'PX',
      'default' => '16'
    ),
    array(
      'id' => 'lebel_fontWeight',
      'type' => 'button_set',
      'title' => 'Font Weight',
      'subtitle' => 'Set label / Title Font Weight',
      'desc' => 'Choose Font Weight',
      'options' => array(
        'normal' => 'Normal',
        'bold' => 'Bold',
      ),
      'default' => 'normal',
    ),
    array(
      'id' => 'label_fontStyle',
      'type' => 'button_set',
      'title' => 'Font Style',
      'subtitle' => 'Set label / Title Font Style',
      'desc' => 'Choose Font Style',
      'options' => array(
        'normal' => 'Normal',
        'italic' => 'Italic',
      ),
      'default' => 'normal',
    ),
    array(
      'id' => 'label_color',
      'type' => 'color',
      'title' => 'label / Title Color',
      'subtitle' => 'Set Label Font Color',
      'desc' => 'Choose Label Font Color',
      'default' => '#222222'
    ),
  )
));

/**
 * Helper function to output Live Preview UI HTML
 */
if (!function_exists('bptl_get_live_preview_html')) {
  function bptl_get_live_preview_html() {
    $post_id = isset($_GET['post']) ? intval($_GET['post']) : (isset($_POST['post_ID']) ? intval($_POST['post_ID']) : 0);
    $preview_url = add_query_arg(['action' => 'bptl_live_preview', 'post_id' => $post_id], admin_url('admin-ajax.php'));

    ob_start();
    ?>
    <div class="bptl-live-preview-wrapper" id="bptlLivePreviewWrapper">
      <style>
        .bptl-preview-bar {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 10px 16px;
          background: #f8f9fa;
          border: 1px solid #c3c4c7;
          border-bottom: none;
          border-radius: 0;
        }
        .bptl-preview-status {
          font-size: 13px;
          color: #50575e;
          display: flex;
          align-items: center;
          gap: 8px;
          font-weight: 500;
        }
        .bptl-preview-status .status-dot {
          width: 8px;
          height: 8px;
          border-radius: 50%;
          background: #00a32a;
          display: inline-block;
          transition: background 0.3s ease;
        }
        .bptl-preview-controls {
          display: flex;
          align-items: center;
          gap: 10px;
        }
        .bptl-device-btn-group {
          display: inline-flex;
          border: 1px solid #8c8f94;
          border-radius: 0;
          overflow: hidden;
          background: #fff;
        }
        .bptl-device-btn {
          background: #fff;
          border: none;
          border-right: 1px solid #c3c4c7;
          border-radius: 0;
          padding: 6px 14px;
          font-size: 12px;
          font-weight: 600;
          color: #2c3338;
          cursor: pointer;
          transition: all 0.2s ease;
        }
        .bptl-device-btn:last-child {
          border-right: none;
        }
        .bptl-device-btn:hover {
          background: #f0f0f1;
        }
        .bptl-device-btn.active {
          background: #2271b1 !important;
          color: #fff !important;
        }
        .bptl-btn-action {
          background: #f6f7f7;
          border: 1px solid #8c8f94;
          color: #2271b1;
          padding: 6px 14px;
          border-radius: 0;
          font-size: 12px;
          font-weight: 600;
          cursor: pointer;
          display: inline-flex;
          align-items: center;
          gap: 5px;
          text-decoration: none;
          transition: all 0.2s ease;
        }
        .bptl-btn-action:hover {
          background: #f0f0f1;
          border-color: #2271b1;
          color: #135e96;
        }
        .bptl-iframe-container {
          background: #2b2b2b;
          border: 1px solid #c3c4c7;
          border-radius: 0;
          padding: 24px 20px;
          position: relative;
          min-height: 420px;
          display: flex;
          justify-content: center;
          box-shadow: inset 0 2px 6px rgba(0,0,0,0.25);
        }
        .bptl-iframe-wrapper {
          width: 100% !important;
          max-width: 100%;
          margin: 0 auto;
          background: #ffffff;
          border-radius: 0;
          box-shadow: 0 10px 30px rgba(0,0,0,0.35);
          transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
          overflow: hidden;
          position: relative;
        }
        .bptl-iframe-wrapper.desktop {
          width: 100% !important;
        }
        .bptl-iframe-wrapper.tablet {
          width: 768px !important;
          max-width: 100%;
        }
        .bptl-iframe-wrapper.mobile {
          width: 375px !important;
          max-width: 100%;
        }
        .bptl-iframe-wrapper iframe {
          width: 100%;
          height: 480px !important;
          border: none;
          border-radius: 0;
          display: block;
        }
        .bptl-iframe-actions {
          position: absolute;
          top: 12px;
          right: 12px;
          z-index: 10;
          display: flex;
          gap: 6px;
        }
        .bptl-iframe-action-btn {
          background: rgba(0,0,0,0.75);
          color: #fff;
          border: 1px solid rgba(255,255,255,0.25);
          border-radius: 0;
          padding: 5px 10px;
          font-size: 11px;
          font-weight: 500;
          cursor: pointer;
          text-decoration: none;
          display: inline-flex;
          align-items: center;
          gap: 5px;
          transition: background 0.2s;
        }
        .bptl-iframe-action-btn:hover {
          background: rgba(0,0,0,0.9);
          color: #64b5f6;
        }
        .bptl-preview-notice-footer {
          padding: 10px 16px;
          background: #f0f6fc;
          border: 1px solid #c3c4c7;
          border-top: none;
          border-radius: 0;
          font-size: 12px;
          color: #1d2327;
          display: flex;
          align-items: center;
          gap: 6px;
          font-weight: 400;
        }
      </style>

      <div class="bptl-preview-bar">
        <div class="bptl-preview-status">
          <span class="status-dot"></span>
          <span class="status-text">Preview up to date</span>
        </div>
        <div class="bptl-preview-controls">
          <div class="bptl-device-btn-group">
            <button type="button" class="bptl-device-btn active" data-device="desktop">Desktop</button>
            <button type="button" class="bptl-device-btn" data-device="tablet">Tablet</button>
            <button type="button" class="bptl-device-btn" data-device="mobile">Mobile</button>
          </div>
          <button type="button" class="bptl-btn-action" id="bptlRefreshPreview">
            <span class="dashicons dashicons-update" style="font-size:14px; width:14px; height:14px; margin-top:2px;"></span> Refresh
          </button>
        </div>
      </div>

      <div class="bptl-iframe-container">
        <div class="bptl-iframe-wrapper desktop" id="bptlPreviewFrameWrapper">
          <div class="bptl-iframe-actions">
            <a href="<?php echo esc_url($preview_url); ?>" target="_blank" class="bptl-iframe-action-btn" title="Open preview in new tab">
              <span class="dashicons dashicons-external" style="font-size:12px; width:12px; height:12px; margin-top:2px;"></span> Fullscreen
            </a>
          </div>
          <iframe id="bptlPreviewIframe" src="<?php echo esc_url($preview_url); ?>"></iframe>
        </div>
      </div>

      <div class="bptl-preview-notice-footer">
        <span class="dashicons dashicons-info" style="font-size:15px; width:15px; height:15px; color:#2271b1;"></span>
        <?php esc_html_e('Unsaved settings are shown here as visitors would see them. Nothing is saved until you press Update.', 'b-timeline'); ?>
      </div>

      <script>
        jQuery(document).ready(function($){
          // Event delegation for device buttons
          $(document).on('click', '.bptl-device-btn', function(e){
            e.preventDefault();
            $('.bptl-device-btn').removeClass('active');
            $(this).addClass('active');
            var device = $(this).attr('data-device');
            $('#bptlPreviewFrameWrapper').removeClass('desktop tablet mobile').addClass(device);
          });

          // Live real-time preview sync (without saving)
          var livePreviewTimer = null;
          function triggerRealtimePreview() {
            clearTimeout(livePreviewTimer);
            $('.bptl-preview-status .status-text').text('Updating live preview...');
            $('.bptl-preview-status .status-dot').css('background', '#f0b840');

            livePreviewTimer = setTimeout(function() {
              if (typeof tinymce !== 'undefined') {
                tinymce.triggerSave();
              }

              var $inputs = $(':input[name*="_bptimeline_"], :input[name*="bptimeline"]');
              if (!$inputs.length) {
                $inputs = $('.csf-framework :input');
              }
              var formData = $inputs.serialize();
              var postId = $('#post_ID').val() || 0;

              $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                  action: 'bptl_live_preview',
                  post_id: postId,
                  formData: formData
                },
                success: function(response) {
                  var iframe = document.getElementById('bptlPreviewIframe');
                  if (iframe && iframe.contentWindow) {
                    var doc = iframe.contentWindow.document;
                    doc.open();
                    doc.write(response);
                    doc.close();

                    setTimeout(function() {
                      try {
                        var body = doc.body;
                        var html = doc.documentElement;
                        var h = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);
                        if (h > 150) {
                          iframe.style.height = (h + 30) + 'px';
                        }
                      } catch(e) {}
                    }, 150);
                  }
                  $('.bptl-preview-status .status-text').text('Preview up to date');
                  $('.bptl-preview-status .status-dot').css('background', '#00a32a');
                },
                error: function() {
                  $('.bptl-preview-status .status-text').text('Preview update failed');
                  $('.bptl-preview-status .status-dot').css('background', '#d94f4f');
                }
              });
            }, 300);
          }

          // Trigger preview on all input/change/keyup/blur events across Codestar inputs
          $(document).on('input change keyup blur', ':input[name*="_bptimeline_"], :input[name*="bptimeline"], .csf-framework :input', function() {
            triggerRealtimePreview();
          });

          // Trigger preview on Codestar repeater / button_set / switcher / color picker clicks
          $(document).on('click', '.csf-repeater-add, .csf-repeater-remove, .csf-repeater-sort, .csf-field-button_set, .csf-field-switcher, .csf-field-color, .wp-picker-container, .iris-palette, .csf-field', function() {
            setTimeout(triggerRealtimePreview, 200);
            setTimeout(triggerRealtimePreview, 500);
          });

          // Manual refresh
          $(document).on('click', '#bptlRefreshPreview', function(e){
            e.preventDefault();
            triggerRealtimePreview();
          });
        });
      </script>
    </div>
    <?php
    return ob_get_clean();
  }
}

//
// Standalone Live Preview Metabox at the bottom of the page
//
$preview_metabox_prefix = '_bptimeline_live_preview_';

CSF::createMetabox($preview_metabox_prefix, array(
  'title'     => 'Live Preview (Click to Show/Hide)',
  'post_type' => 'btimeline',
  'context'   => 'normal',
  'priority'  => 'low',
  'theme'     => 'light'
));

CSF::createSection($preview_metabox_prefix, array(
  'fields' => array(
    array(
      'type'    => 'content',
      'content' => bptl_get_live_preview_html()
    )
  )
));



