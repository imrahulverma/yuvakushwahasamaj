<?php
/**
 * Site Header
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

<!-- Top utility bar -->
<div class="yks-topbar">
	<div class="yks-topbar-inner">
		<span class="yks-topbar-tagline">एकता | युवा | प्रगति &nbsp;·&nbsp; Unity | Youth | Progress</span>
		<span class="yks-topbar-contact">
			<a href="mailto:info@yuvakushwahasamaj.org">✉ info@yuvakushwahasamaj.org</a>
			<a href="tel:+918229062767">📞 +91 82290 62767</a>
		</span>
	</div>
</div>

<header id="masthead" class="yks-header">
	<div class="yks-header-inner">
		<div class="yks-branding">
			<?php if ( has_custom_logo() ) : ?>
				<div class="yks-logo"><?php the_custom_logo(); ?></div>
			<?php else : ?>
				<div class="yks-logo-placeholder">YK</div>
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
					'/'            => 'Home',
					'/about/'      => 'About',
					'/events/'     => 'Events',
		
					'/gallery/'    => 'Gallery',
					'/news/'       => 'News',
					
				);
				foreach ( $default as $url => $label ) {
					printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( $url ) ), esc_html( $label ) );
				}
				echo '</ul>';
			}
			?>
			<a class="yks-nav-cta" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">हमसे जुड़ें</a>
		</nav>
	</div>
</header>

<style>
.skip-link{position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden}
.skip-link:focus{position:static;width:auto;height:auto}

.yks-topbar{background:#138808;color:#fff;font-size:.85rem}
.yks-topbar-inner{max-width:1200px;margin:0 auto;padding:8px 20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px}
.yks-topbar a{color:#fff;text-decoration:none;margin-left:18px}
.yks-topbar a:hover{text-decoration:underline}

.yks-header{background:#fff;border-bottom:3px solid #ff9933;position:sticky;top:0;z-index:100;box-shadow:0 2px 6px rgba(0,0,0,.06)}
.yks-header-inner{max-width:1200px;margin:0 auto;padding:14px 20px;display:flex;justify-content:space-between;align-items:center;gap:20px}

.yks-branding{display:flex;align-items:center;gap:14px}
.yks-logo img,.yks-logo-placeholder{height:56px;width:56px;object-fit:contain;border-radius:50%}
.yks-logo-placeholder{background:linear-gradient(135deg,#ff9933,#138808);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.4rem;letter-spacing:1px}
.yks-site-title{font-size:1.4rem;font-weight:700;color:#222;text-decoration:none;line-height:1.1;display:block}
.yks-site-title:hover{color:#ff9933}
.yks-site-tagline{margin:2px 0 0;font-size:.85rem;color:#666}

.yks-primary-nav{display:flex;align-items:center;gap:18px}
.yks-menu{list-style:none;display:flex;gap:6px;margin:0;padding:0;flex-wrap:wrap}
.yks-menu li{position:relative}
.yks-menu a{display:block;padding:8px 14px;color:#333;text-decoration:none;font-weight:500;border-radius:4px;transition:all .2s}
.yks-menu a:hover,.yks-menu .current-menu-item > a,.yks-menu .current_page_item > a{background:#fff5e6;color:#ff9933}
.yks-menu .sub-menu{position:absolute;top:100%;left:0;background:#fff;box-shadow:0 4px 12px rgba(0,0,0,.1);min-width:200px;padding:6px;display:none;flex-direction:column;border-radius:4px}
.yks-menu li:hover > .sub-menu{display:flex}

.yks-nav-cta{background:#ff9933;color:#fff !important;padding:10px 20px;border-radius:30px;text-decoration:none;font-weight:600;transition:background .2s}
.yks-nav-cta:hover{background:#e68a2e}

.yks-menu-toggle{display:none;flex-direction:column;justify-content:space-between;width:30px;height:22px;background:transparent;border:0;cursor:pointer;padding:0}
.yks-menu-toggle span{display:block;height:3px;background:#333;border-radius:2px;transition:all .25s}
.yks-menu-toggle.is-open span:nth-child(1){transform:translateY(9px) rotate(45deg)}
.yks-menu-toggle.is-open span:nth-child(2){opacity:0}
.yks-menu-toggle.is-open span:nth-child(3){transform:translateY(-9px) rotate(-45deg)}

@media (max-width:900px){
	.yks-topbar-contact{display:none}
	.yks-menu-toggle{display:flex}
	.yks-primary-nav{position:absolute;top:100%;left:0;right:0;background:#fff;flex-direction:column;align-items:stretch;padding:0;max-height:0;overflow:hidden;transition:max-height .3s ease;box-shadow:0 6px 12px rgba(0,0,0,.08);gap:0}
	.yks-menu{flex-direction:column;gap:0;padding:8px 0}
	.yks-menu a{padding:14px 24px;border-bottom:1px solid #f0f0f0}
	#primary-menu.is-open ~ .yks-nav-cta,#primary-menu.is-open{display:flex}
	.yks-primary-nav:has(#primary-menu.is-open){max-height:600px;padding:10px 0 16px}
	.yks-nav-cta{margin:10px 24px;text-align:center}
}
@media (max-width:480px){
	.yks-site-title{font-size:1.1rem}
	.yks-site-tagline{display:none}
}
</style>
