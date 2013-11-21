<?php
/**
 * Template Name: Account Information
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

/** WordPress Administration Bootstrap */
// require_once('../../wp-admin/admin.php');

// wp_reset_vars(array('action', 'redirect', 'profile', 'user_id', 'wp_http_referer'));

$user_id = (int) $user_id;
$current_user = wp_get_current_user();

if ( ! $user_id && IS_PROFILE_PAGE )
	$user_id = $current_user->ID;
elseif ( ! $user_id && ! IS_PROFILE_PAGE )
	wp_die(__( 'Invalid user ID.' ) );
elseif ( ! get_userdata( $user_id ) )
	wp_die( __('Invalid user ID.') );

$profileuser = $current_user;
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
                    </section> <!-- /#heading -->
                    
                    <section id="edit_account_information">
						
                        <form id="your-profile" action="<?php echo esc_url( self_admin_url( IS_PROFILE_PAGE ? 'profile.php' : 'user-edit.php' ) ); ?>" method="post"<?php do_action('user_edit_form_tag'); ?>>
						<?php wp_nonce_field('update-user_' . $user_id) ?>
                        <?php if ( $wp_http_referer ) : ?>
                        <input type="hidden" name="wp_http_referer" value="<?php echo esc_url($wp_http_referer); ?>" />
                        <?php endif; ?>
                        <input type="hidden" name="from" value="profile" />
                        <input type="hidden" name="checkuser_id" value="<?php echo $user_ID ?>" />

                        <table class="form-table width_full">
                            <tr>
                                <th><label for="user_login"><?php _e('Username'); ?></label></th>
                                <td><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr($profileuser->user_login); ?>" disabled="disabled" class="regular-text" /></td>
                            </tr>
                        
                        <?php if ( !IS_PROFILE_PAGE && !is_network_admin() ) : ?>
                        <tr><th><label for="role"><?php _e('Role') ?></label></th>
                        <td><select name="role" id="role">
                        <?php
                        // Compare user role against currently editable roles
                        // TODO: create a function that does this: wp_get_user_role()
                        $user_roles = array_intersect( array_values( $profileuser->roles ), array_keys( get_editable_roles() ) );
                        $user_role  = array_shift( $user_roles );
                        
                        // print the full list of roles with the primary one selected.
                        wp_dropdown_roles($user_role);
                        
                        // print the 'no role' option. Make it selected if the user has no role yet.
                        if ( $user_role )
                            echo '<option value="">' . __('&mdash; No role for this site &mdash;') . '</option>';
                        else
                            echo '<option value="" selected="selected">' . __('&mdash; No role for this site &mdash;') . '</option>';
                        ?>
                        </select></td></tr>
                        <?php endif; //!IS_PROFILE_PAGE
                        
                        if ( is_multisite() && is_network_admin() && ! IS_PROFILE_PAGE && current_user_can( 'manage_network_options' ) && !isset($super_admins) ) { ?>
                        <tr><th><?php _e('Super Admin'); ?></th>
                        <td>
                        <?php if ( $profileuser->user_email != get_site_option( 'admin_email' ) || ! is_super_admin( $profileuser->ID ) ) : ?>
                        <p><label><input type="checkbox" id="super_admin" name="super_admin"<?php checked( is_super_admin( $profileuser->ID ) ); ?> /> <?php _e( 'Grant this user super admin privileges for the Network.' ); ?></label></p>
                        <?php else : ?>
                        <p><?php _e( 'Super admin privileges cannot be removed because this user has the network admin email.' ); ?></p>
                        <?php endif; ?>
                        </td></tr>
                        <?php } ?>
                        
                        <tr>
                            <th><label for="first_name"><?php _e('First Name') ?></label></th>
                            <td><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr($profileuser->first_name) ?>" class="regular-text" /></td>
                        </tr>
                        
                        <tr>
                            <th><label for="last_name"><?php _e('Last Name') ?></label></th>
                            <td><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr($profileuser->last_name) ?>" class="regular-text" /></td>
                        </tr>
                        
                        <tr>
                            <th><label for="nickname"><?php _e('Nickname'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
                            <td><input type="text" name="nickname" id="nickname" value="<?php echo esc_attr($profileuser->nickname) ?>" class="regular-text" /></td>
                        </tr>
                        
                        <tr>
                            <th><label for="display_name"><?php _e('Display Name') ?></label></th>
                            <td>
                                <select name="display_name" id="display_name">
                                <?php
                                    $public_display = array();
                                    $public_display['display_nickname']  = $profileuser->nickname;
                                    $public_display['display_username']  = $profileuser->user_login;
                        
                                    if ( !empty($profileuser->first_name) )
                                        $public_display['display_firstname'] = $profileuser->first_name;
                        
                                    if ( !empty($profileuser->last_name) )
                                        $public_display['display_lastname'] = $profileuser->last_name;
                        
                                    if ( !empty($profileuser->first_name) && !empty($profileuser->last_name) ) {
                                        $public_display['display_firstlast'] = $profileuser->first_name . ' ' . $profileuser->last_name;
                                        $public_display['display_lastfirst'] = $profileuser->last_name . ' ' . $profileuser->first_name;
                                    }
                        
                                    if ( !in_array( $profileuser->display_name, $public_display ) ) // Only add this if it isn't duplicated elsewhere
                                        $public_display = array( 'display_displayname' => $profileuser->display_name ) + $public_display;
                        
                                    $public_display = array_map( 'trim', $public_display );
                                    $public_display = array_unique( $public_display );
                        
                                    foreach ( $public_display as $id => $item ) {
                                ?>
                                    <option <?php selected( $profileuser->display_name, $item ); ?>><?php echo $item; ?></option>
                                <?php
                                    }
                                ?>
                                </select>
                            </td>
                        </tr>
                        </table>
                        
                        <h2><?php _e('Contact Info') ?></h2>
                        
                        <table class="form-table width_full">
                        <tr>
                            <th><label for="email"><?php _e('E-mail'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
                            <td><input type="text" name="email" id="email" value="<?php echo esc_attr($profileuser->user_email) ?>" class="regular-text" />
                            <?php
                            $new_email = get_option( $current_user->ID . '_new_email' );
                            if ( $new_email && $new_email != $current_user->user_email ) : ?>
                            <div class="updated inline">
                            <p><?php printf( __('There is a pending change of your e-mail to <code>%1$s</code>. <a href="%2$s">Cancel</a>'), $new_email['newemail'], esc_url( self_admin_url( 'profile.php?dismiss=' . $current_user->ID . '_new_email' ) ) ); ?></p>
                            </div>
                            <?php endif; ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <th><label for="url"><?php _e('Website') ?></label></th>
                            <td><input type="text" name="url" id="url" value="<?php echo esc_attr($profileuser->user_url) ?>" class="regular-text code" /></td>
                        </tr>
                        
                        <?php
                            foreach (_wp_get_user_contactmethods( $profileuser ) as $name => $desc) {
                        ?>
                        <tr>
                            <th><label for="<?php echo $name; ?>"><?php echo apply_filters('user_'.$name.'_label', $desc); ?></label></th>
                            <td><input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_attr($profileuser->$name) ?>" class="regular-text" /></td>
                        </tr>
                        <?php
                            }
                        ?>
                        </table>
                        
                        <h2><?php IS_PROFILE_PAGE ? _e('About Yourself') : _e('About the user'); ?></h2>
                        
                        <table class="form-table width_full">
                        <tr>
                            <th><label for="description"><?php _e('Biographical Info'); ?></label></th>
                            <td><textarea name="description" id="description" rows="5" cols="30"><?php echo $profileuser->description; // textarea_escaped ?></textarea><br />
                            <span class="description"><?php _e('Share a little biographical information to fill out your profile. This may be shown publicly.'); ?></span></td>
                        </tr>
                        
                        <?php
                        $show_password_fields = apply_filters('show_password_fields', true, $profileuser);
                        if ( $show_password_fields ) :
                        ?>
                        <tr id="password">
                            <th><label for="pass1"><?php _e('New Password'); ?></label></th>
                            <td><input type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off" /><br /> <span class="description"><?php _e("If you would like to change the password type a new one. Otherwise leave this blank."); ?></span><br />
                                <input type="password" name="pass2" id="pass2" size="16" value="" autocomplete="off" /><br /> <span class="description"><?php _e("Type your new password again."); ?></span><br />
                                <div id="pass-strength-result"><?php _e('Strength indicator'); ?></div>
                                <p class="description indicator-hint"><?php _e('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).'); ?></p>
                            </td>
                        </tr>
                        <?php endif; ?>
                        </table>
                        
                        <input type="hidden" name="action" value="update" />
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr($user_id); ?>" />
                        
                        <p class="submit">
                        	<input id="submit" class="button button-primary" type="submit" value="Update Profile" name="submit">
                        </p>
                        
                        </form> <!-- /#your-profile -->
                        
                	</section> <!-- /#settings_form_and_table -->
<?php endwhile; ?>
                </section> <!-- /#main -->
                
            </div>
		</div> <!-- /#container -->
		<?php get_sidebar('right'); ?>
		<div class="clearing width_full">&nbsp;</div>
	</div> <!-- /#wrap_inner -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>