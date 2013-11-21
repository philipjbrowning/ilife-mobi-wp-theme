<?php
	/**
	 * Starkers functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
 	 * @package 	WordPress
 	 * @subpackage 	Starkers
 	 * @since 		Starkers 4.0
	 */

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */

	require_once( 'external/starkers-utilities.php' );

	/* ========================================================================================================================
	
	Theme specific settings

	Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme
	
	======================================================================================================================== */

	add_theme_support('post-thumbnails');
	
	// register_nav_menus(array('primary' => 'Primary Navigation'));

	/* ========================================================================================================================
	
	Actions and Filters
	
	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'starkers_script_enqueuer' );

	add_filter( 'body_class', array( 'Starkers_Utilities', 'add_slug_to_body_class' ) );

	/* ========================================================================================================================
	
	Custom Post Types - include custom post types and taxonimies here e.g.

	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );
	
	======================================================================================================================== */



	/* ========================================================================================================================
	
	Scripts
	
	======================================================================================================================== */

	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */

	function starkers_script_enqueuer() {

		wp_register_style( 'screen', get_stylesheet_directory_uri().'/style.css', '', '', 'screen' );
        wp_enqueue_style( 'screen' );
		
		wp_register_script( 'jquery-uniform', get_template_directory_uri().'/js/uniform/jquery.uniform.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'jquery-uniform' );
		
		wp_register_script( 'jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'jquery-ui' );
		
		wp_register_script( 'jquery-notify', get_template_directory_uri().'/js/jquery.notify.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'jquery-notify' );
		
		wp_register_script( 'site', get_template_directory_uri().'/js/site.js', array( 'jquery' ) );
		wp_enqueue_script( 'site' );
		
		// Page specific scripts
		global $post;
		wp_register_script( 'settings', get_template_directory_uri() . '/js/settings.js', array('jquery'));
		
		if( is_page() || is_single() )
		{
			switch($post->post_name) 
			{
				case 'settings':
					wp_enqueue_script('settings');
					break;
				// More cases can bet added
			}
		}
	}

	/* ========================================================================================================================
	
	Comments
	
	======================================================================================================================== */

	/**
	 * Custom callback for outputting comments 
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	function starkers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>	
		<li>
			<article id="comment-<?php comment_ID() ?>">
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
				<?php comment_text() ?>
			</article>
		<?php endif;
	}
	
	
	
	/**
	 * Prints WP Page Slug
	 *
	 * @author:  Maidul Islam
	 * @source:  http://techsloution4u.com/code-snippet/get-wp-page-slug.html#.UebUhGTTWRY
	 */
	function the_slug() {
		$post_data = get_post($post->ID, ARRAY_A);
		$slug = $post_data['post_name'];
		echo $slug; 
	}
	
	/**
	 * Prints WP Page Slug
	 *
	 * @author:  Maidul Islam
	 * @source:  http://techsloution4u.com/code-snippet/get-wp-page-slug.html#.UebUhGTTWRY
	 */
	function get_the_slug() {
		$post_data = get_post($post->ID, ARRAY_A);
		$slug = $post_data['post_name'];
		return $slug; 
	}
	
	/**
	 * Returns an array of prices and dates organized by ID.
	 */
	function get_price_history($item_IDs, $days_of_prices)
	{
		global $wpdb;
		// Save price information to the price log
		$query = 'SELECT ID, item_ID, price, DATE_FORMAT(price_date, "%m-%d") AS price_date FROM '.$wpdb->prefix.'item_price_log';
		$i = 0;
		if (is_array($item_IDs))
		{
			foreach ($item_IDs as $item_ID)
			{
				if ($i > 0) {
					$query .= ' OR item_ID = ' . $item_ID;
				} else {
					$query .= ' WHERE item_ID = ' . $item_ID;
				}
				$i++;
			}
			$query .=' ORDER BY ID DESC LIMIT 0, ' . ($days_of_prices * count($item_IDs));
			$result = $wpdb->get_results($query);
			return $result;
		}
		return false;
	}