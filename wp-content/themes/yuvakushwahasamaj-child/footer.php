<?php
/**
 * Site Footer — Warm Editorial
 */
?>

<footer id="colophon" class="yks-footer">
	<!-- Decorative top strip echoing header ornament -->
	<div class="yks-footer-strip" aria-hidden="true"></div>

	<div class="yks-footer-inner">

		<!-- Column 1: About -->
		<div class="yks-foot-col yks-foot-about">
			<p class="yks-foot-mark">YK</p>
			<h3 class="yks-foot-title"><?php bloginfo( 'name' ); ?></h3>
			<p class="yks-foot-tagline">एकता · युवा · प्रगति</p>
			<p class="yks-foot-desc">A community devoted to youth empowerment, cultural preservation, and social progress. Together, we build a stronger tomorrow.</p>
			<div class="yks-social" aria-label="Follow us">
				<a href="#" aria-label="Facebook" target="_blank" rel="noopener">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.5h2.5l.4-3h-2.9V8.6c0-.9.2-1.5 1.5-1.5h1.6V4.4c-.3 0-1.2-.1-2.3-.1-2.3 0-3.8 1.4-3.8 3.9v2.2H8v3h2.5V21h3z"/></svg>
				</a>
				<a href="#" aria-label="Instagram" target="_blank" rel="noopener">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/></svg>
				</a>
				<a href="#" aria-label="Twitter / X" target="_blank" rel="noopener">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
				</a>
				<a href="#" aria-label="YouTube" target="_blank" rel="noopener">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M21.6 7.2s-.2-1.4-.8-2c-.7-.8-1.5-.8-1.9-.9C16 4 12 4 12 4s-4 0-6.9.3c-.4.1-1.2.1-1.9.9-.6.6-.8 2-.8 2S2.2 8.8 2.2 10.4v1.5c0 1.6.2 3.2.2 3.2s.2 1.4.8 2c.7.8 1.7.8 2.1.9 1.6.1 6.7.3 6.7.3s4 0 6.9-.3c.4-.1 1.2-.1 1.9-.9.6-.6.8-2 .8-2s.2-1.6.2-3.2v-1.5c0-1.6-.2-3.2-.2-3.2zM10 14.4V8.6l5.2 2.9z"/></svg>
				</a>
				<a href="#" aria-label="WhatsApp" target="_blank" rel="noopener">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.5 3.5A10.4 10.4 0 0 0 12 0C6.2 0 1.5 4.7 1.5 10.5c0 1.8.5 3.6 1.4 5.2L1 24l8.5-2.2c1.5.8 3.2 1.3 4.9 1.3h.1c5.8 0 10.5-4.7 10.5-10.5 0-2.8-1-5.5-3-7.5l-1.5-1.6zM12 21.3c-1.5 0-3-.4-4.3-1.2l-.3-.2-3.7 1 .9-3.5-.2-.3a8.4 8.4 0 0 1-1.3-4.6c0-4.7 3.8-8.5 8.6-8.5 2.3 0 4.4.9 6 2.5a8.5 8.5 0 0 1 2.5 6c0 4.7-3.8 8.5-8.6 8.5zm4.8-6.5c-.3-.1-1.6-.8-1.8-.9-.2-.1-.4-.1-.6.2-.2.3-.6.9-.8 1-.2.2-.3.2-.5.1-.3-.1-1.2-.4-2.2-1.4-.8-.7-1.4-1.6-1.5-1.9-.2-.3 0-.4.1-.5.1-.1.3-.3.4-.5.1-.1.2-.3.3-.5.1-.2 0-.3 0-.5-.1-.1-.7-1.6-.9-2.2-.2-.6-.4-.5-.6-.5h-.5c-.2 0-.5.1-.7.3-.2.3-.9.9-.9 2.1 0 1.3.9 2.5 1.1 2.7.1.2 1.9 2.8 4.5 4 .6.3 1.1.4 1.5.6.6.2 1.2.2 1.6.1.5-.1 1.6-.6 1.8-1.3.2-.6.2-1.2.1-1.3 0-.1-.2-.2-.4-.3z"/></svg>
				</a>
			</div>
		</div>

		<!-- Column 2: Quick Links -->
		<div class="yks-foot-col">
			<h3 class="yks-foot-title">Explore</h3>
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
					'/about/'   => 'About Us',
					'/events/'  => 'Events',
					'/gallery/' => 'Gallery',
					'/news/'    => 'News & Journal',
					'/contact/' => 'Contact',
				);
				foreach ( $links as $url => $label ) {
					printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( $url ) ), esc_html( $label ) );
				}
				echo '</ul>';
			}
			?>
		</div>

		<!-- Column 3: Contact -->
		<div class="yks-foot-col">
			<h3 class="yks-foot-title">Contact</h3>
			<address class="yks-foot-contact">
				<p>
					<span class="yks-foot-lbl">Telephone</span>
					<a href="tel:+918229062767">+91 82290 62767</a>
				</p>
				<p>
					<span class="yks-foot-lbl">Email</span>
					<a href="mailto:info@yuvakushwahasamaj.org">info@yuvakushwahasamaj.org</a>
				</p>
				<p>
					<span class="yks-foot-lbl">Hours</span>
					Mon – Sat, 10:00 AM – 6:00 PM
				</p>
			</address>
		</div>

		<!-- Column 4: Newsletter / invitation -->
		<div class="yks-foot-col">
			<h3 class="yks-foot-title">An Invitation</h3>
			<p class="yks-foot-invite">Receive the community journal — stories, gatherings, and the work ahead.</p>
			<a class="yks-foot-cta" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
				<span>Join the Samaj</span>
				<svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</a>
		</div>

	</div>

	<div class="yks-foot-bottom">
		<div class="yks-foot-bottom-inner">
			<p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
			<p class="yks-foot-credits">Crafted with care for the community.</p>
		</div>
	</div>
</footer>

<style>
.yks-footer{background:var(--ink);color:#c9bfa9;margin-top:0;font-family:var(--font-body);position:relative}
.yks-footer-strip{height:3px;background:
	linear-gradient(90deg,
		var(--saffron) 0%, var(--saffron) 33.33%,
		var(--ink) 33.33%, var(--ink) 33.66%,
		#fff 33.66%, #fff 66.33%,
		var(--ink) 66.33%, var(--ink) 66.66%,
		var(--forest) 66.66%, var(--forest) 100%);
	opacity:.85}

.yks-footer-inner{max-width:1240px;margin:0 auto;padding:80px 28px 56px;display:grid;grid-template-columns:1.4fr 1fr 1.1fr 1.1fr;gap:56px}

.yks-foot-mark{font-family:var(--font-display);font-size:1.3rem;font-weight:600;color:var(--saffron);margin:0 0 12px;display:inline-flex;align-items:center;justify-content:center;width:46px;height:46px;border:1.5px solid var(--saffron);border-radius:50%;letter-spacing:.04em}
.yks-foot-title{font-family:var(--font-display);color:#f3ead9;font-size:1.1rem;font-weight:600;margin:0 0 22px;letter-spacing:.01em;position:relative;padding-bottom:14px}
.yks-foot-title::after{content:"";position:absolute;left:0;bottom:0;width:32px;height:1px;background:var(--saffron)}
.yks-foot-tagline{font-family:var(--font-hindi);color:var(--saffron);font-weight:500;margin:0 0 16px;font-size:1rem;letter-spacing:.04em}
.yks-foot-desc{font-size:.92rem;line-height:1.75;color:#a59c8a;margin:0 0 22px;max-width:320px}

.yks-foot-list{list-style:none;padding:0;margin:0}
.yks-foot-list li{margin:0 0 12px}
.yks-foot-list a{color:#c9bfa9;text-decoration:none;font-size:.95rem;font-weight:400;transition:color .2s,padding .2s;display:inline-flex;align-items:center;gap:10px;position:relative}
.yks-foot-list a::before{content:"";width:0;height:1px;background:var(--saffron);transition:width .25s ease;display:inline-block;flex:0 0 auto}
.yks-foot-list a:hover{color:#f3ead9}
.yks-foot-list a:hover::before{width:14px}

.yks-foot-contact p{margin:0 0 16px;font-size:.95rem;line-height:1.6;color:#c9bfa9;font-style:normal;display:flex;flex-direction:column;gap:3px}
.yks-foot-contact a{color:#f3ead9;text-decoration:none;transition:color .2s}
.yks-foot-contact a:hover{color:var(--saffron)}
.yks-foot-lbl{font-size:.7rem;letter-spacing:.18em;text-transform:uppercase;color:var(--ink-mute);font-weight:600}

.yks-foot-invite{font-size:.93rem;line-height:1.7;color:#a59c8a;margin:0 0 22px}
.yks-foot-cta{display:inline-flex;align-items:center;gap:8px;background:transparent;color:#f3ead9;padding:11px 22px;border:1px solid var(--saffron);text-decoration:none;font-weight:600;font-size:.88rem;letter-spacing:.04em;transition:all .25s}
.yks-foot-cta svg{transition:transform .25s}
.yks-foot-cta:hover{background:var(--saffron);color:#fff;border-color:var(--saffron)}
.yks-foot-cta:hover svg{transform:translateX(3px)}

.yks-social{display:flex;gap:8px;margin-top:14px}
.yks-social a{width:38px;height:38px;border:1px solid #3a312a;color:#c9bfa9;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all .25s;border-radius:50%}
.yks-social a:hover{background:var(--saffron);color:#fff;border-color:var(--saffron);transform:translateY(-2px)}

.yks-foot-bottom{background:#161010;border-top:1px solid #2a221d}
.yks-foot-bottom-inner{max-width:1240px;margin:0 auto;padding:20px 28px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;font-size:.82rem;color:#7a7065}
.yks-foot-bottom p{margin:0}
.yks-foot-credits{font-style:italic;color:#6b6258}

@media (max-width:960px){
	.yks-footer-inner{grid-template-columns:1fr 1fr;gap:42px;padding:60px 24px 40px}
}
@media (max-width:560px){
	.yks-footer-inner{grid-template-columns:1fr;gap:38px;padding:50px 22px 32px}
	.yks-foot-bottom-inner{flex-direction:column;text-align:center;padding:18px 22px}
}
</style>

<?php wp_footer(); ?>
</body>
</html>
