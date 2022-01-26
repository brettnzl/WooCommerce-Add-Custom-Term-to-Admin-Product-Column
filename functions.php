add_action( 'manage_posts_custom_column', 'misha_populate_brands' );
function misha_populate_brands( $column_name ) {

	if ( $column_name  == 'brand' ) {
		// if you suppose to display multiple brands, use foreach();
		$x = get_the_terms( get_the_ID(), 'brands'); // taxonomy name
		if ($x) {
			$i = 1;
			foreach ($x as $brand) {
				echo '<a href="https://www.chefscomplements.co.nz/wp-admin/edit.php?brands='.$brand->slug.'&post_type=product">'.$brand->name.'</a>'; 
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
