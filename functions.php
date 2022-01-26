<?php 

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
