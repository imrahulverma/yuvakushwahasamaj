<?php
/**
 * Site Header — Warm Editorial
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'yuvakushwahasamaj' ); ?></a>

<!-- Editorial top bar -->
<div class="yks-topbar">
	<div class="yks-topbar-inner">
		<span class="yks-topbar-tagline">
			<span class="yks-hindi">एकता · युवा · प्रगति</span>
			<span class="yks-topbar-sep">—</span>
			<span class="yks-topbar-en">Unity · Youth · Progress</span>
		</span>
		<span class="yks-topbar-contact">
			<a href="mailto:info@yuvakushwahasamaj.org">info@yuvakushwahasamaj.org</a>
			<span class="yks-topbar-sep">·</span>
			<a href="tel:+918229062767">+91 82290 62767</a>
		</span>
	</div>
</div>

<header id="masthead" class="yks-header">
	<div class="yks-header-inner">
		<div class="yks-branding">
			<?php
			$site_icon_url = function_exists( 'get_site_icon_url' ) ? get_site_icon_url( 120 ) : '';
			if ( $site_icon_url ) : ?>
				<a class="yks-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					<img src="<?php echo esc_url( $site_icon_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="60" height="60">
				</a>
			<?php elseif ( has_custom_logo() ) : ?>
				<div class="yks-logo"><?php the_custom_logo(); ?></div>
			<?php else : ?>
				<div class="yks-logo-placeholder">
					<span>YK</span>
				</div>
			<?php endif; ?>
			<div class="yks-site-text">
				<a class="yks-site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
				<?php $desc = get_bloginfo( 'description', 'display' ); ?>
				<?php if ( $desc ) : ?>
					<p class="yks-site-tagline"><?php echo esc_html( $desc ); ?></p>
				<?php endif; ?>
			</div>
		</div>

		<button class="yks-menu-toggle" aria-controls="primary-menu" aria-expanded="false" onclick="this.classList.toggle('is-open');this.setAttribute('aria-expanded',this.classList.contains('is-open'));document.getElementById('primary-menu').classList.toggle('is-open');">
			<span></span><span></span><span></span>
		</button>

		<nav class="yks-primary-nav" aria-label="Primary">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'menu_class'     => 'yks-menu',
					'fallback_cb'    => false,
				) );
			} else {
				echo '<ul id="primary-menu" class="yks-menu">';
				$default = array(
					'/'         => 'Home',
					'/about/'   => 'About',
					'/events/'  => 'Events',
					'/gallery/' => 'Gallery',
					'/news/'    => 'News',
				);
				foreach ( $default as $url => $label ) {
					printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( $url ) ), esc_html( $label ) );
				}
				echo '</ul>';
			}
			?>
			<a class="yks-nav-cta" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
				<span>हमसे जुड़ें</span>
				<svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</a>
		</nav>
	</div>
	<!-- Hairline ornament strip -->
	<div class="yks-header-ornament" aria-hidden="true"></div>
</header>

<style>
.skip-link{position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden}
.skip-link:focus{position:static;width:auto;height:auto}

/* ---------- Top bar ---------- */
.yks-topbar{background:var(--ink);color:#e7ddc9;font-size:.78rem;letter-spacing:.04em}
.yks-topbar-inner{max-width:1240px;margin:0 auto;padding:10px 28px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px}
.yks-topbar-tagline{display:inline-flex;align-items:center;gap:10px;flex-wrap:wrap}
.yks-hindi{font-family:var(--font-hindi);color:#f3ead9}
.yks-topbar-en{color:#c9bfa9}
.yks-topbar-sep{color:var(--saffron);opacity:.8}
.yks-topbar-contact a{color:#e7ddc9;text-decoration:none;margin:0 4px;transition:color .2s}
.yks-topbar-contact a:hover{color:var(--saffron);text-decoration:none}

/* ---------- Header ---------- */
.yks-header{background:var(--paper);position:sticky;top:0;z-index:100;border-bottom:1px solid var(--rule)}
.yks-header-inner{max-width:1240px;margin:0 auto;padding:22px 28px;display:flex;justify-content:space-between;align-items:center;gap:24px}

.yks-branding{display:flex;align-items:center;gap:16px}
.yks-logo img{height:58px;width:58px;object-fit:contain;border-radius:50%}
.yks-logo-placeholder{height:60px;width:60px;border-radius:50%;background:var(--paper-deep);border:1.5px solid var(--saffron);display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-weight:700;font-size:1.35rem;color:var(--saffron);letter-spacing:.05em}
.yks-site-title{font-family:var(--font-display);font-size:1.55rem;font-weight:600;color:var(--ink);text-decoration:none;line-height:1.05;display:block;letter-spacing:-.01em}
.yks-site-title:hover{color:var(--saffron)}
.yks-site-tagline{margin:4px 0 0;font-size:.78rem;color:var(--ink-mute);letter-spacing:.06em;text-transform:uppercase;font-weight:500}

.yks-primary-nav{display:flex;align-items:center;gap:22px}
.yks-menu{list-style:none;display:flex;gap:2px;margin:0;padding:0;flex-wrap:wrap}
.yks-menu li{position:relative}
.yks-menu a{display:block;padding:10px 16px;color:var(--ink);text-decoration:none;font-weight:500;font-size:.95rem;letter-spacing:.01em;border-radius:0;position:relative;transition:color .2s}
.yks-menu a::after{content:"";position:absolute;left:16px;right:16px;bottom:6px;height:1px;background:var(--saffron);transform:scaleX(0);transform-origin:left;transition:transform .25s ease}
.yks-menu a:hover,.yks-menu .current-menu-item > a,.yks-menu .current_page_item > a{color:var(--saffron);background:transparent}
.yks-menu a:hover::after,.yks-menu .current-menu-item > a::after,.yks-menu .current_page_item > a::after{transform:scaleX(1)}
.yks-menu .sub-menu{position:absolute;top:100%;left:0;background:var(--card);box-shadow:0 12px 28px rgba(31,22,18,.10);min-width:220px;padding:8px;display:none;flex-direction:column;border-radius:2px;border:1px solid var(--rule)}
.yks-menu li:hover > .sub-menu{display:flex}
.yks-menu .sub-menu a{padding:10px 14px;font-size:.9rem}
.yks-menu .sub-menu a::after{display:none}

.yks-nav-cta{display:inline-flex;align-items:center;gap:8px;background:var(--ink);color:var(--paper) !important;padding:11px 22px;border-radius:2px;text-decoration:none;font-weight:600;font-size:.9rem;letter-spacing:.04em;transition:background .25s,color .25s;font-family:var(--font-hindi)}
.yks-nav-cta svg{transition:transform .25s}
.yks-nav-cta:hover{background:var(--saffron);color:#fff !important}
.yks-nav-cta:hover svg{transform:translateX(3px)}

.yks-menu-toggle{display:none;flex-direction:column;justify-content:space-between;width:30px;height:22px;background:transparent;border:0;cursor:pointer;padding:0}
.yks-menu-toggle span{display:block;height:2px;background:var(--ink);border-radius:1px;transition:all .25s}
.yks-menu-toggle.is-open span:nth-child(1){transform:translateY(10px) rotate(45deg)}
.yks-menu-toggle.is-open span:nth-child(2){opacity:0}
.yks-menu-toggle.is-open span:nth-child(3){transform:translateY(-10px) rotate(-45deg)}

/* Ornamental hairline strip beneath header */
.yks-header-ornament{height:3px;background:
	linear-gradient(90deg,
		var(--saffron) 0%, var(--saffron) 33.33%,
		var(--paper) 33.33%, var(--paper) 33.66%,
		#fff 33.66%, #fff 66.33%,
		var(--paper) 66.33%, var(--paper) 66.66%,
		var(--forest) 66.66%, var(--forest) 100%);
	opacity:.85}

@media (max-width:960px){
	.yks-topbar-contact{display:none}
	.yks-menu-toggle{display:flex}
	.yks-primary-nav{position:absolute;top:100%;left:0;right:0;background:var(--paper);flex-direction:column;align-items:stretch;padding:0;max-height:0;overflow:hidden;transition:max-height .35s ease;border-bottom:1px solid var(--rule);gap:0}
	.yks-menu{flex-direction:column;gap:0;padding:6px 0}
	.yks-menu a{padding:14px 28px;border-bottom:1px solid var(--rule)}
	.yks-menu a::after{display:none}
	.yks-primary-nav:has(#primary-menu.is-open){max-height:640px;padding:8px 0 18px}
	.yks-nav-cta{margin:12px 28px;justify-content:center}
}
@media (max-width:520px){
	.yks-header-inner{padding:16px 18px}
	.yks-topbar-inner{padding:8px 18px;font-size:.72rem}
	.yks-site-title{font-size:1.2rem}
	.yks-site-tagline{display:none}
	.yks-logo-placeholder,.yks-logo img{height:48px;width:48px;font-size:1.1rem}
}
</style>
