<?php
/**
 * Yuvakushwahasamaj Child Theme Functions
 * 
 * This file handles:
 * - Enqueuing parent and child theme styles
 * - Registering custom post types
 * - Registering ACF field groups
 */

// Enqueue parent theme styles
function yuvakushwahasamaj_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_uri(), array( 'parent-style' ) );
}
add_action( 'wp_enqueue_scripts', 'yuvakushwahasamaj_enqueue_styles' );


/**
 * Register navigation menu locations.
 * Assign menus via Appearance → Menus.
 */
function yuvakushwahasamaj_register_menus() {
	register_nav_menus( array(
		'primary' => 'Primary Navigation',
		'footer'  => 'Footer Navigation',
	) );
}
add_action( 'after_setup_theme', 'yuvakushwahasamaj_register_menus' );


/**
 * Editorial ornament — small decorative divider used under section headings.
 * Returns inline SVG. Variant 'light' uses cream color for dark backgrounds.
 */
if ( ! function_exists( 'yks_ornament' ) ) {
	function yks_ornament( $variant = 'default' ) {
		$color = $variant === 'light' ? '#f3ead9' : '#c8541c';
		ob_start();
		?>
		<svg class="hs-ornament" width="68" height="14" viewBox="0 0 68 14" fill="none" aria-hidden="true">
			<path d="M2 7h22" stroke="<?php echo esc_attr( $color ); ?>" stroke-width="1.2" stroke-linecap="round"/>
			<path d="M44 7h22" stroke="<?php echo esc_attr( $color ); ?>" stroke-width="1.2" stroke-linecap="round"/>
			<path d="M34 1c2 2 4 4 4 6s-2 4-4 6c-2-2-4-4-4-6s2-4 4-6z" stroke="<?php echo esc_attr( $color ); ?>" stroke-width="1.2" fill="none"/>
			<circle cx="34" cy="7" r="1.2" fill="<?php echo esc_attr( $color ); ?>"/>
		</svg>
		<?php
		return ob_get_clean();
	}
}


/**
 * Register Custom Post Types
 */
function yuvakushwahasamaj_register_post_types() {
	
	// Home Sections Post Type
	register_post_type( 'home_section', array(
		'label'             => 'Home Sections',
		'public'            => true,
		'has_archive'       => true,
		'hierarchical'      => false,
		'show_in_rest'      => true,
		'menu_position'     => 5,
		'menu_icon'         => 'dashicons-layout',
		'supports'          => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'rewrite'           => array( 'slug' => 'home-section' ),
		'labels'            => array(
			'singular_name' => 'Home Section',
			'all_items'     => 'All Home Sections',
			'add_new_item'  => 'Add New Home Section',
		),
	) );

	// Events Post Type
	register_post_type( 'event', array(
		'label'             => 'Events',
		'public'            => true,
		'has_archive'       => true,
		'hierarchical'      => false,
		'show_in_rest'      => true,
		'menu_position'     => 6,
		'menu_icon'         => 'dashicons-calendar-alt',
		'supports'          => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'rewrite'           => array( 'slug' => 'event' ),
		'labels'            => array(
			'singular_name' => 'Event',
			'all_items'     => 'All Events',
			'add_new_item'  => 'Add New Event',
		),
	) );

	// Team Members Post Type
	register_post_type( 'team_member', array(
		'label'             => 'Team Members',
		'public'            => true,
		'has_archive'       => true,
		'hierarchical'      => false,
		'show_in_rest'      => true,
		'menu_position'     => 7,
		'menu_icon'         => 'dashicons-groups',
		'supports'          => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'rewrite'           => array( 'slug' => 'team-member' ),
		'labels'            => array(
			'singular_name' => 'Team Member',
			'all_items'     => 'All Team Members',
			'add_new_item'  => 'Add New Team Member',
		),
	) );

	// Gallery Items Post Type
	// NOTE: has_archive disabled and rewrite slug changed to 'gallery-item' so that
	// the /gallery/ URL is freed for the WordPress "Gallery" page (which loops
	// gallery_items via templates/page-gallery.php).
	register_post_type( 'gallery_item', array(
		'label'             => 'Gallery',
		'public'            => true,
		'has_archive'       => false,
		'hierarchical'      => false,
		'show_in_rest'      => true,
		'menu_position'     => 8,
		'menu_icon'         => 'dashicons-format-gallery',
		'supports'          => array( 'title', 'thumbnail', 'custom-fields' ),
		'rewrite'           => array( 'slug' => 'gallery-item' ),
		'labels'            => array(
			'singular_name' => 'Gallery Item',
			'all_items'     => 'All Gallery Items',
			'add_new_item'  => 'Add New Gallery Item',
		),
	) );

	// Register custom taxonomies for events and gallery
	register_taxonomy( 'event_category', 'event', array(
		'label'             => 'Event Categories',
		'public'            => true,
		'show_in_rest'      => true,
		'hierarchical'      => true,
		'rewrite'           => array( 'slug' => 'event-category' ),
	) );

	register_taxonomy( 'gallery_category', 'gallery_item', array(
		'label'             => 'Gallery Categories',
		'public'            => true,
		'show_in_rest'      => true,
		'hierarchical'      => true,
		'rewrite'           => array( 'slug' => 'gallery-category' ),
	) );
}
add_action( 'init', 'yuvakushwahasamaj_register_post_types' );


/**
 * One-time rewrite flush after the gallery_item slug change.
 * Bumps when the rule set changes; old installs auto-flush once.
 */
function yuvakushwahasamaj_maybe_flush_rewrites() {
	$version = '2';
	if ( get_option( 'yks_rewrite_version' ) !== $version ) {
		flush_rewrite_rules( false );
		update_option( 'yks_rewrite_version', $version );
	}
}
add_action( 'init', 'yuvakushwahasamaj_maybe_flush_rewrites', 99 );


/**
 * Force child-theme PHP templates to win over parent block-theme HTML
 * templates. In a block theme (parent = TwentyTwentyFive), `.html` templates
 * normally take priority — this filter overrides that for our custom PHP files.
 */
function yuvakushwahasamaj_force_php_templates( $template ) {
	$child_dir = get_stylesheet_directory();

	// Single posts → child single.php
	if ( is_singular( 'post' ) ) {
		$candidate = $child_dir . '/single.php';
		if ( file_exists( $candidate ) ) return $candidate;
	}

	// Front page → child front-page.php
	if ( is_front_page() ) {
		$candidate = $child_dir . '/front-page.php';
		if ( file_exists( $candidate ) ) return $candidate;
	}

	// Page with assigned PHP template (e.g. templates/page-gallery.php) → honor it
	if ( is_page() ) {
		$assigned = get_page_template_slug( get_queried_object_id() );
		if ( $assigned && substr( $assigned, -4 ) === '.php' ) {
			$candidate = $child_dir . '/' . $assigned;
			if ( file_exists( $candidate ) ) return $candidate;
		}
	}

	return $template;
}
add_filter( 'template_include', 'yuvakushwahasamaj_force_php_templates', 99 );


/**
 * Resolve a clean, human-readable author byline for a post.
 *
 * Priority order:
 *   1. Per-post `_yks_byline` meta (set by the seeder or manually)
 *   2. Author's "First Last" (if both fields are populated)
 *   3. Author's display_name (only if it's NOT the same as the login)
 *   4. Fallback to "Editorial Team"
 */
function yks_get_author_byline( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$post    = get_post( $post_id );
	if ( ! $post ) return 'Editorial Team';

	$override = get_post_meta( $post_id, '_yks_byline', true );
	if ( $override ) return $override;

	$author_id = $post->post_author;
	$first     = trim( get_the_author_meta( 'first_name', $author_id ) );
	$last      = trim( get_the_author_meta( 'last_name', $author_id ) );
	if ( $first || $last ) return trim( $first . ' ' . $last );

	$display = get_the_author_meta( 'display_name', $author_id );
	$login   = get_the_author_meta( 'user_login', $author_id );
	if ( $display && strcasecmp( $display, $login ) !== 0 ) return $display;

	return 'Editorial Team';
}


/**
 * Custom Meta Fields Helper Functions
 * Uses WordPress native post meta with Secure Custom Fields (SCF) plugin
 */

/**
 * Get custom field value using post meta
 * 
 * @param string $field_name Field name
 * @param int $post_id Post ID
 * @param mixed $default Default value
 * @return mixed Field value
 */
function get_scf_field( $field_name, $post_id = 0, $default = '' ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	return get_post_meta( $post_id, $field_name, true ) ?: $default;
}

/**
 * Update custom field value
 */
function update_scf_field( $field_name, $value, $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	return update_post_meta( $post_id, $field_name, $value );
}


/**
 * Helper function to get home sections ordered by date
 */
function get_home_sections() {
	$args = array(
		'post_type'      => 'home_section',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	);
	return get_posts( $args );
}

/**
 * Helper function to get upcoming events
 */
function get_upcoming_events( $limit = 3 ) {
	$args = array(
		'post_type'      => 'event',
		'posts_per_page' => $limit,
		'meta_query'     => array(
			array(
				'key'     => 'event_status',
				'value'   => 'upcoming',
				'compare' => '==',
			),
		),
		'orderby'        => 'meta_value',
		'meta_key'       => 'event_date',
		'order'          => 'ASC',
	);
	return get_posts( $args );
}

/**
 * Helper function to get gallery items
 */
function get_gallery_items( $limit = 6, $category = '' ) {
	$args = array(
		'post_type'      => 'gallery_item',
		'posts_per_page' => $limit,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);
	
	if ( ! empty( $category ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'gallery_category',
				'field'    => 'slug',
				'terms'    => $category,
			),
		);
	}
	
	return get_posts( $args );
}

/**
 * Helper function to get team members
 */
function get_team_members() {
	$args = array(
		'post_type'      => 'team_member',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	);
	return get_posts( $args );
}


/**
 * Register SCF (Secure Custom Fields) field groups.
 * Field keys / names must match what templates read via get_scf_field().
 */
function yuvakushwahasamaj_register_field_groups() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// Home Sections
	acf_add_local_field_group( array(
		'key'      => 'group_home_section',
		'title'    => 'Home Section Details',
		'location' => array( array( array(
			'param'    => 'post_type',
			'operator' => '==',
			'value'    => 'home_section',
		) ) ),
		'fields'   => array(
			array(
				'key'     => 'field_hs_section_type',
				'label'   => 'Section Type',
				'name'    => 'section_type',
				'type'    => 'select',
				'choices' => array(
					'hero'         => 'Hero Banner',
					'about'        => 'About Brief',
					'stats'        => 'Key Stats',
					'events'       => 'Latest Events',
					'gallery'      => 'Gallery Preview',
					'testimonials' => 'Testimonials',
					'news'         => 'News Ticker',
					'cta'          => 'Join Us CTA',
				),
			),
			array( 'key' => 'field_hs_hero_image',       'label' => 'Hero Image',       'name' => 'hero_image',       'type' => 'image',   'return_format' => 'id' ),
			array( 'key' => 'field_hs_hero_tagline',     'label' => 'Hero Tagline',     'name' => 'hero_tagline',     'type' => 'text' ),
			array( 'key' => 'field_hs_cta_button_text',  'label' => 'CTA Button Text',  'name' => 'cta_button_text',  'type' => 'text' ),
			array( 'key' => 'field_hs_cta_button_link',  'label' => 'CTA Button Link',  'name' => 'cta_button_link',  'type' => 'text' ),
			array( 'key' => 'field_hs_about_excerpt',    'label' => 'About Excerpt',    'name' => 'about_excerpt',    'type' => 'textarea' ),
			array( 'key' => 'field_hs_read_more_link',   'label' => 'Read More Link',   'name' => 'read_more_link',   'type' => 'url' ),
			array(
				'key'          => 'field_hs_stats_items',
				'label'        => 'Stats Items',
				'name'         => 'stats_items',
				'type'         => 'textarea',
				'instructions' => 'One stat per line, format: "10000+|Members"',
			),
		),
	) );

	// Events
	acf_add_local_field_group( array(
		'key'      => 'group_event',
		'title'    => 'Event Details',
		'location' => array( array( array(
			'param'    => 'post_type',
			'operator' => '==',
			'value'    => 'event',
		) ) ),
		'fields'   => array(
			array( 'key' => 'field_event_date',        'label' => 'Event Date',        'name' => 'event_date',        'type' => 'date_picker',  'return_format' => 'Y-m-d', 'display_format' => 'd/m/Y' ),
			array( 'key' => 'field_event_time',        'label' => 'Event Time',        'name' => 'event_time',        'type' => 'time_picker',  'return_format' => 'g:i a' ),
			array( 'key' => 'field_event_venue',       'label' => 'Venue',             'name' => 'event_venue',       'type' => 'text' ),
			array( 'key' => 'field_event_image',       'label' => 'Event Image',       'name' => 'event_image',       'type' => 'image', 'return_format' => 'id' ),
			array( 'key' => 'field_event_description', 'label' => 'Event Description', 'name' => 'event_description', 'type' => 'textarea' ),
			array( 'key' => 'field_event_register',    'label' => 'Registration Link', 'name' => 'register_link',     'type' => 'url' ),
			array(
				'key'           => 'field_event_status',
				'label'         => 'Status',
				'name'          => 'event_status',
				'type'          => 'select',
				'default_value' => 'upcoming',
				'choices'       => array(
					'upcoming'  => 'Upcoming',
					'completed' => 'Completed',
				),
			),
		),
	) );

	// Team Members
	acf_add_local_field_group( array(
		'key'      => 'group_team_member',
		'title'    => 'Team Member Details',
		'location' => array( array( array(
			'param'    => 'post_type',
			'operator' => '==',
			'value'    => 'team_member',
		) ) ),
		'fields'   => array(
			array( 'key' => 'field_tm_designation',   'label' => 'Designation',   'name' => 'designation',   'type' => 'text' ),
			array( 'key' => 'field_tm_photo',         'label' => 'Photo',         'name' => 'photo',         'type' => 'image', 'return_format' => 'id' ),
			array( 'key' => 'field_tm_bio',           'label' => 'Bio',           'name' => 'bio',           'type' => 'textarea' ),
			array( 'key' => 'field_tm_contact_email', 'label' => 'Contact Email', 'name' => 'contact_email', 'type' => 'email' ),
		),
	) );

	// Gallery Items
	acf_add_local_field_group( array(
		'key'      => 'group_gallery_item',
		'title'    => 'Gallery Item Details',
		'location' => array( array( array(
			'param'    => 'post_type',
			'operator' => '==',
			'value'    => 'gallery_item',
		) ) ),
		'fields'   => array(
			array( 'key' => 'field_gi_image',   'label' => 'Image',   'name' => 'image',   'type' => 'image', 'return_format' => 'id' ),
			array( 'key' => 'field_gi_caption', 'label' => 'Caption', 'name' => 'caption', 'type' => 'text' ),
			array( 'key' => 'field_gi_year',    'label' => 'Year',    'name' => 'year',    'type' => 'number' ),
		),
	) );

	// About Us page — fields bound to the About Us page template
	acf_add_local_field_group( array(
		'key'      => 'group_page_about',
		'title'    => 'About Page Content',
		'location' => array( array( array(
			'param'    => 'page_template',
			'operator' => '==',
			'value'    => 'templates/page-about.php',
		) ) ),
		'fields'   => array(
			array( 'key' => 'field_about_hero_image',    'label' => 'Hero Image (optional)',           'name' => 'about_hero_image',    'type' => 'image', 'return_format' => 'id' ),
			array( 'key' => 'field_about_intro',         'label' => 'Intro Tagline (above the title)', 'name' => 'about_intro',         'type' => 'text' ),

			array( 'key' => 'field_about_mission_title', 'label' => 'Mission Title',                   'name' => 'about_mission_title', 'type' => 'text',     'default_value' => 'Our Mission' ),
			array( 'key' => 'field_about_mission_text',  'label' => 'Mission Text',                    'name' => 'about_mission_text',  'type' => 'textarea', 'rows' => 4 ),
			array( 'key' => 'field_about_mission_icon', 'label' => 'Mission Icon',                     'name' => 'about_mission_icon',  'type' => 'image',    'return_format' => 'id' ),

			array( 'key' => 'field_about_vision_title',  'label' => 'Vision Title',                    'name' => 'about_vision_title',  'type' => 'text',     'default_value' => 'Our Vision' ),
			array( 'key' => 'field_about_vision_text',   'label' => 'Vision Text',                     'name' => 'about_vision_text',   'type' => 'textarea', 'rows' => 4 ),
			array( 'key' => 'field_about_vision_icon',  'label' => 'Vision Icon',                      'name' => 'about_vision_icon',   'type' => 'image',    'return_format' => 'id' ),

			array( 'key' => 'field_about_values_title',  'label' => 'Values Title',                    'name' => 'about_values_title',  'type' => 'text',     'default_value' => 'Our Values' ),
			array( 'key' => 'field_about_values_text',   'label' => 'Values Text',                     'name' => 'about_values_text',   'type' => 'textarea', 'rows' => 4 ),
			array( 'key' => 'field_about_values_icon',  'label' => 'Values Icon',                      'name' => 'about_values_icon',   'type' => 'image',    'return_format' => 'id' ),

			array(
				'key'         => 'field_about_reach_stats',
				'label'       => 'Reach Stats (one per line: NUMBER|LABEL — e.g. "15+|States Covered")',
				'name'        => 'about_reach_stats',
				'type'        => 'textarea',
				'rows'        => 4,
				'default_value' => "15+|States Covered\n50+|Districts Covered\n25+|Community Centers",
			),
			array(
				'key'         => 'field_about_affiliations',
				'label'       => 'Affiliations (one per line)',
				'name'        => 'about_affiliations',
				'type'        => 'textarea',
				'rows'        => 5,
				'default_value' => "Recognized by State Government for Community Services\nMember of National Youth Council\nOfficial Partner with Cultural Preservation Organizations\nAccredited by Social Development Forum",
			),
		),
	) );
}
add_action( 'acf/init', 'yuvakushwahasamaj_register_field_groups' );


/**
 * One-click demo content seeder.
 *
 * Visit /wp-admin/?yks_seed_demo=1 while logged in as admin to populate:
 *   - 8 Home Section posts (one per section_type)
 *   - 3 Events
 *   - 4 Team Members
 *   - 6 Gallery Items
 *
 * Safe to run once. Sets the option `yks_demo_seeded` to prevent duplicates.
 * To re-seed, delete that option (or pass &force=1) and any auto-created posts.
 */
function yuvakushwahasamaj_seed_demo_content() {
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( empty( $_GET['yks_seed_demo'] ) ) {
		return;
	}
	$force = ! empty( $_GET['force'] );
	if ( get_option( 'yks_demo_seeded' ) && ! $force ) {
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-warning"><p><strong>Demo content already seeded.</strong> Append <code>&force=1</code> to re-seed.</p></div>';
		} );
		return;
	}

	$created = array( 'home_section' => 0, 'event' => 0, 'team_member' => 0, 'gallery_item' => 0 );

	$home_sections = array(
		array(
			'title' => 'Hero Section',
			'order' => 1,
			'meta'  => array(
				'section_type'    => 'hero',
				'hero_tagline'    => 'एकता | युवा | प्रगति',
				'cta_button_text' => 'हमसे जुड़ें (Join Us)',
				'cta_button_link' => '/membership/',
			),
			'content' => 'Welcome to Yuvakushwahasamaj — a vibrant community dedicated to youth empowerment, cultural preservation, and social progress.',
		),
		array(
			'title' => 'About Our Community',
			'order' => 2,
			'meta'  => array(
				'section_type'   => 'about',
				'about_excerpt'  => 'We are dedicated to youth empowerment, cultural preservation, and social progress. Together we build a stronger tomorrow.',
				'read_more_link' => '/about/',
			),
			'content' => 'Founded with a vision of unity and progress, our community has grown to serve thousands of members across multiple states.',
		),
		array(
			'title' => 'Our Impact',
			'order' => 3,
			'meta'  => array(
				'section_type' => 'stats',
				'stats_items'  => "10,000+|Active Members\n150+|Events Held\n15+|Years Active\n50+|Districts Reached",
			),
			'content' => '',
		),
		array(
			'title' => 'Upcoming Events',
			'order' => 4,
			'meta'  => array( 'section_type' => 'events' ),
			'content' => '',
		),
		array(
			'title' => 'Community Moments',
			'order' => 5,
			'meta'  => array( 'section_type' => 'gallery' ),
			'content' => '',
		),
		array(
			'title' => 'What Our Members Say',
			'order' => 6,
			'meta'  => array( 'section_type' => 'testimonials' ),
			'content' => "<blockquote>“Joining this community changed my outlook on social service. The events are inspiring.”<br><cite>— Priya Sharma, Member since 2020</cite></blockquote>\n\n<blockquote>“The youth programs gave me leadership skills I use every day.”<br><cite>— Rahul Verma, Youth Wing</cite></blockquote>",
		),
		array(
			'title' => 'Latest Announcements',
			'order' => 7,
			'meta'  => array( 'section_type' => 'news' ),
			'content' => "📢 Annual Sammelan 2026 registration now open — early bird discount until June 30.\n\n📢 New chapter launching in Pune next month.\n\n📢 Community scholarship applications close July 15.",
		),
		array(
			'title' => 'Ready to Join Our Community?',
			'order' => 8,
			'meta'  => array(
				'section_type'    => 'cta',
				'cta_button_text' => 'हमसे जुड़ें (Join Us)',
				'cta_button_link' => '/membership/',
			),
			'content' => 'Be part of a movement driving youth engagement, cultural preservation, and social progress.',
		),
	);
	foreach ( $home_sections as $hs ) {
		$id = wp_insert_post( array(
			'post_type'    => 'home_section',
			'post_status'  => 'publish',
			'post_title'   => $hs['title'],
			'post_content' => $hs['content'],
			'menu_order'   => $hs['order'],
		) );
		if ( $id && ! is_wp_error( $id ) ) {
			foreach ( $hs['meta'] as $k => $v ) {
				update_post_meta( $id, $k, $v );
			}
			$created['home_section']++;
		}
	}

	$events = array(
		array(
			'title'   => 'Annual Youth Sammelan 2026',
			'content' => 'Our flagship annual gathering bringing together community members from across the region.',
			'meta'    => array(
				'event_date'        => '2026-08-15',
				'event_time'        => '10:00 am',
				'event_venue'       => 'Community Hall, Lucknow',
				'event_status'      => 'upcoming',
				'register_link'     => 'https://example.com/register',
				'event_description' => 'A full day of cultural programs, workshops, and community awards.',
			),
		),
		array(
			'title'   => 'Cultural Heritage Workshop',
			'content' => 'Learn traditional arts and crafts from master artisans.',
			'meta'    => array(
				'event_date'   => '2026-07-10',
				'event_time'   => '2:00 pm',
				'event_venue'  => 'Cultural Centre, Kanpur',
				'event_status' => 'upcoming',
			),
		),
		array(
			'title'   => 'Youth Leadership Summit',
			'content' => 'Empowering the next generation of community leaders.',
			'meta'    => array(
				'event_date'   => '2026-06-20',
				'event_time'   => '9:00 am',
				'event_venue'  => 'Conference Hall, Allahabad',
				'event_status' => 'upcoming',
			),
		),
	);
	foreach ( $events as $e ) {
		$id = wp_insert_post( array(
			'post_type'    => 'event',
			'post_status'  => 'publish',
			'post_title'   => $e['title'],
			'post_content' => $e['content'],
		) );
		if ( $id && ! is_wp_error( $id ) ) {
			foreach ( $e['meta'] as $k => $v ) {
				update_post_meta( $id, $k, $v );
			}
			$created['event']++;
		}
	}

	$members = array(
		array( 'title' => 'Dr. Ramesh Kushwaha', 'meta' => array( 'designation' => 'President', 'bio' => 'Leading the community for over a decade with vision and dedication.', 'contact_email' => 'president@example.com' ) ),
		array( 'title' => 'Sunita Devi',          'meta' => array( 'designation' => 'Vice President', 'bio' => 'Champion of women empowerment and youth development programs.', 'contact_email' => 'vp@example.com' ) ),
		array( 'title' => 'Anil Kumar',           'meta' => array( 'designation' => 'Secretary', 'bio' => 'Coordinating community activities and member engagement.', 'contact_email' => 'secretary@example.com' ) ),
		array( 'title' => 'Pooja Sharma',         'meta' => array( 'designation' => 'Youth Wing Head', 'bio' => 'Driving youth participation and leadership initiatives.', 'contact_email' => 'youth@example.com' ) ),
	);
	foreach ( $members as $m ) {
		$id = wp_insert_post( array(
			'post_type'   => 'team_member',
			'post_status' => 'publish',
			'post_title'  => $m['title'],
		) );
		if ( $id && ! is_wp_error( $id ) ) {
			foreach ( $m['meta'] as $k => $v ) {
				update_post_meta( $id, $k, $v );
			}
			$created['team_member']++;
		}
	}

	$gallery = array(
		array( 'title' => 'Annual Sammelan 2025',     'meta' => array( 'caption' => 'Members gathered for our biggest event of the year.', 'year' => '2025' ) ),
		array( 'title' => 'Cultural Program',          'meta' => array( 'caption' => 'Traditional dance performance.',                       'year' => '2025' ) ),
		array( 'title' => 'Youth Workshop',            'meta' => array( 'caption' => 'Skill development session for young members.',         'year' => '2025' ) ),
		array( 'title' => 'Community Service Drive',   'meta' => array( 'caption' => 'Volunteers distributing supplies.',                    'year' => '2024' ) ),
		array( 'title' => 'Independence Day Function', 'meta' => array( 'caption' => 'Celebrating our nation together.',                     'year' => '2024' ) ),
		array( 'title' => 'Health Camp',               'meta' => array( 'caption' => 'Free medical checkup for community members.',          'year' => '2024' ) ),
	);
	foreach ( $gallery as $g ) {
		$id = wp_insert_post( array(
			'post_type'   => 'gallery_item',
			'post_status' => 'publish',
			'post_title'  => $g['title'],
		) );
		if ( $id && ! is_wp_error( $id ) ) {
			foreach ( $g['meta'] as $k => $v ) {
				update_post_meta( $id, $k, $v );
			}
			$created['gallery_item']++;
		}
	}

	update_option( 'yks_demo_seeded', current_time( 'mysql' ) );

	add_action( 'admin_notices', function () use ( $created ) {
		printf(
			'<div class="notice notice-success is-dismissible"><p><strong>Demo content seeded:</strong> %d Home Sections, %d Events, %d Team Members, %d Gallery Items. Visit the homepage to see them. Upload images via each post\'s SCF fields to complete the look.</p></div>',
			$created['home_section'],
			$created['event'],
			$created['team_member'],
			$created['gallery_item']
		);
	} );
}
add_action( 'admin_init', 'yuvakushwahasamaj_seed_demo_content' );


/**
 * Blog post seeder.
 *
 * Visit /wp-admin/?yks_seed_posts=1 to populate 6 sample blog posts
 * across categories: News, Youth Achievements, Community Events, Cultural.
 *
 * Separate from the main seeder so you can run it independently.
 * Re-run with &force=1.
 */
function yuvakushwahasamaj_seed_demo_posts() {
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( empty( $_GET['yks_seed_posts'] ) ) {
		return;
	}
	$force = ! empty( $_GET['force'] );
	if ( get_option( 'yks_posts_seeded' ) && ! $force ) {
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-warning"><p><strong>Blog posts already seeded.</strong> Append <code>&force=1</code> to re-seed.</p></div>';
		} );
		return;
	}

	// Ensure categories exist.
	$category_slugs = array(
		'news'                => 'News',
		'youth-achievements'  => 'Youth Achievements',
		'community-events'    => 'Community Events',
		'cultural'            => 'Cultural',
	);
	$category_ids = array();
	foreach ( $category_slugs as $slug => $name ) {
		$term = term_exists( $slug, 'category' );
		if ( ! $term ) {
			$term = wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
		}
		if ( ! is_wp_error( $term ) ) {
			$category_ids[ $slug ] = is_array( $term ) ? (int) $term['term_id'] : (int) $term;
		}
	}

	$posts = array(
		array(
			'title'    => 'Annual Youth Sammelan 2026 — Registration Now Open',
			'category' => 'news',
			'date'     => '-2 days',
			'byline'   => 'Anil Kumar',
			'content'  => "We're thrilled to announce that registration for the Annual Youth Sammelan 2026 is now officially open! This year's theme — \"Empowered Youth, Stronger Community\" — promises to be our most impactful gathering yet.\n\n<h3>What to Expect</h3>\nThe Sammelan will bring together over 1,000 community members for a full day of cultural performances, leadership workshops, networking sessions, and the annual community awards ceremony.\n\n<h3>Early Bird Discount</h3>\nRegister before June 30, 2026 to receive a 25% discount on registration fees. Members below 25 years of age receive an additional 50% youth discount.\n\n<h3>How to Register</h3>\nVisit the Events page to book your spot. Limited seats available — register early to avoid disappointment.\n\nFor any queries, contact our coordination team at events@yuvakushwahasamaj.org.",
		),
		array(
			'title'    => 'Priya Sharma Wins National Scholarship for Higher Education',
			'category' => 'youth-achievements',
			'date'     => '-7 days',
			'byline'   => 'Pooja Sharma',
			'content'  => "We are immensely proud to share that Priya Sharma, a long-time member of our youth wing, has been awarded the prestigious National Merit Scholarship for her outstanding academic performance and community service.\n\nPriya has been an active member since 2020 and has consistently championed initiatives around girls' education and digital literacy in rural areas. The scholarship will support her Master's program in Public Policy at a leading institution.\n\n<blockquote>\"This community has been my second family. Every workshop, every program shaped who I am today.\" — Priya Sharma</blockquote>\n\nJoin us in congratulating Priya. Her journey is an inspiration to every young member working toward their dreams.",
		),
		array(
			'title'    => 'New Community Center Opens in Pune',
			'category' => 'community-events',
			'date'     => '-14 days',
			'byline'   => 'Sunita Devi',
			'content'  => "After months of planning and dedication from our local volunteers, we are delighted to announce the inauguration of our 26th community center, located in the heart of Pune.\n\nThe new center features:\n<ul>\n<li>A multi-purpose hall accommodating up to 300 attendees</li>\n<li>Dedicated youth library with over 2,000 books</li>\n<li>Computer training lab with 20 workstations</li>\n<li>Yoga and meditation room</li>\n<li>Children's play area</li>\n</ul>\n\nThe inauguration ceremony was graced by senior community leaders and over 400 attendees. Programs at the new center begin from June 1, 2026.\n\nFor membership and program enrollment, please contact our Pune coordinators.",
		),
		array(
			'title'    => 'Celebrating Holi: A Festival of Unity and Colors',
			'category' => 'cultural',
			'date'     => '-21 days',
			'byline'   => 'Dr. Ramesh Kushwaha',
			'content'  => "This year's Holi celebration was nothing short of magical. Over 800 community members from across the region came together at our Lucknow community center for a day filled with colors, music, traditional sweets, and joy.\n\nThe event began with a traditional <em>holika dahan</em> ceremony the previous evening, followed by the main celebration. Cultural programs featured folk dances, devotional music, and a special performance by our youth wing.\n\n<h3>Highlights</h3>\n<ul>\n<li>Organic colors prepared by the women's self-help group</li>\n<li>Traditional gujiya and thandai stalls</li>\n<li>Children's color zone with eco-friendly water games</li>\n<li>Cultural quiz with prizes for participants</li>\n</ul>\n\nA huge thank you to all volunteers who made this event possible. Photos and videos from the celebration are available in our Gallery section.",
		),
		array(
			'title'    => 'Community Health Camp Screens 500+ Members',
			'category' => 'news',
			'date'     => '-30 days',
			'byline'   => 'Anil Kumar',
			'content'  => "In partnership with the District Hospital and Rotary Club, our community organized a free health camp last Sunday, providing essential medical screenings to over 500 members.\n\nServices offered included:\n<ul>\n<li>General physician consultations</li>\n<li>Blood pressure and diabetes screening</li>\n<li>Eye checkups with free reading glasses for seniors</li>\n<li>Dental screening and basic treatments</li>\n<li>Women's health consultations</li>\n</ul>\n\nDr. Rajesh Kumar, the lead physician at the camp, noted that early detection of hypertension and diabetes in 60+ members will significantly improve their quality of life.\n\nThe next health camp is scheduled for August. Watch this space for details.",
		),
		array(
			'title'    => 'Youth Leadership Bootcamp Concludes with 50 New Leaders Trained',
			'category' => 'youth-achievements',
			'date'     => '-45 days',
			'byline'   => 'Pooja Sharma',
			'content'  => "Our 5-day Youth Leadership Bootcamp wrapped up successfully last weekend, training 50 selected participants in essential leadership and community organizing skills.\n\nThe intensive program covered modules on public speaking, project management, conflict resolution, digital outreach, and ethical leadership. Sessions were led by experienced trainers, community elders, and guest speakers from corporate and social sectors.\n\n<h3>Participant Voices</h3>\n<blockquote>\"I came in nervous and left with the confidence to lead my own initiative back home.\" — Rohit, age 22</blockquote>\n\n<blockquote>\"The mentorship sessions were invaluable. I now have a clear path forward.\" — Anjali, age 19</blockquote>\n\nGraduates of this bootcamp will now lead micro-projects in their respective districts over the next six months. Applications for the next batch open in September.",
		),
	);

	$created = 0;
	foreach ( $posts as $p ) {
		$post_date = date( 'Y-m-d H:i:s', strtotime( $p['date'] ) );
		$id = wp_insert_post( array(
			'post_type'     => 'post',
			'post_status'   => 'publish',
			'post_title'    => $p['title'],
			'post_content'  => $p['content'],
			'post_date'     => $post_date,
			'post_date_gmt' => get_gmt_from_date( $post_date ),
			'post_category' => isset( $category_ids[ $p['category'] ] ) ? array( $category_ids[ $p['category'] ] ) : array(),
		) );
		if ( $id && ! is_wp_error( $id ) ) {
			if ( ! empty( $p['byline'] ) ) {
				update_post_meta( $id, '_yks_byline', $p['byline'] );
			}
			$created++;
		}
	}

	update_option( 'yks_posts_seeded', current_time( 'mysql' ) );

	add_action( 'admin_notices', function () use ( $created ) {
		printf(
			'<div class="notice notice-success is-dismissible"><p><strong>Seeded %d blog posts</strong> across News, Youth Achievements, Community Events, and Cultural categories. Visit your News & Blog page to see them.</p></div>',
			$created
		);
	} );
}
add_action( 'admin_init', 'yuvakushwahasamaj_seed_demo_posts' );


/**
 * Page seeder.
 *
 * Visit /wp-admin/?yks_seed_pages=1 to create the standard site pages
 * (About, Events, Gallery, Membership, News & Blog, Contact) with the
 * correct page template assigned to each. Existing pages with matching
 * slugs are updated (template re-assigned) rather than duplicated.
 *
 * Re-run with &force=1.
 */
function yuvakushwahasamaj_seed_demo_pages() {
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( empty( $_GET['yks_seed_pages'] ) ) {
		return;
	}

	$pages = array(
		array( 'slug' => 'about',      'title' => 'About Us',     'template' => 'templates/page-about.php' ),
		array( 'slug' => 'events',     'title' => 'Events',       'template' => 'templates/page-events.php' ),
		array( 'slug' => 'gallery',    'title' => 'Gallery',      'template' => 'templates/page-gallery.php' ),
		array( 'slug' => 'membership', 'title' => 'Membership',   'template' => 'templates/page-membership.php' ),
		array( 'slug' => 'news',       'title' => 'News & Blog',  'template' => 'templates/page-news.php' ),
		array( 'slug' => 'contact',    'title' => 'Contact',      'template' => 'templates/page-contact.php' ),
	);

	$results = array();
	foreach ( $pages as $p ) {
		$existing = get_page_by_path( $p['slug'] );
		if ( $existing ) {
			update_post_meta( $existing->ID, '_wp_page_template', $p['template'] );
			$results[] = array( 'slug' => $p['slug'], 'action' => 'updated', 'id' => $existing->ID );
			continue;
		}
		$id = wp_insert_post( array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $p['title'],
			'post_name'    => $p['slug'],
			'post_content' => '',
		) );
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_wp_page_template', $p['template'] );
			$results[] = array( 'slug' => $p['slug'], 'action' => 'created', 'id' => $id );
		}
	}

	add_action( 'admin_notices', function () use ( $results ) {
		$lines = array();
		foreach ( $results as $r ) {
			$lines[] = sprintf( '<code>/%s/</code> — %s (ID %d)', esc_html( $r['slug'] ), esc_html( $r['action'] ), $r['id'] );
		}
		echo '<div class="notice notice-success is-dismissible"><p><strong>Pages seeded with templates:</strong><br>' . implode( '<br>', $lines ) . '</p><p>If permalinks look wrong, visit <a href="' . esc_url( admin_url( 'options-permalink.php' ) ) . '">Settings → Permalinks</a> and click Save Changes to flush rules.</p></div>';
	} );
}
add_action( 'admin_init', 'yuvakushwahasamaj_seed_demo_pages' );
