<?php
/**
 * @package iLife Mobi
 */

/**
 * Copyright 2013 Philip Browning (email : pbrowning@scs.howard.edu)
 * 
 * This program is free software; you can redistribute it and/or modify it under the terms of the
 * GNU General Public License, version 2, as published by the Free Software Foundation.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with this program; if not,
 * write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

?>
        <aside id="sidebar_right" class="align_right width_300px">
<?php if ( is_user_logged_in() ) { // ===== DISPLAY SECTION TO ADD ITEM =================================================================================
			?>
            	<h2>Unused Sidebar</h2>
            
<?php } else { // ===== DISPLAY SECTION TO EXPLAIN HOW ITEMS CAN BE ADDED =============================================================================== ?>
				<h2>Deal Alert</h2>
                <p>On iLife.Mobi, users can enter an AISN number to receive deal alerts on a list of items. In order to use this feature, you must <?php wp_loginout(); ?> or <?php wp_register('', ''); ?>.</p>
<?php } // END OF IF USER LOGGED IN() =================================================================================================================== ?>            
        </aside> <!-- /#sidebar_right -->