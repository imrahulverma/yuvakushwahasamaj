<?php
/**
 * Template Name: Contact Us
 * Description: Contact Us page template
 */

get_header();
?>

<main id="main" class="site-main">
	<div class="container">
		
		<h1><?php the_title(); ?></h1>
		
		<div class="contact-content">
			
			<!-- Contact Form -->
			<section class="contact-form-section">
				<h2>Get In Touch</h2>
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
							<option>Select Subject</option>
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

					<div class="form-group">
						<label>
							<input type="checkbox" name="privacy" required>
							I agree to the privacy policy
						</label>
					</div>

					<button type="submit" class="btn-submit">Send Message</button>
				</form>
			</section>

			<!-- Contact Information -->
			<section class="contact-info-section">
				<h2>Contact Information</h2>
				
				<div class="contact-info-grid">
					<div class="contact-info-item">
						<div class="contact-icon">📍</div>
						<h3>Address</h3>
						<p>
							Yuvakushwahasamaj Headquarters<br>
							Community Center, City Name<br>
							State, PIN Code
						</p>
					</div>

					<div class="contact-info-item">
						<div class="contact-icon">📞</div>
						<h3>Phone</h3>
						<p>
							Main Line: +91-XXX-XXXX-XXXX<br>
							WhatsApp: +91-XXX-XXXX-XXXX<br>
							Available: Mon-Sun, 9AM-6PM
						</p>
					</div>

					<div class="contact-info-item">
						<div class="contact-icon">✉️</div>
						<h3>Email</h3>
						<p>
							General: info@yuvakushwahasamaj.org<br>
							Membership: members@yuvakushwahasamaj.org<br>
							Events: events@yuvakushwahasamaj.org
						</p>
					</div>

					<div class="contact-info-item">
						<div class="contact-icon">⏰</div>
						<h3>Office Hours</h3>
						<p>
							Monday - Friday: 9:00 AM - 6:00 PM<br>
							Saturday: 10:00 AM - 4:00 PM<br>
							Sunday: Closed
						</p>
					</div>
				</div>
			</section>

			<!-- Social Media -->
			<section class="social-media-section">
				<h2>Follow Us On Social Media</h2>
				<div class="social-links">
					<a href="https://facebook.com/yuvakushwahasamaj" target="_blank" rel="noopener noreferrer" class="social-link facebook">
						<span>📘</span>
						<p>Facebook</p>
					</a>
					<a href="https://instagram.com/yuvakushwahasamaj" target="_blank" rel="noopener noreferrer" class="social-link instagram">
						<span>📷</span>
						<p>Instagram</p>
					</a>
					<a href="https://youtube.com/yuvakushwahasamaj" target="_blank" rel="noopener noreferrer" class="social-link youtube">
						<span>▶️</span>
						<p>YouTube</p>
					</a>
					<a href="https://twitter.com/yuvakushwaha" target="_blank" rel="noopener noreferrer" class="social-link twitter">
						<span>𝕏</span>
						<p>Twitter</p>
					</a>
					<a href="https://wa.me/919876543210" target="_blank" rel="noopener noreferrer" class="social-link whatsapp">
						<span>💬</span>
						<p>WhatsApp</p>
					</a>
				</div>
			</section>

		</div>

	</div>
</main>

<style>
	.container {
		max-width: 1200px;
		margin: 0 auto;
		padding: 0 20px;
	}

	.site-main > .container h1 {
		font-size: 2.5rem;
		margin-bottom: 20px;
		padding-top: 40px;
	}

	.contact-content {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 60px;
		margin: 60px 0;
	}

	section {
		padding: 40px 0;
	}

	section h2 {
		font-size: 1.8rem;
		margin-bottom: 30px;
		text-align: center;
	}

	/* Contact Form */
	.contact-form-section h2 {
		text-align: left;
	}

	.contact-form {
		background-color: #f9f9f9;
		padding: 30px;
		border-radius: 8px;
	}

	.form-group {
		margin-bottom: 20px;
	}

	.form-row {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 20px;
	}

	.form-group label {
		display: block;
		margin-bottom: 8px;
		font-weight: 500;
		color: #333;
	}

	.form-group label span {
		color: #ff9933;
	}

	.form-group input,
	.form-group select,
	.form-group textarea {
		width: 100%;
		padding: 12px;
		border: 1px solid #ddd;
		border-radius: 5px;
		font-size: 1rem;
		font-family: inherit;
	}

	.form-group input:focus,
	.form-group select:focus,
	.form-group textarea:focus {
		outline: none;
		border-color: #ff9933;
		box-shadow: 0 0 0 3px rgba(255, 153, 51, 0.1);
	}

	.form-group label input[type="checkbox"] {
		width: auto;
		margin-right: 8px;
	}

	.btn-submit {
		background-color: #138808;
		color: white;
		padding: 14px 40px;
		border: none;
		border-radius: 5px;
		font-size: 1.1rem;
		font-weight: bold;
		cursor: pointer;
		width: 100%;
		transition: background-color 0.3s ease;
	}

	.btn-submit:hover {
		background-color: #0d6106;
	}

	/* Contact Information */
	.contact-info-section h2 {
		text-align: center;
		grid-column: 1 / -1;
	}

	.contact-info-grid {
		display: grid;
		grid-template-columns: 1fr;
		gap: 20px;
	}

	.contact-info-item {
		background-color: #f9f9f9;
		padding: 25px;
		border-radius: 8px;
		border-left: 4px solid #ff9933;
		transition: transform 0.3s ease, box-shadow 0.3s ease;
	}

	.contact-info-item:hover {
		transform: translateX(5px);
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
	}

	.contact-icon {
		font-size: 2rem;
		margin-bottom: 10px;
	}

	.contact-info-item h3 {
		font-size: 1.2rem;
		margin: 10px 0 15px 0;
		color: #333;
	}

	.contact-info-item p {
		color: #666;
		line-height: 1.8;
		margin: 0;
	}

	/* Social Media */
	.social-media-section {
		grid-column: 1 / -1;
		background-color: #f5f5f5;
		padding: 60px 40px;
		border-radius: 8px;
		text-align: center;
	}

	.social-media-section h2 {
		margin-bottom: 40px;
	}

	.social-links {
		display: flex;
		justify-content: center;
		gap: 30px;
		flex-wrap: wrap;
	}

	.social-link {
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 10px;
		text-decoration: none;
		padding: 20px 30px;
		background-color: white;
		border-radius: 8px;
		transition: all 0.3s ease;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
	}

	.social-link:hover {
		transform: translateY(-5px);
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
	}

	.social-link span {
		font-size: 2.5rem;
	}

	.social-link p {
		margin: 0;
		font-weight: 500;
		color: #333;
	}

	.social-link.facebook:hover {
		background-color: #1877f2;
	}

	.social-link.facebook:hover p {
		color: white;
	}

	.social-link.instagram:hover {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	}

	.social-link.instagram:hover p {
		color: white;
	}

	.social-link.youtube:hover {
		background-color: #ff0000;
	}

	.social-link.youtube:hover p {
		color: white;
	}

	.social-link.twitter:hover {
		background-color: #000;
	}

	.social-link.twitter:hover p {
		color: white;
	}

	.social-link.whatsapp:hover {
		background-color: #25d366;
	}

	.social-link.whatsapp:hover p {
		color: white;
	}

	@media (max-width: 1024px) {
		.contact-content {
			grid-template-columns: 1fr;
			gap: 40px;
		}

		.social-media-section {
			grid-column: 1;
		}
	}

	@media (max-width: 768px) {
		.site-main > .container h1 {
			font-size: 1.8rem;
		}

		section h2 {
			font-size: 1.5rem;
		}

		.form-row {
			grid-template-columns: 1fr;
		}

		.social-links {
			gap: 15px;
		}

		.social-link {
			padding: 15px 20px;
		}

		.social-link span {
			font-size: 2rem;
		}
	}
</style>

<?php
get_footer();
