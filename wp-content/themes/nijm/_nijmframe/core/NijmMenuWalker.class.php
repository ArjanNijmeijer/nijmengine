<?php
class NijmMenuWalker extends Walker_Nav_Menu
{
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
    {
        //
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $classNames = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $classNames = ' class="'. esc_attr( $classNames ) . '"';

        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $classNames .'>';

        // Chech attributes and if set create the html attributes
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'" itemprop="url"' : '';

        $itemOutput  = $args->before . '<a' . $attributes . '>';
        $itemOutput .= $args->link_before . '<span itemprop="name">' .apply_filters( 'the_title', $item->title, $item->ID ) . '</span>' . $args->link_after;
        $itemOutput .= '</a>' . $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $itemOutput, $item, $depth, $args );
    }
}