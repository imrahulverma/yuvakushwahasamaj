<?php
/**
 * Template Name: Gallery
 * Description: Gallery page template
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

	<!-- Hero -->
	<section class="gal-hero">
		<div class="gal-hero-inner">
			<p class="gal-hero-eyebrow">Memories · Moments · Milestones</p>
			<h1><?php the_title(); ?></h1>
			<p class="gal-hero-desc">A visual journey through our community's events, achievements, and celebrations.</p>
			<div class="gal-hero-meta">
				<span><strong><?php echo intval( $total_items ); ?></strong> photos</span>
				<?php if ( $gallery_categories ) : ?>
					<span class="dot">·</span>
					<span><strong><?php echo count( $gallery_categories ); ?></strong> categories</span>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<div class="container">

		<!-- Photo Gallery -->
		<section class="photo-gallery">

			<?php if ( ! is_wp_error( $gallery_categories ) && $gallery_categories ) : ?>
				<nav class="gallery-filters" aria-label="Filter gallery">
					<a href="<?php the_permalink(); ?>" class="filter-btn <?php echo empty( $gallery_filter ) ? 'active' : ''; ?>">
						<span class="filter-dot"></span> All <span class="filter-count"><?php echo intval( $total_items ); ?></span>
					</a>
					<?php foreach ( $gallery_categories as $category ) : ?>
						<a href="<?php echo esc_url( add_query_arg( 'category', $category->slug, get_permalink() ) ); ?>" class="filter-btn <?php echo ( $gallery_filter === $category->slug ) ? 'active' : ''; ?>">
							<span class="filter-dot"></span> <?php echo esc_html( $category->name ); ?> <span class="filter-count"><?php echo intval( $category->count ); ?></span>
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
					// Vary tile sizes for a mosaic feel.
					$size_class = ( $i % 7 === 0 ) ? 'is-large' : ( ( $i % 5 === 0 ) ? 'is-tall' : ( ( $i % 6 === 0 ) ? 'is-wide' : '' ) );
					?>
					<figure class="gallery-item <?php echo esc_attr( $size_class ); ?>" data-full="<?php echo esc_attr( $full_url ); ?>" data-caption="<?php echo esc_attr( $caption ); ?>">
						<?php if ( $image_id ) : ?>
							<?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'gallery-image', 'loading' => 'lazy' ) ); ?>
						<?php else : ?>
							<div class="gallery-placeholder"><span>🖼</span></div>
						<?php endif; ?>
						<figcaption class="gallery-overlay">
							<?php if ( $year ) : ?><span class="gallery-year"><?php echo esc_html( $year ); ?></span><?php endif; ?>
							<?php if ( $caption ) : ?><p class="gallery-caption"><?php echo esc_html( $caption ); ?></p><?php endif; ?>
							<span class="gallery-zoom" aria-hidden="true">⊕</span>
						</figcaption>
					</figure>
				<?php endforeach; wp_reset_postdata(); else : ?>
					<div class="gallery-empty">
						<div class="gallery-empty-icon">📷</div>
						<p>No photos found<?php echo $gallery_filter ? ' in this category' : '' ?>. Check back soon!</p>
					</div>
				<?php endif; ?>
			</div>
		</section>

		<!-- Video Gallery -->
		<section class="video-gallery">
			<h2 class="section-h2">Video Highlights</h2>
			<p class="section-sub">Subscribe to our YouTube channel for the latest community videos.</p>

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
								<svg viewBox="0 0 60 60" width="60" height="60" aria-hidden="true">
									<circle cx="30" cy="30" r="30" fill="#ff9933"/>
									<polygon points="24,18 24,42 44,30" fill="#fff"/>
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
			<p class="video-cta"><a href="#" target="_blank" rel="noopener">▶ Visit our YouTube channel</a></p>
		</section>

		<!-- Press Coverage -->
		<section class="press-coverage">
			<h2 class="section-h2">Press Coverage & Media</h2>
			<p class="section-sub">Our community in the news.</p>

			<div class="press-items">
				<article class="press-item">
					<span class="press-badge">📰 Article</span>
					<h3>Featured in Regional News</h3>
					<p>Our community initiative was highlighted by major regional media outlets for its youth engagement programs.</p>
					<a href="#" class="read-more">Read Article →</a>
				</article>
				<article class="press-item">
					<span class="press-badge">🎙 Interview</span>
					<h3>Interview with Community Leaders</h3>
					<p>Leaders discuss the vision and mission of Yuvakushwahasamaj in national broadcast.</p>
					<a href="#" class="read-more">Watch Interview →</a>
				</article>
				<article class="press-item">
					<span class="press-badge">🏆 Awards</span>
					<h3>Awards & Recognition</h3>
					<p>Recognition from government and civil society for outstanding contributions to youth development.</p>
					<a href="#" class="read-more">Learn More →</a>
				</article>
			</div>
		</section>

	</div>

	<!-- Lightbox -->
	<div class="gallery-lightbox" id="gallery-lightbox" aria-hidden="true" role="dialog" aria-label="Image viewer">
		<button class="lb-close" aria-label="Close">✕</button>
		<button class="lb-prev" aria-label="Previous">‹</button>
		<button class="lb-next" aria-label="Next">›</button>
		<figure class="lb-content">
			<img class="lb-image" src="" alt="">
			<figcaption class="lb-caption"></figcaption>
		</figure>
	</div>

</main>

<style>
.gallery-page{background:#fafafa}
.container{max-width:1200px;margin:0 auto;padding:0 20px}

/* Hero */
.gal-hero{background:linear-gradient(135deg,#ff9933 0%,#138808 100%);color:#fff;padding:80px 20px;text-align:center;position:relative;overflow:hidden}
.gal-hero::before{content:"";position:absolute;inset:0;background-image:radial-gradient(circle at 20% 20%,rgba(255,255,255,.15) 0,transparent 40%),radial-gradient(circle at 80% 80%,rgba(255,255,255,.1) 0,transparent 40%);pointer-events:none}
.gal-hero-inner{position:relative;max-width:760px;margin:0 auto}
.gal-hero-eyebrow{margin:0 0 10px;text-transform:uppercase;letter-spacing:3px;font-size:.82rem;opacity:.9;font-weight:600}
.gal-hero h1{font-size:3.2rem;margin:0 0 16px;font-weight:800;text-shadow:0 2px 12px rgba(0,0,0,.2);line-height:1.1}
.gal-hero-desc{font-size:1.15rem;line-height:1.7;margin:0 0 26px;opacity:.95;font-weight:300}
.gal-hero-meta{display:inline-flex;gap:14px;align-items:center;background:rgba(255,255,255,.18);backdrop-filter:blur(6px);padding:10px 24px;border-radius:30px;font-size:.95rem}
.gal-hero-meta strong{font-size:1.15rem;font-weight:700}
.gal-hero-meta .dot{opacity:.6}

/* Section commons */
.gallery-page section{padding:60px 0}
.section-h2{font-size:2rem;text-align:center;margin:0 0 10px;color:#222}
.section-sub{text-align:center;color:#666;margin:0 0 40px;font-size:1.02rem}

/* Filters */
.gallery-filters{display:flex;flex-wrap:wrap;justify-content:center;gap:10px;margin-bottom:36px}
.filter-btn{display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border:2px solid #e5e5e5;background:#fff;border-radius:30px;text-decoration:none;color:#444;font-weight:500;font-size:.92rem;transition:all .25s}
.filter-btn:hover{border-color:#ff9933;color:#ff9933;transform:translateY(-2px)}
.filter-btn.active{background:#ff9933;border-color:#ff9933;color:#fff;box-shadow:0 4px 12px rgba(255,153,51,.35)}
.filter-dot{width:8px;height:8px;border-radius:50%;background:currentColor;opacity:.6}
.filter-count{background:rgba(0,0,0,.08);padding:2px 8px;border-radius:10px;font-size:.78rem;font-weight:600}
.filter-btn.active .filter-count{background:rgba(255,255,255,.25)}

/* Mosaic — masonry-ish via row-span */
.gallery-mosaic{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));grid-auto-rows:200px;gap:14px}
.gallery-item{position:relative;margin:0;overflow:hidden;border-radius:14px;cursor:pointer;background:#eee;box-shadow:0 2px 8px rgba(0,0,0,.06);transition:transform .3s,box-shadow .3s}
.gallery-item:hover{transform:translateY(-4px);box-shadow:0 10px 24px rgba(0,0,0,.15)}
.gallery-item.is-large{grid-column:span 2;grid-row:span 2}
.gallery-item.is-tall{grid-row:span 2}
.gallery-item.is-wide{grid-column:span 2}
.gallery-item img,.gallery-placeholder{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s}
.gallery-item:hover img{transform:scale(1.08)}
.gallery-placeholder{display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#fff5e6,#e8f5e8);font-size:3rem}

.gallery-overlay{position:absolute;inset:0;display:flex;flex-direction:column;justify-content:flex-end;padding:18px;background:linear-gradient(to top,rgba(0,0,0,.85) 0%,rgba(0,0,0,.2) 60%,transparent 100%);color:#fff;opacity:0;transition:opacity .3s}
.gallery-item:hover .gallery-overlay{opacity:1}
.gallery-year{display:inline-block;background:#ff9933;color:#fff;padding:3px 10px;border-radius:12px;font-size:.72rem;font-weight:700;margin-bottom:8px;align-self:flex-start;letter-spacing:.5px}
.gallery-caption{margin:0;font-size:.92rem;line-height:1.4;font-weight:500}
.gallery-zoom{position:absolute;top:14px;right:14px;width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,.25);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#fff}

.gallery-empty{grid-column:1/-1;text-align:center;padding:60px 20px;color:#888}
.gallery-empty-icon{font-size:4rem;margin-bottom:14px}

/* Video gallery */
.video-gallery{background:#fff;border-radius:16px;padding:60px 30px !important;margin:30px 0;box-shadow:0 2px 12px rgba(0,0,0,.05)}
.video-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px;max-width:1100px;margin:0 auto}
.video-item{background:#fafafa;border-radius:12px;overflow:hidden;transition:transform .25s,box-shadow .25s;cursor:pointer}
.video-item:hover{transform:translateY(-5px);box-shadow:0 8px 20px rgba(0,0,0,.1)}
.video-thumb{position:relative;height:180px;background:linear-gradient(135deg,#222 0%,#444 100%);display:flex;align-items:center;justify-content:center}
.video-placeholder{transition:transform .25s}
.video-item:hover .video-placeholder{transform:scale(1.1)}
.video-body{padding:18px 20px}
.video-body h3{margin:0 0 4px;font-size:1.05rem;color:#222}
.video-body p{margin:0;color:#888;font-size:.85rem}
.video-cta{text-align:center;margin:30px 0 0}
.video-cta a{color:#ff9933;font-weight:600;text-decoration:none;font-size:1rem}
.video-cta a:hover{text-decoration:underline}

/* Press */
.press-items{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px;max-width:1100px;margin:0 auto}
.press-item{background:#fff;padding:30px 26px;border-radius:14px;border-top:4px solid #ff9933;transition:transform .25s,box-shadow .25s;box-shadow:0 2px 10px rgba(0,0,0,.05);position:relative}
.press-item:hover{transform:translateY(-6px);box-shadow:0 10px 24px rgba(0,0,0,.12)}
.press-item:nth-child(2){border-top-color:#138808}
.press-item:nth-child(3){border-top-color:#d4af37}
.press-badge{display:inline-block;background:#fff5e6;color:#ff9933;padding:5px 12px;border-radius:14px;font-size:.78rem;font-weight:600;margin-bottom:14px;letter-spacing:.4px}
.press-item:nth-child(2) .press-badge{background:#e8f5e8;color:#138808}
.press-item:nth-child(3) .press-badge{background:#fdf6e3;color:#b8961f}
.press-item h3{font-size:1.15rem;margin:0 0 12px;color:#222}
.press-item p{color:#666;line-height:1.65;margin:0 0 18px;font-size:.95rem}
.read-more{color:#ff9933;font-weight:600;text-decoration:none;transition:gap .2s}
.read-more:hover{color:#e68a2e}

/* Lightbox */
.gallery-lightbox{position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:9999;display:none;align-items:center;justify-content:center;animation:lbFade .2s}
.gallery-lightbox.is-open{display:flex}
@keyframes lbFade{from{opacity:0}to{opacity:1}}
.lb-content{max-width:90vw;max-height:85vh;margin:0;text-align:center}
.lb-image{max-width:90vw;max-height:80vh;border-radius:8px;box-shadow:0 10px 40px rgba(0,0,0,.5)}
.lb-caption{color:#fff;padding:14px 0 0;font-size:1rem}
.lb-close,.lb-prev,.lb-next{position:absolute;background:rgba(255,255,255,.15);color:#fff;border:0;width:50px;height:50px;border-radius:50%;font-size:1.6rem;cursor:pointer;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(8px);transition:background .2s}
.lb-close:hover,.lb-prev:hover,.lb-next:hover{background:#ff9933}
.lb-close{top:24px;right:24px}
.lb-prev{left:24px;top:50%;transform:translateY(-50%)}
.lb-next{right:24px;top:50%;transform:translateY(-50%)}

@media (max-width:768px){
	.gal-hero{padding:60px 20px}
	.gal-hero h1{font-size:2rem}
	.gal-hero-desc{font-size:1rem}
	.gallery-mosaic{grid-template-columns:repeat(2,1fr);grid-auto-rows:160px}
	.gallery-item.is-large,.gallery-item.is-tall,.gallery-item.is-wide{grid-column:span 1;grid-row:span 1}
	.gallery-item.is-large{grid-column:span 2}
	.section-h2{font-size:1.5rem}
	.lb-close,.lb-prev,.lb-next{width:42px;height:42px;font-size:1.3rem}
	.lb-prev{left:8px}.lb-next{right:8px}
}
@media (max-width:480px){
	.gallery-mosaic{grid-template-columns:1fr;grid-auto-rows:240px}
	.gallery-item.is-large{grid-column:span 1}
	.filter-btn{padding:7px 14px;font-size:.85rem}
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
