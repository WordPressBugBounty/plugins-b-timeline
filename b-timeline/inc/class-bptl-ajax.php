<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BPTLAjax' ) ) {

	/**
	 * AJAX bridge for the dashboard Blocks tab.
	 *
	 * Mirrors TLGBAjax in the Timeline Block plugin so both dashboards behave
	 * identically.
	 */
	class BPTLAjax {

		public function __construct() {
			add_action( 'wp_ajax_bptl_get_blocks', [ $this, 'bptl_get_blocks' ] );
			add_action( 'wp_ajax_bptl_live_preview', [ $this, 'bptl_live_preview' ] );
		}

		/**
		 * Read/write the list of disabled blocks for the dashboard Blocks tab.
		 *
		 * - Called with no `data` payload -> returns the saved list (read).
		 * - Called with a `data` payload  -> saves the list (write).
		 *
		 * The list stores block folder basenames (e.g. "media-story-timeline")
		 * plus "b-timeline" for the shortcode timeline.
		 */
		public function bptl_get_blocks() {
			$nonce = isset( $_POST['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ) : '';

			if ( ! wp_verify_nonce( $nonce, 'bptl_admin_nonce' ) ) {
				wp_send_json_error( __( 'Invalid Request', 'b-timeline' ) );
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( __( 'Permission denied', 'b-timeline' ) );
			}

			// Read path: no data posted -> return the currently disabled blocks.
			if ( ! isset( $_POST['data'] ) ) {
				wp_send_json_success( (array) get_option( 'bptl_disabled_blocks', [] ) );
			}

			$data = json_decode( sanitize_text_field( wp_unslash( $_POST['data'] ) ), true );

			if ( ! is_array( $data ) ) {
				$data = [];
			}

			$data = array_values( array_map( 'sanitize_text_field', $data ) );

			update_option( 'bptl_disabled_blocks', $data );
			wp_send_json_success( $data );
		}

		/**
		 * Render live timeline HTML iframe content for live preview metabox.
		 */
		public function bptl_live_preview() {
			if ( ! current_user_can( 'edit_posts' ) ) {
				wp_die( __( 'Permission denied', 'b-timeline' ) );
			}

			$post_id = isset( $_REQUEST['post_id'] ) ? intval( $_REQUEST['post_id'] ) : 0;
			$bptl_datas = null;

			if ( isset( $_POST['formData'] ) && ! empty( $_POST['formData'] ) ) {
				parse_str( wp_unslash( $_POST['formData'] ), $parsed_form );
				if ( isset( $parsed_form['_bptimeline_'] ) && is_array( $parsed_form['_bptimeline_'] ) ) {
					$bptl_datas = $parsed_form['_bptimeline_'];
				} elseif ( isset( $parsed_form['_bptimeline'] ) && is_array( $parsed_form['_bptimeline'] ) ) {
					$bptl_datas = $parsed_form['_bptimeline'];
				}
			}

			if ( is_null( $bptl_datas ) && $post_id ) {
				$bptl_datas = get_post_meta( $post_id, '_bptimeline_', true );
			}

			header( 'Content-Type: text/html; charset=utf-8' );
			?>
			<!DOCTYPE html>
			<html <?php language_attributes(); ?>>
			<head>
				<meta charset="<?php bloginfo( 'charset' ); ?>">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<style>
					body {
						background: #ffffff;
						margin: 0;
						padding: 25px 20px;
						font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
						box-sizing: border-box;
					}
					* {
						box-sizing: border-box;
					}
				</style>
				<?php
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'bptl-timeline', BPTL_PLUGIN_DIR . 'public/assets/js/timeline.min.js', ['jquery'], BPTL_VER, true );
				wp_enqueue_script( 'bptl-timeline-config', BPTL_PLUGIN_DIR . 'public/assets/js/public.js', ['jquery', 'bptl-timeline'], BPTL_VER, true );
				wp_enqueue_style( 'timeline-style', BPTL_PLUGIN_DIR . 'public/assets/css/timeline.min.css', [], BPTL_VER, 'all' );
				wp_print_styles();
				wp_print_scripts();
				?>
			</head>
			<body>
				<?php
				echo BTimeline::bptl_render_timeline_from_data( $bptl_datas, $post_id );
				?>
			</body>
			</html>
			<?php
			wp_die();
		}
	}

	new BPTLAjax();
}
