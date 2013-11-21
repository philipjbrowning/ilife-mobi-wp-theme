<?php
/**
 * Search results page
 * 
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

	<div id="wrap_inner">
		<div id="container" class="align_left width_full">
        	<div id="content">
            	
				<?php get_sidebar(); ?>
				
				<section id="main" class="margin_left_200px">
<?php if ( have_posts() ): ?>
					<h2>Search Results for '<?php echo get_search_query(); ?>'</h2>	
					<ol>
<?php while ( have_posts() ) : the_post(); ?>
						<li class="individual_item">
                        	<?php $thumbnail_URL = get_post_meta( $post->ID, 'thumbnail_URL', true ); ?>
                        	<?php if (get_post_type( $post ) == 'deal-alert') { // From amazon.com ?>
                            <article class="individual_item_article <?php if ($thumbnail_URL !== false) { ?>amazon_image<?php } ?>">
                            	<?php if ($thumbnail_URL !== false) { ?>
                                <img id="thumbnail" class="align_right margin_left_20px" src="<?php echo $thumbnail_URL; ?>" />
                                <?php } ?>
                                <h3><a href="<?php echo @get_post_meta($post->ID, 'item_URL', true); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                                <time datetime="<?php the_time(); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time>
                                <p><a href="<?php echo @get_post_meta($post->ID, 'item_URL', true); ?>">Amazon.com</a> has a deal on this item. The price has <?php if (@get_post_meta($post->ID, 'actual_change', true) >= 0.00) { ?>increased<?php } else { ?>decreased<?php } ?> <?php echo number_format(((float)@get_post_meta($post->ID, 'current_price', true) - (float)@get_post_meta($post->ID, 'base_price', true)),2,'.',''); ?>%. The new price is $<?php echo @get_post_meta($post->ID, 'current_price', true); ?>. The high price for this item was $<?php echo @get_post_meta($post->ID, 'high_price', true); ?>, and the low price was $<?php echo @get_post_meta($post->ID, 'low_price', true); ?>.</p>
                            </article>
                            <?php } else { // From dealsea.com ?>
                            <article class="individual_item_article<?php if ($thumbnail_URL !== false) { ?> min_height_100px<?php } ?>">
								<?php if ($thumbnail_URL !== false) { ?>
                                <img id="thumbnail" class="align_right margin_left_20px" src="<?php echo $thumbnail_URL; ?>" />
                                <?php } ?>
                                <h3><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                                <time datetime="<?php the_time(); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time>
                              	<?php the_content(); ?>
                                <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?>
                            </article>
                            <?php } ?>
                        </li>
<?php endwhile; ?>
					</ol>
<?php else: ?>
					<h2>No results found for '<?php echo get_search_query(); ?>'</h2>
<?php endif; ?>
				</section> <!-- /#main -->
				
			</div>
		</div> <!-- /#container -->
		<?php get_sidebar('right'); ?>
		<div class="clearing width_full">&nbsp;</div>
	</div> <!-- /#wrap_inner -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>