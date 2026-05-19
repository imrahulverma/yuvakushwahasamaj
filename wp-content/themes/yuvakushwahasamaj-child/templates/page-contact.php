<?php
/**
 * Template Name: Contact Us
 * Description: Contact Us page template — warm editorial style
 */

get_header();
?>

<main id="main" class="site-main contact-page">

	<!-- Editorial page hero -->
	<section class="page-hero">
		<div class="page-hero-inner">
			<span class="eyebrow">Get in Touch · We are Listening</span>
			<h1><?php the_title(); ?></h1>
			<?php echo yks_ornament(); ?>
			<p class="page-hero-lede">Send us a note — about membership, an event you are planning, or simply to say hello. We respond within two working days.</p>
		</div>
	</section>

	<div class="container">

		<section class="contact-grid">

			<!-- Contact Form -->
			<div class="contact-form-section">
				<header class="section-head section-head--left">
					<span class="eyebrow">Chapter 01 · Write to Us</span>
					<h2>Send a Message</h2>
					<?php echo yks_ornament(); ?>
				</header>

				<form id="contact-form" method="POST" class="contact-form">
					<?php wp_nonce_field( 'contact_form_nonce' ); ?>

					<div class="form-group">
						<label for="contact_name">Full Name <span>*</span></label>
						<input type="text" id="contact_name" name="contact_name" required>
					</div>

					<div class="form-row">
						<div class="form-group">
							<label for="contact_email">Email <span>*</span></label>
							<input type="email" id="contact_email" name="contact_email" required>
						</div>
						<div class="form-group">
							<label for="contact_phone">Phone</label>
							<input type="tel" id="contact_phone" name="contact_phone">
						</div>
					</div>

					<div class="form-group">
						<label for="contact_subject">Subject <span>*</span></label>
						<select id="contact_subject" name="contact_subject" required>
							<option>Select subject</option>
							<option value="inquiry">General Inquiry</option>
							<option value="membership">Membership Question</option>
							<option value="event">Event Information</option>
							<option value="partnership">Partnership Opportunity</option>
							<option value="feedback">Feedback</option>
							<option value="other">Other</option>
						</select>
					</div>

					<div class="form-group">
						<label for="contact_message">Message <span>*</span></label>
						<textarea id="contact_message" name="contact_message" rows="6" required></textarea>
					</div>

					<div class="form-group form-check">
						<label>
							<input type="checkbox" name="privacy" required>
							<span>I agree to the privacy policy and the terms of communication.</span>
						</label>
					</div>

					<button type="submit" class="form-submit">
						<span>Send Message</span>
						<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
				</form>
			</div>

			<!-- Contact Information -->
			<aside class="contact-info-section">
				<header class="section-head section-head--left">
					<span class="eyebrow">Chapter 02 · Find Us</span>
					<h2>Contact Information</h2>
					<?php echo yks_ornament(); ?>
				</header>

				<div class="contact-info-list">
					<article class="contact-info-item">
						<span class="contact-info-label">Address</span>
						<p>
							Yuvakushwahasamaj Headquarters<br>
							Community Centre, City Name<br>
							State, PIN Code
						</p>
					</article>

					<article class="contact-info-item">
						<span class="contact-info-label">Telephone</span>
						<p>
							<a href="tel:+918229062767">+91 82290 62767</a><br>
							<a href="https://wa.me/918229062767" target="_blank" rel="noopener">WhatsApp · +91 82290 62767</a><br>
							<span class="contact-info-meta">Mon – Sat, 9 AM – 6 PM</span>
						</p>
					</article>

					<article class="contact-info-item">
						<span class="contact-info-label">Email</span>
						<p>
							<a href="mailto:info@yuvakushwahasamaj.org">info@yuvakushwahasamaj.org</a><br>
							<a href="mailto:members@yuvakushwahasamaj.org">members@yuvakushwahasamaj.org</a><br>
							<a href="mailto:events@yuvakushwahasamaj.org">events@yuvakushwahasamaj.org</a>
						</p>
					</article>

					<article class="contact-info-item">
						<span class="contact-info-label">Hours</span>
						<p>
							Monday – Friday · 9:00 AM – 6:00 PM<br>
							Saturday · 10:00 AM – 4:00 PM<br>
							Sunday · Closed
						</p>
					</article>
				</div>
			</aside>

		</section>

		<!-- Social Media -->
		<section class="social-media-section">
			<header class="section-head section-head--center">
				<span class="eyebrow">Chapter 03 · Follow Us</span>
				<h2>Find Us Online</h2>
				<?php echo yks_ornament(); ?>
			</header>
			<div class="social-links">
				<a href="https://facebook.com/yuvakushwahasamaj" target="_blank" rel="noopener noreferrer" class="social-link">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.5h2.5l.4-3h-2.9V8.6c0-.9.2-1.5 1.5-1.5h1.6V4.4c-.3 0-1.2-.1-2.3-.1-2.3 0-3.8 1.4-3.8 3.9v2.2H8v3h2.5V21h3z"/></svg>
					<span>Facebook</span>
				</a>
				<a href="https://instagram.com/yuvakushwahasamaj" target="_blank" rel="noopener noreferrer" class="social-link">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/></svg>
					<span>Instagram</span>
				</a>
				<a href="https://youtube.com/yuvakushwahasamaj" target="_blank" rel="noopener noreferrer" class="social-link">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M21.6 7.2s-.2-1.4-.8-2c-.7-.8-1.5-.8-1.9-.9C16 4 12 4 12 4s-4 0-6.9.3c-.4.1-1.2.1-1.9.9-.6.6-.8 2-.8 2S2.2 8.8 2.2 10.4v1.5c0 1.6.2 3.2.2 3.2s.2 1.4.8 2c.7.8 1.7.8 2.1.9 1.6.1 6.7.3 6.7.3s4 0 6.9-.3c.4-.1 1.2-.1 1.9-.9.6-.6.8-2 .8-2s.2-1.6.2-3.2v-1.5c0-1.6-.2-3.2-.2-3.2zM10 14.4V8.6l5.2 2.9z"/></svg>
					<span>YouTube</span>
				</a>
				<a href="https://twitter.com/yuvakushwaha" target="_blank" rel="noopener noreferrer" class="social-link">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
					<span>Twitter</span>
				</a>
				<a href="https://wa.me/919876543210" target="_blank" rel="noopener noreferrer" class="social-link">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.5 3.5A10.4 10.4 0 0 0 12 0C6.2 0 1.5 4.7 1.5 10.5c0 1.8.5 3.6 1.4 5.2L1 24l8.5-2.2c1.5.8 3.2 1.3 4.9 1.3h.1c5.8 0 10.5-4.7 10.5-10.5 0-2.8-1-5.5-3-7.5l-1.5-1.6zM12 21.3c-1.5 0-3-.4-4.3-1.2l-.3-.2-3.7 1 .9-3.5-.2-.3a8.4 8.4 0 0 1-1.3-4.6c0-4.7 3.8-8.5 8.6-8.5 2.3 0 4.4.9 6 2.5a8.5 8.5 0 0 1 2.5 6c0 4.7-3.8 8.5-8.6 8.5zm4.8-6.5c-.3-.1-1.6-.8-1.8-.9-.2-.1-.4-.1-.6.2-.2.3-.6.9-.8 1-.2.2-.3.2-.5.1-.3-.1-1.2-.4-2.2-1.4-.8-.7-1.4-1.6-1.5-1.9-.2-.3 0-.4.1-.5.1-.1.3-.3.4-.5.1-.1.2-.3.3-.5.1-.2 0-.3 0-.5-.1-.1-.7-1.6-.9-2.2-.2-.6-.4-.5-.6-.5h-.5c-.2 0-.5.1-.7.3-.2.3-.9.9-.9 2.1 0 1.3.9 2.5 1.1 2.7.1.2 1.9 2.8 4.5 4 .6.3 1.1.4 1.5.6.6.2 1.2.2 1.6.1.5-.1 1.6-.6 1.8-1.3.2-.6.2-1.2.1-1.3 0-.1-.2-.2-.4-.3z"/></svg>
					<span>WhatsApp</span>
				</a>
			</div>
		</section>

	</div>
</main>

<style>
.contact-page{background:var(--paper);font-family:var(--font-body);color:var(--ink-soft)}
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
.contact-page section{padding:80px 0}
.section-head{margin:0 0 40px;max-width:680px}
.section-head--left{text-align:left}
.section-head--center{text-align:center;margin-left:auto;margin-right:auto}
.section-head--center .hs-ornament{margin-left:auto;margin-right:auto}
.section-head h2{font-family:var(--font-display);font-weight:600;font-size:clamp(1.7rem,3vw,2.4rem);line-height:1.1;letter-spacing:-.015em;color:var(--ink);margin:8px 0 0}
.section-head .hs-ornament{margin-top:18px}
.section-head--left .hs-ornament{margin-left:0}

/* ---------- Two-column grid ---------- */
.contact-grid{display:grid;grid-template-columns:1.2fr 1fr;gap:80px;align-items:start}

/* ---------- Contact form ---------- */
.contact-form{background:var(--card);padding:40px;border:1px solid var(--rule)}
.form-group{margin-bottom:22px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.form-group label{display:block;margin-bottom:8px;font-weight:600;color:var(--ink);font-size:.74rem;letter-spacing:.16em;text-transform:uppercase}
.form-group label span{color:var(--saffron);margin-left:3px}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:13px 14px;border:1px solid var(--rule);background:var(--paper);font-size:1rem;font-family:inherit;color:var(--ink);transition:border-color .2s,background .2s;resize:vertical}
.form-group input:focus,.form-group select:focus,.form-group textarea:focus{outline:none;border-color:var(--saffron);background:var(--card)}
.form-check label{display:flex;align-items:flex-start;gap:10px;text-transform:none;letter-spacing:0;font-size:.92rem;color:var(--ink-soft);font-weight:400;line-height:1.6}
.form-check input[type="checkbox"]{width:18px;height:18px;margin-top:2px;accent-color:var(--saffron);flex:0 0 auto}
.form-submit{display:inline-flex;align-items:center;gap:10px;background:var(--ink);color:var(--paper);padding:14px 28px;border:0;font-size:.95rem;font-weight:600;letter-spacing:.04em;cursor:pointer;transition:background .25s;font-family:var(--font-body);width:100%;justify-content:center}
.form-submit svg{transition:transform .25s}
.form-submit:hover{background:var(--saffron);color:#fff}
.form-submit:hover svg{transform:translateX(3px)}

/* ---------- Contact info ---------- */
.contact-info-list{display:flex;flex-direction:column;gap:0;border-top:1px solid var(--rule)}
.contact-info-item{padding:24px 0;border-bottom:1px solid var(--rule);display:grid;grid-template-columns:120px 1fr;gap:24px;align-items:start}
.contact-info-label{font-size:.72rem;color:var(--saffron);font-weight:600;letter-spacing:.2em;text-transform:uppercase;padding-top:3px}
.contact-info-item p{margin:0;color:var(--ink);line-height:1.85;font-size:.96rem}
.contact-info-item a{color:var(--ink);text-decoration:none;border-bottom:1px solid var(--rule);transition:border-color .2s,color .2s}
.contact-info-item a:hover{color:var(--saffron);border-bottom-color:var(--saffron)}
.contact-info-meta{display:inline-block;margin-top:6px;font-size:.78rem;color:var(--ink-mute);letter-spacing:.06em;text-transform:uppercase;font-weight:500}

/* ---------- Social media ---------- */
.social-media-section{background:var(--paper-deep);margin:30px -28px;padding:80px 28px !important}
.social-links{display:flex;justify-content:center;gap:14px;flex-wrap:wrap}
.social-link{display:inline-flex;align-items:center;gap:12px;text-decoration:none;padding:14px 24px;background:var(--card);border:1px solid var(--rule);color:var(--ink);transition:all .25s;font-weight:600;font-size:.92rem;letter-spacing:.02em}
.social-link:hover{background:var(--ink);color:var(--paper);border-color:var(--ink);transform:translateY(-3px)}
.social-link svg{color:currentColor;transition:color .25s}

@media (max-width:960px){
	.contact-grid{grid-template-columns:1fr;gap:60px}
	.contact-page section{padding:60px 0}
	.social-media-section{margin:30px -20px;padding:60px 22px !important}
}
@media (max-width:768px){
	.page-hero{padding:60px 24px 60px}
	.form-row{grid-template-columns:1fr;gap:0}
	.contact-form{padding:28px 22px}
	.contact-info-item{grid-template-columns:1fr;gap:8px}
	.social-link{padding:12px 20px;font-size:.88rem}
}
</style>

<?php
get_footer();
