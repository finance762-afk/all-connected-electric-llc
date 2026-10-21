<?php
/**
 * includes/header.php — skip link, fixed glass navbar, mobile overlay menu; opens <main id="main-content">.
 * Include after head.php (which opens <body>). Nav state comes from the page's $currentPage:
 *   home | services | areas | about | blog | contact
 * LINK INTEGRITY: every internal link is rendered only when its page exists on disk (siteHas / serviceUrl / areaUrl),
 * so the nav fills in automatically as later phases build pages and can never point at a 404.
 * Shared-include rule: loop variables are prefixed ($navSvc, $navArea).
 */
$navPhoneText = formatPhone($phone);
$navLogo      = siteLogo();
$navSub       = $tagline !== '' ? $tagline : $address['city'] . ', Maryland';
$navCtaHref   = siteHas('/contact/') ? '/contact/' : 'tel:' . $phoneRaw;   // data-open-estimate opens the dialog; href is the no-JS fallback

// Built service pages (name => url)
$navServices = [];
foreach ($services as $navSvc) {
    $navSvcUrl = serviceUrl($navSvc['slug']);
    if ($navSvcUrl !== '') $navServices[] = ['name' => $navSvc['name'], 'url' => $navSvcUrl];
}
// Built area pages
$navAreas = [];
foreach ($serviceAreas as $navArea) {
    $navAreaUrl = areaUrl($navArea['slug']);
    if ($navAreaUrl !== '') $navAreas[] = ['name' => $navArea['name'], 'url' => $navAreaUrl];
}
$navHasServices = siteHas('/services/');
$navHasAreas    = siteHas('/service-areas/');
?>
<a href="#main-content" class="skip-link">Skip to main content</a>

<header class="site-header" data-header>
  <nav class="navbar" aria-label="Main navigation">
    <div class="navbar-inner container">

      <a class="brand site-logo" href="/" aria-label="<?php echo esc($siteName); ?> — home">
<?php if ($navLogo): ?>
        <img src="<?php echo esc($navLogo['src']); ?>" alt="<?php echo esc($siteName); ?>" width="<?php echo (int) $navLogo['width']; ?>" height="<?php echo (int) $navLogo['height']; ?>"<?php echo $navLogo['class'] !== '' ? ' class="' . esc($navLogo['class']) . '"' : ''; ?> decoding="async">
<?php else: ?>
        <span class="logo-mark" aria-hidden="true"><?php echo boltMark(24); ?></span>
        <span class="logo-text">
          <span class="brand-name logo-name">All Connected Electric</span>
          <span class="brand-sub logo-tagline">LLC &middot; <?php echo esc($navSub); ?></span>
        </span>
<?php endif; ?>
      </a>

      <ul class="navbar-links">
        <li><a href="/"<?php echo ariaCurrent('home'); ?>>Home</a></li>
<?php if ($navHasServices || $navServices): ?>
        <li class="has-dropdown">
<?php if ($navHasServices): ?>
          <a href="/services/"<?php echo ariaCurrent('services'); ?>>Services <?php echo icon('chevron-down', 14, 'nav-caret'); ?></a>
<?php else: ?>
          <button type="button" class="dropdown-toggle" aria-haspopup="true">Services <?php echo icon('chevron-down', 14, 'nav-caret'); ?></button>
<?php endif; ?>
<?php if ($navServices): ?>
          <ul class="dropdown dropdown--wide" aria-label="Electrical services" style="display:none">
<?php foreach ($navServices as $navSvcItem): ?>
            <li><a href="<?php echo esc($navSvcItem['url']); ?>"><?php echo esc($navSvcItem['name']); ?></a></li>
<?php endforeach; ?>
<?php if ($navHasServices): ?>
            <li class="dropdown-all"><a href="/services/">View all services <?php echo icon('arrow-right', 14); ?></a></li>
<?php endif; ?>
          </ul>
<?php endif; ?>
        </li>
<?php endif; ?>
<?php if ($tier === 'premium' && ($navHasAreas || $navAreas)): ?>
        <li class="has-dropdown">
<?php if ($navHasAreas): ?>
          <a href="/service-areas/"<?php echo ariaCurrent('areas'); ?>>Service Areas <?php echo icon('chevron-down', 14, 'nav-caret'); ?></a>
<?php else: ?>
          <button type="button" class="dropdown-toggle" aria-haspopup="true">Service Areas <?php echo icon('chevron-down', 14, 'nav-caret'); ?></button>
<?php endif; ?>
<?php if ($navAreas): ?>
          <ul class="dropdown" aria-label="Service areas" style="display:none">
<?php foreach ($navAreas as $navAreaItem): ?>
            <li><a href="<?php echo esc($navAreaItem['url']); ?>"><?php echo esc($navAreaItem['name']); ?></a></li>
<?php endforeach; ?>
<?php if ($navHasAreas): ?>
            <li class="dropdown-all"><a href="/service-areas/">View all areas <?php echo icon('arrow-right', 14); ?></a></li>
<?php endif; ?>
          </ul>
<?php endif; ?>
        </li>
<?php endif; ?>
<?php if (siteHas('/about/')): ?>
        <li><a href="/about/"<?php echo ariaCurrent('about'); ?>>About</a></li>
<?php endif; ?>
<?php if ($tier === 'premium' && siteHas('/blog/')): ?>
        <li><a href="/blog/"<?php echo ariaCurrent('blog'); ?>>Blog</a></li>
<?php endif; ?>
<?php if (siteHas('/contact/')): ?>
        <li><a href="/contact/"<?php echo ariaCurrent('contact'); ?>>Contact</a></li>
<?php endif; ?>
      </ul>

      <div class="navbar-cta">
        <a class="btn btn-secondary navbar-phone" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?><span><?php echo esc($navPhoneText); ?></span></a>
        <a class="btn btn-nav-cta" href="<?php echo esc($navCtaHref); ?>" data-open-estimate>Get an Estimate</a>
      </div>

      <button type="button" class="hamburger" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
      </button>

    </div>
  </nav>
</header>

<?php /* Mobile overlay lives OUTSIDE <header>: the header's backdrop-filter would become the containing block for position:fixed and shrink the overlay to the bar height. main.js toggles .active + aria-hidden. */ ?>
<div class="mobile-menu" id="mobile-menu" aria-hidden="true">
  <nav class="mobile-menu-inner" aria-label="Mobile navigation">
    <ul class="mobile-menu-links mm-top">
      <li><a href="/"<?php echo ariaCurrent('home'); ?>>Home</a></li>
<?php if ($navHasServices || $navServices): ?>
      <li>
<?php if ($navHasServices): ?>
        <a href="/services/"<?php echo ariaCurrent('services'); ?>>Services</a>
<?php else: ?>
        <span class="mm-label">Services</span>
<?php endif; ?>
<?php if ($navServices): ?>
        <ul class="mobile-submenu">
<?php foreach ($navServices as $navSvcItem): ?>
          <li><a href="<?php echo esc($navSvcItem['url']); ?>"><?php echo esc($navSvcItem['name']); ?></a></li>
<?php endforeach; ?>
        </ul>
<?php endif; ?>
      </li>
<?php endif; ?>
<?php if ($tier === 'premium' && ($navHasAreas || $navAreas)): ?>
      <li>
<?php if ($navHasAreas): ?>
        <a href="/service-areas/"<?php echo ariaCurrent('areas'); ?>>Service Areas</a>
<?php else: ?>
        <span class="mm-label">Service Areas</span>
<?php endif; ?>
<?php if ($navAreas): ?>
        <ul class="mobile-submenu">
<?php foreach ($navAreas as $navAreaItem): ?>
          <li><a href="<?php echo esc($navAreaItem['url']); ?>"><?php echo esc($navAreaItem['name']); ?></a></li>
<?php endforeach; ?>
        </ul>
<?php endif; ?>
      </li>
<?php endif; ?>
<?php if (siteHas('/about/')): ?>
      <li><a href="/about/"<?php echo ariaCurrent('about'); ?>>About</a></li>
<?php endif; ?>
<?php if ($tier === 'premium' && siteHas('/blog/')): ?>
      <li><a href="/blog/"<?php echo ariaCurrent('blog'); ?>>Blog</a></li>
<?php endif; ?>
<?php if (siteHas('/faq/')): ?>
      <li><a href="/faq/"<?php echo ariaCurrent('faq'); ?>>FAQ</a></li>
<?php endif; ?>
<?php if (siteHas('/contact/')): ?>
      <li><a href="/contact/"<?php echo ariaCurrent('contact'); ?>>Contact</a></li>
<?php endif; ?>
    </ul>
    <div class="mobile-menu-cta">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 20); ?>Call <?php echo esc($navPhoneText); ?></a>
      <a class="btn btn-outline-white btn-lg" href="<?php echo esc($navCtaHref); ?>" data-open-estimate>Get an Estimate</a>
    </div>
  </nav>
</div>

<main id="main-content">
