<?php
/**
 * Single Event Template — Warm Editorial
 * Used for individual event detail pages (event CPT).
 */

get_header();

while ( have_posts() ) :
	the_post();
	$event_id      = get_the_ID();
	$event_date    = get_scf_field( 'event_date', $event_id );
	$event_time    = get_scf_field( 'event_time', $event_id );
	$event_venue   = get_scf_field( 'event_venue', $event_id );
	$event_image   = get_scf_field( 'event_image', $event_id );
	$event_status  = get_scf_field( 'event_status', $event_id );
	$register_link = get_scf_field( 'register_link', $event_id );

	$ts            = $event_date ? strtotime( $event_date ) : false;
	$time_ts       = $event_time ? strtotime( $event_time ) : false;
	$is_upcoming   = ( $event_status === 'upcoming' );
	$is_past       = in_array( $event_status, array( 'completed' ), true );

	// Related — other upcoming events excluding this one.
	$related = get_posts( array(
		'post_type'      => 'event',
		'posts_per_page' => 3,
		'post__not_in'   => array( $event_id ),
		'meta_query'     => array(
			array( 'key' => 'event_status', 'value' => 'upcoming', 'compare' => '==' ),
		),
		'meta_key'       => 'event_date',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
	) );
	?>

<main id="main" class="site-main single-event-page">

	<!-- Editorial hero -->
	<header class="se-hero">
		<div class="se-hero-inner">
			<nav class="se-breadcrumbs" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
				<span>·</span>
				<a href="<?php echo esc_url( home_url( '/events/' ) ); ?>">Events</a>
				<span>·</span>
				<span class="se-breadcrumbs-current"><?php the_title(); ?></span>
			</nav>

			<span class="se-status-badge se-status-badge--<?php echo esc_attr( $event_status ?: 'upcoming' ); ?>">
				<?php
				if ( $is_upcoming )       echo 'Upcoming Gathering';
				elseif ( $event_status === 'ongoing' ) echo 'Happening Now';
				elseif ( $is_past )       echo 'In the Archive';
				else                      echo 'Event';
				?>
			</span>

			<h1 class="se-title"><?php the_title(); ?></h1>

			<?php echo yks_ornament(); ?>

			<!-- Key meta band -->
			<dl class="se-meta-band">
				<?php if ( $ts ) : ?>
					<div class="se-meta-cell">
						<dt>Date</dt>
						<dd>
							<span class="se-meta-strong"><?php echo esc_html( date_i18n( 'l', $ts ) ); ?></span>
							<?php echo esc_html( date_i18n( 'F j, Y', $ts ) ); ?>
						</dd>
					</div>
				<?php endif; ?>
				<?php if ( $time_ts ) : ?>
					<div class="se-meta-cell">
						<dt>Time</dt>
						<dd>
							<span class="se-meta-strong"><?php echo esc_html( date_i18n( 'h:i A', $time_ts ) ); ?></span>
							onwards
						</dd>
					</div>
				<?php endif; ?>
				<?php if ( $event_venue ) : ?>
					<div class="se-meta-cell">
						<dt>Venue</dt>
						<dd>
							<span class="se-meta-strong"><?php echo esc_html( $event_venue ); ?></span>
						</dd>
					</div>
				<?php endif; ?>
			</dl>

			<?php if ( $register_link && ! $is_past ) : ?>
				<a class="se-cta-btn" href="<?php echo esc_url( $register_link ); ?>" target="_blank" rel="noopener">
					<span>Register for this event</span>
					<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</a>
			<?php endif; ?>
		</div>

		<?php if ( $event_image ) : ?>
			<figure class="se-hero-figure">
				<div class="se-hero-frame">
					<?php echo wp_get_attachment_image( $event_image, 'full', false, array( 'class' => 'se-hero-img' ) ); ?>
				</div>
			</figure>
		<?php endif; ?>
	</header>

	<!-- Body -->
	<div class="se-wrap">
		<article class="se-article">

			<aside class="se-sidebar">
				<div class="se-card">
					<span class="se-card-label">At a Glance</span>
					<ul class="se-card-list">
						<?php if ( $ts ) : ?>
							<li>
								<span class="se-card-key">When</span>
								<span class="se-card-val"><?php echo esc_html( date_i18n( 'F j, Y', $ts ) ); ?><?php if ( $time_ts ) echo '<br>' . esc_html( date_i18n( 'h:i A', $time_ts ) ); ?></span>
							</li>
						<?php endif; ?>
						<?php if ( $event_venue ) : ?>
							<li>
								<span class="se-card-key">Where</span>
								<span class="se-card-val"><?php echo esc_html( $event_venue ); ?></span>
							</li>
						<?php endif; ?>
						<li>
							<span class="se-card-key">Status</span>
							<span class="se-card-val"><?php echo esc_html( ucfirst( $event_status ?: 'upcoming' ) ); ?></span>
						</li>
					</ul>
					<?php if ( $register_link && ! $is_past ) : ?>
						<a class="se-card-cta" href="<?php echo esc_url( $register_link ); ?>" target="_blank" rel="noopener">
							<span>Register</span>
							<svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
						</a>
					<?php endif; ?>
				</div>

				<aside class="se-share" aria-label="Share">
					<p class="se-share-label">Share</p>
					<?php
					$share_url   = urlencode( get_permalink() );
					$share_title = urlencode( get_the_title() );
					?>
					<div class="se-share-row">
						<a class="se-share-btn" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener" aria-label="Share on Facebook">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.5h2.5l.4-3h-2.9V8.6c0-.9.2-1.5 1.5-1.5h1.6V4.4c-.3 0-1.2-.1-2.3-.1-2.3 0-3.8 1.4-3.8 3.9v2.2H8v3h2.5V21h3z"/></svg>
						</a>
						<a class="se-share-btn" href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" rel="noopener" aria-label="Share on Twitter">
							<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
						</a>
						<a class="se-share-btn" href="https://wa.me/?text=<?php echo $share_title . '%20' . $share_url; ?>" target="_blank" rel="noopener" aria-label="Share on WhatsApp">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.5 3.5A10.4 10.4 0 0 0 12 0C6.2 0 1.5 4.7 1.5 10.5c0 1.8.5 3.6 1.4 5.2L1 24l8.5-2.2c1.5.8 3.2 1.3 4.9 1.3h.1c5.8 0 10.5-4.7 10.5-10.5 0-2.8-1-5.5-3-7.5l-1.5-1.6zM12 21.3c-1.5 0-3-.4-4.3-1.2l-.3-.2-3.7 1 .9-3.5-.2-.3a8.4 8.4 0 0 1-1.3-4.6c0-4.7 3.8-8.5 8.6-8.5 2.3 0 4.4.9 6 2.5a8.5 8.5 0 0 1 2.5 6c0 4.7-3.8 8.5-8.6 8.5z"/></svg>
						</a>
						<button class="se-share-btn se-share-copy" type="button" data-url="<?php echo esc_url( get_permalink() ); ?>" aria-label="Copy link">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
						</button>
					</div>
				</aside>
			</aside>

			<div class="se-content">
				<?php the_content(); ?>
			</div>

		</article>
	</div>

	<!-- Related upcoming events -->
	<?php if ( $related ) : ?>
		<section class="se-related">
			<div class="se-related-inner">
				<header class="section-head section-head--left">
					<span class="eyebrow">More Gatherings</span>
					<h2>Other Upcoming Events</h2>
					<?php echo yks_ornament(); ?>
				</header>
				<div class="se-related-grid">
					<?php foreach ( $related as $rp ) :
						$r_date    = get_scf_field( 'event_date', $rp->ID );
						$r_image   = get_scf_field( 'event_image', $rp->ID );
						$r_venue   = get_scf_field( 'event_venue', $rp->ID );
						$r_ts      = $r_date ? strtotime( $r_date ) : false;
						?>
						<article class="se-rel-card">
							<?php if ( $r_image ) : ?>
								<a class="se-rel-image" href="<?php echo esc_url( get_permalink( $rp ) ); ?>">
									<?php echo wp_get_attachment_image( $r_image, 'medium_large' ); ?>
								</a>
							<?php else : ?>
								<div class="se-rel-image se-rel-image--ph"><span>YK</span></div>
							<?php endif; ?>
							<div class="se-rel-body">
								<?php if ( $r_ts ) : ?>
									<div class="se-rel-date">
										<span class="se-rel-day"><?php echo esc_html( date_i18n( 'd', $r_ts ) ); ?></span>
										<span class="se-rel-month"><?php echo esc_html( date_i18n( 'M Y', $r_ts ) ); ?></span>
									</div>
								<?php endif; ?>
								<div class="se-rel-text">
									<h3><a href="<?php echo esc_url( get_permalink( $rp ) ); ?>"><?php echo esc_html( get_the_title( $rp ) ); ?></a></h3>
									<?php if ( $r_venue ) : ?>
										<p class="se-rel-venue"><?php echo esc_html( $r_venue ); ?></p>
									<?php endif; ?>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
				<div class="se-related-cta">
					<a href="<?php echo esc_url( home_url( '/events/' ) ); ?>" class="se-related-btn">
						<span>View all events</span>
						<svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</a>
				</div>
			</div>
		</section>
	<?php endif; ?>

</main>

<?php endwhile; ?>

<style>
.single-event-page{background:var(--paper);font-family:var(--font-body);color:var(--ink-soft)}

/* ---------- Hero ---------- */
.se-hero{background:
	radial-gradient(1200px 600px at 80% 10%, rgba(200,84,28,.08), transparent 60%),
	radial-gradient(900px 500px at 0% 90%, rgba(30,90,60,.08), transparent 60%),
	var(--paper);
	padding:60px 28px 30px}
.se-hero-inner{max-width:920px;margin:0 auto}

.se-breadcrumbs{margin:0 0 22px;font-size:.78rem;color:var(--ink-mute);letter-spacing:.06em}
.se-breadcrumbs a{color:var(--ink-mute);text-decoration:none;transition:color .2s}
.se-breadcrumbs a:hover{color:var(--saffron)}
.se-breadcrumbs span{margin:0 8px;color:var(--saffron);opacity:.6}
.se-breadcrumbs-current{color:var(--ink);font-weight:500}

.se-status-badge{display:inline-block;font-family:var(--font-body);text-transform:uppercase;letter-spacing:.22em;font-size:.72rem;font-weight:600;color:var(--saffron);padding-left:34px;position:relative;margin-bottom:16px}
.se-status-badge::before{content:"";position:absolute;left:0;top:50%;width:24px;height:1px;background:var(--saffron)}
.se-status-badge--completed{color:var(--ink-mute)}
.se-status-badge--completed::before{background:var(--ink-mute)}
.se-status-badge--ongoing{color:var(--forest)}
.se-status-badge--ongoing::before{background:var(--forest)}

.se-title{font-family:var(--font-display);font-weight:600;font-size:clamp(2.2rem,4.6vw,3.6rem);margin:8px 0 0;line-height:1.08;color:var(--ink);letter-spacing:-.022em;max-width:880px}
.se-title::first-letter{color:var(--saffron);font-style:italic}
.se-hero-inner .hs-ornament{margin:22px 0}

/* ---------- Meta band ---------- */
.se-meta-band{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:0;margin:30px 0 32px;padding:0;border-top:1px solid var(--rule);border-left:1px solid var(--rule);background:var(--card)}
.se-meta-cell{padding:22px 24px;border-right:1px solid var(--rule);border-bottom:1px solid var(--rule);margin:0}
.se-meta-cell dt{font-size:.7rem;color:var(--saffron);font-weight:600;letter-spacing:.22em;text-transform:uppercase;margin:0 0 8px}
.se-meta-cell dd{margin:0;font-size:.95rem;line-height:1.55;color:var(--ink-soft)}
.se-meta-strong{display:block;font-family:var(--font-display);font-size:1.15rem;font-weight:600;color:var(--ink);letter-spacing:-.01em;margin-bottom:2px}

.se-cta-btn{display:inline-flex;align-items:center;gap:10px;background:var(--ink);color:var(--paper);padding:14px 28px;text-decoration:none;font-weight:600;font-size:.95rem;letter-spacing:.04em;transition:background .25s,transform .25s;font-family:var(--font-body)}
.se-cta-btn svg{transition:transform .25s}
.se-cta-btn:hover{background:var(--saffron);color:#fff;transform:translateY(-2px)}
.se-cta-btn:hover svg{transform:translateX(4px)}

/* ---------- Hero figure ---------- */
.se-hero-figure{max-width:1240px;margin:48px auto 0;padding:0 28px;display:block}
.se-hero-frame{position:relative;overflow:hidden;background:var(--paper-deep);border:1px solid var(--rule);box-shadow:0 30px 60px -20px rgba(31,22,18,.25);aspect-ratio:16 / 7}
.se-hero-frame::before{content:"";position:absolute;inset:14px;border:1px solid rgba(255,255,255,.55);pointer-events:none;z-index:2}
.se-hero-frame img,.se-hero-frame .se-hero-img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;display:block;filter:saturate(.95) contrast(1.02)}

/* ---------- Body ---------- */
.se-wrap{max-width:1240px;margin:0 auto;padding:60px 28px 40px}
.se-article{display:grid;grid-template-columns:1fr 320px;gap:60px;align-items:start}

/* ---------- Sidebar ---------- */
.se-sidebar{position:sticky;top:140px;display:flex;flex-direction:column;gap:24px}
.se-card{background:var(--card);border:1px solid var(--rule);padding:28px 26px}
.se-card-label{display:inline-block;font-family:var(--font-body);text-transform:uppercase;letter-spacing:.22em;font-size:.7rem;font-weight:600;color:var(--saffron);padding-left:28px;position:relative;margin-bottom:18px}
.se-card-label::before{content:"";position:absolute;left:0;top:50%;width:20px;height:1px;background:var(--saffron)}
.se-card-list{list-style:none;padding:0;margin:0 0 22px;display:flex;flex-direction:column;gap:0;border-top:1px solid var(--rule)}
.se-card-list li{padding:14px 0;border-bottom:1px solid var(--rule);display:flex;flex-direction:column;gap:4px}
.se-card-key{font-size:.7rem;color:var(--ink-mute);letter-spacing:.18em;text-transform:uppercase;font-weight:600}
.se-card-val{font-size:.95rem;color:var(--ink);line-height:1.5}
.se-card-cta{display:inline-flex;align-items:center;justify-content:center;gap:8px;background:var(--ink);color:var(--paper);padding:12px 20px;text-decoration:none;font-weight:600;font-size:.88rem;letter-spacing:.04em;transition:background .25s;width:100%}
.se-card-cta svg{transition:transform .25s}
.se-card-cta:hover{background:var(--saffron);color:#fff}
.se-card-cta:hover svg{transform:translateX(3px)}

.se-share{padding:0}
.se-share-label{font-size:.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.22em;color:var(--ink-mute);margin:0 0 12px}
.se-share-row{display:flex;gap:8px}
.se-share-btn{width:38px;height:38px;background:var(--card);color:var(--ink-soft);border:1px solid var(--rule);display:flex;align-items:center;justify-content:center;text-decoration:none;cursor:pointer;transition:all .25s;font-family:inherit}
.se-share-btn:hover{background:var(--ink);color:var(--paper);border-color:var(--ink);transform:translateY(-2px)}

/* ---------- Content ---------- */
.se-content{font-family:var(--font-body);font-size:1.06rem;line-height:1.85;color:var(--ink-soft)}
.se-content > *:first-child{margin-top:0}
.se-content p{margin:0 0 1.4em}
.se-content p:first-of-type::first-letter{font-family:var(--font-display);font-size:4em;font-weight:600;float:left;line-height:.9;padding:6px 14px 0 0;color:var(--saffron);font-style:italic}
.se-content h2{font-family:var(--font-display);font-size:1.85rem;margin:1.8em 0 .7em;color:var(--ink);font-weight:600;line-height:1.2;letter-spacing:-.015em}
.se-content h3{font-family:var(--font-display);font-size:1.4rem;margin:1.6em 0 .5em;color:var(--ink);font-weight:600;letter-spacing:-.01em}
.se-content a{color:var(--saffron);text-decoration:none;border-bottom:1px solid var(--saffron);padding-bottom:1px;transition:color .2s,border-color .2s}
.se-content a:hover{color:var(--saffron-d);border-bottom-color:var(--saffron-d)}
.se-content ul,.se-content ol{padding-left:24px;margin:0 0 1.4em}
.se-content li{margin:0 0 8px}
.se-content blockquote{margin:1.8em 0;padding:8px 0 8px 28px;border-left:3px solid var(--saffron);font-family:var(--font-display);font-style:italic;font-size:1.25rem;color:var(--ink);font-weight:400;line-height:1.55}
.se-content img{margin:1.6em 0;display:block;width:100%;border:1px solid var(--rule)}

/* ---------- Related ---------- */
.se-related{background:var(--paper-deep);padding:80px 28px;margin-top:60px;border-top:1px solid var(--rule)}
.se-related-inner{max-width:1240px;margin:0 auto}
.section-head{margin:0 0 40px;max-width:760px}
.section-head--left{text-align:left}
.section-head--left .hs-ornament{margin-top:18px;margin-left:0}
.section-head h2{font-family:var(--font-display);font-size:clamp(1.7rem,3vw,2.4rem);margin:8px 0 0;color:var(--ink);font-weight:600;line-height:1.1;letter-spacing:-.015em}
.se-related-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:28px}
.se-rel-card{background:var(--card);border:1px solid var(--rule);overflow:hidden;transition:transform .25s,box-shadow .25s,border-color .25s;display:flex;flex-direction:column}
.se-rel-card:hover{transform:translateY(-5px);box-shadow:0 20px 40px -18px rgba(31,22,18,.16);border-color:var(--saffron)}
.se-rel-image{display:block;height:200px;overflow:hidden;background:var(--paper-deep);text-decoration:none}
.se-rel-image img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.se-rel-card:hover .se-rel-image img{transform:scale(1.05)}
.se-rel-image--ph{display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#f3ead9,#e6dccb)}
.se-rel-image--ph span{font-family:var(--font-display);font-size:2.5rem;color:var(--saffron);opacity:.4;font-weight:600;letter-spacing:.05em}

.se-rel-body{padding:22px 24px 26px;display:flex;gap:18px;align-items:flex-start;flex:1}
.se-rel-date{flex:0 0 auto;text-align:center;padding-right:16px;border-right:1px solid var(--rule);min-width:54px}
.se-rel-day{display:block;font-family:var(--font-display);font-size:1.9rem;font-weight:600;color:var(--saffron);line-height:1}
.se-rel-month{display:block;margin-top:4px;font-size:.68rem;letter-spacing:.16em;color:var(--ink-mute);text-transform:uppercase;font-weight:600}
.se-rel-text h3{font-family:var(--font-display);font-size:1.1rem;line-height:1.35;margin:0 0 6px;font-weight:600;letter-spacing:-.01em}
.se-rel-text h3 a{color:var(--ink);text-decoration:none}
.se-rel-text h3 a:hover{color:var(--saffron)}
.se-rel-venue{color:var(--ink-mute);font-size:.85rem;margin:0;line-height:1.5}
.se-rel-venue::before{content:"◦ ";color:var(--saffron)}

.se-related-cta{text-align:center;margin-top:48px}
.se-related-btn{display:inline-flex;align-items:center;gap:10px;background:var(--ink);color:var(--paper);padding:14px 28px;text-decoration:none;font-weight:600;font-size:.95rem;letter-spacing:.04em;transition:background .25s}
.se-related-btn svg{transition:transform .25s}
.se-related-btn:hover{background:var(--saffron);color:#fff}
.se-related-btn:hover svg{transform:translateX(4px)}

/* ---------- Responsive ---------- */
@media (max-width:960px){
	.se-article{grid-template-columns:1fr;gap:40px}
	.se-sidebar{position:static;flex-direction:row;flex-wrap:wrap;gap:24px}
	.se-card{flex:1;min-width:260px}
	.se-share{flex:0 0 auto}
}
@media (max-width:768px){
	.se-hero{padding:40px 22px 24px}
	.se-hero-figure{padding:0 18px;margin-top:32px}
	.se-hero-frame{aspect-ratio:16 / 10}
	.se-wrap{padding:40px 18px}
	.se-content{font-size:1rem}
	.se-content h2{font-size:1.45rem}
	.se-content p:first-of-type::first-letter{font-size:3em}
	.se-meta-cell{padding:18px 20px}
	.se-meta-strong{font-size:1rem}
	.se-rel-body{padding:20px 22px}
	.se-related{padding:60px 22px}
}
</style>

<script>
(function(){
	var copyBtn = document.querySelector('.se-share-copy');
	if (!copyBtn) return;
	copyBtn.addEventListener('click', function(){
		var url = this.getAttribute('data-url');
		if (!navigator.clipboard) return;
		navigator.clipboard.writeText(url).then(function(){
			var originalHTML = copyBtn.innerHTML;
			copyBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>';
			copyBtn.style.background = 'var(--forest)';
			copyBtn.style.color = '#fff';
			copyBtn.style.borderColor = 'var(--forest)';
			setTimeout(function(){
				copyBtn.innerHTML = originalHTML;
				copyBtn.style.background = '';
				copyBtn.style.color = '';
				copyBtn.style.borderColor = '';
			}, 1600);
		});
	});
})();
</script>

<?php
get_footer();
