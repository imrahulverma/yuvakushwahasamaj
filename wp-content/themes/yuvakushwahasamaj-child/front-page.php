<?php
/**
 * Front Page Template — Warm Editorial
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

// Chapter counter for editorial numbering
$chapter = 0;

// Alternating background tracker — only counts "light" sections (hero/stats/cta have their own fixed dark treatments).
$light_index   = 0;
$dark_types    = array( 'hero', 'stats', 'cta' );

foreach ( $sections as $section ) {
	setup_postdata( $section );
	$post_id      = $section->ID;
	$section_type = get_scf_field( 'section_type', $post_id );
	$chapter++;
	$chapter_label = sprintf( 'Chapter %02d', $chapter );

	// Compute light-band alternation class for non-dark sections
	$alt_class = '';
	if ( ! in_array( $section_type, $dark_types, true ) ) {
		$light_index++;
		$alt_class = ( $light_index % 2 === 1 ) ? ' hs-band--paper' : ' hs-band--paper-deep';
	}

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
			$chapter--; // Hero doesn't count as a chapter
			?>
			<section class="hs-hero<?php echo $hero_image_id ? ' hs-hero--has-image' : ''; ?>">
				<?php if ( $hero_image_id ) : ?>
					<div class="hs-hero-bg" aria-hidden="true">
						<?php echo wp_get_attachment_image( $hero_image_id, 'full' ); ?>
					</div>
					<div class="hs-hero-overlay" aria-hidden="true"></div>
				<?php endif; ?>
				<div class="hs-hero-content">
					<span class="hs-hero-est">Est. Community · India</span>
					<h1 class="hs-hero-title">
						<?php echo esc_html( $tagline ); ?>
					</h1>
					<?php if ( $tagline ) : ?>
						<p class="hs-hero-tagline"><?php echo esc_html( $tagline ); ?></p>
					<?php endif; ?>
					<div class="hs-hero-actions">
						<a class="hs-cta-btn" href="<?php echo esc_url( $cta_link ); ?>">
							<span><?php echo esc_html( $cta_text ); ?></span>
							<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
						</a>
						<!-- <a class="hs-hero-secondary" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">Our Story</a> -->
					</div>
				</div>
				<div class="hs-hero-scroll" aria-hidden="true">
					<span>Scroll</span>
					<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 5v14M6 13l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</div>
			</section>
			<?php
			break;

		case 'about':
			$excerpt   = get_scf_field( 'about_excerpt', $post_id );
			$read_more = get_scf_field( 'read_more_link', $post_id );
			?>
			<section class="hs-about<?php echo esc_attr( $alt_class ); ?>">
				<div class="hs-about-inner">
					<header class="hs-section-head hs-section-head--left">
						<span class="eyebrow"><?php echo esc_html( $chapter_label ); ?> · About</span>
						<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
						<?php echo yks_ornament(); ?>
					</header>
					<div class="hs-about-body">
						<?php if ( $excerpt ) : ?>
							<p class="hs-about-excerpt"><?php echo esc_html( $excerpt ); ?></p>
						<?php else : ?>
							<div class="hs-about-content"><?php echo wp_kses_post( apply_filters( 'the_content', $section->post_content ) ); ?></div>
						<?php endif; ?>
						<?php if ( $read_more ) : ?>
							<a class="hs-read-more" href="<?php echo esc_url( $read_more ); ?>">
								<span>Read the full story</span>
								<svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</section>
			<?php
			break;

		case 'stats':
			$raw   = get_scf_field( 'stats_items', $post_id );
			$lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $raw ) ) );
			?>
			<section class="hs-stats">
				<div class="hs-stats-inner">
					<header class="hs-section-head hs-section-head--center hs-section-head--inverse">
						<span class="eyebrow"><?php echo esc_html( $chapter_label ); ?> · By the Numbers</span>
						<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
						<?php echo yks_ornament( 'light' ); ?>
					</header>
					<div class="hs-stats-grid">
						<?php foreach ( $lines as $i => $line ) :
							$parts = array_map( 'trim', explode( '|', $line, 2 ) );
							$value = $parts[0] ?? '';
							$label = $parts[1] ?? '';
							?>
							<div class="hs-stat">
								<span class="hs-stat-num"><?php echo esc_html( str_pad( $i + 1, 2, '0', STR_PAD_LEFT ) ); ?></span>
								<p class="hs-stat-value"><?php echo esc_html( $value ); ?></p>
								<p class="hs-stat-label"><?php echo esc_html( $label ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</section>
			<?php
			break;

		case 'events':
			$events = get_upcoming_events( 3 );
			?>
			<section class="hs-events<?php echo esc_attr( $alt_class ); ?>">
				<div class="hs-events-inner">
					<header class="hs-section-head hs-section-head--left">
						<span class="eyebrow"><?php echo esc_html( $chapter_label ); ?> · Gatherings</span>
						<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
						<?php echo yks_ornament(); ?>
					</header>
					<div class="hs-events-grid">
						<?php if ( $events ) : foreach ( $events as $event ) :
							$event_date     = get_scf_field( 'event_date', $event->ID );
							$event_venue    = get_scf_field( 'event_venue', $event->ID );
							$event_image_id = get_scf_field( 'event_image', $event->ID );
							$ts = $event_date ? strtotime( $event_date ) : false;
							?>
							<article class="hs-event-card">
								<a class="hs-event-image" href="<?php echo esc_url( get_permalink( $event ) ); ?>">
									<?php if ( $event_image_id ) {
										echo wp_get_attachment_image( $event_image_id, 'medium_large' );
									} else { ?>
										<div class="hs-event-placeholder"></div>
									<?php } ?>
								</a>
								<div class="hs-event-body">
									<?php if ( $ts ) : ?>
										<div class="hs-event-date">
											<span class="hs-event-day"><?php echo esc_html( date_i18n( 'd', $ts ) ); ?></span>
											<span class="hs-event-month"><?php echo esc_html( date_i18n( 'M Y', $ts ) ); ?></span>
										</div>
									<?php endif; ?>
									<div class="hs-event-text">
										<h3><a href="<?php echo esc_url( get_permalink( $event ) ); ?>"><?php echo esc_html( get_the_title( $event ) ); ?></a></h3>
										<?php if ( $event_venue ) : ?>
											<p class="hs-event-venue"><?php echo esc_html( $event_venue ); ?></p>
										<?php endif; ?>
									</div>
								</div>
							</article>
						<?php endforeach; else : ?>
							<p class="hs-empty">No upcoming events scheduled.</p>
						<?php endif; ?>
					</div>
					<p class="hs-link-more"><a href="<?php echo esc_url( home_url( '/events/' ) ); ?>">View all events &nbsp;→</a></p>
				</div>
			</section>
			<?php
			break;

				case 'news':
			// Two modes for the "News Ticker" section type:
			//   1. If the section post has content → render it as an announcements list (manual)
			//   2. If empty → pull the latest 6 blog posts and render as journal cards
			$has_manual_announcements = trim( wp_strip_all_tags( $section->post_content ) ) !== '';
			$eyebrow_suffix           = $has_manual_announcements ? 'Announcements' : 'Journal';
			?>
			<section class="hs-news-section<?php echo esc_attr( $alt_class ); ?>">
				<div class="hs-news-inner">
					<header class="hs-section-head hs-section-head--left">
						<span class="eyebrow"><?php echo esc_html( $chapter_label . ' · ' . $eyebrow_suffix ); ?></span>
						<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
						<?php echo yks_ornament(); ?>
					</header>

					<?php if ( $has_manual_announcements ) : ?>
						<div class="hs-announcements">
							<?php echo wp_kses_post( apply_filters( 'the_content', $section->post_content ) ); ?>
						</div>
					<?php else :
						$latest_news = get_posts( array(
							'post_type'      => 'post',
							'post_status'    => 'publish',
							'posts_per_page' => 6,
						) );
						?>
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
											<div class="hs-news-placeholder">
												<span>YK</span>
											</div>
										<?php } ?>
										<?php if ( $first_cat ) : ?>
											<span class="hs-news-cat"><?php echo esc_html( $first_cat->name ); ?></span>
										<?php endif; ?>
									</a>
									<div class="hs-news-card-body">
										<p class="hs-news-date"><?php echo esc_html( get_the_date( 'F j, Y', $news ) ); ?></p>
										<h3 class="hs-news-title"><a href="<?php echo esc_url( get_permalink( $news ) ); ?>"><?php echo esc_html( get_the_title( $news ) ); ?></a></h3>
										<p class="hs-news-excerpt"><?php echo esc_html( wp_trim_words( strip_shortcodes( wp_strip_all_tags( $news->post_content ) ), 22 ) ); ?></p>
										<a class="hs-news-more" href="<?php echo esc_url( get_permalink( $news ) ); ?>">Continue reading &nbsp;→</a>
									</div>
								</article>
							<?php endforeach; else : ?>
								<p class="hs-empty">No journal entries yet.</p>
							<?php endif; ?>
						</div>
						<p class="hs-link-more"><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">Read the journal &nbsp;→</a></p>
					<?php endif; ?>
				</div>
			</section>
			<?php
			break;

		case 'gallery':
			$items = get_gallery_items( 6 );
			?>
			<section class="hs-gallery<?php echo esc_attr( $alt_class ); ?>">
				<div class="hs-gallery-inner">
					<header class="hs-section-head hs-section-head--left">
						<span class="eyebrow"><?php echo esc_html( $chapter_label ); ?> · Album</span>
						<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
						<?php echo yks_ornament(); ?>
					</header>
					<div class="hs-gallery-grid">
						<?php foreach ( $items as $item ) :
							$image_id = get_scf_field( 'image', $item->ID );
							$caption  = get_scf_field( 'caption', $item->ID );
							if ( ! $image_id ) continue;
							?>
							<figure class="hs-gallery-item">
								<?php echo wp_get_attachment_image( $image_id, 'medium_large' ); ?>
								<?php if ( $caption ) : ?><figcaption><?php echo esc_html( $caption ); ?></figcaption><?php endif; ?>
							</figure>
						<?php endforeach; ?>
					</div>
					<p class="hs-link-more"><a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>">View full gallery &nbsp;→</a></p>
				</div>
			</section>
			<?php
			break;

		case 'testimonials':
			?>
			<section class="hs-testimonials<?php echo esc_attr( $alt_class ); ?>">
				<div class="hs-testimonials-inner">
					<header class="hs-section-head hs-section-head--center">
						<span class="eyebrow"><?php echo esc_html( $chapter_label ); ?> · Voices</span>
						<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
						<?php echo yks_ornament(); ?>
					</header>
					<div class="hs-testimonials-content"><?php echo wp_kses_post( apply_filters( 'the_content', $section->post_content ) ); ?></div>
				</div>
			</section>
			<?php
			break;

	

		case 'cta':
			$cta_text = get_scf_field( 'cta_button_text', $post_id ) ?: 'Join Us';
			$cta_link = get_scf_field( 'cta_button_link', $post_id ) ?: home_url( '/membership/' );
			?>
			<section class="hs-cta-banner">
				<div class="hs-cta-inner">
					<span class="eyebrow eyebrow--light">An Invitation</span>
					<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
					<?php echo yks_ornament( 'light' ); ?>
					<div class="hs-cta-body"><?php echo wp_kses_post( apply_filters( 'the_content', $section->post_content ) ); ?></div>
					<a class="hs-cta-btn hs-cta-btn--invert" href="<?php echo esc_url( $cta_link ); ?>">
						<span><?php echo esc_html( $cta_text ); ?></span>
						<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</a>
				</div>
			</section>
			<?php
			break;

		default:
			?>
			<section class="hs-generic<?php echo esc_attr( $alt_class ); ?>">
				<div class="hs-generic-inner">
					<header class="hs-section-head hs-section-head--center">
						<span class="eyebrow"><?php echo esc_html( $chapter_label ); ?></span>
						<h2><?php echo esc_html( get_the_title( $section ) ); ?></h2>
						<?php echo yks_ornament(); ?>
					</header>
					<div class="hs-generic-content"><?php echo wp_kses_post( apply_filters( 'the_content', $section->post_content ) ); ?></div>
				</div>
			</section>
			<?php
			break;
	}
}
wp_reset_postdata();
?>
</main>

<style>
.front-page{font-family:var(--font-body);color:var(--ink-soft);background:var(--paper)}
.front-page section{padding:110px 28px;position:relative}

/* Section heads (editorial) */
.hs-section-head{margin:0 0 50px}
.hs-section-head--left{text-align:left}
.hs-section-head--center{text-align:center}
.hs-section-head--center .hs-ornament{margin-left:auto;margin-right:auto}
.hs-section-head h2{font-family:var(--font-display);font-weight:600;font-size:clamp(2rem,3.6vw,3.1rem);line-height:1.1;margin:8px 0 0;color:var(--ink);letter-spacing:-.015em}
.hs-section-head--inverse h2{color:#fff}
.hs-section-head--inverse .eyebrow{color:#f3ead9}
.hs-ornament{display:block;margin-top:18px}
.hs-section-head--left .hs-ornament{margin-left:0}

.eyebrow{display:inline-block;font-family:var(--font-body);text-transform:uppercase;letter-spacing:.22em;font-size:.72rem;font-weight:600;color:var(--saffron)}
.eyebrow--light{color:#f3ead9}

/* ---------- Hero (full-bleed banner) ---------- */
.hs-hero{position:relative;min-height:88vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:80px 28px 100px !important;overflow:hidden;color:var(--paper);background:var(--ink)}
.hs-hero:not(.hs-hero--has-image){background:
	radial-gradient(1200px 600px at 80% 10%, rgba(200,84,28,.35), transparent 60%),
	radial-gradient(900px 500px at 0% 90%, rgba(30,90,60,.4), transparent 60%),
	var(--ink)}
.hs-hero-bg{position:absolute;inset:0;z-index:0}
.hs-hero-bg img{width:100%;height:100%;object-fit:cover;display:block;filter:saturate(.95) contrast(1.02)}
.hs-hero-overlay{position:absolute;inset:0;z-index:1;background:
	linear-gradient(180deg, rgba(31,22,18,.55) 0%, rgba(31,22,18,.4) 40%, rgba(31,22,18,.78) 100%),
	radial-gradient(900px 500px at 50% 100%, rgba(200,84,28,.22), transparent 65%)}

.hs-hero-content{position:relative;z-index:2;max-width:920px;margin:0 auto;padding:40px 0}
.hs-hero-est{display:inline-block;font-size:.74rem;letter-spacing:.32em;text-transform:uppercase;color:#f3ead9;font-weight:600;position:relative;padding:0 46px;margin:0 0 26px}
.hs-hero-est::before,.hs-hero-est::after{content:"";position:absolute;top:50%;width:34px;height:1px;background:var(--saffron)}
.hs-hero-est::before{left:0}
.hs-hero-est::after{right:0}
.hs-hero-title{font-family:var(--font-display);font-weight:600;font-size:clamp(2.6rem,6.4vw,5.2rem);line-height:1.02;letter-spacing:-.025em;color:#fff;margin:0 0 26px;text-shadow:0 4px 30px rgba(0,0,0,.35);max-width:880px;margin-left:auto;margin-right:auto}
.hs-hero-title::first-letter{color:var(--saffron);font-style:italic}
.hs-hero-tagline{font-family:var(--font-display);font-style:italic;font-weight:400;font-size:clamp(1.1rem,1.6vw,1.45rem);line-height:1.55;color:#f3ead9;margin:0 auto 40px;max-width:620px;text-shadow:0 2px 16px rgba(0,0,0,.4)}
.hs-hero-actions{display:flex;align-items:center;justify-content:center;gap:24px;flex-wrap:wrap}
.hs-cta-btn{display:inline-flex;align-items:center;gap:10px;background:var(--saffron);color:#fff;padding:16px 32px;border-radius:2px;text-decoration:none;font-weight:600;font-size:.98rem;letter-spacing:.04em;transition:background .25s,transform .25s,box-shadow .25s;font-family:var(--font-hindi);box-shadow:0 10px 30px -10px rgba(200,84,28,.55)}
.hs-cta-btn svg{transition:transform .25s}
.hs-cta-btn:hover{background:#fff;color:var(--ink);transform:translateY(-2px);box-shadow:0 14px 36px -10px rgba(0,0,0,.4)}
.hs-cta-btn:hover svg{transform:translateX(4px)}
.hs-hero-secondary{font-weight:600;font-size:.95rem;color:#f3ead9;text-decoration:none;border-bottom:1px solid var(--saffron);padding-bottom:4px;letter-spacing:.02em;transition:color .2s,border-color .2s}
.hs-hero-secondary:hover{color:#fff;border-bottom-color:#fff}

.hs-hero-scroll{position:absolute;bottom:32px;left:50%;transform:translateX(-50%);z-index:2;display:inline-flex;flex-direction:column;align-items:center;gap:8px;color:#f3ead9;font-size:.7rem;letter-spacing:.28em;text-transform:uppercase;font-weight:600;opacity:.75}
.hs-hero-scroll svg{animation:scrollHint 1.8s ease-in-out infinite}
@keyframes scrollHint{0%,100%{transform:translateY(0);opacity:.7}50%{transform:translateY(5px);opacity:1}}

/* ---------- Alternating light bands (position-based, survives reordering) ---------- */
.hs-band--paper{background:var(--paper)}
.hs-band--paper-deep{background:var(--paper-deep)}

/* ---------- About ---------- */
.hs-about-inner{max-width:1240px;margin:0 auto;display:grid;grid-template-columns:1fr 1.4fr;gap:80px;align-items:start}
.hs-about-body{font-size:1.08rem;line-height:1.85;color:var(--ink-soft)}
.hs-about-excerpt,.hs-about-content{margin:0 0 28px}
.hs-about-excerpt{font-family:var(--font-display);font-style:italic;font-size:1.35rem;line-height:1.6;color:var(--ink);font-weight:400;border-left:2px solid var(--saffron);padding-left:24px}
.hs-read-more{display:inline-flex;align-items:center;gap:8px;color:var(--ink);font-weight:600;text-decoration:none;border-bottom:1px solid var(--saffron);padding:0 0 4px;transition:color .2s}
.hs-read-more svg{transition:transform .25s}
.hs-read-more:hover{color:var(--saffron)}
.hs-read-more:hover svg{transform:translateX(4px)}

/* ---------- Stats ---------- */
.hs-stats{background:var(--ink);color:#f3ead9;position:relative;overflow:hidden}
.hs-stats::before{content:"";position:absolute;inset:0;background:
	radial-gradient(800px 400px at 90% 0%, rgba(200,84,28,.18), transparent 60%),
	radial-gradient(700px 400px at 0% 100%, rgba(30,90,60,.18), transparent 60%);
	pointer-events:none}
.hs-stats-inner{max-width:1240px;margin:0 auto;position:relative}
.hs-stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:0;border-top:1px solid rgba(243,234,217,.18);border-left:1px solid rgba(243,234,217,.18)}
.hs-stat{padding:42px 30px;border-right:1px solid rgba(243,234,217,.18);border-bottom:1px solid rgba(243,234,217,.18);position:relative;transition:background .25s}
.hs-stat:hover{background:rgba(200,84,28,.08)}
.hs-stat-num{font-family:var(--font-display);font-size:.85rem;color:var(--saffron);font-weight:600;letter-spacing:.2em}
.hs-stat-value{font-family:var(--font-display);font-size:3.6rem;font-weight:600;margin:18px 0 6px;line-height:1;color:#fff;letter-spacing:-.02em}
.hs-stat-label{font-size:.85rem;margin:0;color:#d8cdb6;letter-spacing:.06em;text-transform:uppercase;font-weight:500}

/* ---------- Events ---------- */
.hs-events-inner{max-width:1240px;margin:0 auto}
.hs-events-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:32px}
.hs-event-card{background:var(--card);border:1px solid var(--rule);transition:transform .3s,box-shadow .3s,border-color .3s;display:flex;flex-direction:column;overflow:hidden}
.hs-event-card:hover{transform:translateY(-6px);box-shadow:0 22px 40px -20px rgba(31,22,18,.22);border-color:var(--saffron)}
.hs-event-image{display:block;height:220px;overflow:hidden;background:var(--paper-deep)}
.hs-event-image img{width:100%;height:100%;object-fit:cover;transition:transform .5s ease}
.hs-event-card:hover .hs-event-image img{transform:scale(1.05)}
.hs-event-placeholder{height:100%;background:linear-gradient(135deg,#f3ead9,#e6dccb)}
.hs-event-body{padding:26px 26px 28px;display:flex;gap:18px;align-items:flex-start;flex:1}
.hs-event-date{flex:0 0 auto;text-align:center;padding-right:18px;border-right:1px solid var(--rule);min-width:60px}
.hs-event-day{display:block;font-family:var(--font-display);font-size:2.1rem;font-weight:600;color:var(--saffron);line-height:1}
.hs-event-month{display:block;margin-top:4px;font-size:.7rem;letter-spacing:.16em;color:var(--ink-mute);text-transform:uppercase;font-weight:600}
.hs-event-text h3{font-family:var(--font-display);font-size:1.2rem;font-weight:600;margin:0 0 8px;line-height:1.3;letter-spacing:-.01em}
.hs-event-text h3 a{color:var(--ink);text-decoration:none}
.hs-event-text h3 a:hover{color:var(--saffron)}
.hs-event-venue{color:var(--ink-mute);font-size:.88rem;margin:0;line-height:1.5}
.hs-event-venue::before{content:"◦ ";color:var(--saffron)}

.hs-link-more{text-align:right;margin:42px 0 0}
.hs-link-more a{color:var(--ink);font-weight:600;text-decoration:none;font-size:.95rem;letter-spacing:.04em;border-bottom:1px solid var(--saffron);padding-bottom:3px;transition:color .2s}
.hs-link-more a:hover{color:var(--saffron)}
.hs-empty{text-align:center;color:var(--ink-mute);padding:40px 20px;grid-column:1/-1;font-style:italic}

/* ---------- Gallery ---------- */
.hs-gallery-inner{max-width:1240px;margin:0 auto}
.hs-gallery-grid{display:grid;grid-template-columns:repeat(12,1fr);gap:14px;grid-auto-rows:160px}
.hs-gallery-item{position:relative;margin:0;overflow:hidden;cursor:pointer;background:var(--paper-deep);border:1px solid var(--rule)}
.hs-gallery-item:nth-child(1){grid-column:span 6;grid-row:span 2}
.hs-gallery-item:nth-child(2){grid-column:span 3;grid-row:span 1}
.hs-gallery-item:nth-child(3){grid-column:span 3;grid-row:span 1}
.hs-gallery-item:nth-child(4){grid-column:span 3;grid-row:span 1}
.hs-gallery-item:nth-child(5){grid-column:span 3;grid-row:span 1}
.hs-gallery-item:nth-child(6){grid-column:span 6;grid-row:span 1}
.hs-gallery-item img{width:100%;height:100%;object-fit:cover;transition:transform .6s ease,filter .4s}
.hs-gallery-item:hover img{transform:scale(1.06);filter:saturate(1.1)}
.hs-gallery-item figcaption{position:absolute;inset:auto 0 0 0;background:linear-gradient(transparent,rgba(31,22,18,.85));color:#fff;padding:40px 18px 16px;font-size:.85rem;font-style:italic;opacity:0;transform:translateY(10px);transition:all .35s}
.hs-gallery-item:hover figcaption{opacity:1;transform:translateY(0)}

/* ---------- Testimonials ---------- */
.hs-testimonials{text-align:center}
.hs-testimonials-inner{max-width:1100px;margin:0 auto}
.hs-testimonials-content{max-width:900px;margin:0 auto;font-size:1.1rem;line-height:1.8}
.hs-testimonials blockquote{background:var(--card);padding:50px 44px;border:1px solid var(--rule);position:relative;margin:24px 0;font-family:var(--font-display);font-style:italic;font-size:1.25rem;line-height:1.7;color:var(--ink);font-weight:400}
.hs-testimonials blockquote::before{content:"\201C";position:absolute;top:-8px;left:24px;font-size:6rem;color:var(--saffron);opacity:.25;line-height:1;font-family:var(--font-display)}
.hs-testimonials cite{display:block;margin-top:24px;color:var(--ink-mute);font-style:normal;font-weight:600;font-size:.82rem;letter-spacing:.16em;text-transform:uppercase;font-family:var(--font-body)}

/* ---------- News / Journal ---------- */
.hs-news-inner{max-width:1240px;margin:0 auto}
.hs-news-intro{max-width:780px;margin:0 0 40px;color:var(--ink-soft);font-size:1.05rem;line-height:1.8}

/* ---------- Announcements (manual content variant of news section) ---------- */
.hs-announcements{max-width:960px;border-top:1px solid var(--rule)}
.hs-announcements p,.hs-announcements li{margin:0;padding:22px 28px 22px 64px;border-bottom:1px solid var(--rule);font-size:1.05rem;line-height:1.6;color:var(--ink);position:relative;transition:background .2s,padding-left .2s;list-style:none}
.hs-announcements p::before,.hs-announcements li::before{content:"";position:absolute;left:26px;top:50%;width:22px;height:1px;background:var(--saffron);transform:translateY(-50%)}
.hs-announcements p:hover,.hs-announcements li:hover{background:var(--card);padding-left:72px}
.hs-announcements ul,.hs-announcements ol{padding:0;margin:0;list-style:none}
.hs-announcements blockquote{margin:0;padding:0}
.hs-announcements a{color:var(--saffron);border-bottom:1px solid var(--saffron);text-decoration:none}
.hs-announcements a:hover{color:var(--saffron-d);border-bottom-color:var(--saffron-d)}
.hs-news-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(330px,1fr));gap:36px}
.hs-news-card{background:var(--card);border:1px solid var(--rule);transition:transform .3s,box-shadow .3s,border-color .3s;display:flex;flex-direction:column;overflow:hidden}
.hs-news-card:hover{transform:translateY(-5px);box-shadow:0 20px 40px -20px rgba(31,22,18,.18);border-color:var(--saffron)}
.hs-news-card-image{position:relative;display:block;height:220px;overflow:hidden;background:var(--paper-deep);text-decoration:none}
.hs-news-card-image img{width:100%;height:100%;object-fit:cover;transition:transform .5s ease}
.hs-news-card:hover .hs-news-card-image img{transform:scale(1.05)}
.hs-news-placeholder{height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#f3ead9,#e6dccb)}
.hs-news-placeholder span{font-family:var(--font-display);font-size:3rem;color:var(--saffron);opacity:.4;font-weight:600;letter-spacing:.05em}
.hs-news-cat{position:absolute;top:16px;left:16px;background:var(--ink);color:var(--paper);padding:5px 12px;font-size:.68rem;font-weight:600;text-transform:uppercase;letter-spacing:.14em}
.hs-news-card-body{padding:26px 26px 28px;display:flex;flex-direction:column;flex:1}
.hs-news-date{color:var(--ink-mute);font-size:.75rem;margin:0 0 12px;font-weight:600;letter-spacing:.1em;text-transform:uppercase}
.hs-news-title{font-family:var(--font-display);font-size:1.3rem;line-height:1.32;margin:0 0 14px;font-weight:600;letter-spacing:-.01em}
.hs-news-title a{color:var(--ink);text-decoration:none;transition:color .2s}
.hs-news-title a:hover{color:var(--saffron)}
.hs-news-excerpt{color:var(--ink-soft);font-size:.95rem;line-height:1.7;margin:0 0 20px;flex:1}
.hs-news-more{color:var(--ink);text-decoration:none;font-weight:600;font-size:.88rem;align-self:flex-start;border-bottom:1px solid var(--saffron);padding-bottom:2px;transition:color .2s}
.hs-news-more:hover{color:var(--saffron)}

/* ---------- CTA banner ---------- */
.hs-cta-banner{background:var(--forest);color:#f3ead9;text-align:center;padding:100px 28px;position:relative;overflow:hidden}
.hs-cta-banner::before{content:"";position:absolute;inset:0;background:
	radial-gradient(800px 400px at 50% 0%, rgba(200,84,28,.18), transparent 60%);
	pointer-events:none}
.hs-cta-inner{max-width:780px;margin:0 auto;position:relative}
.hs-cta-banner h2{font-family:var(--font-display);font-size:clamp(2rem,3.6vw,3.1rem);color:#fff;margin:10px 0 0;line-height:1.1;letter-spacing:-.015em}
.hs-cta-banner .hs-ornament{margin:18px auto 0}
.hs-cta-body{max-width:640px;margin:30px auto 36px;font-size:1.1rem;line-height:1.8;opacity:.92;color:#f3ead9}
.hs-cta-btn--invert{background:var(--saffron);color:#fff}
.hs-cta-btn--invert:hover{background:#fff;color:var(--saffron)}

/* ---------- Generic fallback ---------- */
.hs-generic-inner{max-width:900px;margin:0 auto;text-align:center}
.hs-generic-content{font-size:1.05rem;line-height:1.8;color:var(--ink-soft)}

/* ---------- Responsive ---------- */
@media (max-width:960px){
	.front-page section{padding:80px 24px}
	.hs-hero{padding:60px 24px 80px !important}
	.hs-hero-grid{grid-template-columns:1fr;gap:50px}
	.hs-hero-frame img{height:380px}
	.hs-about-inner{grid-template-columns:1fr;gap:30px}
	.hs-section-head{margin-bottom:36px}
	.hs-gallery-grid{grid-template-columns:repeat(6,1fr);grid-auto-rows:130px}
	.hs-gallery-item:nth-child(1){grid-column:span 6;grid-row:span 2}
	.hs-gallery-item:nth-child(n+2){grid-column:span 3;grid-row:span 1}
	.hs-link-more{text-align:left}
}
@media (max-width:560px){
	.front-page section{padding:60px 20px}
	.hs-hero-title{font-size:2.4rem}
	.hs-event-body{flex-direction:column;gap:12px}
	.hs-event-date{padding-right:0;padding-bottom:10px;border-right:0;border-bottom:1px solid var(--rule);min-width:0;text-align:left;display:flex;align-items:baseline;gap:8px}
	.hs-stat-value{font-size:2.6rem}
	.hs-testimonials blockquote{padding:36px 24px;font-size:1.1rem}
}
</style>

<?php
get_footer();
