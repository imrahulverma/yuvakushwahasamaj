<?php
/**
 * Template Name: Membership
 * Description: Membership page template
 */

get_header();
?>

<main id="main" class="site-main">
	<div class="container">
		
		<h1><?php the_title(); ?></h1>
		
		<!-- Why Join Section -->
		<section class="why-join">
			<h2>Why Join Yuvakushwahasamaj?</h2>
			<div class="benefits-grid">
				<div class="benefit-item">
					<div class="benefit-icon">👥</div>
					<h3>Community Network</h3>
					<p>Connect with thousands of members across the region</p>
				</div>
				<div class="benefit-item">
					<div class="benefit-icon">📚</div>
					<h3>Learning Opportunities</h3>
					<p>Access to educational programs and skill development workshops</p>
				</div>
				<div class="benefit-item">
					<div class="benefit-icon">🎉</div>
					<h3>Exclusive Events</h3>
					<p>Priority access to cultural programs, sports events, and felicitations</p>
				</div>
				<div class="benefit-item">
					<div class="benefit-icon">📰</div>
					<h3>Member Newsletter</h3>
					<p>Stay updated with community news and achievements</p>
				</div>
				<div class="benefit-item">
					<div class="benefit-icon">🏆</div>
					<h3>Recognition Program</h3>
					<p>Celebrate achievements and contributions of community members</p>
				</div>
				<div class="benefit-item">
					<div class="benefit-icon">💼</div>
					<h3>Career Support</h3>
					<p>Access to mentorship and professional networking opportunities</p>
				</div>
			</div>
		</section>

		<!-- Membership Tiers -->
		<section class="membership-tiers">
			<h2>Membership Tiers</h2>
			<div class="tiers-grid">
				<div class="tier-card">
					<h3>Youth Member</h3>
					<p class="tier-price">₹500 <span>/year</span></p>
					<p class="tier-age">Ages 18-35</p>
					<ul class="tier-features">
						<li>✓ Community membership</li>
						<li>✓ Event access</li>
						<li>✓ Newsletter subscription</li>
						<li>✓ Digital membership card</li>
					</ul>
					<a href="#registration" class="btn-primary">Join Now</a>
				</div>

				<div class="tier-card featured">
					<span class="tier-badge">Most Popular</span>
					<h3>Life Member</h3>
					<p class="tier-price">₹10,000 <span>/lifetime</span></p>
					<p class="tier-age">All ages</p>
					<ul class="tier-features">
						<li>✓ Lifetime membership</li>
						<li>✓ All event access</li>
						<li>✓ Newsletter subscription</li>
						<li>✓ Physical ID card</li>
						<li>✓ Priority event registration</li>
						<li>✓ Voting rights</li>
					</ul>
					<a href="#registration" class="btn-primary">Join Now</a>
				</div>

				<div class="tier-card">
					<h3>Patron Member</h3>
					<p class="tier-price">₹25,000 <span>/lifetime</span></p>
					<p class="tier-age">All ages</p>
					<ul class="tier-features">
						<li>✓ Lifetime membership</li>
						<li>✓ VIP event access</li>
						<li>✓ All Life Member benefits</li>
						<li>✓ Recognition in publications</li>
						<li>✓ Advisory council eligibility</li>
						<li>✓ Exclusive networking events</li>
					</ul>
					<a href="#registration" class="btn-primary">Join Now</a>
				</div>
			</div>
		</section>

		<!-- Registration Form -->
		<section class="registration-section" id="registration">
			<h2>Register for Membership</h2>
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
							<option>Select Membership Tier</option>
							<option value="youth">Youth Member (₹500/year)</option>
							<option value="life">Life Member (₹10,000/lifetime)</option>
							<option value="patron">Patron Member (₹25,000/lifetime)</option>
						</select>
					</div>

					<div class="form-group">
						<label>
							<input type="checkbox" name="terms" required>
							I agree to the terms and conditions
						</label>
					</div>

					<button type="submit" class="btn-submit">Submit Registration</button>
				</form>
			</div>
		</section>

		<!-- Membership Benefits Info -->
		<section class="membership-info">
			<h2>Your Digital Membership Card</h2>
			<div class="membership-card-preview">
				<div class="card-front">
					<div class="card-logo">YKS</div>
					<div class="card-text">
						<p>MEMBER ID</p>
						<p class="card-member-id">2026-XXXXX</p>
						<p>Member Name</p>
						<p class="card-date">Valid 2026-2027</p>
					</div>
				</div>
				<p style="text-align: center; margin-top: 20px;">Digital membership card will be sent to your registered email immediately after registration.</p>
			</div>
		</section>

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

	section {
		padding: 60px 0;
		border-bottom: 1px solid #eee;
	}

	section h2 {
		font-size: 2rem;
		margin-bottom: 40px;
		text-align: center;
	}

	/* Why Join Section */
	.benefits-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
		gap: 30px;
	}

	.benefit-item {
		text-align: center;
		padding: 30px;
		border-radius: 8px;
		background-color: #f9f9f9;
		transition: transform 0.3s ease, box-shadow 0.3s ease;
	}

	.benefit-item:hover {
		transform: translateY(-5px);
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
	}

	.benefit-icon {
		font-size: 3rem;
		margin-bottom: 15px;
	}

	.benefit-item h3 {
		font-size: 1.3rem;
		color: #ff9933;
		margin: 15px 0;
	}

	.benefit-item p {
		color: #666;
		line-height: 1.6;
	}

	/* Membership Tiers */
	.tiers-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
		gap: 30px;
		margin-bottom: 40px;
	}

	.tier-card {
		background: white;
		border: 2px solid #ddd;
		border-radius: 8px;
		padding: 30px;
		text-align: center;
		transition: transform 0.3s ease, box-shadow 0.3s ease;
		position: relative;
	}

	.tier-card:hover {
		transform: translateY(-10px);
		box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
	}

	.tier-card.featured {
		border-color: #ff9933;
		border-width: 3px;
		box-shadow: 0 4px 12px rgba(255, 153, 51, 0.2);
	}

	.tier-badge {
		position: absolute;
		top: -15px;
		left: 50%;
		transform: translateX(-50%);
		background-color: #ff9933;
		color: white;
		padding: 5px 15px;
		border-radius: 20px;
		font-size: 0.85rem;
		font-weight: bold;
	}

	.tier-card h3 {
		font-size: 1.5rem;
		margin: 20px 0 10px 0;
		color: #333;
	}

	.tier-price {
		font-size: 2rem;
		font-weight: bold;
		color: #ff9933;
		margin: 10px 0;
	}

	.tier-price span {
		font-size: 0.8rem;
		color: #999;
		font-weight: normal;
	}

	.tier-age {
		color: #666;
		font-size: 0.95rem;
		margin-bottom: 20px;
	}

	.tier-features {
		list-style: none;
		padding: 20px 0;
		text-align: left;
		border-top: 1px solid #eee;
		border-bottom: 1px solid #eee;
		margin: 20px 0;
	}

	.tier-features li {
		padding: 10px 0;
		color: #666;
	}

	.btn-primary {
		background-color: #ff9933;
		color: white;
		padding: 12px 30px;
		border: none;
		border-radius: 5px;
		font-size: 1rem;
		font-weight: bold;
		cursor: pointer;
		text-decoration: none;
		display: inline-block;
		transition: background-color 0.3s ease;
		margin-top: 15px;
	}

	.btn-primary:hover {
		background-color: #e68a2e;
	}

	/* Registration Form */
	.form-container {
		max-width: 700px;
		margin: 0 auto;
		background-color: #f9f9f9;
		padding: 40px;
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

	/* Membership Card Preview */
	.membership-card-preview {
		max-width: 500px;
		margin: 30px auto;
	}

	.card-front {
		background: linear-gradient(135deg, #ff9933 0%, #e68a2e 100%);
		color: white;
		padding: 40px;
		border-radius: 8px;
		box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
		aspect-ratio: 16 / 10;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		font-family: 'Courier New', monospace;
	}

	.card-logo {
		font-size: 2rem;
		font-weight: bold;
		letter-spacing: 2px;
	}

	.card-text p {
		margin: 5px 0;
		font-size: 0.85rem;
		font-weight: 500;
	}

	.card-member-id {
		font-size: 1.3rem !important;
		letter-spacing: 1px;
		margin-bottom: 15px;
	}

	.card-date {
		font-size: 0.9rem !important;
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

		.card-front {
			aspect-ratio: auto;
			min-height: 200px;
		}
	}
</style>

<?php
get_footer();
