<?php
                        
// RELATED POSTS BY CATEGORY
$curr_post_id = get_the_ID();

$categories = get_the_category(get_the_ID());

if ($categories) {
    $category_ids = array();
    //foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
        	
    $args=array(
        'category__in' => wp_get_post_categories($curr_post_id),
        'post__not_in' => array($curr_post_id),
        'posts_per_page'=> 2, // Number of related posts that will be shown.
        'caller_get_posts'=> 1,
        'orderby' => 'rand'
    );

    $my_query = new wp_query( $args );

    if ( $my_query->have_posts() ) {

    	while( $my_query->have_posts() ) {
            $my_query->the_post();
            $related_post_ids[] = get_the_ID();
        }
    }

    wp_reset_postdata();

    if (isset($related_post_ids)):
    	?>

    	<div class="em-related-posts">
    		<h2 class="margin-bot-50">
                Ähnliche Beiträge
				<?php // _e('Similar articles', 'eichmeister'); ?>
			</h2>
        	<?php EM()->Template->posts_grid( $related_post_ids, 2 ); ?>
        </div>

        <?php
    endif;
}

?>