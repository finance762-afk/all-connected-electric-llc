<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /cookie-policy/ — Cookie Policy (Phase 5, legal-compliance.md cookie template adapted to what this build really sets).
 * Real inventory: p1_ft (first-party attribution cookie, includes/attribution.php, 30 days, HttpOnly, SameSite=Lax);
 * cookieBannerDismissed_v1 (localStorage flag from main.js); Google Analytics 4 cookies only once $googleAnalyticsId is set
 * in config.php; NO Google Fonts (fonts are self-hosted) and no ad or social-pixel cookies. Update if any of that changes.
 */
$companyName       = $siteName;
$companyEntityType = 'Limited Liability Company';
$companyState      = 'Maryland';
$companyEmail      = $email;
$companyPhone      = formatPhone($phone);
$companyPhoneE164  = $phoneRaw;
$companyAddress    = $address['street'] . ', ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
$lastUpdated       = 'October 21, 2026';

$pageTitle       = 'Cookie Policy | All Connected Electric | Hagerstown, MD';
$pageDescription = 'The cookies and browser storage used on the All Connected Electric LLC website in Hagerstown, MD, what each one does, and how you can control or block them.';
$canonicalUrl    = $siteUrl . '/cookie-policy/';
$ogImage         = '';
$currentPage     = 'cookie-policy';
$pageType        = 'other';
$heroPreload     = [];

$schemaMarkup = [
    ['@type' => 'WebPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => $pageTitle, 'description' => $pageDescription,
     'dateModified' => '2026-10-21', 'isPartOf' => ['@id' => rtrim($siteUrl, '/') . '/#website']],
    generateBreadcrumbSchema([
        ['name' => 'Home',          'url' => $siteUrl . '/'],
        ['name' => 'Cookie Policy', 'url' => $canonicalUrl],
    ]),
];

$legalTitle = 'Cookie Policy';
$legalLede  = 'The small files and browser storage this website uses, what each does, and how to turn them off.';
$legalUpdated = $lastUpdated;
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php $legalEyebrow = $legalEyebrow ?? 'Legal'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-page.css'; ?></style>

<section class="hero hero--legal" aria-labelledby="legal-hero-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page"><?php echo esc($legalTitle); ?></span></li>
      </ol>
    </nav>
    <span class="eyebrow"><?php echo esc($legalEyebrow); ?></span>
    <h1 id="legal-hero-title"><?php echo esc($legalTitle); ?></h1>
    <p class="legal-lede"><?php echo esc($legalLede); ?></p>
    <p class="legal-updated">Last Updated: <time datetime="<?php echo esc(date('Y-m-d', strtotime($legalUpdated))); ?>"><?php echo esc($legalUpdated); ?></time></p>
  </div>
</section>

<section class="legal-section" aria-label="Cookie Policy text">
  <div class="container">
    <article class="legal-prose content-narrow">

      <h2 id="what-are-cookies">1. What are cookies?</h2>
      <p>Cookies are small text files a website stores on your device. They make a site work, remember a choice, or tell the site owner how visitors use it. Browser storage, such as "local storage", does a similar job. This policy covers both on <?php echo esc($domain); ?>, which is operated by <?php echo esc($companyName); ?>.</p>

      <h2 id="what-we-use">2. What we use</h2>
      <div class="legal-table-wrap">
        <table>
          <caption class="sr-only">Cookies and browser storage used on this website</caption>
          <thead><tr><th scope="col">Name</th><th scope="col">Type</th><th scope="col">What it does</th><th scope="col">How long</th></tr></thead>
          <tbody>
            <tr><th scope="row"><code>p1_ft</code></th><td>First-party cookie</td><td>Records your first page on the site, the site or ad that sent you, campaign tags in the link, a random session number and whether you are on a phone, tablet or computer, so a request you send can be tied to the page that earned it.</td><td>30 days</td></tr>
            <tr><th scope="row"><code>cookieBannerDismissed_v1</code></th><td>Local storage</td><td>Remembers that you closed the cookie notice so it does not appear again.</td><td>Until you clear site data</td></tr>
            <tr><th scope="row"><code>_ga</code>, <code>_ga_*</code></th><td>Analytics cookies (Google Analytics 4)</td><td>Count visits and show which pages are viewed. Set only when Google Analytics is switched on for this site.</td><td>Up to 2 years</td></tr>
          </tbody>
        </table>
      </div>

      <h3>Strictly necessary</h3>
      <p>The <code>p1_ft</code> cookie and the notice flag keep the site's request forms and cookie notice working properly. They do not show you ads and are not shared for advertising.</p>

      <h3>Analytics (Google Analytics 4)</h3>
      <p>When Google Analytics 4 is enabled, Google receives your IP address, device and browser details and the pages you view, so we can see how people use the site. We use this to improve the site, not to identify you personally.</p>

      <h3>What we do not use</h3>
      <p>This website does not load Google Fonts (our fonts are served from the site itself), and it does not set advertising or social-media tracking cookies.</p>

      <h3>Third-party content</h3>
      <p>Some pages link to Google Maps or our Google Business Profile, and the Contact page may show an embedded Google map. Google may set its own cookies when you open or load those, under Google's privacy policy.</p>

      <h2 id="control">3. How to control cookies</h2>
      <p>Most browsers let you see, delete and block cookies, either for all sites or for particular ones. Instructions are available from Google, Mozilla, Apple and Microsoft for their browsers. If you block all cookies, parts of this site may not work as intended, though you can still call <a href="tel:<?php echo esc($companyPhoneE164); ?>"><?php echo esc($companyPhone); ?></a> or email <a href="mailto:<?php echo esc($companyEmail); ?>"><?php echo esc($companyEmail); ?></a> to reach us.</p>

      <h2 id="analytics-opt-out">4. Opting out of Google Analytics</h2>
      <p>You can stop Google Analytics from measuring your visits on any website by installing Google's Analytics Opt-out Browser Add-on, available at <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener">tools.google.com/dlpage/gaoptout</a>.</p>

      <h2 id="cookie-notice">5. Our cookie notice</h2>
      <p>We show a short notice about cookies on your first visit. When you close it, we save that choice in your browser's local storage and do not show it again. Clearing your browser's site data brings the notice back.</p>

      <h2 id="changes">6. Changes to this policy</h2>
      <p>We may update this Cookie Policy as the site changes. The "Last Updated" date at the top shows the latest version. See also our <a href="/privacy-policy/">Privacy Policy</a>.</p>

      <h2 id="contact">7. Contact us</h2>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-contact.php'; ?>

    </article>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
