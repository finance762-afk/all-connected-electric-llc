<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /accessibility/ — Accessibility Statement (Phase 5, legal-compliance.md accessibility template).
 * The features listed are the ones the scaffold ships (skip link, landmarks, focus ring, reduced-motion CSS, labelled
 * fields, aria-expanded on the menu toggle, aria-current on the nav). Conformance is stated as PARTIAL, as the template
 * does, until a full audit has been run. There are no content photos on the site yet, so alt text is described as a practice.
 */
$companyName       = $siteName;
$companyEntityType = 'Limited Liability Company';
$companyState      = 'Maryland';
$companyEmail      = $email;
$companyPhone      = formatPhone($phone);
$companyPhoneE164  = $phoneRaw;
$companyAddress    = $address['street'] . ', ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
$lastUpdated       = 'October 21, 2026';

$pageTitle       = 'Accessibility Statement | ' . $siteName;
$pageDescription = $siteName . ' aims for WCAG 2.1 Level AA on this website. Read its accessibility features, known gaps and how to report a barrier.';
$canonicalUrl    = $siteUrl . '/accessibility/';
$ogImage         = '';
$currentPage     = 'accessibility';
$pageType        = 'other';
$heroPreload     = [];

$schemaMarkup = [
    ['@type' => 'WebPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => $pageTitle, 'description' => $pageDescription,
     'dateModified' => '2026-10-21', 'isPartOf' => ['@id' => rtrim($siteUrl, '/') . '/#website']],
    generateBreadcrumbSchema([
        ['name' => 'Home',                    'url' => $siteUrl . '/'],
        ['name' => 'Accessibility Statement', 'url' => $canonicalUrl],
    ]),
];

$legalTitle = 'Accessibility Statement';
$legalLede  = 'Our goal is a website everyone can use, and a phone number to call when it falls short.';
$legalUpdated = $lastUpdated;
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-hero.php'; ?>

<section class="legal-section" aria-label="Accessibility Statement text">
  <div class="container">
    <article class="legal-prose content-narrow">

      <h2 id="commitment">1. Our commitment</h2>
      <p><?php echo esc($companyName); ?> is committed to making <?php echo esc($domain); ?> usable by people with disabilities. We keep improving the experience for everyone and apply accessibility standards as we build and update the site.</p>

      <h2 id="conformance">2. Conformance status</h2>
      <p>This website is designed to meet the Web Content Accessibility Guidelines (WCAG) 2.1 at Level AA. We believe it partially conforms with that standard, which means some content does not yet fully meet it. We are working to close the gaps we know about.</p>

      <h2 id="features">3. Accessibility features</h2>
      <ul>
        <li>A "Skip to main content" link at the top of every page</li>
        <li>Page structure with landmark regions: header, navigation, main content and footer</li>
        <li>Visible keyboard focus outlines on links, buttons and form fields</li>
        <li>Menus and dialogs that work with a keyboard, and a mobile menu button that reports whether it is open or closed to screen readers</li>
        <li>The current page marked in the navigation for assistive technology</li>
        <li>Text alternatives for meaningful images</li>
        <li>Text and button colors chosen for sufficient contrast</li>
        <li>Form fields with labels attached to them, and consent choices written out in full sentences next to their checkboxes</li>
        <li>A layout that adapts to phone, tablet and desktop screens and to zoomed text</li>
        <li>Motion and animation turned off for visitors whose device is set to reduce motion</li>
      </ul>

      <h2 id="known-issues">4. Known issues</h2>
      <p>We know of these areas that need attention:</p>
      <ul>
        <li>Content from other companies, such as an embedded Google map, may not fully meet WCAG. The same information is available by phone and email, and the office address is written out on the Contact page.</li>
        <li>We have not yet completed a full third-party accessibility audit of the site.</li>
      </ul>

      <h2 id="feedback">5. Feedback and reporting a barrier</h2>
      <p>If something on this website is hard for you to use, please tell us which page it is on and what happened. We aim to reply within 5 business days and to fix what we can. You can email <a href="mailto:<?php echo esc($companyEmail); ?>"><?php echo esc($companyEmail); ?></a> or call <a href="tel:<?php echo esc($companyPhoneE164); ?>"><?php echo esc($companyPhone); ?></a>.</p>

      <h2 id="alternatives">6. Other ways to reach us</h2>
      <p>If the website does not work for you, you can reach us by phone, email or mail at the address below. We will provide information about our services in another format on request.</p>

      <h2 id="changes">7. Changes to this statement</h2>
      <p>We review this statement as the site changes. The "Last Updated" date at the top shows the latest version.</p>

      <h2 id="contact">8. Contact us</h2>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-contact.php'; ?>

    </article>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
