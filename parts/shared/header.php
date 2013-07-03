    <header class="align_left width_full">
	    <div id="wrap_h1">
        	<div id="wrap_title" class="align_left height_60 width_third">
	        	<h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
	        	<?php bloginfo( 'description' ); ?>
            </div>
            <div id="wrap_login_links" class="align_left height_30 text_right width_two_thirds">
            	<ul  class="ul_horizontal">
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
				</ul>
            </div>
            <div id="wrap_mainlinks" class="align_left height_30 text_center text_height_30 width_third">
            	<ul class="ul_horizontal">
                	<li><a href="">Hot Deals</a></li>
                    <li><a href="">Coupons</a></li>
                    <li><a href="">More &raquo;</a></li>
                </ul>
            </div>
            <div id="wrap_blank" class="align_left height_30 width_third">
            	&nbsp;
            </div>
        </div> <!-- End of #wrap_h1 -->
        <div id="wrap_sublinks" class="align_left links_white text_center text_height_30 width_full">
           	<ul class="ul_horizontal">
               	<li><a href="">Laptops, Desktops & Tablets</a></li> | 
                <li><a href="">Cameras</a></li> | 
                <li><a href="">TVs</a></li> | 
                <li><a href="">Beauty</a></li> | 
                <li><a href="">Fashion</a></li> | 
                <li><a href="">Latest News</a></li> | 
                <li><a href="">Share a Deal</a></li>
            </ul>
        </div>
    </header>
    <!-- =================================================================== -->
    
    <!-- =================================================================== -->
    <!-- This is the wrapper for individual page content. -->
    <div id="wrap_content" class="align_left width_full">
