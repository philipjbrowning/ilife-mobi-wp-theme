        <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
            <div id="search_box" class="align_left bg_green text_white top_corners_curved width_180px">
                <p><label class="font_uppercase_arial screen-reader-text" for="s">Search</label></p>
            </div>
            <div id="search_input" class="align_left bg_beige border_brown">
                <input type="text" value="" name="s" id="s" class="" placeholder="Enter Keyword" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Keyword'" />
                <input type="submit" id="searchsubmit" class="not_uniform" value="Go" />
            </div>
        </form>