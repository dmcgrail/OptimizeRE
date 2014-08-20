<?php
/**
 * Custom Menu Walker  - WORK IN PROGRESS
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.33
*/


if ( ! class_exists( 'Menu_Item_Custom_Fields' ) ) {
	/**
	* Menu Item Custom Fields Loader
	*/
	class Menu_Item_Custom_Fields {

		/**
		* Add filter
		*
		* @wp_hook action wp_loaded
		*/
		public static function load() {
			add_filter( 'wp_edit_nav_menu_walker', array( __CLASS__, '_filter_walker' ), 99 );
		}


		/**
		* Replace default menu editor walker with ours
		*
		* We don't actually replace the default walker. We're still using it and
		* only injecting some HTMLs.
		*
		* @since   0.1.0
		* @access  private
		* @wp_hook filter wp_edit_nav_menu_walker
		* @param   string $walker Walker class name
		* @return  string Walker class name
		*/
		public static function _filter_walker( $walker ) {
			$walker = 'Menu_Item_Custom_Fields_Walker';
			if ( ! class_exists( $walker ) ) {
				require_once( WPEX_FUNCTIONS_DIR . '/header/menu/walker-nav-menu-edit.php' );
			}
			return $walker;
		}
	}
	add_action( 'wp_loaded', array( 'Menu_Item_Custom_Fields', 'load' ), 9 );
} // class_exists( 'Menu_Item_Custom_Fields' )


/**
 * Add Custom Fields to menu
 *
 * @since 1.33
 */
if ( ! class_exists( 'WPEX_Menu_Custom_Fields' ) ) {
	class WPEX_Menu_Custom_Fields {

		/**
		 * Initialize plugin
		 */
		public static function init() {
			add_action( 'menu_item_custom_fields', array( __CLASS__, '_fields' ), 10, 3 );
			add_action( 'wp_update_nav_menu_item', array( __CLASS__, '_save' ), 10, 3 );
			add_filter( 'manage_nav-menus_columns', array( __CLASS__, '_columns' ), 99 );
		}


		/**
		 * Save custom field value
		 *
		 * @wp_hook action wp_update_nav_menu_item
		 *
		 * @param int   $menu_id         Nav menu ID
		 * @param int   $menu_item_db_id Menu item ID
		 * @param array $menu_item_args  Menu item data
		 */
		public static function _save( $menu_id, $menu_item_db_id, $menu_item_args ) {
			check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

			// Sanitize
			if ( ! empty( $_POST['menu-item-wpex-megamenu'][ $menu_item_db_id ] ) ) {
				// Do some checks here...
				$value = $_POST['menu-item-wpex-megamenu'][ $menu_item_db_id ];
			} else {
				$value = '';
			}

			// Update
			if ( ! empty( $value ) ) {
				echo 'test';
				update_post_meta( $menu_item_db_id, '_wpex_megamenu_cols', $value );
			}
			else {
				delete_post_meta( $menu_item_db_id, '_wpex_megamenu_cols' );
			}
		}


		/**
		 * Print field
		 *
		 * @param object $item  Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args  Menu item args.
		 * @param int    $id    Nav menu ID.
		 *
		 * @return string Form fields
		 */
		public static function _fields( $item, $depth, $args = array(), $id = 0 ) { ?>
			<p class="field-custom description description-wide">
					<label for="edit-menu-item-wpex-megamenu-<?php echo esc_attr( $item->ID ) ?>"><?php _e( 'Mega Menu', 'my-plugin' ) ?>
						<br />
						<select id="edit-menu-item-wpex-megamenu-<?php echo esc_attr( $item->ID ) ?>" class="widefat code edit-menu-item-wpex-megamenu" name="menu-item-wpex-megamenu[<?php echo $item_id; ?>]">
							<option value="" <?php selected( esc_attr( get_post_meta( $item->ID, '_wpex_megamenu_cols', true ) ), '' ); ?>><?php _e( 'No Mega Menu', 'wpex' ); ?></option>
							<option value="1" <?php selected( esc_attr( get_post_meta( $item->ID, '_wpex_megamenu_cols', true ) ), '1' ); ?>><?php _e( '1 Column', 'wpex' ); ?></option>
							<option value="2" <?php selected( esc_attr( get_post_meta( $item->ID, '_wpex_megamenu_cols', true ) ), '2' ); ?>><?php _e( '2 Columns', 'wpex' ); ?></option>
							<option value="3" <?php selected( esc_attr( get_post_meta( $item->ID, '_wpex_megamenu_cols', true ) ), '3' ); ?>><?php _e( '3 Columns', 'wpex' ); ?></option>
							<option value="4" <?php selected( esc_attr( get_post_meta( $item->ID, '_wpex_megamenu_cols', true ) ), '4' ); ?>><?php _e( '4 Columns', 'wpex' ); ?></option>
							<option value="5" <?php selected( esc_attr( get_post_meta( $item->ID, '_wpex_megamenu_cols', true ) ), '5' ); ?>><?php _e( '5 Columns', 'wpex' ); ?></option>
							<option value="6" <?php selected( esc_attr( get_post_meta( $item->ID, '_wpex_megamenu_cols', true ) ), '6' ); ?>><?php _e( '6 Columns', 'wpex' ); ?></option>
						</select>
					</label>
				</p>
			<?php
		}

		/**
		 * Add our field to the screen options toggle
		 *
		 * @param array $columns Menu item columns
		 * @return array
		 */
		public static function _columns( $columns ) {
			$columns['wpex-megamenu'] = __( 'Megamenu Columns', 'wpex' );
			return $columns;
		}
	}
}
WPEX_Menu_Custom_Fields::init();