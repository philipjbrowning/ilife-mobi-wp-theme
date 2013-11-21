					<form id="edit_item" action="" method="post">
<?php
global $wpdb;
$current_user = '';
if ($_GET)
{
	// Include WP-Load
	include_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
	
	// Save user ID
	$current_user->ID = $_GET['item_author'];
} 
else
{
	$current_user = wp_get_current_user();
	if ( !($current_user instanceof WP_User) ) {
		 $current_user->ID = 0;
	}
}
?>
                        <table class="text_left">
                            <thead>
                                <tr id="item_head">
                                    <th>Item Title</th>
                                    <th>Item AISN</th>
                                    <th>% Change</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$results = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'items_of_interest WHERE item_author='.$current_user->ID.' LIMIT 0, 30');
if (is_array($results))
{
    foreach ($results as $result) {
?>
                                <tr id="item_<?php echo $result->ID; ?>" class="item">
                                    <td class="width_half"><input type="text" id="item_title_<?php echo $result->ID; ?>" class="item_title margin_top_bottom_3px width_96p" name="item_title_<?php echo $result->ID; ?>" value="<?php echo stripslashes($result->item_title); ?>" placeholder="Name this Item" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name this Item'" /></td>
                                    <td class="width_20p"><input type="text" id="item_ASIN_<?php echo $result->ID; ?>" class="item_ASIN margin_top_bottom_3px width_90p" name="item_ASIN_<?php echo $result->ID; ?>" value="<?php echo $result->item_ASIN; ?>" placeholder="Enter the ASIN" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter the ASIN'" /></td>
                                    <td class="width_8p"><input type="text" id="percent_change_<?php echo $result->ID; ?>" class="percent_change margin_top_bottom_3px" name="percent_change_<?php echo $result->ID; ?>" value="<?php echo $result->percent_change; ?>" placeholder="Percent Change" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Percent Change'" /></td>
                                    <td class="width_12p"><button id="update_item_<?php echo $result->ID; ?>" class="update_item" name="update_item_<?php echo $result->ID; ?>">Update</button></td>
                                    <td class="width_12p"><button id="delete_item_<?php echo $result->ID; ?>" class="delete_item" name="delete_item_<?php echo $result->ID; ?>">Delete</button></td>
                                </tr>
<?php
	}
} else { // It is not an array
?>
                                <tr>
                                    <td colspan="5"><pre><?php print_r($results); ?></pre></td>
                                </tr>
<?php } ?>
                            </tbody>
                        </table>
                        <input type="hidden" id="item_author" name="item_author" value="<?php echo $result->ID; ?>" />
                        <input type="hidden" id="plugins_url" name="plugins_url" value="<?php echo plugins_url(); ?>" />
                        </form> <!-- /#edit_item -->