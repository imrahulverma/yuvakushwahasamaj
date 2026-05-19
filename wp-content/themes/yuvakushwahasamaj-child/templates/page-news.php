<?php
/**
 * Template Name: News & Blog
 * Description: News and blog listing page template — warm editorial style
 */

get_header();

$paged    = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
$per_page = 6;

$cat_slug = isset( $_GET['cat'] ) ? sanitize_key( $_GET['cat'] ) : '';

$args = array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => $per_page,
	'paged'          => $paged,
);
if ( $cat_slug ) {
	$args['category_name'] = $cat_slug;
}

$news_query = new WP_Query( $args );
$categories = get_categories( array( 'hide_empty' => true ) );
?>

<main id="main" class="site-main news-page">

	<!-- Editorial page hero -->
	<section class="page-hero">
		<div class="page-hero-inner">
			<span class="eyebrow">The Community Journal</span>
			<h1><?php the_title(); ?></h1>
			<?php echo yks_ornament(); ?>
			<p class="page-hero-lede">Stories, announcements, and reflections from the community — written by our members for our members.</p>
		</div>
	</section>

	<div class="container">

		<?php if ( $categories ) : ?>
			<nav class="news-filters" aria-label="Filter by category">
				<a class="news-filter<?php echo ! $cat_slug ? ' is-active' : ''; ?>" href="<?php the_permalink(); ?>">All</a>
				<?php foreach ( $categories as $cat ) : ?>
					<a class="news-filter<?php echo $cat_slug === $cat->slug ? ' is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'cat', $cat->slug, get_permalink() ) ); ?>">
						<?php echo esc_html( $cat->name ); ?>
						<span class="news-filter-count"><?php echo intval( $cat->count ); ?></span>
					</a>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>

		<section class="news-grid-wrap">
			<?php if ( $news_query->have_posts() ) : ?>
				<div class="news-grid">
					<?php while ( $news_query->have_posts() ) : $news_query->the_post();
						$post_cats = get_the_category();
						$first_cat = $post_cats ? $post_cats[0] : null;
						?>
						<article class="news-card">
							<a class="news-card-image" href="<?php the_permalink(); ?>">
								<?php if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'medium_large' );
								} else { ?>
									<div class="news-card-placeholder"><span>YK</span></div>
								<?php } ?>
								<?php if ( $first_cat ) : ?>
									<span class="news-card-cat"><?php echo esc_html( $first_cat->name ); ?></span>
								<?php endif; ?>
							</a>
							<div class="news-card-body">
								<p class="news-card-date">
									<?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
									<span class="news-card-author">· by <?php echo esc_html( yks_get_author_byline() ); ?></span>
								</p>
								<h2 class="news-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p class="news-card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
								<a class="news-card-more" href="<?php the_permalink(); ?>">Continue reading &nbsp;→</a>
							</div>
						</article>
					<?php endwhile; ?>
				</div>

				<?php
				$big = 999999999;
				$pagination = paginate_links( array(
					'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => '?paged=%#%',
					'current'   => $paged,
					'total'     => $news_query->max_num_pages,
					'prev_text' => '← Previous',
					'next_text' => 'Next →',
					'type'      => 'array',
				) );
				if ( $pagination ) : ?>
					<nav class="news-pagination" aria-label="Pagination">
						<?php foreach ( $pagination as $link ) echo '<span>' . $link . '</span>'; ?>
					</nav>
				<?php endif; ?>

			<?php else : ?>
				<div class="news-empty">
					<p>No journal entries found<?php echo $cat_slug ? ' in this category' : ''; ?>. Check back soon.</p>
					<?php if ( $cat_slug ) : ?>
						<a class="news-empty-btn" href="<?php the_permalink(); ?>">View all posts</a>
					<?php endif; ?>
				</div>
			<?php endif;
			wp_reset_postdata(); ?>
		</section>

	</div>
</main>

<style>
.news-page{background:var(--paper);font-family:var(--font-body);color:var(--ink-soft)}
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
.page-hero-lede{font-family:var(--font-display);font-style:italic;font-size:1.25rem;line-height:1.55;color:var(--ink);margin:0;max-width:680px}

/* ---------- Filters ---------- */
.news-filters{display:flex;flex-wrap:wrap;justify-content:center;gap:6px;margin:50px 0 50px;padding:14px 18px;border-top:1px solid var(--rule);border-bottom:1px solid var(--rule)}
.news-filter{display:inline-flex;align-items:center;gap:8px;padding:8px 18px;text-decoration:none;color:var(--ink-soft);font-size:.88rem;font-weight:500;letter-spacing:.02em;border-radius:0;transition:color .2s,background .2s;position:relative}
.news-filter:hover{color:var(--saffron)}
.news-filter.is-active{color:var(--saffron)}
.news-filter.is-active::after{content:"";position:absolute;left:18px;right:18px;bottom:2px;height:1px;background:var(--saffron)}
.news-filter-count{background:var(--paper-deep);padding:2px 8px;font-size:.72rem;font-weight:600;color:var(--ink-mute);border-radius:0}
.news-filter.is-active .news-filter-count{background:var(--saffron);color:#fff}

/* ---------- Grid + cards ---------- */
.news-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(330px,1fr));gap:36px;margin-bottom:60px}
.news-card{background:var(--card);border:1px solid var(--rule);overflow:hidden;transition:transform .3s,box-shadow .3s,border-color .3s;display:flex;flex-direction:column}
.news-card:hover{transform:translateY(-5px);box-shadow:0 20px 40px -20px rgba(31,22,18,.18);border-color:var(--saffron)}
.news-card-image{position:relative;display:block;height:220px;overflow:hidden;background:var(--paper-deep);text-decoration:none}
.news-card-image img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.news-card:hover .news-card-image img{transform:scale(1.05)}
.news-card-placeholder{height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#f3ead9,#e6dccb)}
.news-card-placeholder span{font-family:var(--font-display);font-size:3rem;color:var(--saffron);opacity:.4;font-weight:600;letter-spacing:.05em}
.news-card-cat{position:absolute;top:16px;left:16px;background:var(--ink);color:var(--paper);padding:5px 12px;font-size:.68rem;font-weight:600;text-transform:uppercase;letter-spacing:.14em}

.news-card-body{padding:26px 26px 28px;display:flex;flex-direction:column;flex:1}
.news-card-date{color:var(--ink-mute);font-size:.75rem;margin:0 0 12px;font-weight:600;letter-spacing:.1em;text-transform:uppercase}
.news-card-author{color:var(--ink-mute);font-weight:500;text-transform:none;letter-spacing:0}
.news-card-title{font-family:var(--font-display);font-size:1.3rem;line-height:1.32;margin:0 0 14px;font-weight:600;letter-spacing:-.01em}
.news-card-title a{color:var(--ink);text-decoration:none;transition:color .2s}
.news-card-title a:hover{color:var(--saffron)}
.news-card-excerpt{color:var(--ink-soft);font-size:.95rem;line-height:1.7;margin:0 0 20px;flex:1}
.news-card-more{color:var(--ink);text-decoration:none;font-weight:600;font-size:.88rem;align-self:flex-start;border-bottom:1px solid var(--saffron);padding-bottom:2px;transition:color .2s}
.news-card-more:hover{color:var(--saffron)}

/* ---------- Pagination ---------- */
.news-pagination{display:flex;justify-content:center;gap:4px;margin:40px 0 70px;flex-wrap:wrap}
.news-pagination .page-numbers{display:inline-flex;align-items:center;justify-content:center;min-width:42px;height:42px;padding:0 14px;border:1px solid var(--rule);background:var(--card);text-decoration:none;color:var(--ink-soft);font-weight:500;font-size:.92rem;transition:all .2s}
.news-pagination .page-numbers:hover{border-color:var(--saffron);color:var(--saffron)}
.news-pagination .page-numbers.current{background:var(--ink);border-color:var(--ink);color:var(--paper)}
.news-pagination .dots{border:0;background:none}

.news-empty{text-align:center;padding:70px 20px;color:var(--ink-mute)}
.news-empty p{font-size:1.1rem;margin:0 0 24px;font-style:italic;font-family:var(--font-display)}
.news-empty-btn{display:inline-flex;align-items:center;gap:8px;background:var(--ink);color:var(--paper);padding:11px 24px;text-decoration:none;font-weight:600;font-size:.9rem;letter-spacing:.04em;transition:background .25s}
.news-empty-btn:hover{background:var(--saffron);color:#fff}

@media (max-width:768px){
	.page-hero{padding:60px 24px 60px}
	.news-grid{grid-template-columns:1fr;gap:24px}
	.news-filters{padding:10px 12px;gap:2px}
}
</style>

<?php
get_footer();
