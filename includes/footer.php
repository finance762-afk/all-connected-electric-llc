<?php
/**
 * includes/footer.php — closes <main>; footer (brand, services, areas, contact, AEO entity block, legal row, credit,
 * partner badge), back-to-top, mobile CTA bar, cookie banner, estimate dialog, scripts. Closes </body></html>.
 * Pages with their own full lead form (contact, thank-you) set $noEstimateDialog = true before this include.
 * Service pages set $dialogService = '<service name>' so the dialog's service select arrives preselected.
 * LINK INTEGRITY: page links render only when the page exists on disk; unbuilt services/areas print as plain text.
 * Shared-include rule: loop variables are prefixed ($footSvc, $footArea, $footLink).
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/p1-form-helpers.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/text-us.php';

$footPhone   = formatPhone($phone);
$footLogo    = siteLogo();
$footSub     = $tagline !== '' ? $tagline : $address['city'] . ', Maryland';
$footCtaHref = siteHas('/contact/') ? '/contact/' : 'tel:' . $phoneRaw;
$footStreet  = !empty($addressPublic) && !empty($address['street']) ? $address['street'] : '';
$footCityLine = $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
$footCompany = [];
foreach ([['/about/', 'About'], ['/faq/', 'FAQ'], ['/blog/', 'Blog'], ['/contact/', 'Contact']] as $footLink) {
    if (siteHas($footLink[0])) $footCompany[] = $footLink;
}
$footEntityServices = [];
foreach ($services as $footSvc) $footEntityServices[] = strtolower($footSvc['name']);
?>
</main>

<footer class="site-footer">
  <div class="footer-top">
    <div class="container">
      <div class="footer-grid">

        <div class="footer-col footer-brand">
          <a class="brand site-logo footer-logo" href="/" aria-label="<?php echo esc($siteName); ?> — home">
<?php if ($footLogo): ?>
            <img src="<?php echo esc($footLogo['src']); ?>" alt="<?php echo esc($siteName); ?>" width="<?php echo (int) $footLogo['width']; ?>" height="<?php echo (int) $footLogo['height']; ?>" loading="lazy" decoding="async">
<?php else: ?>
            <span class="logo-mark" aria-hidden="true"><?php echo boltMark(24); ?></span>
            <span class="logo-text">
              <span class="brand-name logo-name">All Connected Electric</span>
              <span class="brand-sub logo-tagline">LLC &middot; <?php echo esc($footSub); ?></span>
            </span>
<?php endif; ?>
          </a>
          <p><?php echo esc($siteName); ?> handles commercial, residential and industrial electrical work in <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?> and the surrounding area.</p>
          <div class="footer-badges">
            <span>Since <?php echo (int) $yearEstablished; ?></span>
            <span>Commercial</span>
            <span>Residential</span>
            <span>Industrial</span>
          </div>
        </div>

        <div class="footer-col">
          <h4>Services</h4>
          <ul>
<?php foreach ($services as $footSvc): $footSvcUrl = serviceUrl($footSvc['slug']); ?>
            <li><?php if ($footSvcUrl !== ''): ?><a href="<?php echo esc($footSvcUrl); ?>"><?php echo esc($footSvc['name']); ?></a><?php else: ?><span><?php echo esc($footSvc['name']); ?></span><?php endif; ?></li>
<?php endforeach; ?>
<?php if (siteHas('/services/')): ?>
            <li><a href="/services/">View all services</a></li>
<?php endif; ?>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Service Areas</h4>
          <ul>
<?php foreach ($serviceAreas as $footArea): $footAreaUrl = areaUrl($footArea['slug']); ?>
            <li><?php if ($footAreaUrl !== ''): ?><a href="<?php echo esc($footAreaUrl); ?>"><?php echo esc($footArea['name']); ?>, <?php echo esc($address['state']); ?></a><?php else: ?><span><?php echo esc($footArea['name']); ?>, <?php echo esc($address['state']); ?></span><?php endif; ?></li>
<?php endforeach; ?>
<?php if (siteHas('/service-areas/')): ?>
            <li><a href="/service-areas/">View all areas</a></li>
<?php endif; ?>
          </ul>
<?php if ($footCompany): ?>
          <h4 class="footer-col__subhead">Company</h4>
          <ul>
<?php foreach ($footCompany as $footLink): ?>
            <li><a href="<?php echo esc($footLink[0]); ?>"><?php echo esc($footLink[1]); ?></a></li>
<?php endforeach; ?>
          </ul>
<?php endif; ?>
        </div>

        <div class="footer-col">
          <h4>Contact</h4>
          <address class="footer-nap">
            <div><?php echo icon('phone', 18); ?><a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($footPhone); ?></a></div>
            <div><?php echo icon('mail', 18); ?><a href="mailto:<?php echo esc($email); ?>"><?php echo esc($email); ?></a></div>
            <div><?php echo icon('map-pin', 18); ?><span><?php if ($footStreet !== ''): ?><?php echo esc($footStreet); ?><br><?php endif; ?><?php echo esc($footCityLine); ?></span></div>
<?php if (is_string($businessHours) && $businessHours !== ''): ?>
            <div><?php echo icon('clock', 18); ?><span><?php echo esc($businessHours); ?></span></div>
<?php endif; ?>
          </address>
<?php if (!empty($socialLinks) && is_array($socialLinks)): ?>
          <ul class="footer-social" aria-label="Social media">
<?php foreach ($socialLinks as $footSocialName => $footSocialUrl):
    $footSocialLabel = is_string($footSocialName) ? ucfirst($footSocialName) : ucfirst(preg_replace('/^www\./', '', (string) parse_url($footSocialUrl, PHP_URL_HOST))); ?>
            <li><a href="<?php echo esc($footSocialUrl); ?>" target="_blank" rel="noopener"><?php echo esc($footSocialLabel); ?></a></li>
<?php endforeach; ?>
          </ul>
<?php endif; ?>
          <p><a class="btn btn-accent" href="<?php echo esc($footCtaHref); ?>" data-open-estimate>Get an Estimate</a></p>
        </div>

      </div>

      <!-- AEO entity block: consistent NAP + a plain-language statement of who, what, where -->
      <div class="footer-entity aeo-entity" itemscope itemtype="https://schema.org/Electrician" itemid="<?php echo esc(rtrim($siteUrl, '/')); ?>/#organization">
        <meta itemprop="name" content="<?php echo esc($siteName); ?>">
        <meta itemprop="url" content="<?php echo esc(rtrim($siteUrl, '/')); ?>/">
        <meta itemprop="telephone" content="<?php echo esc($phoneRaw); ?>">
        <p><strong><?php echo esc($siteName); ?></strong> is an electrician in <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?>, serving <?php echo esc($address['city']); ?> and the surrounding area since <?php echo (int) $yearEstablished; ?>. Services: <?php echo esc(implode(', ', $footEntityServices)); ?>. Call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc($footPhone); ?></a>.</p>
      </div>
    </div>
  </div>

  <div class="footer-bottom-bar footer-bottom">
    <div class="container">
      <div class="footer-legal-row" role="navigation" aria-label="Legal">
        <a href="/privacy-policy/">Privacy Policy</a>
        <span class="divider">|</span>
        <a href="/terms/">Terms of Service</a>
        <span class="divider">|</span>
        <a href="/cookie-policy/">Cookie Policy</a>
        <span class="divider">|</span>
        <a href="/accessibility/">Accessibility</a>
        <span class="divider">|</span>
        <a href="/privacy-policy/#ccpa-rights">Do Not Sell or Share My Personal Information</a>
        <span class="divider">|</span>
        <a href="/sitemap.xml">Sitemap</a>
      </div>
      <div class="footer-bottom-inner">
        <span class="footer-copy">&copy; <?php echo date('Y'); ?> <?php echo esc($siteName); ?>. All rights reserved.</span>
        <span class="footer-credit"><a href="https://pageoneinsights.com" rel="dofollow" target="_blank">Web Design & Hosting by Page One Insights, LLC</a></span>
      </div>
    </div>
  </div>
  <?php include __DIR__ . '/partner-badge.php'; ?>
</footer>

<button type="button" class="back-to-top" aria-label="Back to top"><svg aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg></button>

<!-- Mobile sticky CTA bar (≤760px, appears once the hero scrolls away) -->
<div class="mobile-cta-bar" role="region" aria-label="Quick contact">
  <a class="mobile-cta-bar__call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call Now</a>
  <a class="mobile-cta-bar__estimate" href="<?php echo esc($footCtaHref); ?>" data-open-estimate>Get an Estimate</a>
</div>

<?php echo p1_text_us(); ?>

<!-- Cookie banner: dismissed via main.js + localStorage; sits above the mobile bar -->
<div class="cookie-banner" id="cookie-banner" role="region" aria-label="Cookie notice">
  <p class="cookie-banner__text">We use cookies to improve your experience and analyze site usage. <a href="/cookie-policy/">Learn more</a>.</p>
  <button type="button" class="cookie-banner__dismiss" aria-label="Dismiss cookie notice">Got it</button>
</div>

<?php if (empty($noEstimateDialog)): ?>
<dialog id="estimate-dialog" class="estimate-dialog" aria-labelledby="estimate-dialog-title">
  <div class="dialog-head">
    <h2 id="estimate-dialog-title">Need an estimate?</h2>
    <button type="button" class="dialog-close" data-close-estimate aria-label="Close estimate form"><?php echo icon('x', 20); ?></button>
  </div>
  <div class="dialog-body">
    <p class="form-disclaimer">Tell <?php echo esc($siteName); ?> what you need and we will follow up by phone or email.</p>
    <form class="estimate-form" action="<?php echo esc($formAction); ?>" method="POST">
      <?php echo p1_lead_hidden_fields('dialog'); ?>
      <div class="form-grid">
        <div class="field"><label for="dialog-name">Your name *</label><input id="dialog-name" type="text" name="name" autocomplete="name" required></div>
        <div class="field"><label for="dialog-phone">Phone *</label><input id="dialog-phone" type="tel" name="phone" autocomplete="tel" inputmode="tel" required></div>
        <div class="field full"><label for="dialog-email">Email *</label><input id="dialog-email" type="email" name="email" autocomplete="email" required></div>
        <div class="field full"><label for="dialog-service">Service needed</label><select id="dialog-service" name="service"><?php echo p1_service_options($dialogService ?? ''); ?></select></div>
        <div class="field full"><label for="dialog-message">Project details</label><textarea id="dialog-message" name="message" rows="3"></textarea></div>
      </div>
      <label class="consent" for="dialog-email-opt-in">
        <input id="dialog-email-opt-in" type="checkbox" name="email_opt_in" value="yes">
        <span><strong>Email updates (optional):</strong> I agree to receive emails from <?php echo esc($siteName); ?> about my inquiry and services. I can unsubscribe at any time.</span>
      </label>
      <label class="consent" for="dialog-sms-opt-in">
        <input id="dialog-sms-opt-in" type="checkbox" name="sms_opt_in" value="yes">
        <span><strong>Text messages (optional):</strong> I agree to receive text messages from <?php echo esc($siteName); ?> at the number I provided. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe, HELP for help. Consent is not a condition of purchase.</span>
      </label>
      <?php echo p1_consent_row('dialog'); ?>
      <button type="submit" class="btn btn-accent btn-block btn-lg">Send My Request</button>
    </form>
  </div>
</dialog>
<?php endif; ?>

<script src="/assets/js/main.js?v=<?php echo esc($cssVersion); ?>" defer></script>
<script src="/assets/js/animations.js?v=<?php echo esc($cssVersion); ?>" defer></script>
<script src="/assets/js/effects.js?v=<?php echo esc($cssVersion); ?>" defer></script>
</body>
</html>
