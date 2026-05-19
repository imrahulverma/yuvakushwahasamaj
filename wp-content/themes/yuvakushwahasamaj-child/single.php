<?php
/**
 * Single Post Template — Warm Editorial
 * Used for individual blog post / news article pages.
 */

get_header();

while ( have_posts() ) :
	the_post();
	$cats         = get_the_category();
	$primary_cat  = $cats ? $cats[0] : null;
	$reading_time = max( 1, (int) ceil( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) );
	$author_id    = get_the_author_meta( 'ID' );

	$related = ! empty( $cats ) ? get_posts( array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'post__not_in'   => array( get_the_ID() ),
		'category__in'   => wp_list_pluck( $cats, 'term_id' ),
		'orderby'        => 'date',
		'order'          => 'DESC',
	) ) : array();
	?>

<main id="main" class="site-main single-post-page">

	<!-- Editorial hero -->
	<header class="sp-hero">
		<div class="sp-hero-inner">
			<nav class="sp-breadcrumbs" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
				<span>·</span>
				<a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">Journal</a>
				<?php if ( $primary_cat ) : ?>
					<span>·</span>
					<a href="<?php echo esc_url( add_query_arg( 'cat', $primary_cat->slug, home_url( '/news/' ) ) ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a>
				<?php endif; ?>
			</nav>

			<?php if ( $primary_cat ) : ?>
				<a class="sp-category-badge" href="<?php echo esc_url( add_query_arg( 'cat', $primary_cat->slug, home_url( '/news/' ) ) ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a>
			<?php endif; ?>

			<h1 class="sp-title"><?php the_title(); ?></h1>

			<?php echo yks_ornament(); ?>

			<div class="sp-meta">
				<span class="sp-meta-item sp-meta-author">
					<?php echo get_avatar( $author_id, 36, '', '', array( 'class' => 'sp-avatar' ) ); ?>
					<span>By <strong><?php echo esc_html( yks_get_author_byline() ); ?></strong></span>
				</span>
				<span class="sp-meta-sep">·</span>
				<span class="sp-meta-item"><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></span>
				<span class="sp-meta-sep">·</span>
				<span class="sp-meta-item"><?php echo intval( $reading_time ); ?> min read</span>
			</div>

		</div>

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="sp-hero-figure">
				<div class="sp-hero-frame">
					<?php the_post_thumbnail( 'full', array( 'class' => 'sp-hero-img' ) ); ?>
				</div>
				<?php
				$thumb_caption = get_the_post_thumbnail_caption();
				if ( $thumb_caption ) : ?>
					<figcaption class="sp-hero-figcaption">
						<span class="sp-hero-figcaption-rule"></span>
						<span><?php echo esc_html( $thumb_caption ); ?></span>
					</figcaption>
				<?php endif; ?>
			</figure>
		<?php endif; ?>
	</header>

	<!-- Body -->
	<div class="sp-wrap">
		<article class="sp-article" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<aside class="sp-share" aria-label="Share this post">
				<p class="sp-share-label">Share</p>
				<?php
				$share_url   = urlencode( get_permalink() );
				$share_title = urlencode( get_the_title() );
				?>
				<a class="sp-share-btn" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener" aria-label="Share on Facebook">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.5h2.5l.4-3h-2.9V8.6c0-.9.2-1.5 1.5-1.5h1.6V4.4c-.3 0-1.2-.1-2.3-.1-2.3 0-3.8 1.4-3.8 3.9v2.2H8v3h2.5V21h3z"/></svg>
				</a>
				<a class="sp-share-btn" href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" rel="noopener" aria-label="Share on Twitter">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
				</a>
				<a class="sp-share-btn" href="https://wa.me/?text=<?php echo $share_title . '%20' . $share_url; ?>" target="_blank" rel="noopener" aria-label="Share on WhatsApp">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.5 3.5A10.4 10.4 0 0 0 12 0C6.2 0 1.5 4.7 1.5 10.5c0 1.8.5 3.6 1.4 5.2L1 24l8.5-2.2c1.5.8 3.2 1.3 4.9 1.3h.1c5.8 0 10.5-4.7 10.5-10.5 0-2.8-1-5.5-3-7.5l-1.5-1.6zM12 21.3c-1.5 0-3-.4-4.3-1.2l-.3-.2-3.7 1 .9-3.5-.2-.3a8.4 8.4 0 0 1-1.3-4.6c0-4.7 3.8-8.5 8.6-8.5 2.3 0 4.4.9 6 2.5a8.5 8.5 0 0 1 2.5 6c0 4.7-3.8 8.5-8.6 8.5z"/></svg>
				</a>
				<a class="sp-share-btn" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>" target="_blank" rel="noopener" aria-label="Share on LinkedIn">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zM8.3 18.3H5.7V10h2.6v8.3zM7 8.8c-.9 0-1.5-.6-1.5-1.4S6.2 6 7 6s1.5.6 1.5 1.4S7.9 8.8 7 8.8zm11.3 9.5h-2.6v-4.2c0-1.1-.4-1.8-1.4-1.8-.8 0-1.2.5-1.4 1-.1.2-.1.5-.1.7v4.3h-2.6V10h2.6v1.1c.3-.5 1-1.3 2.4-1.3 1.8 0 3.1 1.1 3.1 3.6v4.9z"/></svg>
				</a>
				<button class="sp-share-btn sp-share-copy" type="button" data-url="<?php echo esc_url( get_permalink() ); ?>" aria-label="Copy link">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
				</button>
			</aside>

			<div class="sp-content">
				<?php the_content(); ?>
			</div>

			<?php if ( has_tag() ) : ?>
				<div class="sp-tags">
					<span class="sp-tags-label">Tagged</span>
					<?php the_tags( '', '', '' ); ?>
				</div>
			<?php endif; ?>

			<!-- Post navigation -->
			<nav class="sp-postnav" aria-label="Post navigation">
				<?php
				$prev = get_previous_post();
				$next = get_next_post();
				?>
				<?php if ( $prev ) : ?>
					<a class="sp-postnav-link sp-prev" href="<?php echo esc_url( get_permalink( $prev ) ); ?>">
						<span class="sp-postnav-arrow">←</span>
						<span class="sp-postnav-body">
							<span class="sp-postnav-eyebrow">Previous</span>
							<span class="sp-postnav-title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
						</span>
					</a>
				<?php else : ?><span></span><?php endif; ?>

				<?php if ( $next ) : ?>
					<a class="sp-postnav-link sp-next" href="<?php echo esc_url( get_permalink( $next ) ); ?>">
						<span class="sp-postnav-body">
							<span class="sp-postnav-eyebrow">Next</span>
							<span class="sp-postnav-title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
						</span>
						<span class="sp-postnav-arrow">→</span>
					</a>
				<?php endif; ?>
			</nav>

		</article>
	</div>

	<!-- Related posts -->
	<?php if ( $related ) : ?>
		<section class="sp-related">
			<div class="sp-related-inner">
				<header class="section-head section-head--left">
					<span class="eyebrow">Further Reading</span>
					<h2 class="sp-related-title">Related Articles</h2>
					<?php echo yks_ornament(); ?>
				</header>
				<div class="sp-related-grid">
					<?php foreach ( $related as $rp ) :
						$rp_cats = get_the_category( $rp->ID );
						$rp_cat  = $rp_cats ? $rp_cats[0] : null;
						?>
						<article class="sp-rel-card">
							<a class="sp-rel-image" href="<?php echo esc_url( get_permalink( $rp ) ); ?>">
								<?php if ( has_post_thumbnail( $rp ) ) {
									echo get_the_post_thumbnail( $rp, 'medium_large' );
								} else { ?>
									<div class="sp-rel-placeholder"><span>YK</span></div>
								<?php } ?>
								<?php if ( $rp_cat ) : ?>
									<span class="sp-rel-cat"><?php echo esc_html( $rp_cat->name ); ?></span>
								<?php endif; ?>
							</a>
							<div class="sp-rel-body">
								<p class="sp-rel-date"><?php echo esc_html( get_the_date( 'F j, Y', $rp ) ); ?></p>
								<h3 class="sp-rel-h3"><a href="<?php echo esc_url( get_permalink( $rp ) ); ?>"><?php echo esc_html( get_the_title( $rp ) ); ?></a></h3>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
				<div class="sp-related-cta">
					<a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" class="sp-related-btn">
						<span>Read the journal</span>
						<svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</a>
				</div>
			</div>
		</section>
	<?php endif; ?>

</main>

<?php endwhile; ?>

<style>
.single-post-page{background:var(--paper);font-family:var(--font-body);color:var(--ink-soft)}

/* ---------- Hero ---------- */
.sp-hero{background:
	radial-gradient(1200px 600px at 80% 10%, rgba(200,84,28,.08), transparent 60%),
	radial-gradient(900px 500px at 0% 90%, rgba(30,90,60,.08), transparent 60%),
	var(--paper);
	padding:60px 28px 30px}
.sp-hero-inner{max-width:880px;margin:0 auto}

.sp-breadcrumbs{margin:0 0 22px;font-size:.78rem;color:var(--ink-mute);letter-spacing:.06em}
.sp-breadcrumbs a{color:var(--ink-mute);text-decoration:none;transition:color .2s}
.sp-breadcrumbs a:hover{color:var(--saffron)}
.sp-breadcrumbs span{margin:0 8px;color:var(--saffron);opacity:.6}

.sp-category-badge{display:inline-block;font-family:var(--font-body);text-transform:uppercase;letter-spacing:.22em;font-size:.72rem;font-weight:600;color:var(--saffron);padding-left:34px;position:relative;text-decoration:none;margin-bottom:16px;transition:color .2s}
.sp-category-badge::before{content:"";position:absolute;left:0;top:50%;width:24px;height:1px;background:var(--saffron)}
.sp-category-badge:hover{color:var(--saffron-d)}

.sp-title{font-family:var(--font-display);font-weight:600;font-size:clamp(2.2rem,4.6vw,3.6rem);margin:8px 0 0;line-height:1.08;color:var(--ink);letter-spacing:-.022em;max-width:840px}
.sp-title::first-letter{color:var(--saffron);font-style:italic}
.sp-hero-inner .hs-ornament{margin:22px 0 22px}

.sp-meta{display:flex;flex-wrap:wrap;align-items:center;gap:12px;font-size:.92rem;color:var(--ink-mute);font-family:var(--font-body)}
.sp-meta-item{display:inline-flex;align-items:center;gap:8px}
.sp-meta-item strong{color:var(--ink);font-weight:600;font-family:var(--font-display)}
.sp-meta-sep{color:var(--saffron);opacity:.7}
.sp-avatar{border-radius:50%;width:36px;height:36px;border:1px solid var(--rule)}

.sp-hero-figure{max-width:1240px;margin:48px auto 0;padding:0 28px;display:block}
.sp-hero-frame{position:relative;overflow:hidden;background:var(--paper-deep);border:1px solid var(--rule);box-shadow:0 30px 60px -20px rgba(31,22,18,.25);aspect-ratio:16 / 7}
.sp-hero-frame::before{content:"";position:absolute;inset:14px;border:1px solid rgba(255,255,255,.55);pointer-events:none;z-index:2}
.sp-hero-frame img,.sp-hero-frame .sp-hero-img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;display:block;filter:saturate(.95) contrast(1.02)}
.sp-hero-figcaption{display:flex;align-items:center;gap:14px;margin:16px 0 0;font-size:.78rem;letter-spacing:.08em;color:var(--ink-mute);text-transform:uppercase;font-weight:500;font-family:var(--font-body)}
.sp-hero-figcaption-rule{display:inline-block;width:36px;height:1px;background:var(--saffron);flex:0 0 auto}

/* ---------- Body wrapper ---------- */
.sp-wrap{max-width:820px;margin:0 auto;padding:60px 28px 40px;position:relative}
.sp-article{background:var(--card);border:1px solid var(--rule);padding:60px 64px 48px;position:relative}

/* ---------- Share column ---------- */
.sp-share{position:absolute;left:-90px;top:60px;display:flex;flex-direction:column;align-items:center;gap:10px}
.sp-share-label{margin:0 0 8px;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.2em;color:var(--ink-mute);writing-mode:vertical-rl;transform:rotate(180deg)}
.sp-share-btn{width:42px;height:42px;background:var(--card);color:var(--ink-soft);border:1px solid var(--rule);display:flex;align-items:center;justify-content:center;text-decoration:none;cursor:pointer;transition:all .25s;font-family:inherit}
.sp-share-btn:hover{background:var(--ink);color:var(--paper);border-color:var(--ink);transform:translateY(-3px)}

/* ---------- Content typography ---------- */
.sp-content{font-family:var(--font-body);font-size:1.08rem;line-height:1.85;color:var(--ink-soft)}
.sp-content > *:first-child{margin-top:0}
.sp-content p{margin:0 0 1.5em}
.sp-content p:first-of-type::first-letter{font-family:var(--font-display);font-size:4.2em;font-weight:600;float:left;line-height:.88;padding:8px 16px 0 0;color:var(--saffron);font-style:italic}
.sp-content h2{font-family:var(--font-display);font-size:1.9rem;margin:2em 0 .8em;color:var(--ink);font-weight:600;line-height:1.2;letter-spacing:-.015em}
.sp-content h3{font-family:var(--font-display);font-size:1.45rem;margin:1.8em 0 .6em;color:var(--ink);font-weight:600;letter-spacing:-.01em}
.sp-content a{color:var(--saffron);text-decoration:none;border-bottom:1px solid var(--saffron);padding-bottom:1px;transition:color .2s,border-color .2s}
.sp-content a:hover{color:var(--saffron-d);border-bottom-color:var(--saffron-d)}
.sp-content ul,.sp-content ol{padding-left:24px;margin:0 0 1.5em}
.sp-content li{margin:0 0 10px}
.sp-content blockquote{margin:2em 0;padding:8px 0 8px 30px;background:transparent;border-left:3px solid var(--saffron);font-family:var(--font-display);font-style:italic;font-size:1.3rem;color:var(--ink);font-weight:400;line-height:1.55}
.sp-content blockquote p:last-child{margin-bottom:0}
.sp-content blockquote cite{display:block;margin-top:14px;font-style:normal;font-family:var(--font-body);font-size:.78rem;color:var(--ink-mute);font-weight:600;text-transform:uppercase;letter-spacing:.16em}
.sp-content img{margin:1.8em 0;display:block;width:100%;border:1px solid var(--rule)}
.sp-content figure{margin:1.8em 0}
.sp-content figcaption{margin-top:10px;font-family:var(--font-display);font-style:italic;font-size:.92rem;color:var(--ink-mute);text-align:center}
.sp-content code{background:var(--paper-deep);padding:2px 8px;font-size:.92em;color:var(--saffron-d);font-family:'SF Mono',Menlo,Consolas,monospace}
.sp-content pre{background:var(--ink);color:#f3ead9;padding:22px 26px;overflow-x:auto;margin:1.8em 0;font-family:'SF Mono',Menlo,Consolas,monospace;font-size:.92rem;line-height:1.6}
.sp-content pre code{background:transparent;color:inherit;padding:0}
.sp-content hr{border:0;height:1px;background:var(--rule);margin:3em 0}

/* ---------- Tags ---------- */
.sp-tags{margin:48px 0 0;padding:24px 0 0;border-top:1px solid var(--rule);font-size:.85rem;color:var(--ink-mute);display:flex;flex-wrap:wrap;gap:10px;align-items:center}
.sp-tags-label{font-weight:600;color:var(--ink);text-transform:uppercase;letter-spacing:.18em;font-size:.72rem;margin-right:6px}
.sp-tags a{display:inline-block;background:var(--paper-deep);color:var(--ink-soft);padding:6px 14px;text-decoration:none;font-size:.85rem;margin:0;transition:all .2s;border:1px solid transparent}
.sp-tags a:hover{background:var(--ink);color:var(--paper);border-color:var(--ink)}

/* ---------- Post nav ---------- */
.sp-postnav{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin:48px 0 0}
.sp-postnav-link{display:flex;align-items:center;gap:16px;padding:22px 26px;background:var(--paper);border:1px solid var(--rule);text-decoration:none;color:var(--ink);transition:all .25s}
.sp-postnav-link:hover{background:var(--paper-deep);border-color:var(--saffron);transform:translateY(-3px)}
.sp-postnav-arrow{font-size:1.4rem;color:var(--saffron);font-weight:600;font-family:var(--font-display)}
.sp-postnav-body{display:flex;flex-direction:column;flex:1;min-width:0}
.sp-postnav-eyebrow{font-size:.7rem;text-transform:uppercase;letter-spacing:.22em;color:var(--ink-mute);font-weight:600;margin-bottom:6px}
.sp-postnav-title{font-family:var(--font-display);font-size:.98rem;font-weight:600;color:var(--ink);line-height:1.35;overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical}
.sp-next{flex-direction:row;text-align:right}
.sp-next .sp-postnav-body{align-items:flex-end}

/* ---------- Related ---------- */
.sp-related{background:var(--paper-deep);padding:80px 28px;margin-top:60px;border-top:1px solid var(--rule)}
.sp-related-inner{max-width:1240px;margin:0 auto}
.section-head{margin:0 0 40px;max-width:760px}
.section-head--left{text-align:left}
.section-head--left .hs-ornament{margin-top:18px;margin-left:0}
.sp-related-title{font-family:var(--font-display);font-size:clamp(1.7rem,3vw,2.4rem);margin:8px 0 0;color:var(--ink);font-weight:600;line-height:1.1;letter-spacing:-.015em}
.sp-related-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:28px}
.sp-rel-card{background:var(--card);border:1px solid var(--rule);overflow:hidden;transition:transform .25s,box-shadow .25s,border-color .25s}
.sp-rel-card:hover{transform:translateY(-5px);box-shadow:0 20px 40px -18px rgba(31,22,18,.16);border-color:var(--saffron)}
.sp-rel-image{position:relative;display:block;height:200px;overflow:hidden;background:var(--paper-deep)}
.sp-rel-image img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.sp-rel-card:hover .sp-rel-image img{transform:scale(1.05)}
.sp-rel-placeholder{height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#f3ead9,#e6dccb)}
.sp-rel-placeholder span{font-family:var(--font-display);font-size:2.6rem;color:var(--saffron);opacity:.4;font-weight:600;letter-spacing:.05em}
.sp-rel-cat{position:absolute;top:14px;left:14px;background:var(--ink);color:var(--paper);padding:4px 12px;font-size:.66rem;font-weight:600;text-transform:uppercase;letter-spacing:.14em}
.sp-rel-body{padding:22px 24px 24px}
.sp-rel-date{font-size:.72rem;color:var(--ink-mute);margin:0 0 10px;letter-spacing:.1em;text-transform:uppercase;font-weight:600}
.sp-rel-h3{font-family:var(--font-display);font-size:1.12rem;line-height:1.4;margin:0;font-weight:600;letter-spacing:-.01em}
.sp-rel-h3 a{color:var(--ink);text-decoration:none}
.sp-rel-h3 a:hover{color:var(--saffron)}

.sp-related-cta{text-align:center;margin-top:48px}
.sp-related-btn{display:inline-flex;align-items:center;gap:10px;background:var(--ink);color:var(--paper);padding:14px 28px;text-decoration:none;font-weight:600;font-size:.95rem;letter-spacing:.04em;transition:background .25s}
.sp-related-btn svg{transition:transform .25s}
.sp-related-btn:hover{background:var(--saffron);color:#fff}
.sp-related-btn:hover svg{transform:translateX(4px)}

/* ---------- Responsive ---------- */
@media (max-width:1000px){
	.sp-share{position:static;flex-direction:row;justify-content:center;margin-bottom:30px;gap:10px}
	.sp-share-label{writing-mode:horizontal-tb;transform:none;margin:0 8px 0 0;align-self:center}
}
@media (max-width:768px){
	.sp-hero{padding:40px 22px 24px}
	.sp-hero-figure{padding:0 18px;margin-top:32px}
	.sp-hero-frame{aspect-ratio:16 / 10}
	.sp-wrap{padding:30px 18px}
	.sp-article{padding:36px 28px 30px}
	.sp-content{font-size:1rem}
	.sp-content h2{font-size:1.5rem}
	.sp-content p:first-of-type::first-letter{font-size:3.2em}
	.sp-content blockquote{font-size:1.1rem;padding-left:22px}
	.sp-postnav{grid-template-columns:1fr}
	.sp-next{flex-direction:row-reverse;text-align:left}
	.sp-next .sp-postnav-body{align-items:flex-start}
	.sp-related{padding:60px 22px}
}
</style>

<script>
(function(){
	var copyBtn = document.querySelector('.sp-share-copy');
	if (!copyBtn) return;
	copyBtn.addEventListener('click', function(){
		var url = this.getAttribute('data-url');
		if (!navigator.clipboard) return;
		navigator.clipboard.writeText(url).then(function(){
			var originalHTML = copyBtn.innerHTML;
			copyBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>';
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
