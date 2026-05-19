<?php
/**
 * Template Name: Membership
 * Description: Membership page template — warm editorial style
 */

get_header();
?>

<main id="main" class="site-main membership-page">

	<!-- Editorial page hero -->
	<section class="page-hero">
		<div class="page-hero-inner">
			<span class="eyebrow">Belonging · Service · Continuity</span>
			<h1><?php the_title(); ?></h1>
			<?php echo yks_ornament(); ?>
			<p class="page-hero-lede">Join a community of members who share a commitment to youth empowerment, cultural heritage, and collective progress.</p>
		</div>
	</section>

	<div class="container">

		<!-- Why Join Section -->
		<section class="why-join">
			<header class="section-head section-head--left">
				<span class="eyebrow">Chapter 01 · Why Join</span>
				<h2>What Membership Means</h2>
				<?php echo yks_ornament(); ?>
			</header>
			<div class="benefits-grid">
				<?php
				$benefits = array(
					array( 'num' => '01', 'title' => 'Community Network', 'text' => 'Connect with thousands of members across the region.' ),
					array( 'num' => '02', 'title' => 'Learning Opportunities', 'text' => 'Access to educational programmes and skill workshops.' ),
					array( 'num' => '03', 'title' => 'Exclusive Events', 'text' => 'Priority access to cultural programmes and felicitations.' ),
					array( 'num' => '04', 'title' => 'Member Journal', 'text' => 'Stay updated with community news and achievements.' ),
					array( 'num' => '05', 'title' => 'Recognition Programme', 'text' => 'Celebrate the work and contributions of members.' ),
					array( 'num' => '06', 'title' => 'Career Support', 'text' => 'Mentorship and professional networking opportunities.' ),
				);
				foreach ( $benefits as $b ) : ?>
					<article class="benefit-item">
						<span class="benefit-num"><?php echo esc_html( $b['num'] ); ?></span>
						<h3><?php echo esc_html( $b['title'] ); ?></h3>
						<p><?php echo esc_html( $b['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</section>

		<!-- Membership Tiers -->
		<section class="membership-tiers">
			<header class="section-head section-head--left">
				<span class="eyebrow">Chapter 02 · Tiers</span>
				<h2>Choose Your Path</h2>
				<?php echo yks_ornament(); ?>
			</header>
			<div class="tiers-grid">
				<div class="tier-card">
					<span class="tier-label">Youth</span>
					<h3>Youth Member</h3>
					<p class="tier-price">₹500 <span>/ year</span></p>
					<p class="tier-age">Ages 18 – 35</p>
					<ul class="tier-features">
						<li>Community membership</li>
						<li>Event access</li>
						<li>Journal subscription</li>
						<li>Digital membership card</li>
					</ul>
					<a href="#registration" class="tier-cta">
						<span>Join now</span>
						<svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</a>
				</div>

				<div class="tier-card tier-card--featured">
					<span class="tier-badge">Most Popular</span>
					<span class="tier-label">Life</span>
					<h3>Life Member</h3>
					<p class="tier-price">₹10,000 <span>/ lifetime</span></p>
					<p class="tier-age">All ages</p>
					<ul class="tier-features">
						<li>Lifetime membership</li>
						<li>All event access</li>
						<li>Journal subscription</li>
						<li>Physical ID card</li>
						<li>Priority event registration</li>
						<li>Voting rights</li>
					</ul>
					<a href="#registration" class="tier-cta tier-cta--solid">
						<span>Join now</span>
						<svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</a>
				</div>

				<div class="tier-card">
					<span class="tier-label">Patron</span>
					<h3>Patron Member</h3>
					<p class="tier-price">₹25,000 <span>/ lifetime</span></p>
					<p class="tier-age">All ages</p>
					<ul class="tier-features">
						<li>Lifetime membership</li>
						<li>VIP event access</li>
						<li>All Life Member benefits</li>
						<li>Recognition in publications</li>
						<li>Advisory council eligibility</li>
						<li>Exclusive networking events</li>
					</ul>
					<a href="#registration" class="tier-cta">
						<span>Join now</span>
						<svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</a>
				</div>
			</div>
		</section>

		<!-- Registration Form -->
		<section class="registration-section" id="registration">
			<header class="section-head section-head--left">
				<span class="eyebrow">Chapter 03 · Enrolment</span>
				<h2>Register for Membership</h2>
				<?php echo yks_ornament(); ?>
				<p class="section-sub">Fill in the form below — we will be in touch within two working days.</p>
			</header>
			<div class="form-container">
				<form id="membership-form" method="POST" class="membership-form">
					<?php wp_nonce_field( 'membership_registration' ); ?>

					<div class="form-group">
						<label for="member_name">Full Name <span>*</span></label>
						<input type="text" id="member_name" name="member_name" required>
					</div>

					<div class="form-row">
						<div class="form-group">
							<label for="member_age">Age <span>*</span></label>
							<input type="number" id="member_age" name="member_age" min="1" required>
						</div>
						<div class="form-group">
							<label for="member_gender">Gender</label>
							<select id="member_gender" name="member_gender">
								<option>Select</option>
								<option value="male">Male</option>
								<option value="female">Female</option>
								<option value="other">Other</option>
							</select>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group">
							<label for="member_email">Email <span>*</span></label>
							<input type="email" id="member_email" name="member_email" required>
						</div>
						<div class="form-group">
							<label for="member_phone">Mobile Number <span>*</span></label>
							<input type="tel" id="member_phone" name="member_phone" pattern="[0-9]{10}" placeholder="10-digit number" required>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group">
							<label for="member_city">City <span>*</span></label>
							<input type="text" id="member_city" name="member_city" required>
						</div>
						<div class="form-group">
							<label for="member_state">State</label>
							<input type="text" id="member_state" name="member_state">
						</div>
					</div>

					<div class="form-group">
						<label for="member_tier">Membership Tier <span>*</span></label>
						<select id="member_tier" name="member_tier" required>
							<option>Select membership tier</option>
							<option value="youth">Youth Member (₹500 / year)</option>
							<option value="life">Life Member (₹10,000 / lifetime)</option>
							<option value="patron">Patron Member (₹25,000 / lifetime)</option>
						</select>
					</div>

					<div class="form-group form-check">
						<label>
							<input type="checkbox" name="terms" required>
							<span>I agree to the terms and conditions and privacy policy.</span>
						</label>
					</div>

					<button type="submit" class="form-submit">
						<span>Submit Registration</span>
						<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
				</form>
			</div>
		</section>

		<!-- Membership Card Preview -->
		<section class="membership-info">
			<header class="section-head section-head--left">
				<span class="eyebrow">Chapter 04 · Your Card</span>
				<h2>Digital Membership Card</h2>
				<?php echo yks_ornament(); ?>
				<p class="section-sub">Sent to your registered email immediately after enrolment is confirmed.</p>
			</header>
			<div class="membership-card-preview">
				<div class="card-front">
					<div class="card-top">
						<span class="card-logo">YK</span>
						<span class="card-id">Samaj · Member</span>
					</div>
					<div class="card-body">
						<p class="card-label">Member ID</p>
						<p class="card-member-id">2026-XXXXX</p>
						<p class="card-label">Name</p>
						<p class="card-member-name">Sample Member</p>
					</div>
					<div class="card-bottom">
						<span>Valid 2026 – 2027</span>
						<span class="card-tricolor"></span>
					</div>
				</div>
			</div>
		</section>

	</div>
</main>

<style>
.membership-page{background:var(--paper);font-family:var(--font-body);color:var(--ink-soft)}
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

/* ---------- Section heads ---------- */
.membership-page section{padding:90px 0}
.section-head{margin:0 0 50px;max-width:760px}
.section-head--left{text-align:left}
.section-head h2{font-family:var(--font-display);font-weight:600;font-size:clamp(1.9rem,3.4vw,2.8rem);line-height:1.1;letter-spacing:-.015em;color:var(--ink);margin:8px 0 0}
.section-head .hs-ornament{margin-top:18px;margin-left:0}
.section-sub{margin:18px 0 0;color:var(--ink-mute);font-size:1.02rem;line-height:1.7}

/* ---------- Benefits ---------- */
.benefits-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:0;border-top:1px solid var(--rule);border-left:1px solid var(--rule)}
.benefit-item{background:var(--card);padding:40px 32px;border-right:1px solid var(--rule);border-bottom:1px solid var(--rule);transition:background .25s}
.benefit-item:hover{background:#fffaf2}
.benefit-num{font-family:var(--font-display);font-size:.82rem;color:var(--saffron);font-weight:600;letter-spacing:.2em}
.benefit-item h3{font-family:var(--font-display);font-size:1.25rem;font-weight:600;margin:14px 0 12px;color:var(--ink);line-height:1.3;letter-spacing:-.01em}
.benefit-item p{color:var(--ink-soft);line-height:1.7;margin:0;font-size:.96rem}

/* ---------- Tiers ---------- */
.tiers-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px}
.tier-card{background:var(--card);border:1px solid var(--rule);padding:36px 32px 32px;position:relative;transition:transform .25s,box-shadow .25s,border-color .25s;display:flex;flex-direction:column}
.tier-card:hover{transform:translateY(-6px);box-shadow:0 22px 40px -18px rgba(31,22,18,.18);border-color:var(--saffron)}
.tier-card--featured{border-color:var(--saffron);border-width:2px;background:linear-gradient(180deg, #fffaf2 0%, var(--card) 60%)}
.tier-badge{position:absolute;top:-1px;right:24px;background:var(--saffron);color:#fff;padding:6px 14px;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.16em}
.tier-label{font-family:var(--font-body);font-size:.72rem;color:var(--saffron);font-weight:600;text-transform:uppercase;letter-spacing:.22em}
.tier-card h3{font-family:var(--font-display);font-size:1.55rem;font-weight:600;margin:10px 0 14px;color:var(--ink);letter-spacing:-.01em}
.tier-price{font-family:var(--font-display);font-size:2.4rem;font-weight:600;color:var(--ink);margin:0;line-height:1;letter-spacing:-.02em}
.tier-price span{font-family:var(--font-body);font-size:.9rem;color:var(--ink-mute);font-weight:400;margin-left:6px}
.tier-age{color:var(--ink-mute);font-size:.85rem;letter-spacing:.06em;text-transform:uppercase;margin:10px 0 22px;font-weight:500}
.tier-features{list-style:none;padding:22px 0;text-align:left;border-top:1px solid var(--rule);border-bottom:1px solid var(--rule);margin:0 0 24px;flex:1}
.tier-features li{padding:7px 0 7px 22px;color:var(--ink-soft);font-size:.94rem;position:relative}
.tier-features li::before{content:"";position:absolute;left:0;top:14px;width:10px;height:1px;background:var(--saffron)}

.tier-cta{display:inline-flex;align-items:center;gap:8px;background:transparent;color:var(--ink);padding:12px 22px;border:1px solid var(--saffron);text-decoration:none;font-weight:600;font-size:.9rem;letter-spacing:.04em;transition:all .25s;align-self:flex-start}
.tier-cta svg{transition:transform .25s}
.tier-cta:hover{background:var(--saffron);color:#fff;border-color:var(--saffron)}
.tier-cta:hover svg{transform:translateX(3px)}
.tier-cta--solid{background:var(--ink);color:var(--paper);border-color:var(--ink)}
.tier-cta--solid:hover{background:var(--saffron);border-color:var(--saffron);color:#fff}

/* ---------- Registration form ---------- */
.registration-section{background:var(--paper-deep);margin:30px -28px;padding:90px 28px !important}
.form-container{max-width:760px;background:var(--card);padding:48px;border:1px solid var(--rule)}
.form-group{margin-bottom:22px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:22px}
.form-group label{display:block;margin-bottom:8px;font-weight:600;color:var(--ink);font-size:.78rem;letter-spacing:.14em;text-transform:uppercase}
.form-group label span{color:var(--saffron);margin-left:3px}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:13px 14px;border:1px solid var(--rule);background:var(--paper);font-size:1rem;font-family:inherit;color:var(--ink);transition:border-color .2s,background .2s}
.form-group input:focus,.form-group select:focus,.form-group textarea:focus{outline:none;border-color:var(--saffron);background:var(--card)}
.form-check label{display:flex;align-items:flex-start;gap:10px;text-transform:none;letter-spacing:0;font-size:.92rem;color:var(--ink-soft);font-weight:400;line-height:1.6}
.form-check input[type="checkbox"]{width:18px;height:18px;margin-top:2px;accent-color:var(--saffron);flex:0 0 auto}
.form-submit{display:inline-flex;align-items:center;gap:10px;background:var(--ink);color:var(--paper);padding:14px 28px;border:0;font-size:.95rem;font-weight:600;letter-spacing:.04em;cursor:pointer;transition:background .25s,transform .25s;font-family:var(--font-body)}
.form-submit svg{transition:transform .25s}
.form-submit:hover{background:var(--saffron);color:#fff}
.form-submit:hover svg{transform:translateX(3px)}

/* ---------- Membership card preview ---------- */
.membership-card-preview{max-width:560px}
.card-front{background:linear-gradient(135deg,var(--ink) 0%, #2a1d16 100%);color:#f3ead9;padding:30px;aspect-ratio:16 / 10;display:flex;flex-direction:column;justify-content:space-between;position:relative;overflow:hidden;border:1px solid #3a2d24;box-shadow:0 30px 60px -20px rgba(31,22,18,.4)}
.card-front::before{content:"";position:absolute;top:-30%;right:-20%;width:300px;height:300px;background:radial-gradient(circle, rgba(200,84,28,.25), transparent 60%);pointer-events:none}
.card-top{display:flex;justify-content:space-between;align-items:center;position:relative;z-index:1}
.card-logo{font-family:var(--font-display);font-size:1.6rem;font-weight:600;color:var(--saffron);width:48px;height:48px;border:1.5px solid var(--saffron);border-radius:50%;display:flex;align-items:center;justify-content:center;letter-spacing:.04em}
.card-id{font-size:.7rem;letter-spacing:.22em;text-transform:uppercase;color:#c9bfa9;font-weight:600}
.card-body{position:relative;z-index:1}
.card-label{margin:0;font-size:.68rem;letter-spacing:.2em;text-transform:uppercase;color:#a59c8a;font-weight:600}
.card-member-id{font-family:var(--font-display);font-size:1.35rem;font-weight:600;letter-spacing:.05em;margin:4px 0 14px;color:#f3ead9}
.card-member-name{font-family:var(--font-display);font-size:1.25rem;font-weight:500;margin:4px 0 0;color:#fff;letter-spacing:-.01em}
.card-bottom{display:flex;justify-content:space-between;align-items:center;font-size:.75rem;letter-spacing:.12em;color:#a59c8a;font-weight:500;text-transform:uppercase;position:relative;z-index:1}
.card-tricolor{display:inline-block;width:60px;height:3px;background:linear-gradient(90deg,var(--saffron) 0% 33.33%, #fff 33.33% 66.66%, var(--forest) 66.66% 100%);opacity:.9}

@media (max-width:768px){
	.page-hero{padding:60px 24px 60px}
	.membership-page section{padding:70px 0}
	.form-row{grid-template-columns:1fr}
	.form-container{padding:32px 24px}
	.registration-section{margin:30px -20px;padding:60px 22px !important}
	.card-front{aspect-ratio:auto;min-height:240px;padding:24px}
	.card-member-id{font-size:1.15rem}
}
</style>

<?php
get_footer();
