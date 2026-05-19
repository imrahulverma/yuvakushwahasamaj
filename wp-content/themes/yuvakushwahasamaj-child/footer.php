<?php
/**
 * Site Footer
 */
?>

<footer id="colophon" class="yks-footer">
	<div class="yks-footer-inner">

		<!-- Column 1: About -->
		<div class="yks-foot-col yks-foot-about">
			<h3 class="yks-foot-title"><?php bloginfo( 'name' ); ?></h3>
			<p class="yks-foot-tagline">एकता | युवा | प्रगति</p>
			<p class="yks-foot-desc">A vibrant community dedicated to youth empowerment, cultural preservation, and social progress. Together we build a stronger tomorrow.</p>
			<div class="yks-social">
				<a href="#" aria-label="Facebook" target="_blank" rel="noopener">f</a>
				<a href="#" aria-label="Instagram" target="_blank" rel="noopener">◉</a>
				<a href="#" aria-label="Twitter" target="_blank" rel="noopener">𝕏</a>
				<a href="#" aria-label="YouTube" target="_blank" rel="noopener">▶</a>
				<a href="#" aria-label="WhatsApp" target="_blank" rel="noopener">💬</a>
			</div>
		</div>

		<!-- Column 2: Quick Links -->
		<div class="yks-foot-col">
			<h3 class="yks-foot-title">Quick Links</h3>
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'yks-foot-list',
					'depth'          => 1,
				) );
			} else {
				echo '<ul class="yks-foot-list">';
				$links = array(
					'/about/'      => 'About Us',
					'/events/'     => 'Events',
					// '/membership/' => 'Membership',
					'/gallery/'    => 'Gallery',
					'/news/'       => 'News & Blog',
					'/contact/'    => 'Contact',
				);
				foreach ( $links as $url => $label ) {
					printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( $url ) ), esc_html( $label ) );
				}
				echo '</ul>';
			}
			?>
		</div>

		<!-- Column 3: Get Involved -->
		<!-- <div class="yks-foot-col">
			<h3 class="yks-foot-title">Get Involved</h3>
			<ul class="yks-foot-list">
				<li><a href="<?php echo esc_url( home_url( '/membership/' ) ); ?>">Become a Member</a></li>
				<li><a href="<?php echo esc_url( home_url( '/events/' ) ); ?>">Upcoming Events</a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Volunteer</a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Donate</a></li>
				<li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">Newsletter</a></li>
			</ul>
		</div> -->

		<!-- Column 4: Contact -->
		<div class="yks-foot-col">
			<h3 class="yks-foot-title">Contact Us</h3>
			<address class="yks-foot-contact">
				<!-- <p>📍 Community Office<br>Lucknow, Uttar Pradesh, India</p> -->
				<p>📞 <a href="tel:+918229062767">+91 82290 62767</a></p>
				<p>✉ <a href="mailto:info@yuvakushwahasamaj.org">info@yuvakushwahasamaj.org</a></p>
				<p>🕐 Mon–Sat, 10:00 AM – 6:00 PM</p>
			</address>
		</div>

	</div>

	<div class="yks-foot-bottom">
		<div class="yks-foot-bottom-inner">
			<p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
			<p class="yks-foot-credits">Made with ❤ for the community</p>
		</div>
	</div>
</footer>

<style>
.yks-footer{background:#1a1a1a;color:#ccc;margin-top:60px}
.yks-footer-inner{max-width:1200px;margin:0 auto;padding:60px 20px 40px;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:40px}

.yks-foot-title{color:#fff;font-size:1.1rem;margin:0 0 20px;padding-bottom:10px;border-bottom:2px solid #ff9933;display:inline-block}
.yks-foot-tagline{color:#ff9933;font-weight:600;margin:0 0 12px;font-size:1rem}
.yks-foot-desc{font-size:.9rem;line-height:1.7;color:#aaa;margin:0 0 20px}

.yks-foot-list{list-style:none;padding:0;margin:0}
.yks-foot-list li{margin:0 0 10px}
.yks-foot-list a{color:#bbb;text-decoration:none;font-size:.92rem;transition:color .2s,padding .2s}
.yks-foot-list a:hover{color:#ff9933;padding-left:6px}
.yks-foot-list a::before{content:"›";color:#ff9933;margin-right:6px;font-weight:700}

.yks-foot-contact p{margin:0 0 12px;font-size:.92rem;line-height:1.6;color:#bbb;font-style:normal}
.yks-foot-contact a{color:#bbb;text-decoration:none}
.yks-foot-contact a:hover{color:#ff9933}

.yks-social{display:flex;gap:10px;margin-top:14px}
.yks-social a{width:38px;height:38px;border-radius:50%;background:#2a2a2a;color:#ccc;display:flex;align-items:center;justify-content:center;text-decoration:none;font-weight:700;transition:all .2s}
.yks-social a:hover{background:#ff9933;color:#fff;transform:translateY(-2px)}

.yks-foot-bottom{background:#000;padding:18px 0;border-top:1px solid #2a2a2a}
.yks-foot-bottom-inner{max-width:1200px;margin:0 auto;padding:0 20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;font-size:.85rem;color:#888}
.yks-foot-bottom p{margin:0}
.yks-foot-credits{color:#666}

@media (max-width:600px){
	.yks-footer-inner{padding:40px 20px 20px;gap:30px}
	.yks-foot-bottom-inner{flex-direction:column;text-align:center}
}
</style>

<?php wp_footer(); ?>
</body>
</html>
