    <form id="select_URL_top" name="select_URL_top" action="" method="get">
    
    <!-- ======================================================================================= -->
    <header class="align_left width_full">
	    
        <!-- =================================================================================== -->
        <div id="main_top" class="bg_grey">
            
            <div id="logo_top" class="align_left height_50">
                <h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
            </div>
            <div id="search_input_top" class="align_left">
                <input type="url" id="website_URL" class="form_change search_input" name="website_URL" placeholder="Enter a URL (e.g. http://www.amazon.com)" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter a URL (e.g. http://www.amazon.com)'" value="<?php echo $GLOBALS['website_URL']; ?>" required />
            </div>
            <div id="search_buttons_top" class="align_left height_50">
                <input type="submit" id="search_submit_top" class="button" name="search_submit_top" value="Parse" />
            </div>
            <div id="links_top" class="align_left height_50">
                <p><input type="button" id="button_testing"class="button" name="button_testing" value="Testing" /></p>
            </div>
            
        </div> <!-- End of #main_top -->
        <!-- =================================================================================== -->
        
    </header> <!-- End of header -->
    <!-- ======================================================================================= -->
    