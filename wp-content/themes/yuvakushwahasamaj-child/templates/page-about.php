<?php
/**
 * Template Name: About Us
 * Description: About Us page template — warm editorial style
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

	<!-- Editorial page hero -->
	<section class="page-hero">
		<div class="page-hero-inner">
			<div class="page-hero-text">
				<span class="eyebrow">A Chapter About · Us</span>
				<h1><?php the_title(); ?></h1>
				<?php echo yks_ornament(); ?>
				<?php if ( $intro ) : ?>
					<p class="page-hero-lede"><?php echo esc_html( $intro ); ?></p>
				<?php endif; ?>
				<?php
				while ( have_posts() ) :
					the_post();
					if ( get_the_content() ) : ?>
						<div class="page-hero-body"><?php the_content(); ?></div>
					<?php endif;
				endwhile;
				rewind_posts();
				?>
			</div>
			<?php if ( $hero_image_id ) : ?>
				<div class="page-hero-figure">
					<div class="page-hero-frame">
						<?php echo wp_get_attachment_image( $hero_image_id, 'large' ); ?>
					</div>
					<div class="page-hero-caption">
						<span class="page-hero-caption-rule"></span>
						<span>A glimpse of the community we build</span>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<!-- Mission / Vision / Values -->
	<?php if ( $mission_text || $vision_text || $values_text ) : ?>
		<section class="mvv">
			<div class="container">
				<header class="section-head section-head--left">
					<span class="eyebrow">Chapter 01 · What We Stand For</span>
					<h2>Mission, Vision &amp; Values</h2>
					<?php echo yks_ornament(); ?>
				</header>
				<div class="mvv-grid">
					<?php
					$mvv = array(
						array( 'title' => $mission_title, 'text' => $mission_text, 'icon' => $mission_icon_id, 'num' => '01', 'class' => 'mvv-mission' ),
						array( 'title' => $vision_title,  'text' => $vision_text,  'icon' => $vision_icon_id,  'num' => '02', 'class' => 'mvv-vision' ),
						array( 'title' => $values_title,  'text' => $values_text,  'icon' => $values_icon_id,  'num' => '03', 'class' => 'mvv-values' ),
					);
					foreach ( $mvv as $item ) :
						if ( ! $item['text'] ) continue; ?>
						<article class="mvv-item <?php echo esc_attr( $item['class'] ); ?>">
							<div class="mvv-head">
								<span class="mvv-num"><?php echo esc_html( $item['num'] ); ?></span>
								<?php if ( $item['icon'] ) : ?>
									<div class="mvv-icon"><?php echo wp_get_attachment_image( $item['icon'], 'thumbnail' ); ?></div>
								<?php endif; ?>
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
			<header class="section-head section-head--left">
				<span class="eyebrow">Chapter 02 · The People</span>
				<h2>Our Leadership</h2>
				<?php echo yks_ornament(); ?>
				<p class="section-sub">The hands behind our community's growth.</p>
			</header>
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
									<div class="team-photo-placeholder"><span>YK</span></div>
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
					echo '<p class="section-empty">Leadership team members coming soon.</p>';
				}
				?>
			</div>
		</div>
	</section>

	<!-- Our Reach -->
	<?php if ( $reach_lines ) : ?>
		<section class="our-reach">
			<div class="container">
				<header class="section-head section-head--center section-head--inverse">
					<span class="eyebrow eyebrow--light">Chapter 03 · By the Numbers</span>
					<h2>Our Reach</h2>
					<?php echo yks_ornament( 'light' ); ?>
					<p class="section-sub section-sub--light">Operating across multiple states and districts.</p>
				</header>
				<div class="reach-grid">
					<?php foreach ( $reach_lines as $i => $line ) :
						$parts = array_map( 'trim', explode( '|', $line, 2 ) );
						$num   = $parts[0] ?? '';
						$lbl   = $parts[1] ?? '';
						?>
						<div class="reach-item">
							<span class="reach-tag"><?php echo esc_html( str_pad( $i + 1, 2, '0', STR_PAD_LEFT ) ); ?></span>
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
				<header class="section-head section-head--left">
					<span class="eyebrow">Chapter 04 · Recognition</span>
					<h2>Affiliations &amp; Honours</h2>
					<?php echo yks_ornament(); ?>
				</header>
				<ul class="affiliations-list">
					<?php foreach ( $aff_lines as $i => $aff ) : ?>
						<li>
							<span class="aff-num"><?php echo esc_html( str_pad( $i + 1, 2, '0', STR_PAD_LEFT ) ); ?></span>
							<span class="aff-text"><?php echo esc_html( $aff ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

</main>

<style>
.about-page{background:var(--paper);font-family:var(--font-body);color:var(--ink-soft)}
.container{max-width:1240px;margin:0 auto;padding:0 28px}

/* ---------- Editorial page hero (shared pattern) ---------- */
.page-hero{padding:80px 28px 100px;background:
	radial-gradient(1200px 600px at 80% 10%, rgba(200,84,28,.08), transparent 60%),
	radial-gradient(900px 500px at 0% 90%, rgba(30,90,60,.08), transparent 60%),
	var(--paper)}
.page-hero-inner{max-width:1240px;margin:0 auto;display:grid;grid-template-columns:1.1fr 1fr;gap:80px;align-items:start}
.page-hero-text .eyebrow{padding-left:46px;position:relative}
.page-hero-text .eyebrow::before{content:"";position:absolute;left:0;top:50%;width:34px;height:1px;background:var(--saffron)}
.page-hero-text h1{font-family:var(--font-display);font-weight:600;font-size:clamp(2.4rem,4.6vw,3.8rem);line-height:1.05;letter-spacing:-.022em;color:var(--ink);margin:14px 0 0}
.page-hero-text h1::first-letter{color:var(--saffron);font-style:italic}
.page-hero-text .hs-ornament{margin:18px 0 24px}
.page-hero-lede{font-family:var(--font-display);font-style:italic;font-size:1.25rem;line-height:1.55;color:var(--ink);margin:0 0 24px;font-weight:400}
.page-hero-body{font-size:1.05rem;line-height:1.85;color:var(--ink-soft)}
.page-hero-body p{margin:0 0 1em}
.page-hero-figure{position:relative}
.page-hero-frame{position:relative;border-radius:2px;overflow:hidden;background:var(--paper-deep);box-shadow:0 30px 60px -20px rgba(31,22,18,.25), 0 0 0 1px var(--rule)}
.page-hero-frame::before{content:"";position:absolute;inset:14px;border:1px solid rgba(255,255,255,.55);pointer-events:none;z-index:2}
.page-hero-frame img{width:100%;height:500px;object-fit:cover;display:block;filter:saturate(.95) contrast(1.02)}
.page-hero-caption{display:flex;align-items:center;gap:14px;margin:18px 0 0;font-size:.78rem;letter-spacing:.06em;color:var(--ink-mute);text-transform:uppercase;font-weight:500}
.page-hero-caption-rule{display:inline-block;width:36px;height:1px;background:var(--saffron)}

/* ---------- Section heads ---------- */
.about-page section{padding:100px 0}
.section-head{margin:0 0 50px;max-width:760px}
.section-head--left{text-align:left}
.section-head--center{text-align:center;margin-left:auto;margin-right:auto}
.section-head--center .hs-ornament{margin-left:auto;margin-right:auto}
.section-head h2{font-family:var(--font-display);font-weight:600;font-size:clamp(1.9rem,3.4vw,2.9rem);line-height:1.1;letter-spacing:-.015em;color:var(--ink);margin:8px 0 0}
.section-head--inverse h2{color:#fff}
.section-head .hs-ornament{margin-top:18px}
.section-head--left .hs-ornament{margin-left:0}
.section-sub{margin:18px 0 0;color:var(--ink-mute);font-size:1.02rem;line-height:1.7}
.section-sub--light{color:#d8cdb6}
.section-empty{color:var(--ink-mute);font-style:italic;padding:24px 0}

/* ---------- MVV ---------- */
.mvv{background:var(--paper-deep)}
.mvv-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:0;border-top:1px solid var(--rule);border-left:1px solid var(--rule)}
.mvv-item{background:var(--card);padding:46px 36px;border-right:1px solid var(--rule);border-bottom:1px solid var(--rule);transition:background .25s,border-color .25s;position:relative}
.mvv-item:hover{background:#fffaf2}
.mvv-head{display:flex;align-items:center;gap:18px;margin:0 0 24px}
.mvv-num{font-family:var(--font-display);font-size:.9rem;font-weight:600;color:var(--saffron);letter-spacing:.18em}
.mvv-icon{width:48px;height:48px;border-radius:50%;overflow:hidden;background:var(--paper-deep);display:flex;align-items:center;justify-content:center}
.mvv-icon img{width:100%;height:100%;object-fit:cover}
.mvv-item h3{font-family:var(--font-display);font-size:1.45rem;font-weight:600;margin:0 0 14px;color:var(--ink);line-height:1.25}
.mvv-item p{color:var(--ink-soft);line-height:1.75;margin:0;font-size:.98rem}

/* ---------- Leadership ---------- */
.leadership-team{background:var(--paper)}
.team-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:32px}
.team-card{background:var(--card);border:1px solid var(--rule);overflow:hidden;transition:transform .25s,box-shadow .25s,border-color .25s}
.team-card:hover{transform:translateY(-5px);box-shadow:0 20px 40px -18px rgba(31,22,18,.18);border-color:var(--saffron)}
.team-photo{width:100%;height:300px;overflow:hidden;background:var(--paper-deep)}
.team-photo img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.team-card:hover .team-photo img{transform:scale(1.04)}
.team-photo-placeholder{height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#f3ead9,#e6dccb)}
.team-photo-placeholder span{font-family:var(--font-display);font-size:3rem;color:var(--saffron);opacity:.45;font-weight:600;letter-spacing:.05em}
.team-body{padding:24px 24px 28px}
.team-card h3{font-family:var(--font-display);font-size:1.3rem;font-weight:600;margin:0 0 6px;color:var(--ink);letter-spacing:-.01em}
.team-card .designation{color:var(--saffron);font-weight:600;font-size:.74rem;text-transform:uppercase;letter-spacing:.18em;margin:0 0 14px}
.team-card .bio{color:var(--ink-soft);font-size:.93rem;line-height:1.7;margin:0}

/* ---------- Our Reach ---------- */
.our-reach{background:var(--ink);color:#f3ead9;position:relative;overflow:hidden}
.our-reach::before{content:"";position:absolute;inset:0;background:
	radial-gradient(800px 400px at 80% 0%, rgba(200,84,28,.18), transparent 60%),
	radial-gradient(700px 400px at 10% 100%, rgba(30,90,60,.18), transparent 60%);
	pointer-events:none}
.our-reach .container{position:relative}
.reach-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:0;border-top:1px solid rgba(243,234,217,.18);border-left:1px solid rgba(243,234,217,.18)}
.reach-item{padding:42px 30px;border-right:1px solid rgba(243,234,217,.18);border-bottom:1px solid rgba(243,234,217,.18);transition:background .25s}
.reach-item:hover{background:rgba(200,84,28,.08)}
.reach-tag{font-family:var(--font-display);font-size:.82rem;color:var(--saffron);font-weight:600;letter-spacing:.2em}
.reach-number{font-family:var(--font-display);font-size:3.4rem;font-weight:600;margin:18px 0 6px;line-height:1;color:#fff;letter-spacing:-.02em}
.reach-item h3{margin:0;font-size:.85rem;color:#d8cdb6;letter-spacing:.08em;text-transform:uppercase;font-weight:500;font-family:var(--font-body)}

/* ---------- Affiliations ---------- */
.affiliations{background:var(--paper)}
.affiliations-list{list-style:none;padding:0;max-width:820px;margin:0;display:grid;grid-template-columns:1fr;gap:0;border-top:1px solid var(--rule)}
.affiliations-list li{padding:22px 28px;border-bottom:1px solid var(--rule);font-size:1.02rem;color:var(--ink);display:flex;align-items:center;gap:24px;transition:background .2s,padding .2s}
.affiliations-list li:hover{background:var(--paper-deep);padding-left:36px}
.aff-num{font-family:var(--font-display);font-size:.85rem;color:var(--saffron);font-weight:600;letter-spacing:.18em;flex:0 0 auto;min-width:36px}
.aff-text{flex:1}

/* ---------- Responsive ---------- */
@media (max-width:960px){
	.page-hero{padding:60px 24px 70px}
	.page-hero-inner{grid-template-columns:1fr;gap:50px}
	.page-hero-frame img{height:360px}
	.about-page section{padding:70px 0}
}
@media (max-width:560px){
	.page-hero{padding:50px 20px 60px}
	.container{padding:0 20px}
	.team-photo{height:240px}
	.reach-number{font-size:2.4rem}
}
</style>

<?php
get_footer();
