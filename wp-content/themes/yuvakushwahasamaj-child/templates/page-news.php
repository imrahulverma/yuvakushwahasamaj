<?php
/**
 * Template Name: News & Blog
 * Description: News and blog listing page template
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

<main id="main" class="site-main">
	<div class="container">

		<header class="news-header">
			<h1><?php the_title(); ?></h1>
			<p class="news-intro">Stay updated with the latest happenings, achievements, and announcements from our community.</p>
		</header>

		<?php if ( $categories ) : ?>
			<nav class="news-filters" aria-label="Filter by category">
				<a class="news-filter<?php echo ! $cat_slug ? ' is-active' : ''; ?>" href="<?php the_permalink(); ?>">All</a>
				<?php foreach ( $categories as $cat ) : ?>
					<a class="news-filter<?php echo $cat_slug === $cat->slug ? ' is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'cat', $cat->slug, get_permalink() ) ); ?>">
						<?php echo esc_html( $cat->name ); ?>
						<span class="news-filter-count">(<?php echo intval( $cat->count ); ?>)</span>
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
									<div class="news-card-placeholder">📰</div>
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
								<a class="news-card-more" href="<?php the_permalink(); ?>">Read More →</a>
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
					<p>No posts found<?php echo $cat_slug ? ' in this category' : ''; ?>. Check back soon!</p>
					<?php if ( $cat_slug ) : ?>
						<a class="btn-register" href="<?php the_permalink(); ?>">View all posts</a>
					<?php endif; ?>
				</div>
			<?php endif;
			wp_reset_postdata(); ?>
		</section>

	</div>
</main>

<style>
.container{max-width:1200px;margin:0 auto;padding:0 20px}
.site-main{padding-top:30px}
.news-header{text-align:center;padding:40px 0 20px}
.news-header h1{font-size:2.6rem;margin:0 0 10px;color:#222}
.news-intro{color:#666;font-size:1.05rem;max-width:640px;margin:0 auto}

.news-filters{display:flex;flex-wrap:wrap;justify-content:center;gap:8px;margin:30px 0 40px}
.news-filter{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border:2px solid #eee;border-radius:30px;text-decoration:none;color:#555;font-size:.92rem;font-weight:500;transition:all .2s;background:#fff}
.news-filter:hover{border-color:#ff9933;color:#ff9933}
.news-filter.is-active{background:#ff9933;border-color:#ff9933;color:#fff}
.news-filter-count{font-size:.8rem;opacity:.8}

.news-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:30px;margin-bottom:50px}
.news-card{background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.06);transition:transform .25s,box-shadow .25s;display:flex;flex-direction:column}
.news-card:hover{transform:translateY(-4px);box-shadow:0 8px 20px rgba(0,0,0,.12)}
.news-card-image{position:relative;display:block;height:200px;overflow:hidden;background:#f5f5f5}
.news-card-image img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s}
.news-card:hover .news-card-image img{transform:scale(1.05)}
.news-card-placeholder{height:100%;display:flex;align-items:center;justify-content:center;font-size:3.5rem;background:linear-gradient(135deg,#fff5e6,#e8f5e8)}
.news-card-cat{position:absolute;top:14px;left:14px;background:#ff9933;color:#fff;padding:4px 12px;border-radius:20px;font-size:.78rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px}

.news-card-body{padding:22px;display:flex;flex-direction:column;flex:1}
.news-card-date{color:#888;font-size:.82rem;margin:0 0 10px}
.news-card-author{color:#aaa}
.news-card-title{font-size:1.25rem;line-height:1.35;margin:0 0 12px}
.news-card-title a{color:#222;text-decoration:none;transition:color .2s}
.news-card-title a:hover{color:#ff9933}
.news-card-excerpt{color:#666;font-size:.94rem;line-height:1.6;margin:0 0 18px;flex:1}
.news-card-more{color:#138808;text-decoration:none;font-weight:600;font-size:.92rem;align-self:flex-start;transition:gap .2s}
.news-card-more:hover{color:#0f6606}

.news-pagination{display:flex;justify-content:center;gap:6px;margin:30px 0 60px;flex-wrap:wrap}
.news-pagination .page-numbers{display:inline-flex;align-items:center;justify-content:center;min-width:40px;height:40px;padding:0 12px;border:2px solid #eee;border-radius:6px;text-decoration:none;color:#555;font-weight:500;transition:all .2s}
.news-pagination .page-numbers:hover{border-color:#ff9933;color:#ff9933}
.news-pagination .page-numbers.current{background:#ff9933;border-color:#ff9933;color:#fff}
.news-pagination .dots{border:0;background:none}

.news-empty{text-align:center;padding:60px 20px;color:#666}
.news-empty p{font-size:1.1rem;margin:0 0 20px}
.btn-register{background-color:#ff9933;color:#fff;padding:10px 24px;text-decoration:none;border-radius:5px;display:inline-block;transition:background-color .3s}
.btn-register:hover{background-color:#e68a2e}

@media (max-width:768px){
	.news-header h1{font-size:1.9rem}
	.news-grid{grid-template-columns:1fr;gap:20px}
}
</style>

<?php
get_footer();
