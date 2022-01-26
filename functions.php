<?php 


// Brands Taxonomy Filter - ADMIN AREA
add_filter( 'woocommerce_product_filters', 'admin_filter_products_by_din' );
function admin_filter_products_by_din( $output ) {
    global $wp_query;

    $taxonomy      = 'brands';
    $selected      = isset( $wp_query->query_vars[$taxonomy] ) ? $wp_query->query_vars[$taxonomy] : '';
    $info_taxonomy = get_taxonomy($taxonomy);

    $custom_dropdown = wp_dropdown_categories(array(
        'show_option_none' => __("Select a {$info_taxonomy->label}"), // changed
        'taxonomy'         => $taxonomy,
        'name'             => $taxonomy,
        'order'            => 'ASC',
        'echo'             => false, // <== Needed in a filter hook
        'tab_index'        => '2',
        'selected'         => $selected,
        'show_count'       => true,
        'hide_empty'       => false,
        'value_field'      => 'slug',
		'option_none_value'=> ''
    ));

    $after = '<select name="product_type"'; // The start of the html output of product type filter dropdown.

    $output = str_replace( $after, $custom_dropdown . $after, $output );

    return $output;
}



add_filter( 'manage_edit-product_columns', 'misha_brand_column', 20 );
function misha_brand_column( $columns_array ) {

	// I want to display Brand column just after the product name column
	return array_slice( $columns_array, 0, 3, true )
	+ array( 'brand' => 'Brand' )
	+ array_slice( $columns_array, 3, NULL, true );


}


add_action( 'manage_posts_custom_column', 'misha_populate_brands' );
function misha_populate_brands( $column_name ) {

	if ( $column_name  == 'brand' ) {
		// if you suppose to display multiple brands, use foreach();
		$x = get_the_terms( get_the_ID(), 'brands'); // taxonomy name
		if ($x) {
			$i = 1;
			foreach ($x as $brand) {
				echo '<a href="/wp-admin/edit.php?brands='.$brand->slug.'&post_type=product">'.$brand->name.'</a>'; 
				if ( $i < sizeof($x) ){ 
					echo ', ';
				};
				$i++;
			}
		} else {
			echo "n/a";
		}
	}

}
