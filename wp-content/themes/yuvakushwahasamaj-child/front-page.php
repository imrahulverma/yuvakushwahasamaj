<?php
/**
 * Front Page Template
 *
 * Loops through all `home_section` posts (ordered by menu_order) and renders
 * each one based on its `section_type` SCF field.
 */

get_header();
?>
<main id="main" class="site-main front-page">
<?php
$sections = get_posts( array(
	'post_type'      => 'home_section',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
) );

foreach ( $sections as $section ) {
	setup_postdata( $section );
	$post_id      = $section->ID;
	$section_type = get_scf_field( 'section_type', $post_id );

	switch ( $section_type ) {

		case 'hero':
			$hero_image_id = get_scf_field( 'hero_image', $post_id );
			$tagline       = get_scf_field( 'hero_tagline', $post_id );
			$cta_text     = get_scf_field( 'cta_button_text', $post_id ) ?: 'हमसे जुड़ें (Join Us)';
			$cta_link_raw = get_scf_field( 'cta_button_link', $post_id );
			if ( $cta_link_raw ) {
				$cta_link = preg_match( '#^https?://#i', $cta_link_raw ) ? $cta_link_raw : home_url( $cta_link_raw );
			} else {
				$cta_link = home_url( '/contact/' );
			}
			?>
			<section class="hs-hero">
				<?php if ( $hero_image_id ) : ?>
					<div class="hs-hero-image"><?php echo wp_get_attachment_image( $hero_image_id, 'full' ); ?></div>
				<?php endif; ?>
				<div class="hs-hero-content">
					<!-- <h1><?php echo esc_html( get_the_title( $section ) ); ?></h1> -->
					<?php if ( $tagline ) : ?><p class="hs-hero-tagline"><?php echo esc_html( $tagline ); ?></p><?php endif; ?>
					<a class="hs-cta-btn" href="<?php echo esc_url( $cta_link ); ?>"><?php echo esc_html( $cta_text ); ?></a>
				</div>
			</section>
			<?php
			break;

		case 'about':
			$excerpt   = get_scf_field( 'about_excerpt', $post_id );
			$read_more = get_scf_field( 'read_more_link', $post_id );
			?>
			<section class="hs-about">
				<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
				<?php if ( $excerpt ) : ?>
					<p class="hs-about-excerpt"><?php echo esc_html( $excerpt ); ?></p>
				<?php else : ?>
					<div class="hs-about-content"><?php echo wp_kses_post( apply_filters( 'the_content', $section->post_content ) ); ?></div>
				<?php endif; ?>
				<?php if ( $read_more ) : ?><a class="hs-read-more" href="<?php echo esc_url( $read_more ); ?>">Read More</a><?php endif; ?>
			</section>
			<?php
			break;

		case 'stats':
			$raw   = get_scf_field( 'stats_items', $post_id );
			$lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $raw ) ) );
			?>
			<section class="hs-stats">
				<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
				<div class="hs-stats-grid">
					<?php foreach ( $lines as $line ) :
						$parts = array_map( 'trim', explode( '|', $line, 2 ) );
						$value = $parts[0] ?? '';
						$label = $parts[1] ?? '';
						?>
						<div class="hs-stat">
							<p class="hs-stat-value"><?php echo esc_html( $value ); ?></p>
							<p class="hs-stat-label"><?php echo esc_html( $label ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</section>
			<?php
			break;

		case 'events':
			$events = get_upcoming_events( 3 );
			?>
			<section class="hs-events">
				<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
				<div class="hs-events-grid">
					<?php if ( $events ) : foreach ( $events as $event ) :
						$event_date     = get_scf_field( 'event_date', $event->ID );
						$event_venue    = get_scf_field( 'event_venue', $event->ID );
						$event_image_id = get_scf_field( 'event_image', $event->ID );
						?>
						<article class="hs-event-card">
							<?php if ( $event_image_id ) echo wp_get_attachment_image( $event_image_id, 'medium' ); ?>
							<?php if ( $event_date ) : ?><p class="hs-event-date"><?php echo esc_html( date_i18n( 'F d, Y', strtotime( $event_date ) ) ); ?></p><?php endif; ?>
							<h3><a href="<?php echo esc_url( get_permalink( $event ) ); ?>"><?php echo esc_html( get_the_title( $event ) ); ?></a></h3>
							<?php if ( $event_venue ) : ?><p class="hs-event-venue">📍 <?php echo esc_html( $event_venue ); ?></p><?php endif; ?>
						</article>
					<?php endforeach; else : ?>
						<p>No upcoming events.</p>
					<?php endif; ?>
				</div>
				<p class="hs-events-more"><a href="<?php echo esc_url( home_url( '/events/' ) ); ?>">View All Events →</a></p>
			</section>
			<?php
			break;

		case 'gallery':
			$items = get_gallery_items( 6 );
			?>
			<section class="hs-gallery">
				<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
				<div class="hs-gallery-grid">
					<?php foreach ( $items as $item ) :
						$image_id = get_scf_field( 'image', $item->ID );
						$caption  = get_scf_field( 'caption', $item->ID );
						if ( ! $image_id ) continue;
						?>
						<figure class="hs-gallery-item">
							<?php echo wp_get_attachment_image( $image_id, 'medium' ); ?>
							<?php if ( $caption ) : ?><figcaption><?php echo esc_html( $caption ); ?></figcaption><?php endif; ?>
						</figure>
					<?php endforeach; ?>
				</div>
				<p class="hs-gallery-more"><a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>">View Full Gallery →</a></p>
			</section>
			<?php
			break;

		case 'testimonials':
			?>
			<section class="hs-testimonials">
				<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
				<div class="hs-testimonials-content"><?php echo wp_kses_post( apply_filters( 'the_content', $section->post_content ) ); ?></div>
			</section>
			<?php
			break;

		case 'news':
			$latest_news = get_posts( array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => 6,
			) );
			?>
			<section class="hs-news-section">
				<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
				<?php if ( $section->post_content ) : ?>
					<div class="hs-news-intro"><?php echo wp_kses_post( apply_filters( 'the_content', $section->post_content ) ); ?></div>
				<?php endif; ?>
				<div class="hs-news-grid">
					<?php if ( $latest_news ) : foreach ( $latest_news as $news ) :
						$news_cats = get_the_category( $news->ID );
						$first_cat = $news_cats ? $news_cats[0] : null;
						?>
						<article class="hs-news-card">
							<a class="hs-news-card-image" href="<?php echo esc_url( get_permalink( $news ) ); ?>">
								<?php if ( has_post_thumbnail( $news ) ) {
									echo get_the_post_thumbnail( $news, 'medium_large' );
								} else { ?>
									<div class="hs-news-placeholder">📰</div>
								<?php } ?>
								<?php if ( $first_cat ) : ?>
									<span class="hs-news-cat"><?php echo esc_html( $first_cat->name ); ?></span>
								<?php endif; ?>
							</a>
							<div class="hs-news-card-body">
								<p class="hs-news-date"><?php echo esc_html( get_the_date( 'F j, Y', $news ) ); ?></p>
								<h3 class="hs-news-title"><a href="<?php echo esc_url( get_permalink( $news ) ); ?>"><?php echo esc_html( get_the_title( $news ) ); ?></a></h3>
								<p class="hs-news-excerpt"><?php echo esc_html( wp_trim_words( strip_shortcodes( wp_strip_all_tags( $news->post_content ) ), 18 ) ); ?></p>
								<a class="hs-news-more" href="<?php echo esc_url( get_permalink( $news ) ); ?>">Read More →</a>
							</div>
						</article>
					<?php endforeach; else : ?>
						<p class="hs-news-empty">No posts published yet.</p>
					<?php endif; ?>
				</div>
				<p class="hs-news-cta"><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">View All News →</a></p>
			</section>
			<?php
			break;

		case 'cta':
			$cta_text = get_scf_field( 'cta_button_text', $post_id ) ?: 'Join Us';
			$cta_link = get_scf_field( 'cta_button_link', $post_id ) ?: home_url( '/membership/' );
			?>
			<section class="hs-cta-banner">
				<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
				<div class="hs-cta-body"><?php echo wp_kses_post( apply_filters( 'the_content', $section->post_content ) ); ?></div>
				<a class="hs-cta-btn" href="<?php echo esc_url( $cta_link ); ?>"><?php echo esc_html( $cta_text ); ?></a>
			</section>
			<?php
			break;

		default:
			?>
			<section class="hs-generic">
				<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
				<div><?php echo wp_kses_post( apply_filters( 'the_content', $section->post_content ) ); ?></div>
			</section>
			<?php
			break;
	}
}
wp_reset_postdata();
?>
</main>

<style>
.front-page{font-family:inherit;color:#222}
.front-page section{padding:80px 20px;position:relative}
.front-page section > h2{font-size:2.4rem;text-align:center;margin:0 0 16px;color:#222;position:relative}
.front-page section > h2::after{content:"";display:block;width:60px;height:4px;background:linear-gradient(90deg,#ff9933,#138808);margin:14px auto 0;border-radius:2px}

/* ---------- Hero ---------- */
.hs-hero{padding:0 !important;min-height:560px;display:flex;align-items:center;justify-content:center;text-align:center;color:#fff;position:relative;overflow:hidden;background:linear-gradient(135deg,#ff9933 0%,#138808 100%)}
.hs-hero-image{position:absolute;inset:0;z-index:0}
.hs-hero-image img{width:100%;height:100%;object-fit:cover;filter:brightness(.55)}
.hs-hero-content{position:relative;z-index:1;max-width:900px;padding:80px 20px;animation:fadeUp .8s ease}
.hs-hero-content h1{font-size:3.4rem;font-weight:800;margin:0 0 18px;line-height:1.1;text-shadow:0 2px 10px rgba(0,0,0,.4)}
.hs-hero-tagline{font-size:1.4rem;margin:0 0 32px;font-weight:300;text-shadow:0 2px 8px rgba(0,0,0,.4)}
.hs-cta-btn{display:inline-block;background:#fff;color:#ff9933;padding:14px 40px;border-radius:40px;text-decoration:none;font-weight:700;font-size:1.05rem;box-shadow:0 4px 14px rgba(0,0,0,.2);transition:all .3s}
.hs-cta-btn:hover{transform:translateY(-3px);box-shadow:0 8px 20px rgba(0,0,0,.3);background:#ff9933;color:#fff}
@keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}

/* ---------- About ---------- */
.hs-about{background:#fff;max-width:1100px;margin:0 auto;text-align:center}
.hs-about-excerpt,.hs-about-content{font-size:1.15rem;line-height:1.8;color:#555;max-width:800px;margin:0 auto 30px}
.hs-read-more{display:inline-block;color:#ff9933;font-weight:600;text-decoration:none;padding:10px 24px;border:2px solid #ff9933;border-radius:30px;transition:all .25s}
.hs-read-more:hover{background:#ff9933;color:#fff}

/* ---------- Stats ---------- */
.hs-stats{background:linear-gradient(135deg,#ff9933 0%,#e68a2e 50%,#138808 100%);color:#fff;text-align:center}
.hs-stats > h2{color:#fff}
.hs-stats > h2::after{background:#fff}
.hs-stats-grid{max-width:1100px;margin:50px auto 0;display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:30px}
.hs-stat{padding:30px 20px;background:rgba(255,255,255,.12);border-radius:14px;backdrop-filter:blur(4px);transition:transform .25s}
.hs-stat:hover{transform:translateY(-6px)}
.hs-stat-value{font-size:3.2rem;font-weight:800;margin:0;line-height:1;text-shadow:0 2px 8px rgba(0,0,0,.2)}
.hs-stat-label{font-size:1rem;margin:10px 0 0;font-weight:500;opacity:.95;letter-spacing:.5px}

/* ---------- Events ---------- */
.hs-events{background:#f9f9f9}
.hs-events-grid{max-width:1200px;margin:50px auto 30px;display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:30px}
.hs-event-card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.06);transition:transform .3s,box-shadow .3s}
.hs-event-card:hover{transform:translateY(-6px);box-shadow:0 10px 24px rgba(0,0,0,.12)}
.hs-event-card img{width:100%;height:220px;object-fit:cover;display:block}
.hs-event-card .hs-event-date,.hs-event-card h3,.hs-event-card .hs-event-venue{padding:0 22px}
.hs-event-card .hs-event-date{color:#ff9933;font-weight:700;font-size:.85rem;margin:20px 0 8px;text-transform:uppercase;letter-spacing:1px}
.hs-event-card h3{font-size:1.25rem;margin:0 0 10px;line-height:1.35}
.hs-event-card h3 a{color:#222;text-decoration:none}
.hs-event-card h3 a:hover{color:#ff9933}
.hs-event-card .hs-event-venue{color:#666;font-size:.92rem;padding-bottom:22px;margin:0}
.hs-events-more,.hs-gallery-more{text-align:center;margin:30px 0 0}
.hs-events-more a,.hs-gallery-more a{color:#138808;font-weight:600;text-decoration:none;font-size:1.05rem}
.hs-events-more a:hover,.hs-gallery-more a:hover{color:#0f6606}

/* ---------- Gallery preview ---------- */
.hs-gallery{background:#fff}
.hs-gallery-grid{max-width:1200px;margin:50px auto 30px;display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:14px}
.hs-gallery-item{position:relative;margin:0;overflow:hidden;border-radius:10px;aspect-ratio:1;cursor:pointer;background:#f5f5f5}
.hs-gallery-item img{width:100%;height:100%;object-fit:cover;transition:transform .4s}
.hs-gallery-item:hover img{transform:scale(1.08)}
.hs-gallery-item figcaption{position:absolute;inset:auto 0 0 0;background:linear-gradient(transparent,rgba(0,0,0,.8));color:#fff;padding:30px 16px 14px;font-size:.85rem;opacity:0;transform:translateY(10px);transition:all .3s}
.hs-gallery-item:hover figcaption{opacity:1;transform:translateY(0)}

/* ---------- Testimonials ---------- */
.hs-testimonials{background:#f9f9f9;text-align:center}
.hs-testimonials-content{max-width:900px;margin:0 auto}
.hs-testimonials blockquote{background:#fff;padding:36px 30px;border-radius:14px;box-shadow:0 2px 12px rgba(0,0,0,.06);position:relative;margin:20px 0;font-size:1.1rem;line-height:1.7;color:#444;font-style:italic;border-left:5px solid #ff9933}
.hs-testimonials blockquote::before{content:"\201C";position:absolute;top:-10px;left:20px;font-size:5rem;color:#ff9933;opacity:.25;line-height:1;font-family:Georgia,serif}
.hs-testimonials cite{display:block;margin-top:16px;color:#888;font-style:normal;font-weight:600;font-size:.95rem}

/* ---------- News section (latest posts) ---------- */
.hs-news-section{background:#fafafa}
.hs-news-intro{max-width:780px;margin:0 auto 30px;text-align:center;color:#666;font-size:1.05rem;line-height:1.7}
.hs-news-grid{max-width:1200px;margin:50px auto 30px;display:grid;grid-template-columns:repeat(auto-fill,minmax(310px,1fr));gap:28px}
.hs-news-card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.06);transition:transform .3s,box-shadow .3s;display:flex;flex-direction:column}
.hs-news-card:hover{transform:translateY(-5px);box-shadow:0 10px 24px rgba(0,0,0,.12)}
.hs-news-card-image{position:relative;display:block;height:200px;overflow:hidden;background:#f5f5f5;text-decoration:none}
.hs-news-card-image img{width:100%;height:100%;object-fit:cover;transition:transform .4s}
.hs-news-card:hover .hs-news-card-image img{transform:scale(1.06)}
.hs-news-placeholder{height:100%;display:flex;align-items:center;justify-content:center;font-size:3.5rem;background:linear-gradient(135deg,#fff5e6,#e8f5e8)}
.hs-news-cat{position:absolute;top:14px;left:14px;background:#ff9933;color:#fff;padding:4px 12px;border-radius:14px;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px}
.hs-news-card-body{padding:22px;display:flex;flex-direction:column;flex:1}
.hs-news-date{color:#888;font-size:.82rem;margin:0 0 10px;font-weight:500}
.hs-news-title{font-size:1.18rem;line-height:1.4;margin:0 0 12px}
.hs-news-title a{color:#222;text-decoration:none;transition:color .2s}
.hs-news-title a:hover{color:#ff9933}
.hs-news-excerpt{color:#666;font-size:.92rem;line-height:1.6;margin:0 0 16px;flex:1}
.hs-news-more{color:#138808;text-decoration:none;font-weight:600;font-size:.9rem;align-self:flex-start}
.hs-news-more:hover{color:#0f6606}
.hs-news-cta{text-align:center;margin:30px 0 0}
.hs-news-cta a{color:#ff9933;font-weight:600;text-decoration:none;font-size:1.05rem}
.hs-news-cta a:hover{color:#e68a2e}
.hs-news-empty{text-align:center;color:#888;grid-column:1/-1;padding:40px 20px}

/* ---------- CTA banner ---------- */
.hs-cta-banner{background:linear-gradient(135deg,#138808 0%,#0a5005 100%);color:#fff;text-align:center;padding:70px 20px}
.hs-cta-banner > h2{color:#fff}
.hs-cta-banner > h2::after{background:#fff}
.hs-cta-body{max-width:700px;margin:0 auto 30px;font-size:1.15rem;line-height:1.7;opacity:.95}
.hs-cta-banner .hs-cta-btn{background:#ff9933;color:#fff;border:2px solid #ff9933}
.hs-cta-banner .hs-cta-btn:hover{background:#fff;color:#ff9933}

/* ---------- Generic fallback ---------- */
.hs-generic{background:#fff;max-width:900px;margin:0 auto;text-align:center}
.hs-generic div{font-size:1.05rem;line-height:1.7;color:#555}

@media (max-width:768px){
	.front-page section{padding:50px 20px}
	.front-page section > h2{font-size:1.8rem}
	.hs-hero{min-height:420px}
	.hs-hero-content h1{font-size:2.2rem}
	.hs-hero-tagline{font-size:1.05rem}
	.hs-stat-value{font-size:2.4rem}
	.hs-event-card img{height:180px}
}
</style>

<?php
get_footer();
