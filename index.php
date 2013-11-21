<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file 
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
 
 // 'author=123'
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

	<div id="wrap_inner">
		<div id="container" class="align_left width_full">
        	<div id="content">
            	
				<?php get_sidebar(); ?>
				
				<section id="main" class="margin_left_200px">
					<?php if ( have_posts() ): ?>
                    <h2>Top Deals from Dealsea.com</h2>	
                    <ol>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <li class="individual_item">
                            <?php $thumbnail_URL = get_post_meta( $post->ID, 'thumbnail_URL', true ); ?>
                            <article class="individual_item_article<?php if ($thumbnail_URL !== false) { ?> min_height_100px<?php } ?>">
								<?php if ($thumbnail_URL !== false) { ?>
                                <img id="thumbnail" class="align_right margin_left_20px" src="<?php echo $thumbnail_URL; ?>" />
                                <?php } ?>
                                <h3><?php the_title(); ?></h3>
                                <time datetime="<?php the_time(); ?>" pubdate><?php the_time('l, F jS, Y') ?></time>
                              	<?php the_content(); ?>
                                <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?>
                            </article>
                        </li>
                    <?php endwhile; ?>
                    </ol>
                    <div class="navigation text_center width_full"><p><?php posts_nav_link(); ?></p></div>
                    <?php else: ?>
                    <h3>No posts to display</h3>
                    <?php endif; ?>
				</section> <!-- /#main -->
				
			</div>
		</div> <!-- /#container -->
		<?php get_sidebar('right'); ?>
		<div class="clearing width_full">&nbsp;</div>
	</div> <!-- /#wrap_inner -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>