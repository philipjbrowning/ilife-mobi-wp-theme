<?php
/**
 * Template Name: JpGraph
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
$wpdb->show_errors();

$paged = NULL;
if ( get_query_var('paged') ) {
	$paged = get_query_var('paged');
}
elseif ( get_query_var('page') ) {
	$paged = get_query_var('page');
}
else {
	$paged = 1;
}
$args = array(
	'post_type'      => 'deal-alert',
	'posts_per_page' => 20,
	'paged'          => $paged
);

query_posts($args);
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

	<div id="wrap_inner">
		<div id="container" class="align_left width_full">
        	<div id="content">
            	
				<?php get_sidebar(); ?>
				
				<section id="main" class="margin_left_200px">
					<?php if ( have_posts() ): ?>
                    <h2>Hot Deals from Amazon.com</h2>	
                    <ol class="width_full">
                    	<li class="individual_item">
                        	<h3>Graph</h3>
                        	<p><img src="<?php echo get_template_directory_uri(); ?>/jpgraph/history-two-weeks.php"> </p>
                        </li>
                    <?php while (have_posts()) : the_post(); ?>
                    	<li class="individual_item">
                            <?php $thumbnail_URL = get_post_meta( $post->ID, 'thumbnail_URL', true ); ?>
                            <article class="individual_item_article <?php if ($thumbnail_URL !== false) { ?>amazon_image<?php } ?>">
                            	<?php if ($thumbnail_URL !== false) { ?>
                                <img id="thumbnail" class="align_right margin_left_20px" src="<?php echo $thumbnail_URL; ?>" />
                                <?php } ?>
                                <h3><a href="<?php echo @get_post_meta($post->ID, 'item_URL', true); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                                <time datetime="<?php the_time(); ?>" pubdate><?php the_time('l, F jS, Y') ?></time>
                                <p><a href="<?php echo @get_post_meta($post->ID, 'item_URL', true); ?>">Amazon.com</a> has a deal on this item. The price has decreased <?php echo abs(round(@get_post_meta($post->ID, 'actual_change', true), 1)); ?>%. The new price is $<?php echo @get_post_meta($post->ID, 'current_price', true); ?> (was $<?php echo @get_post_meta($post->ID, 'base_price', true); ?>). High price: $<?php echo @get_post_meta($post->ID, 'high_price', true); ?>. Low price: $<?php echo @get_post_meta($post->ID, 'low_price', true); ?>.</p>
                                <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?>
                            </article>
                            <aside>
								<p>graph</p>
                            </aside>
                        </li>
                    <?php endwhile;?>
                    </ol>
                    <div class="navigation text_center width_full"><p><?php posts_nav_link(); ?></p></div>
                    <?php else: ?>
                    <h3>No deal alerts to display.</h3>
                    <?php endif; ?>
                </section> <!-- /#main -->
				
			</div>
		</div> <!-- /#container -->
		<?php get_sidebar('right'); ?>
		<div class="clearing width_full">&nbsp;</div>
	</div> <!-- /#wrap_inner -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>