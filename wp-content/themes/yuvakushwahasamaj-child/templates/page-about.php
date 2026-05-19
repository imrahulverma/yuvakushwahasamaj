<?php
/**
 * Template Name: About Us
 * Description: About Us page template
 */

get_header();

$post_id = get_the_ID();

$hero_image_id   = get_scf_field( 'about_hero_image', $post_id );
$intro           = get_scf_field( 'about_intro', $post_id );

$mission_title   = get_scf_field( 'about_mission_title', $post_id ) ?: 'Our Mission';
$mission_text    = get_scf_field( 'about_mission_text', $post_id );
$mission_icon_id = get_scf_field( 'about_mission_icon', $post_id );

$vision_title    = get_scf_field( 'about_vision_title', $post_id ) ?: 'Our Vision';
$vision_text     = get_scf_field( 'about_vision_text', $post_id );
$vision_icon_id  = get_scf_field( 'about_vision_icon', $post_id );

$values_title    = get_scf_field( 'about_values_title', $post_id ) ?: 'Our Values';
$values_text     = get_scf_field( 'about_values_text', $post_id );
$values_icon_id  = get_scf_field( 'about_values_icon', $post_id );

$reach_raw       = get_scf_field( 'about_reach_stats', $post_id );
$reach_lines     = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $reach_raw ) ) );

$aff_raw         = get_scf_field( 'about_affiliations', $post_id );
$aff_lines       = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $aff_raw ) ) );
?>

<main id="main" class="site-main about-page">

	<!-- Hero / Story -->
	<section class="about-hero">
		<?php if ( $hero_image_id ) : ?>
			<div class="about-hero-bg" aria-hidden="true"><?php echo wp_get_attachment_image( $hero_image_id, 'full' ); ?></div>
		<?php endif; ?>
		<div class="about-hero-inner">
			<?php if ( $intro ) : ?><p class="about-eyebrow"><?php echo esc_html( $intro ); ?></p><?php endif; ?>
			<h1><?php the_title(); ?></h1>
			<?php
			while ( have_posts() ) :
				the_post();
				if ( get_the_content() ) : ?>
					<div class="about-content"><?php the_content(); ?></div>
				<?php endif;
			endwhile;
			rewind_posts();
			?>
		</div>
	</section>

	<!-- Mission / Vision / Values -->
	<?php if ( $mission_text || $vision_text || $values_text ) : ?>
		<section class="mvv">
			<div class="container">
				<h2 class="section-h2">Our Mission, Vision &amp; Core Values</h2>
				<div class="mvv-grid">
					<?php
					$mvv = array(
						array( 'title' => $mission_title, 'text' => $mission_text, 'icon' => $mission_icon_id, 'emoji' => '🎯', 'class' => 'mvv-mission' ),
						array( 'title' => $vision_title,  'text' => $vision_text,  'icon' => $vision_icon_id,  'emoji' => '👁',  'class' => 'mvv-vision' ),
						array( 'title' => $values_title,  'text' => $values_text,  'icon' => $values_icon_id,  'emoji' => '💎', 'class' => 'mvv-values' ),
					);
					foreach ( $mvv as $item ) :
						if ( ! $item['text'] ) continue; ?>
						<article class="mvv-item <?php echo esc_attr( $item['class'] ); ?>">
							<div class="mvv-icon">
								<?php if ( $item['icon'] ) {
									echo wp_get_attachment_image( $item['icon'], 'thumbnail' );
								} else {
									echo '<span class="mvv-emoji">' . esc_html( $item['emoji'] ) . '</span>';
								} ?>
							</div>
							<h3><?php echo esc_html( $item['title'] ); ?></h3>
							<p><?php echo esc_html( $item['text'] ); ?></p>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- Leadership Team -->
	<section class="leadership-team">
		<div class="container">
			<h2 class="section-h2">Our Leadership Team</h2>
			<p class="section-sub">The people behind our community's growth</p>
			<div class="team-grid">
				<?php
				$team_members = get_posts( array(
					'post_type'      => 'team_member',
					'posts_per_page' => -1,
				) );

				if ( $team_members ) {
					foreach ( $team_members as $member ) {
						$designation = get_scf_field( 'designation', $member->ID );
						$photo_id    = get_scf_field( 'photo', $member->ID );
						$bio         = get_scf_field( 'bio', $member->ID );
						?>
						<article class="team-card">
							<div class="team-photo">
								<?php if ( $photo_id ) {
									echo wp_get_attachment_image( $photo_id, 'medium', false, array( 'loading' => 'lazy' ) );
								} else { ?>
									<div class="team-photo-placeholder">👤</div>
								<?php } ?>
							</div>
							<div class="team-body">
								<h3><?php echo esc_html( get_the_title( $member ) ); ?></h3>
								<?php if ( $designation ) : ?>
									<p class="designation"><?php echo esc_html( $designation ); ?></p>
								<?php endif; ?>
								<?php if ( $bio ) : ?>
									<p class="bio"><?php echo esc_html( $bio ); ?></p>
								<?php endif; ?>
							</div>
						</article>
						<?php
					}
				} else {
					echo '<p>Leadership team members coming soon.</p>';
				}
				?>
			</div>
		</div>
	</section>

	<!-- Our Reach -->
	<?php if ( $reach_lines ) : ?>
		<section class="our-reach">
			<div class="container">
				<h2 class="section-h2 section-h2-light">Our Reach</h2>
				<p class="section-sub section-sub-light">Operating across multiple states and districts.</p>
				<div class="reach-stats">
					<?php foreach ( $reach_lines as $line ) :
						$parts = array_map( 'trim', explode( '|', $line, 2 ) );
						$num   = $parts[0] ?? '';
						$lbl   = $parts[1] ?? '';
						?>
						<div class="reach-item">
							<p class="reach-number"><?php echo esc_html( $num ); ?></p>
							<h3><?php echo esc_html( $lbl ); ?></h3>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- Affiliations -->
	<?php if ( $aff_lines ) : ?>
		<section class="affiliations">
			<div class="container">
				<h2 class="section-h2">Affiliations &amp; Recognition</h2>
				<ul class="affiliations-list">
					<?php foreach ( $aff_lines as $aff ) : ?>
						<li><?php echo esc_html( $aff ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

</main>

<style>
.about-page{background:#fafafa}
.container{max-width:1200px;margin:0 auto;padding:0 20px}

/* Hero */
.about-hero{position:relative;color:#fff;text-align:center;padding:90px 24px;background:linear-gradient(135deg,#ff9933 0%,#138808 100%);overflow:hidden}
.about-hero-bg{position:absolute;inset:0;z-index:0}
.about-hero-bg img{width:100%;height:100%;object-fit:cover;opacity:.35}
.about-hero::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(0,0,0,.1),rgba(0,0,0,.45));z-index:1}
.about-hero-inner{position:relative;z-index:2;max-width:820px;margin:0 auto}
.about-eyebrow{margin:0 0 10px;text-transform:uppercase;letter-spacing:3px;font-size:.82rem;font-weight:600;opacity:.95}
.about-hero h1{font-size:3rem;font-weight:800;margin:0 0 20px;line-height:1.15;text-shadow:0 2px 12px rgba(0,0,0,.3)}
.about-content{font-size:1.1rem;line-height:1.8;opacity:.95;max-width:720px;margin:0 auto}
.about-content p{margin:0 0 1em}

/* Section commons */
.section-h2{font-size:2.2rem;text-align:center;margin:0 0 10px;color:#222;font-weight:700;position:relative;padding-bottom:14px}
.section-h2::after{content:"";display:block;width:60px;height:4px;background:linear-gradient(90deg,#ff9933,#138808);margin:14px auto 0;border-radius:2px}
.section-sub{text-align:center;color:#666;margin:0 0 50px;font-size:1.05rem}
.section-h2-light{color:#fff}
.section-h2-light::after{background:#fff}
.section-sub-light{color:rgba(255,255,255,.95)}

/* MVV */
.mvv{padding:80px 0;background:#fff}
.mvv-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:30px;margin-top:50px}
.mvv-item{background:#fafafa;padding:40px 30px;border-radius:14px;text-align:center;transition:transform .25s,box-shadow .25s;border-top:4px solid #ff9933}
.mvv-item:hover{transform:translateY(-6px);box-shadow:0 12px 28px rgba(0,0,0,.08)}
.mvv-item.mvv-vision{border-top-color:#138808}
.mvv-item.mvv-values{border-top-color:#d4af37}
.mvv-icon{width:90px;height:90px;margin:0 auto 22px;border-radius:50%;background:linear-gradient(135deg,#fff5e6,#e8f5e8);display:flex;align-items:center;justify-content:center;overflow:hidden}
.mvv-icon img{width:100%;height:100%;object-fit:cover;border-radius:50%}
.mvv-emoji{font-size:2.5rem}
.mvv-item h3{font-size:1.4rem;margin:0 0 14px;color:#222;font-weight:700}
.mvv-item p{color:#555;line-height:1.7;margin:0;font-size:.98rem}

/* Leadership */
.leadership-team{padding:80px 0;background:#fafafa}
.team-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:28px}
.team-card{background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.05);transition:transform .25s,box-shadow .25s;text-align:center}
.team-card:hover{transform:translateY(-6px);box-shadow:0 14px 30px rgba(0,0,0,.1)}
.team-photo{width:100%;height:280px;overflow:hidden;background:#eee}
.team-photo img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s}
.team-card:hover .team-photo img{transform:scale(1.05)}
.team-photo-placeholder{height:100%;display:flex;align-items:center;justify-content:center;font-size:4rem;background:linear-gradient(135deg,#fff5e6,#e8f5e8);color:rgba(255,153,51,.55)}
.team-body{padding:22px 22px 26px}
.team-card h3{font-size:1.22rem;margin:0 0 4px;color:#222}
.team-card .designation{color:#ff9933;font-weight:700;font-size:.88rem;text-transform:uppercase;letter-spacing:.8px;margin:0 0 12px}
.team-card .bio{color:#666;font-size:.92rem;line-height:1.6;margin:0}

/* Reach */
.our-reach{padding:80px 0;background:linear-gradient(135deg,#ff9933 0%,#e68a2e 50%,#138808 100%);color:#fff}
.reach-stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:24px;margin-top:50px}
.reach-item{background:rgba(255,255,255,.14);backdrop-filter:blur(6px);padding:36px 24px;border-radius:14px;text-align:center;transition:transform .25s}
.reach-item:hover{transform:translateY(-5px)}
.reach-number{font-size:3.2rem;font-weight:800;margin:0 0 10px;line-height:1;text-shadow:0 2px 8px rgba(0,0,0,.15)}
.reach-item h3{margin:0;font-size:1rem;font-weight:500;opacity:.95;letter-spacing:.5px}

/* Affiliations */
.affiliations{padding:80px 0;background:#fff}
.affiliations-list{list-style:none;padding:0;max-width:720px;margin:50px auto 0;display:grid;grid-template-columns:1fr;gap:0}
.affiliations-list li{padding:18px 24px 18px 56px;border-bottom:1px solid #eee;font-size:1.02rem;color:#333;position:relative;transition:background .2s,padding-left .2s}
.affiliations-list li:hover{background:#fff8ed;padding-left:62px}
.affiliations-list li::before{content:"✓";position:absolute;left:18px;top:50%;transform:translateY(-50%);background:#138808;color:#fff;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.92rem}
.affiliations-list li:last-child{border-bottom:0}

@media (max-width:768px){
	.about-hero{padding:60px 20px}
	.about-hero h1{font-size:2rem}
	.about-content{font-size:1rem}
	.section-h2{font-size:1.6rem}
	.mvv,.leadership-team,.our-reach,.affiliations{padding:50px 0}
	.team-photo{height:240px}
	.reach-number{font-size:2.4rem}
}
</style>

<?php
get_footer();
