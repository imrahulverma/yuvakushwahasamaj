<?php
/**
 * Single Post Template
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

	<!-- Hero -->
	<header class="sp-hero">
		<div class="sp-hero-bg" aria-hidden="true">
			<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'full' ); ?>
		</div>
		<div class="sp-hero-inner">
			<nav class="sp-breadcrumbs" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
				<span>›</span>
				<a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">News & Blog</a>
				<?php if ( $primary_cat ) : ?>
					<span>›</span>
					<a href="<?php echo esc_url( add_query_arg( 'cat', $primary_cat->slug, home_url( '/news/' ) ) ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a>
				<?php endif; ?>
			</nav>

			<?php if ( $primary_cat ) : ?>
				<a class="sp-category-badge" href="<?php echo esc_url( add_query_arg( 'cat', $primary_cat->slug, home_url( '/news/' ) ) ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a>
			<?php endif; ?>

			<h1 class="sp-title"><?php the_title(); ?></h1>

			<div class="sp-meta">
				<span class="sp-meta-item">
					<?php echo get_avatar( $author_id, 32, '', '', array( 'class' => 'sp-avatar' ) ); ?>
					<span>By <strong><?php echo esc_html( yks_get_author_byline() ); ?></strong></span>
				</span>
				<span class="sp-meta-sep">·</span>
				<span class="sp-meta-item">📅 <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></span>
				<span class="sp-meta-sep">·</span>
				<span class="sp-meta-item">⏱ <?php echo intval( $reading_time ); ?> min read</span>
			</div>
		</div>
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
				<a class="sp-share-btn fb" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener" aria-label="Share on Facebook">f</a>
				<a class="sp-share-btn tw" href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" rel="noopener" aria-label="Share on Twitter">𝕏</a>
				<a class="sp-share-btn wa" href="https://wa.me/?text=<?php echo $share_title . '%20' . $share_url; ?>" target="_blank" rel="noopener" aria-label="Share on WhatsApp">💬</a>
				<a class="sp-share-btn li" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>" target="_blank" rel="noopener" aria-label="Share on LinkedIn">in</a>
				<button class="sp-share-btn copy" type="button" data-url="<?php echo esc_url( get_permalink() ); ?>" aria-label="Copy link">🔗</button>
			</aside>

			<div class="sp-content">
				<?php the_content(); ?>
			</div>

			<?php if ( has_tag() ) : ?>
				<div class="sp-tags">
					<span class="sp-tags-label">Tagged:</span>
					<?php the_tags( '', ' ', '' ); ?>
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
							<span class="sp-postnav-eyebrow">Previous post</span>
							<span class="sp-postnav-title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
						</span>
					</a>
				<?php else : ?><span></span><?php endif; ?>

				<?php if ( $next ) : ?>
					<a class="sp-postnav-link sp-next" href="<?php echo esc_url( get_permalink( $next ) ); ?>">
						<span class="sp-postnav-body">
							<span class="sp-postnav-eyebrow">Next post</span>
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
				<h2 class="sp-related-title">Related Articles</h2>
				<p class="sp-related-sub">More stories you might enjoy</p>
				<div class="sp-related-grid">
					<?php foreach ( $related as $rp ) :
						$rp_cats = get_the_category( $rp->ID );
						$rp_cat  = $rp_cats ? $rp_cats[0] : null;
						?>
						<article class="sp-rel-card">
							<a class="sp-rel-image" href="<?php echo esc_url( get_permalink( $rp ) ); ?>">
								<?php if ( has_post_thumbnail( $rp ) ) {
									echo get_the_post_thumbnail( $rp, 'medium' );
								} else { ?>
									<div class="sp-rel-placeholder">📰</div>
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
					<a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" class="sp-related-btn">View All Posts →</a>
				</div>
			</div>
		</section>
	<?php endif; ?>

</main>

<?php endwhile; ?>

<style>
.single-post-page{background:#fafafa}

/* Hero */
.sp-hero{position:relative;min-height:420px;display:flex;align-items:flex-end;color:#fff;overflow:hidden;background:linear-gradient(135deg,#1a1a1a 0%,#333 100%)}
.sp-hero-bg{position:absolute;inset:0;z-index:0}
.sp-hero-bg img{width:100%;height:100%;object-fit:cover;opacity:.5}
.sp-hero::after{content:"";position:absolute;inset:0;background:linear-gradient(to bottom,rgba(0,0,0,.2) 0%,rgba(0,0,0,.85) 100%);z-index:1}
.sp-hero-inner{position:relative;z-index:2;max-width:900px;margin:0 auto;padding:60px 24px 48px;width:100%}

.sp-breadcrumbs{margin:0 0 20px;font-size:.85rem;color:rgba(255,255,255,.85)}
.sp-breadcrumbs a{color:rgba(255,255,255,.85);text-decoration:none}
.sp-breadcrumbs a:hover{color:#ff9933}
.sp-breadcrumbs span{margin:0 8px;opacity:.5}

.sp-category-badge{display:inline-block;background:#ff9933;color:#fff;padding:6px 16px;border-radius:20px;font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;text-decoration:none;margin-bottom:18px;transition:background .2s}
.sp-category-badge:hover{background:#e68a2e;color:#fff}

.sp-title{font-size:2.8rem;margin:0 0 24px;line-height:1.2;font-weight:800;text-shadow:0 2px 14px rgba(0,0,0,.5);max-width:850px}

.sp-meta{display:flex;flex-wrap:wrap;align-items:center;gap:10px;font-size:.95rem;color:rgba(255,255,255,.95)}
.sp-meta-item{display:inline-flex;align-items:center;gap:8px}
.sp-meta-sep{opacity:.5}
.sp-avatar{border-radius:50%;width:32px;height:32px}

/* Body wrapper */
.sp-wrap{max-width:780px;margin:0 auto;padding:50px 24px 40px;position:relative}
.sp-article{background:#fff;border-radius:14px;padding:50px 50px 40px;box-shadow:0 2px 16px rgba(0,0,0,.06);position:relative}

/* Share floating column */
.sp-share{position:absolute;left:-80px;top:50px;display:flex;flex-direction:column;align-items:center;gap:10px}
.sp-share-label{margin:0 0 6px;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#888;writing-mode:vertical-rl;transform:rotate(180deg)}
.sp-share-btn{width:42px;height:42px;border-radius:50%;background:#fff;color:#444;border:2px solid #eee;display:flex;align-items:center;justify-content:center;text-decoration:none;font-weight:700;font-size:1rem;cursor:pointer;transition:all .2s;font-family:inherit}
.sp-share-btn:hover{transform:translateY(-3px);box-shadow:0 6px 14px rgba(0,0,0,.12)}
.sp-share-btn.fb:hover{background:#1877f2;color:#fff;border-color:#1877f2}
.sp-share-btn.tw:hover{background:#000;color:#fff;border-color:#000}
.sp-share-btn.wa:hover{background:#25d366;color:#fff;border-color:#25d366}
.sp-share-btn.li:hover{background:#0a66c2;color:#fff;border-color:#0a66c2}
.sp-share-btn.copy:hover{background:#ff9933;color:#fff;border-color:#ff9933}

/* Content typography */
.sp-content{font-size:1.08rem;line-height:1.8;color:#333}
.sp-content > *:first-child{margin-top:0}
.sp-content p{margin:0 0 1.5em}
.sp-content p:first-of-type::first-letter{font-size:3.5em;font-weight:800;float:left;line-height:.95;padding:6px 12px 0 0;color:#ff9933;font-family:Georgia,serif}
.sp-content h2{font-size:1.85rem;margin:2em 0 .8em;color:#222;font-weight:700;line-height:1.3;position:relative;padding-left:18px}
.sp-content h2::before{content:"";position:absolute;left:0;top:8px;bottom:8px;width:5px;background:linear-gradient(180deg,#ff9933,#138808);border-radius:3px}
.sp-content h3{font-size:1.45rem;margin:1.8em 0 .6em;color:#222;font-weight:700}
.sp-content a{color:#ff9933;text-decoration:underline;text-decoration-thickness:1px;text-underline-offset:3px}
.sp-content a:hover{color:#e68a2e}
.sp-content ul,.sp-content ol{padding-left:28px;margin:0 0 1.5em}
.sp-content li{margin:0 0 8px}
.sp-content blockquote{margin:2em 0;padding:24px 30px;background:#fff8ed;border-left:5px solid #ff9933;border-radius:6px;font-style:italic;font-size:1.1rem;color:#444;position:relative}
.sp-content blockquote::before{content:"\201C";position:absolute;top:-10px;left:14px;font-size:4rem;color:#ff9933;opacity:.25;line-height:1;font-family:Georgia,serif}
.sp-content blockquote cite{display:block;margin-top:14px;font-style:normal;font-size:.92rem;color:#888;font-weight:600}
.sp-content img{border-radius:10px;margin:1.5em 0;box-shadow:0 4px 14px rgba(0,0,0,.08)}
.sp-content figure{margin:1.5em 0}
.sp-content code{background:#f5f5f5;padding:2px 8px;border-radius:4px;font-size:.92em;color:#d63384}
.sp-content pre{background:#1e1e1e;color:#e0e0e0;padding:18px 22px;border-radius:8px;overflow-x:auto;margin:1.5em 0}
.sp-content hr{border:0;height:1px;background:linear-gradient(90deg,transparent,#ddd,transparent);margin:2.5em 0}

/* Tags */
.sp-tags{margin:36px 0 0;padding:20px 0 0;border-top:1px solid #eee;font-size:.92rem;color:#666}
.sp-tags-label{font-weight:700;margin-right:8px;color:#222}
.sp-tags a{display:inline-block;background:#f5f5f5;color:#555;padding:4px 12px;border-radius:14px;text-decoration:none;font-size:.85rem;margin:0 4px 4px 0;transition:all .2s}
.sp-tags a:hover{background:#ff9933;color:#fff}

/* Post nav */
.sp-postnav{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin:40px 0 0}
.sp-postnav-link{display:flex;align-items:center;gap:14px;padding:20px 24px;background:#fff;border-radius:12px;text-decoration:none;color:#333;box-shadow:0 2px 10px rgba(0,0,0,.05);transition:all .25s;border:2px solid transparent}
.sp-postnav-link:hover{transform:translateY(-3px);box-shadow:0 8px 20px rgba(0,0,0,.1);border-color:#ff9933}
.sp-postnav-arrow{font-size:1.5rem;color:#ff9933;font-weight:700}
.sp-postnav-body{display:flex;flex-direction:column;flex:1}
.sp-postnav-eyebrow{font-size:.72rem;text-transform:uppercase;letter-spacing:1.5px;color:#888;font-weight:700;margin-bottom:4px}
.sp-postnav-title{font-size:.95rem;font-weight:600;color:#222;line-height:1.4}
.sp-next{flex-direction:row;text-align:right}
.sp-next .sp-postnav-body{align-items:flex-end}

/* Related */
.sp-related{background:#fff;padding:60px 24px;margin-top:40px;border-top:1px solid #eee}
.sp-related-inner{max-width:1100px;margin:0 auto}
.sp-related-title{font-size:2rem;text-align:center;margin:0 0 8px;color:#222;font-weight:700}
.sp-related-sub{text-align:center;color:#666;margin:0 0 40px}
.sp-related-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px}
.sp-rel-card{background:#fafafa;border-radius:12px;overflow:hidden;transition:transform .25s,box-shadow .25s}
.sp-rel-card:hover{transform:translateY(-5px);box-shadow:0 10px 24px rgba(0,0,0,.1)}
.sp-rel-image{position:relative;display:block;height:180px;overflow:hidden;background:#eee}
.sp-rel-image img{width:100%;height:100%;object-fit:cover;transition:transform .4s}
.sp-rel-card:hover .sp-rel-image img{transform:scale(1.08)}
.sp-rel-placeholder{height:100%;display:flex;align-items:center;justify-content:center;font-size:3rem;background:linear-gradient(135deg,#fff5e6,#e8f5e8)}
.sp-rel-cat{position:absolute;top:12px;left:12px;background:#ff9933;color:#fff;padding:4px 12px;border-radius:14px;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px}
.sp-rel-body{padding:18px 20px}
.sp-rel-date{font-size:.8rem;color:#888;margin:0 0 8px}
.sp-rel-h3{font-size:1.05rem;line-height:1.4;margin:0}
.sp-rel-h3 a{color:#222;text-decoration:none}
.sp-rel-h3 a:hover{color:#ff9933}

.sp-related-cta{text-align:center;margin-top:40px}
.sp-related-btn{display:inline-block;background:#ff9933;color:#fff;padding:12px 32px;border-radius:30px;text-decoration:none;font-weight:600;transition:all .2s}
.sp-related-btn:hover{background:#e68a2e;transform:translateY(-2px);box-shadow:0 6px 14px rgba(255,153,51,.4)}

@media (max-width:900px){
	.sp-share{position:static;flex-direction:row;justify-content:center;margin-bottom:24px}
	.sp-share-label{writing-mode:horizontal-tb;transform:none;margin:0 6px 0 0}
}
@media (max-width:768px){
	.sp-hero{min-height:320px}
	.sp-hero-inner{padding:40px 20px 30px}
	.sp-title{font-size:1.85rem}
	.sp-meta{font-size:.85rem;gap:6px}
	.sp-meta-sep{display:none}
	.sp-wrap{padding:24px 16px}
	.sp-article{padding:30px 24px 24px}
	.sp-content{font-size:1rem}
	.sp-content h2{font-size:1.4rem}
	.sp-content p:first-of-type::first-letter{font-size:2.8em}
	.sp-postnav{grid-template-columns:1fr}
	.sp-next{flex-direction:row-reverse;text-align:left}
	.sp-next .sp-postnav-body{align-items:flex-start}
}
</style>

<script>
(function(){
	var copyBtn = document.querySelector('.sp-share-btn.copy');
	if (!copyBtn) return;
	copyBtn.addEventListener('click', function(){
		var url = this.getAttribute('data-url');
		if (!navigator.clipboard) return;
		navigator.clipboard.writeText(url).then(function(){
			var original = copyBtn.textContent;
			copyBtn.textContent = '✓';
			copyBtn.style.background = '#138808';
			copyBtn.style.color = '#fff';
			copyBtn.style.borderColor = '#138808';
			setTimeout(function(){
				copyBtn.textContent = original;
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
