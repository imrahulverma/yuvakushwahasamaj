<?php
/**
 * Template Name: Events
 * Description: Events page template — warm editorial style
 */

get_header();
?>

<main id="main" class="site-main events-page">

	<!-- Editorial page hero -->
	<section class="page-hero">
		<div class="page-hero-inner page-hero-inner--solo">
			<span class="eyebrow">Calendar · Gatherings · Festivities</span>
			<h1><?php the_title(); ?></h1>
			<?php echo yks_ornament(); ?>
			<p class="page-hero-lede">A record of the gatherings that mark our community year — from intimate meetings to the grand annual sammelan.</p>
		</div>
	</section>

	<div class="container">

		<!-- Upcoming Events -->
		<section class="upcoming-events">
			<header class="section-head section-head--left">
				<span class="eyebrow">Chapter 01 · Forthcoming</span>
				<h2>Upcoming Events</h2>
				<?php echo yks_ornament(); ?>
			</header>
			<div class="event-cards">
				<?php
					$upcoming_events = get_posts( array(
						'post_type'      => 'event',
						'posts_per_page' => -1,
						'meta_query'     => array(
							array(
								'key'     => 'event_status',
								'value'   => 'upcoming',
								'compare' => '==',
							),
						),
						'meta_key'       => 'event_date',
						'orderby'        => 'meta_value',
						'order'          => 'ASC',
					) );

					if ( $upcoming_events ) {
						foreach ( $upcoming_events as $event ) {
							setup_postdata( $event );
							$event_date     = get_scf_field( 'event_date', $event->ID );
							$event_time     = get_scf_field( 'event_time', $event->ID );
							$event_venue    = get_scf_field( 'event_venue', $event->ID );
							$event_image_id = get_scf_field( 'event_image', $event->ID );
							$register_link  = get_scf_field( 'register_link', $event->ID );
							$ts             = $event_date ? strtotime( $event_date ) : false;
							?>
							<article class="event-card">
								<?php if ( $event_image_id ) : ?>
									<a class="event-card-image" href="<?php the_permalink(); ?>">
										<?php echo wp_get_attachment_image( $event_image_id, 'medium_large' ); ?>
									</a>
								<?php else : ?>
									<div class="event-card-image event-card-image--ph"><span>YK</span></div>
								<?php endif; ?>
								<div class="event-card-body">
									<?php if ( $ts ) : ?>
										<div class="event-date">
											<span class="event-day"><?php echo esc_html( date_i18n( 'd', $ts ) ); ?></span>
											<span class="event-month"><?php echo esc_html( date_i18n( 'M Y', $ts ) ); ?></span>
										</div>
									<?php endif; ?>
									<div class="event-text">
										<h3 class="event-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<?php if ( $event_venue ) : ?>
											<p class="event-meta event-venue"><?php echo esc_html( $event_venue ); ?></p>
										<?php endif; ?>
										<?php if ( $event_time ) : ?>
											<p class="event-meta event-time"><?php echo esc_html( date_i18n( 'h:i A', strtotime( $event_time ) ) ); ?></p>
										<?php endif; ?>
										<p class="event-excerpt"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_content() ), 22 ) ); ?></p>
										<?php if ( $register_link ) : ?>
											<a href="<?php echo esc_url( $register_link ); ?>" class="event-cta" target="_blank" rel="noopener">
												<span>Register</span>
												<svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
											</a>
										<?php endif; ?>
									</div>
								</div>
							</article>
							<?php
						}
						wp_reset_postdata();
					} else {
						echo '<p class="section-empty">No upcoming events scheduled. Check back soon.</p>';
					}
				?>
			</div>
		</section>

		<!-- Past Events Archive -->
		<section class="past-events">
			<header class="section-head section-head--left">
				<span class="eyebrow">Chapter 02 · Archive</span>
				<h2>Past Gatherings</h2>
				<?php echo yks_ornament(); ?>
			</header>
			<div class="event-cards">
				<?php
					$past_events = get_posts( array(
						'post_type'      => 'event',
						'posts_per_page' => 6,
						'meta_query'     => array(
							array(
								'key'     => 'event_status',
								'value'   => array( 'completed', 'ongoing' ),
								'compare' => 'IN',
							),
						),
						'meta_key'       => 'event_date',
						'orderby'        => 'meta_value',
						'order'          => 'DESC',
					) );

					if ( $past_events ) {
						foreach ( $past_events as $event ) {
							setup_postdata( $event );
							$event_date     = get_scf_field( 'event_date', $event->ID );
							$event_image_id = get_scf_field( 'event_image', $event->ID );
							$ts             = $event_date ? strtotime( $event_date ) : false;
							?>
							<article class="event-card past-event">
								<?php if ( $event_image_id ) : ?>
									<a class="event-card-image" href="<?php the_permalink(); ?>">
										<?php echo wp_get_attachment_image( $event_image_id, 'medium_large' ); ?>
									</a>
								<?php else : ?>
									<div class="event-card-image event-card-image--ph"><span>YK</span></div>
								<?php endif; ?>
								<div class="event-card-body">
									<?php if ( $ts ) : ?>
										<div class="event-date">
											<span class="event-day"><?php echo esc_html( date_i18n( 'd', $ts ) ); ?></span>
											<span class="event-month"><?php echo esc_html( date_i18n( 'M Y', $ts ) ); ?></span>
										</div>
									<?php endif; ?>
									<div class="event-text">
										<h3 class="event-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<p class="event-excerpt"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_content() ), 22 ) ); ?></p>
										<a href="<?php the_permalink(); ?>" class="event-cta event-cta--ghost">
											<span>View details</span>
											<svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
										</a>
									</div>
								</div>
							</article>
							<?php
						}
						wp_reset_postdata();
					} else {
						echo '<p class="section-empty">No past events on record.</p>';
					}
				?>
			</div>
		</section>

		<!-- Annual Sammelan Highlight -->
		<section class="sammelan-highlight">
			<div class="sammelan-inner">
				<span class="eyebrow eyebrow--light">An Invitation</span>
				<h2>Annual Sammelan &amp; Mahasammelan</h2>
				<?php echo yks_ornament( 'light' ); ?>
				<p>Our flagship annual gathering brings together community members from across the region to celebrate our heritage, share achievements, and plan for the future.</p>
				<p class="sammelan-stay">Details about the upcoming Mahasammelan will be announced here.</p>
			</div>
		</section>

	</div>
</main>

<style>
.events-page{background:var(--paper);font-family:var(--font-body);color:var(--ink-soft)}
.container{max-width:1240px;margin:0 auto;padding:0 28px}

/* ---------- Editorial page hero ---------- */
.page-hero{padding:80px 28px 90px;background:
	radial-gradient(1200px 600px at 80% 10%, rgba(200,84,28,.08), transparent 60%),
	radial-gradient(900px 500px at 0% 90%, rgba(30,90,60,.08), transparent 60%),
	var(--paper)}
.page-hero-inner{max-width:1240px;margin:0 auto}
.page-hero-inner--solo{max-width:820px;text-align:left}
.page-hero-inner--solo .eyebrow{padding-left:46px;position:relative}
.page-hero-inner--solo .eyebrow::before{content:"";position:absolute;left:0;top:50%;width:34px;height:1px;background:var(--saffron)}
.page-hero-inner--solo h1{font-family:var(--font-display);font-weight:600;font-size:clamp(2.4rem,4.6vw,3.8rem);line-height:1.05;letter-spacing:-.022em;color:var(--ink);margin:14px 0 0}
.page-hero-inner--solo h1::first-letter{color:var(--saffron);font-style:italic}
.page-hero-inner--solo .hs-ornament{margin:18px 0 24px}
.page-hero-lede{font-family:var(--font-display);font-style:italic;font-size:1.25rem;line-height:1.55;color:var(--ink);margin:0;font-weight:400;max-width:680px}

/* ---------- Section heads ---------- */
.events-page section{padding:80px 0}
.section-head{margin:0 0 50px;max-width:760px}
.section-head--left{text-align:left}
.section-head h2{font-family:var(--font-display);font-weight:600;font-size:clamp(1.9rem,3.4vw,2.9rem);line-height:1.1;letter-spacing:-.015em;color:var(--ink);margin:8px 0 0}
.section-head .hs-ornament{margin-top:18px;margin-left:0}
.section-empty{color:var(--ink-mute);font-style:italic;padding:30px 0;text-align:center}

/* ---------- Event cards ---------- */
.event-cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:32px}
.event-card{background:var(--card);border:1px solid var(--rule);transition:transform .25s,box-shadow .25s,border-color .25s;overflow:hidden;display:flex;flex-direction:column}
.event-card:hover{transform:translateY(-5px);box-shadow:0 22px 40px -20px rgba(31,22,18,.18);border-color:var(--saffron)}
.event-card-image{display:block;height:220px;overflow:hidden;background:var(--paper-deep);text-decoration:none}
.event-card-image img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.event-card:hover .event-card-image img{transform:scale(1.04)}
.event-card-image--ph{display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#f3ead9,#e6dccb)}
.event-card-image--ph span{font-family:var(--font-display);font-size:2.5rem;color:var(--saffron);opacity:.4;font-weight:600;letter-spacing:.05em}

.event-card-body{padding:26px;display:flex;gap:20px;align-items:flex-start;flex:1}
.event-date{flex:0 0 auto;text-align:center;padding-right:18px;border-right:1px solid var(--rule);min-width:62px}
.event-day{display:block;font-family:var(--font-display);font-size:2.2rem;font-weight:600;color:var(--saffron);line-height:1}
.event-month{display:block;margin-top:4px;font-size:.7rem;letter-spacing:.16em;color:var(--ink-mute);text-transform:uppercase;font-weight:600}
.event-text{flex:1}
.event-title{font-family:var(--font-display);font-size:1.28rem;font-weight:600;margin:0 0 10px;line-height:1.3;letter-spacing:-.01em}
.event-title a{color:var(--ink);text-decoration:none}
.event-title a:hover{color:var(--saffron)}
.event-meta{color:var(--ink-mute);font-size:.88rem;margin:0 0 6px;line-height:1.5}
.event-meta::before{content:"◦ ";color:var(--saffron)}
.event-excerpt{color:var(--ink-soft);font-size:.92rem;line-height:1.65;margin:10px 0 16px}
.event-cta{display:inline-flex;align-items:center;gap:8px;background:var(--ink);color:var(--paper);padding:9px 18px;text-decoration:none;font-weight:600;font-size:.85rem;letter-spacing:.04em;transition:background .25s,transform .25s}
.event-cta svg{transition:transform .25s}
.event-cta:hover{background:var(--saffron);color:#fff}
.event-cta:hover svg{transform:translateX(3px)}
.event-cta--ghost{background:transparent;color:var(--ink);border:1px solid var(--saffron)}
.event-cta--ghost:hover{background:var(--saffron);color:#fff}

.past-event{opacity:.92}

/* ---------- Sammelan highlight ---------- */
.sammelan-highlight{background:var(--forest);color:#f3ead9;text-align:center;margin:60px -28px;padding:90px 28px;position:relative;overflow:hidden}
.sammelan-highlight::before{content:"";position:absolute;inset:0;background:radial-gradient(800px 400px at 50% 0%, rgba(200,84,28,.18), transparent 60%);pointer-events:none}
.sammelan-inner{max-width:760px;margin:0 auto;position:relative}
.sammelan-inner h2{font-family:var(--font-display);font-weight:600;font-size:clamp(1.9rem,3.4vw,2.8rem);line-height:1.1;color:#fff;letter-spacing:-.015em;margin:10px 0 0}
.sammelan-inner .hs-ornament{margin:18px auto 24px}
.sammelan-inner p{font-size:1.08rem;line-height:1.8;margin:0 auto 14px;color:#f3ead9;opacity:.94;max-width:640px}
.sammelan-stay{font-style:italic;opacity:.85;font-family:var(--font-display)}

/* ---------- Responsive ---------- */
@media (max-width:960px){
	.page-hero{padding:60px 24px 70px}
	.events-page section{padding:60px 0}
}
@media (max-width:560px){
	.event-card-body{flex-direction:column;gap:14px}
	.event-date{padding-right:0;padding-bottom:10px;border-right:0;border-bottom:1px solid var(--rule);text-align:left;display:flex;align-items:baseline;gap:8px;min-width:0}
	.sammelan-highlight{margin:50px -20px;padding:70px 22px}
}
</style>

<?php
get_footer();
