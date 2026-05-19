<?php
/**
 * Template Name: Gallery
 * Description: Gallery page template — warm editorial style
 */

get_header();

$gallery_filter = isset( $_GET['category'] ) ? sanitize_text_field( $_GET['category'] ) : '';

$gallery_items = get_posts( array(
	'post_type'      => 'gallery_item',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'tax_query'      => ! empty( $gallery_filter ) ? array(
		array(
			'taxonomy' => 'gallery_category',
			'field'    => 'slug',
			'terms'    => $gallery_filter,
		),
	) : array(),
) );

$total_items        = count( $gallery_items );
$gallery_categories = get_terms( array( 'taxonomy' => 'gallery_category', 'hide_empty' => true ) );
?>

<main id="main" class="site-main gallery-page">

	<!-- Editorial page hero -->
	<section class="page-hero">
		<div class="page-hero-inner">
			<span class="eyebrow">Album · Memories · Milestones</span>
			<h1><?php the_title(); ?></h1>
			<?php echo yks_ornament(); ?>
			<p class="page-hero-lede">A visual record of our community's gatherings, achievements, and quiet moments — assembled by the people who lived them.</p>
			<div class="gal-hero-meta">
				<span><strong><?php echo intval( $total_items ); ?></strong> photographs</span>
				<?php if ( $gallery_categories ) : ?>
					<span class="gal-hero-sep">·</span>
					<span><strong><?php echo count( $gallery_categories ); ?></strong> collections</span>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<div class="container">

		<!-- Photo Gallery -->
		<section class="photo-gallery">

			<?php if ( ! is_wp_error( $gallery_categories ) && $gallery_categories ) : ?>
				<nav class="gallery-filters" aria-label="Filter gallery">
					<a href="<?php the_permalink(); ?>" class="filter-btn <?php echo empty( $gallery_filter ) ? 'is-active' : ''; ?>">
						All <span class="filter-count"><?php echo intval( $total_items ); ?></span>
					</a>
					<?php foreach ( $gallery_categories as $category ) : ?>
						<a href="<?php echo esc_url( add_query_arg( 'category', $category->slug, get_permalink() ) ); ?>" class="filter-btn <?php echo ( $gallery_filter === $category->slug ) ? 'is-active' : ''; ?>">
							<?php echo esc_html( $category->name ); ?> <span class="filter-count"><?php echo intval( $category->count ); ?></span>
						</a>
					<?php endforeach; ?>
				</nav>
			<?php endif; ?>

			<div class="gallery-mosaic">
				<?php if ( $gallery_items ) : foreach ( $gallery_items as $i => $item ) :
					setup_postdata( $item );
					$image_id = get_scf_field( 'image', $item->ID );
					$caption  = get_scf_field( 'caption', $item->ID );
					$year     = get_scf_field( 'year', $item->ID );
					$full_url = $image_id ? wp_get_attachment_image_url( $image_id, 'full' ) : '';
					$size_class = ( $i % 7 === 0 ) ? 'is-large' : ( ( $i % 5 === 0 ) ? 'is-tall' : ( ( $i % 6 === 0 ) ? 'is-wide' : '' ) );
					?>
					<figure class="gallery-item <?php echo esc_attr( $size_class ); ?>" data-full="<?php echo esc_attr( $full_url ); ?>" data-caption="<?php echo esc_attr( $caption ); ?>">
						<?php if ( $image_id ) : ?>
							<?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'gallery-image', 'loading' => 'lazy' ) ); ?>
						<?php else : ?>
							<div class="gallery-placeholder"><span>YK</span></div>
						<?php endif; ?>
						<figcaption class="gallery-overlay">
							<?php if ( $year ) : ?><span class="gallery-year"><?php echo esc_html( $year ); ?></span><?php endif; ?>
							<?php if ( $caption ) : ?><p class="gallery-caption"><?php echo esc_html( $caption ); ?></p><?php endif; ?>
							<span class="gallery-zoom" aria-hidden="true">
								<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="6"/><path d="m20 20-3.5-3.5" stroke-linecap="round"/><path d="M11 8v6M8 11h6" stroke-linecap="round"/></svg>
							</span>
						</figcaption>
					</figure>
				<?php endforeach; wp_reset_postdata(); else : ?>
					<div class="gallery-empty">
						<p>No photographs found<?php echo $gallery_filter ? ' in this collection' : '' ?>. Check back soon.</p>
					</div>
				<?php endif; ?>
			</div>
		</section>

		<!-- Video Gallery -->
		<section class="video-gallery">
			<header class="section-head section-head--left">
				<span class="eyebrow">Chapter 02 · Moving Picture</span>
				<h2>Video Highlights</h2>
				<?php echo yks_ornament(); ?>
				<p class="section-sub">Subscribe to our YouTube channel for the latest community videos.</p>
			</header>

			<div class="video-grid">
				<?php
				$videos = array(
					array( 'title' => 'Annual Sammelan Highlights', 'date' => 'August 2025' ),
					array( 'title' => 'Youth Leadership Bootcamp', 'date' => 'June 2025' ),
					array( 'title' => 'Cultural Heritage Workshop', 'date' => 'April 2025' ),
				);
				foreach ( $videos as $v ) : ?>
					<div class="video-item">
						<div class="video-thumb">
							<div class="video-placeholder">
								<svg viewBox="0 0 60 60" width="56" height="56" aria-hidden="true">
									<circle cx="30" cy="30" r="29" fill="none" stroke="currentColor" stroke-width="1.5"/>
									<polygon points="25,18 25,42 43,30" fill="currentColor"/>
								</svg>
							</div>
						</div>
						<div class="video-body">
							<h3><?php echo esc_html( $v['title'] ); ?></h3>
							<p><?php echo esc_html( $v['date'] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<p class="video-cta"><a href="#" target="_blank" rel="noopener">Visit our YouTube channel &nbsp;→</a></p>
		</section>

		<!-- Press Coverage -->
		<section class="press-coverage">
			<header class="section-head section-head--left">
				<span class="eyebrow">Chapter 03 · In the Papers</span>
				<h2>Press &amp; Media</h2>
				<?php echo yks_ornament(); ?>
				<p class="section-sub">Our community in the news.</p>
			</header>

			<div class="press-items">
				<article class="press-item">
					<span class="press-badge">Article</span>
					<h3>Featured in Regional News</h3>
					<p>Our community initiative was highlighted by major regional media outlets for its youth engagement programmes.</p>
					<a href="#" class="press-read">Read article &nbsp;→</a>
				</article>
				<article class="press-item">
					<span class="press-badge">Interview</span>
					<h3>Interview with Community Leaders</h3>
					<p>Leaders discuss the vision and mission of Yuvakushwahasamaj in national broadcast.</p>
					<a href="#" class="press-read">Watch interview &nbsp;→</a>
				</article>
				<article class="press-item">
					<span class="press-badge">Honour</span>
					<h3>Awards &amp; Recognition</h3>
					<p>Recognition from government and civil society for outstanding contributions to youth development.</p>
					<a href="#" class="press-read">Learn more &nbsp;→</a>
				</article>
			</div>
		</section>

	</div>

	<!-- Lightbox -->
	<div class="gallery-lightbox" id="gallery-lightbox" aria-hidden="true" role="dialog" aria-label="Image viewer">
		<button class="lb-close" aria-label="Close">
			<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
		</button>
		<button class="lb-prev" aria-label="Previous">
			<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 6l-6 6 6 6"/></svg>
		</button>
		<button class="lb-next" aria-label="Next">
			<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>
		</button>
		<figure class="lb-content">
			<img class="lb-image" src="" alt="">
			<figcaption class="lb-caption"></figcaption>
		</figure>
	</div>

</main>

<style>
.gallery-page{background:var(--paper);font-family:var(--font-body);color:var(--ink-soft)}
.container{max-width:1240px;margin:0 auto;padding:0 28px}

/* ---------- Editorial page hero ---------- */
.page-hero{padding:80px 28px 70px;background:
	radial-gradient(1200px 600px at 80% 10%, rgba(200,84,28,.08), transparent 60%),
	radial-gradient(900px 500px at 0% 90%, rgba(30,90,60,.08), transparent 60%),
	var(--paper)}
.page-hero-inner{max-width:820px;margin:0 auto}
.page-hero .eyebrow{padding-left:46px;position:relative}
.page-hero .eyebrow::before{content:"";position:absolute;left:0;top:50%;width:34px;height:1px;background:var(--saffron)}
.page-hero h1{font-family:var(--font-display);font-weight:600;font-size:clamp(2.4rem,4.6vw,3.8rem);line-height:1.05;letter-spacing:-.022em;color:var(--ink);margin:14px 0 0}
.page-hero h1::first-letter{color:var(--saffron);font-style:italic}
.page-hero .hs-ornament{margin:18px 0 24px}
.page-hero-lede{font-family:var(--font-display);font-style:italic;font-size:1.25rem;line-height:1.55;color:var(--ink);margin:0 0 24px;max-width:680px}
.gal-hero-meta{display:inline-flex;gap:14px;align-items:center;font-size:.85rem;color:var(--ink-mute);letter-spacing:.04em;border-top:1px solid var(--rule);padding-top:18px}
.gal-hero-meta strong{font-family:var(--font-display);font-size:1.1rem;font-weight:600;color:var(--ink);margin-right:4px}
.gal-hero-sep{opacity:.6;color:var(--saffron)}

/* ---------- Section heads ---------- */
.gallery-page section{padding:60px 0}
.section-head{margin:0 0 40px;max-width:760px}
.section-head--left{text-align:left}
.section-head h2{font-family:var(--font-display);font-weight:600;font-size:clamp(1.7rem,3vw,2.4rem);line-height:1.1;letter-spacing:-.015em;color:var(--ink);margin:8px 0 0}
.section-head .hs-ornament{margin-top:18px;margin-left:0}
.section-sub{margin:14px 0 0;color:var(--ink-mute);font-size:1rem;line-height:1.7}

/* ---------- Filters ---------- */
.gallery-filters{display:flex;flex-wrap:wrap;gap:4px;margin-bottom:36px;padding:10px 0;border-top:1px solid var(--rule);border-bottom:1px solid var(--rule)}
.filter-btn{display:inline-flex;align-items:center;gap:8px;padding:8px 16px;text-decoration:none;color:var(--ink-soft);font-weight:500;font-size:.88rem;letter-spacing:.02em;transition:color .2s;position:relative}
.filter-btn:hover{color:var(--saffron)}
.filter-btn.is-active{color:var(--saffron)}
.filter-btn.is-active::after{content:"";position:absolute;left:16px;right:16px;bottom:2px;height:1px;background:var(--saffron)}
.filter-count{background:var(--paper-deep);padding:2px 8px;font-size:.72rem;font-weight:600;color:var(--ink-mute)}
.filter-btn.is-active .filter-count{background:var(--saffron);color:#fff}

/* ---------- Mosaic ---------- */
.gallery-mosaic{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));grid-auto-rows:200px;gap:12px}
.gallery-item{position:relative;margin:0;overflow:hidden;cursor:pointer;background:var(--paper-deep);border:1px solid var(--rule);transition:transform .3s,box-shadow .3s,border-color .3s}
.gallery-item:hover{transform:translateY(-4px);box-shadow:0 18px 30px -16px rgba(31,22,18,.22);border-color:var(--saffron)}
.gallery-item.is-large{grid-column:span 2;grid-row:span 2}
.gallery-item.is-tall{grid-row:span 2}
.gallery-item.is-wide{grid-column:span 2}
.gallery-item img,.gallery-placeholder{width:100%;height:100%;object-fit:cover;display:block;transition:transform .6s ease,filter .4s}
.gallery-item:hover img{transform:scale(1.06);filter:saturate(1.1)}
.gallery-placeholder{display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#f3ead9,#e6dccb)}
.gallery-placeholder span{font-family:var(--font-display);font-size:2.4rem;color:var(--saffron);opacity:.4;font-weight:600;letter-spacing:.05em}

.gallery-overlay{position:absolute;inset:0;display:flex;flex-direction:column;justify-content:flex-end;padding:18px;background:linear-gradient(to top,rgba(31,22,18,.88) 0%,rgba(31,22,18,.2) 55%,transparent 100%);color:#fff;opacity:0;transition:opacity .3s}
.gallery-item:hover .gallery-overlay{opacity:1}
.gallery-year{display:inline-block;background:var(--saffron);color:#fff;padding:3px 10px;font-size:.7rem;font-weight:700;margin-bottom:8px;align-self:flex-start;letter-spacing:.14em;text-transform:uppercase}
.gallery-caption{margin:0;font-family:var(--font-display);font-style:italic;font-size:.95rem;line-height:1.5;font-weight:400}
.gallery-zoom{position:absolute;top:14px;right:14px;width:38px;height:38px;background:rgba(255,255,255,.18);backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;color:#fff;border:1px solid rgba(255,255,255,.3)}

.gallery-empty{grid-column:1/-1;text-align:center;padding:70px 20px;color:var(--ink-mute);font-style:italic;font-family:var(--font-display);font-size:1.05rem}

/* ---------- Video gallery ---------- */
.video-gallery{background:var(--paper-deep);margin:30px -28px;padding:80px 28px !important}
.video-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:28px;max-width:1100px}
.video-item{background:var(--card);border:1px solid var(--rule);overflow:hidden;transition:transform .25s,box-shadow .25s,border-color .25s;cursor:pointer}
.video-item:hover{transform:translateY(-5px);box-shadow:0 18px 30px -16px rgba(31,22,18,.18);border-color:var(--saffron)}
.video-thumb{position:relative;height:200px;background:var(--ink);display:flex;align-items:center;justify-content:center;color:var(--saffron)}
.video-placeholder{transition:transform .25s}
.video-item:hover .video-placeholder{transform:scale(1.08)}
.video-body{padding:22px 24px 26px}
.video-body h3{font-family:var(--font-display);margin:0 0 6px;font-size:1.15rem;color:var(--ink);font-weight:600;letter-spacing:-.01em}
.video-body p{margin:0;color:var(--ink-mute);font-size:.82rem;letter-spacing:.1em;text-transform:uppercase;font-weight:600}
.video-cta{text-align:left;margin:36px 0 0}
.video-cta a{color:var(--ink);font-weight:600;text-decoration:none;font-size:.95rem;border-bottom:1px solid var(--saffron);padding-bottom:3px;transition:color .2s}
.video-cta a:hover{color:var(--saffron)}

/* ---------- Press ---------- */
.press-items{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:28px}
.press-item{background:var(--card);padding:36px 30px;border:1px solid var(--rule);transition:transform .25s,box-shadow .25s,border-color .25s;position:relative}
.press-item:hover{transform:translateY(-5px);box-shadow:0 18px 30px -16px rgba(31,22,18,.18);border-color:var(--saffron)}
.press-badge{display:inline-block;font-family:var(--font-body);text-transform:uppercase;letter-spacing:.2em;font-size:.7rem;font-weight:600;color:var(--saffron);padding-left:32px;position:relative;margin-bottom:16px}
.press-badge::before{content:"";position:absolute;left:0;top:50%;width:22px;height:1px;background:var(--saffron)}
.press-item h3{font-family:var(--font-display);font-size:1.22rem;margin:0 0 12px;color:var(--ink);font-weight:600;letter-spacing:-.01em;line-height:1.3}
.press-item p{color:var(--ink-soft);line-height:1.7;margin:0 0 20px;font-size:.95rem}
.press-read{color:var(--ink);font-weight:600;text-decoration:none;font-size:.88rem;border-bottom:1px solid var(--saffron);padding-bottom:2px;transition:color .2s}
.press-read:hover{color:var(--saffron)}

/* ---------- Lightbox ---------- */
.gallery-lightbox{position:fixed;inset:0;background:rgba(31,22,18,.94);z-index:9999;display:none;align-items:center;justify-content:center;animation:lbFade .2s}
.gallery-lightbox.is-open{display:flex}
@keyframes lbFade{from{opacity:0}to{opacity:1}}
.lb-content{max-width:90vw;max-height:85vh;margin:0;text-align:center}
.lb-image{max-width:90vw;max-height:80vh;box-shadow:0 30px 60px rgba(0,0,0,.5)}
.lb-caption{color:#f3ead9;padding:16px 0 0;font-size:.95rem;font-family:var(--font-display);font-style:italic}
.lb-close,.lb-prev,.lb-next{position:absolute;background:rgba(243,234,217,.1);color:#f3ead9;border:1px solid rgba(243,234,217,.18);width:48px;height:48px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s}
.lb-close:hover,.lb-prev:hover,.lb-next:hover{background:var(--saffron);border-color:var(--saffron);color:#fff}
.lb-close{top:24px;right:24px}
.lb-prev{left:24px;top:50%;transform:translateY(-50%)}
.lb-next{right:24px;top:50%;transform:translateY(-50%)}

@media (max-width:768px){
	.page-hero{padding:60px 24px 60px}
	.gallery-mosaic{grid-template-columns:repeat(2,1fr);grid-auto-rows:160px}
	.gallery-item.is-large,.gallery-item.is-tall,.gallery-item.is-wide{grid-column:span 1;grid-row:span 1}
	.gallery-item.is-large{grid-column:span 2}
	.video-gallery{margin:30px -20px;padding:60px 22px !important}
	.lb-close,.lb-prev,.lb-next{width:42px;height:42px}
	.lb-prev{left:10px}.lb-next{right:10px}
}
@media (max-width:480px){
	.gallery-mosaic{grid-template-columns:1fr;grid-auto-rows:240px}
	.gallery-item.is-large{grid-column:span 1}
	.filter-btn{padding:7px 12px;font-size:.84rem}
}
</style>

<script>
(function(){
	var lb = document.getElementById('gallery-lightbox');
	if (!lb) return;
	var img = lb.querySelector('.lb-image');
	var cap = lb.querySelector('.lb-caption');
	var items = Array.prototype.slice.call(document.querySelectorAll('.gallery-item[data-full]'));
	var idx = -1;

	function open(i){
		var el = items[i];
		if (!el) return;
		var src = el.getAttribute('data-full');
		if (!src) return;
		idx = i;
		img.src = src;
		cap.textContent = el.getAttribute('data-caption') || '';
		lb.classList.add('is-open');
		document.body.style.overflow = 'hidden';
	}
	function close(){
		lb.classList.remove('is-open');
		img.src = '';
		document.body.style.overflow = '';
	}
	function nav(d){ open((idx + d + items.length) % items.length); }

	items.forEach(function(el, i){ el.addEventListener('click', function(){ open(i); }); });
	lb.querySelector('.lb-close').addEventListener('click', close);
	lb.querySelector('.lb-prev').addEventListener('click', function(){ nav(-1); });
	lb.querySelector('.lb-next').addEventListener('click', function(){ nav(1); });
	lb.addEventListener('click', function(e){ if (e.target === lb) close(); });
	document.addEventListener('keydown', function(e){
		if (!lb.classList.contains('is-open')) return;
		if (e.key === 'Escape') close();
		else if (e.key === 'ArrowLeft') nav(-1);
		else if (e.key === 'ArrowRight') nav(1);
	});
})();
</script>

<?php
get_footer();
