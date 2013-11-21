    <header id="header_website" class="align_left margin_bottom_20px width_full">
    	<div id="logo" class="align_left height_60px position_relative text_bottom width_thirtieth">
        	<div class="bottom">
            	<h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
        		<?php bloginfo( 'description' ); ?>
            </div> <!-- /.bottom -->
        </div><!-- /#logo -->
        
        <nav id="pages" class="align_left height_60px position_relative text_bottom text_center width_fortieth">
        	<div class="bottom width_full">
                
                <ul id="nav">
                    <?php 
					$args = array();
					if ( is_user_logged_in() ) {
						if(get_current_user_id() === 1)
						{
							$args = array(
								'depth'        => 1,
								'show_date'    => '',
								'date_format'  => get_option('date_format'),
								'child_of'     => 0,
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
						} else {
							$args = array(
								'depth'        => 1,
								'show_date'    => '',
								'date_format'  => get_option('date_format'),
								'child_of'     => 0,
								'exclude'      => '2666',
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
						}
					} else {
						$args = array(
							'depth'        => 1,
							'show_date'    => '',
							'date_format'  => get_option('date_format'),
							'child_of'     => 0,
							'exclude'      => '2,230,2666',
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
					}
					
                    wp_list_pages( $args );
                    ?>
                </ul>
            </div> <!-- /.bottom -->
        </nav> <!-- /#pages -->
        
        <div id="login_register" class="align_left height_60px text_bottom text_right width_thirtieth">
        	<p><?php wp_loginout(); if ( !is_user_logged_in() ) { ?> or <?php wp_register('', ''); } ?></p>
        </div> <!-- /#login_register -->
        <div id="items_tracked" class="align_left bg_green text_center width_full">
        <?php
		$show_sub_menu = false;
		$slug = get_the_slug();
		if(($slug == 'account-information') || ($slug == 'email-preferences') || ($slug == 'new-deal-alert') || ($slug == 'settings'))
		{
			$show_sub_menu = true;
		}
		if ($show_sub_menu == true) {
		?>
        	<ul>
                <li><a href="http://ilife.mobi/settings/new-deal-alert/">New Deal Alert</a></li>
                <li><a href="http://ilife.mobi/settings/account-information/">Account Information</a></li>
                <li><a href="http://ilife.mobi/settings/email-preferences/">Email Preferences</a></li>
            </ul>
        <?php } else { ?>
        	<ul>
            	<li>&nbsp;</li>
            </ul>
        <?php } ?>
        </div> <!-- /#items_tracked -->
    </header> <!-- /#header_website -->
    
    <div id="wrap_sub_nav" class="align_left width_full">
    	
                
    </div>
    
    <div id="wrap_outer" class="align_left margin_bottom_20px width_full">
