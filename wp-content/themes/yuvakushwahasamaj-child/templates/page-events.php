<?php
/**
 * Template Name: Events
 * Description: Events page template
 */

get_header();
?>

<main id="main" class="site-main">
	<div class="container">
		
		<h1><?php the_title(); ?></h1>
		
		<!-- Upcoming Events -->
		<section class="upcoming-events">
			<h2>Upcoming Events</h2>
			<div class="event-cards">
				<?php
					$upcoming_events = get_posts( array(
						'post_type'      => 'event',
						'posts_per_page' => -1,
						'meta_query'     => array(
							array(
								'key'     => 'event_status',
								'value'   => 'upcoming',
								'compare' => '==',
							),
						),
						'meta_key'       => 'event_date',
						'orderby'        => 'meta_value',
						'order'          => 'ASC',
					) );
					
					if ( $upcoming_events ) {
						foreach ( $upcoming_events as $event ) {
							setup_postdata( $event );
							// Get custom fields using SCF helper function
							$event_date = get_scf_field( 'event_date', $event->ID );
							$event_time = get_scf_field( 'event_time', $event->ID );
							$event_venue = get_scf_field( 'event_venue', $event->ID );
							$event_image_id = get_scf_field( 'event_image', $event->ID );
							$register_link = get_scf_field( 'register_link', $event->ID );
							?>
							<div class="event-card">
								<?php if ( $event_image_id ) : ?>
									<div class="event-card-image">
										<?php echo wp_get_attachment_image( $event_image_id, 'medium' ); ?>
									</div>
								<?php endif; ?>
								<div class="event-card-content">
									<?php if ( $event_date ) : ?>
										<p class="event-date"><?php echo esc_html( date_i18n( 'F d, Y', strtotime( $event_date ) ) ); ?></p>
									<?php endif; ?>
									<h3 class="event-title"><?php the_title(); ?></h3>
									<?php if ( $event_venue ) : ?>
										<p class="event-venue">📍 <?php echo esc_html( $event_venue ); ?></p>
									<?php endif; ?>
									<?php if ( $event_time ) : ?>
										<p class="event-time">🕐 <?php echo esc_html( date_i18n( 'H:i A', strtotime( $event_time ) ) ); ?></p>
									<?php endif; ?>
									<p><?php echo wp_kses_post( wp_trim_words( get_the_content(), 20 ) ); ?></p>
									<?php if ( $register_link ) : ?>
										<a href="<?php echo esc_url( $register_link ); ?>" class="btn-register" target="_blank">Register Now</a>
									<?php endif; ?>
								</div>
							</div>
							<?php
						}
						wp_reset_postdata();
					} else {
						echo '<p>No upcoming events at the moment. Check back soon!</p>';
					}
				?>
			</div>
		</section>

		<!-- Past Events Archive -->
		<section class="past-events">
			<h2>Past Events</h2>
			<div class="event-cards">
				<?php
					$past_events = get_posts( array(
						'post_type'      => 'event',
						'posts_per_page' => 6,
						'meta_query'     => array(
							array(
								'key'     => 'event_status',
								'value'   => array( 'completed', 'ongoing' ),
								'compare' => 'IN',
							),
						),
						'meta_key'       => 'event_date',
						'orderby'        => 'meta_value',
						'order'          => 'DESC',
					) );
					
					if ( $past_events ) {
						foreach ( $past_events as $event ) {
							setup_postdata( $event );
							// Get custom fields using SCF helper function
							$event_date = get_scf_field( 'event_date', $event->ID );
							$event_image_id = get_scf_field( 'event_image', $event->ID );
							?>
							<div class="event-card past-event">
								<?php if ( $event_image_id ) : ?>
									<div class="event-card-image">
										<?php echo wp_get_attachment_image( $event_image_id, 'medium' ); ?>
									</div>
								<?php endif; ?>
								<div class="event-card-content">
									<?php if ( $event_date ) : ?>
										<p class="event-date"><?php echo esc_html( date_i18n( 'F d, Y', strtotime( $event_date ) ) ); ?></p>
									<?php endif; ?>
									<h3 class="event-title"><?php the_title(); ?></h3>
									<p><?php echo wp_kses_post( wp_trim_words( get_the_content(), 20 ) ); ?></p>
									<a href="<?php the_permalink(); ?>" class="btn-register">View Details</a>
								</div>
							</div>
							<?php
						}
						wp_reset_postdata();
					} else {
						echo '<p>No past events yet.</p>';
					}
				?>
			</div>
		</section>

		<!-- Annual Sammelan Highlight -->
		<section class="sammelan-highlight">
			<h2>Annual Sammelan/Mahasammelan</h2>
			<div class="sammelan-content">
				<p>Our flagship annual gathering brings together community members from across the region to celebrate our heritage, share achievements, and plan for the future.</p>
				<p>Stay tuned for details about the upcoming Mahasammelan event!</p>
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
	}

	section h2 {
		font-size: 2rem;
		margin-bottom: 40px;
		text-align: center;
	}

	.event-cards {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
		gap: 30px;
	}

	.event-card {
		background: white;
		border-radius: 8px;
		overflow: hidden;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
		transition: transform 0.3s ease, box-shadow 0.3s ease;
	}

	.event-card:hover {
		transform: translateY(-5px);
		box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
	}

	.event-card-image {
		width: 100%;
		height: 200px;
		overflow: hidden;
	}

	.event-card-image img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

	.event-card-content {
		padding: 20px;
	}

	.event-date {
		color: #ff9933;
		font-weight: bold;
		font-size: 0.85rem;
		margin: 0;
	}

	.event-title {
		font-size: 1.3rem;
		margin: 10px 0 5px 0;
		color: #333;
	}

	.event-venue,
	.event-time {
		color: #666;
		font-size: 0.95rem;
		margin: 5px 0;
	}

	.event-card-content p:last-of-type {
		margin-bottom: 15px;
		line-height: 1.6;
	}

	.btn-register {
		background-color: #ff9933;
		color: white;
		padding: 10px 20px;
		text-decoration: none;
		border-radius: 5px;
		display: inline-block;
		transition: background-color 0.3s ease;
	}

	.btn-register:hover {
		background-color: #e68a2e;
	}

	.past-event {
		opacity: 0.9;
	}

	.sammelan-highlight {
		background: linear-gradient(135deg, #ff9933 0%, #138808 100%);
		color: white;
		text-align: center;
	}

	.sammelan-content p {
		font-size: 1.1rem;
		margin: 15px 0;
		max-width: 600px;
		margin-left: auto;
		margin-right: auto;
	}

	@media (max-width: 768px) {
		.site-main > .container h1 {
			font-size: 1.8rem;
		}

		section h2 {
			font-size: 1.5rem;
		}

		.event-cards {
			grid-template-columns: 1fr;
		}
	}
</style>

<?php
get_footer();
