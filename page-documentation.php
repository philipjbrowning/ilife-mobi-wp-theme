<?php
/**
 * Template Name: Documentation
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
?> 
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

	<div id="wrap_inner">
		<div id="container" class="align_left width_full">
        	<div id="content">
            	
				<?php get_sidebar(); ?>
				
				<section id="main" class="margin_left_200px">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<section id="heading">
						<h2><?php the_title(); ?></h2>
						<?php the_content(); ?><br />
                        <ul id="links">
							<?php 
                            $args = array();
							$args = array(
								'depth'        => 0,
								'show_date'    => '',
								'date_format'  => get_option('date_format'),
								'child_of'     => 2666,
								'exclude'      => '',
								'include'      => '',
								'title_li'     => __(''),
								'echo'         => 1,
								'authors'      => '',
								'sort_column'  => 'menu_order, post_title',
								'link_before'  => '',
								'link_after'   => '',
								'walker'       => '',
								'post_type'    => 'page',
								'post_status'  => 'publish' 
							);
                            wp_list_pages( $args );
                            ?>
                        </ul>
                    </section> <!-- /#heading -->
<?php endwhile; ?>
                </section> <!-- /#main -->
                
            </div>
		</div> <!-- /#container -->
		<?php get_sidebar('right'); ?>
		<div class="clearing width_full">&nbsp;</div>
	</div> <!-- /#wrap_inner -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>