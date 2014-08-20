<?php
/**
 * Custom Menu Walker
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/


class WPEX_Dropdown_Walker_Nav_Menu extends Walker_Nav_Menu {
	function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
		$id_field = $this->db_fields['id'];
		if( !empty( $children_elements[$element->$id_field] ) && ( $depth == 0 ) ) {
			$element->classes[] = 'dropdown';
			if ( wpex_option('menu_arrow_down', '0' ) == '1' ) {
				$element->title .= ' <span class="nav-arrow fa fa-angle-down"></span>';
			}
		}
		if( !empty( $children_elements[$element->$id_field] ) && ( $depth > 0 ) ) {
			$element->classes[] = 'dropdown';
			if ( wpex_option('menu_arrow_side', '1' ) == '1' ) {
				$element->title .= ' <span class="nav-arrow fa fa-angle-right"></span>';
			}
		}
		Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}
}