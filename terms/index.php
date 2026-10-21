<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /terms/ — Terms of Service (Phase 5, legal-compliance.md terms template adapted to an electrical contractor).
 * Left out on purpose: the template's "Insurance Claim Work" clause (this trade does not do insurance work) and its
 * "all workers carry workers' comp / we are licensed and insured" sentences (not confirmed by the client — see
 * /content-confirmations.json). Deposit, cancellation and warranty specifics are deferred to the written contract.
 */
$companyName       = $siteName;
$companyEntityType = 'Limited Liability Company';
$companyState      = 'Maryland';   // governing law; state of formation was not collected at intake — confirm with the client
$companyCounty     = 'Washington County';
$companyEmail      = $email;
$companyPhone      = formatPhone($phone);
$companyPhoneE164  = $phoneRaw;
$companyAddress    = $address['street'] . ', ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
$lastUpdated       = 'October 21, 2026';

$pageTitle       = 'Terms of Service | ' . $siteName;
$pageDescription = 'The terms for using the ' . $siteName . ' website and for hiring the company for electrical work in Hagerstown, MD: estimates, payment and law.';
$canonicalUrl    = $siteUrl . '/terms/';
$ogImage         = '';
$currentPage     = 'terms';
$pageType        = 'other';
$heroPreload     = [];

$schemaMarkup = [
    ['@type' => 'WebPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => $pageTitle, 'description' => $pageDescription,
     'dateModified' => '2026-10-21', 'isPartOf' => ['@id' => rtrim($siteUrl, '/') . '/#website']],
    generateBreadcrumbSchema([
        ['name' => 'Home',             'url' => $siteUrl . '/'],
        ['name' => 'Terms of Service', 'url' => $canonicalUrl],
    ]),
];

$legalTitle = 'Terms of Service';
$legalLede  = 'The rules for using this website and for hiring ' . $siteName . ' for electrical work.';
$legalUpdated = $lastUpdated;
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-hero.php'; ?>

<section class="legal-section" aria-label="Terms of Service text">
  <div class="container">
    <article class="legal-prose content-narrow">

      <h2 id="agreement">1. Agreement to these terms</h2>
      <p>By using <?php echo esc($domain); ?> or hiring <?php echo esc($companyName); ?>, a <?php echo esc($companyState); ?> <?php echo esc($companyEntityType); ?> ("we", "us", "our"), you agree to these Terms of Service and to our <a href="/privacy-policy/">Privacy Policy</a>. If you do not agree, please do not use this website or our services.</p>

      <h2 id="website-use">2. Use of this website</h2>
      <ul>
        <li>You may use this website for personal, non-commercial purposes: to learn about our services and to contact us.</li>
        <li>You may not use it for anything unlawful, try to reach parts of our systems that are not public, copy or scrape its content without written permission, send false information through our forms, or use automated tools to pull data from it.</li>
        <li>Information on this website, including the guidance on warning signs, permits and code, is general information. It does not replace an electrician looking at your building, and it is not a quote.</li>
      </ul>

      <h2 id="estimates">3. Estimates and quotes</h2>
      <p>An estimate is based on the information you give us and the conditions we can see at the time. The price can change if the scope changes, if hidden conditions are found behind walls or in a panel, if material costs change before the work starts, or if the permit office or inspector requires something different from what was assumed. A verbal price is not binding. A written proposal or contract that both sides have accepted is the final agreement.</p>

      <h2 id="project-work">4. Project work</h2>
      <ul>
        <li>Each job is governed by a written estimate or contract that describes its scope and price.</li>
        <li>Electrical work is done to the electrical codes and permit requirements that apply at the job site, which differ between the City of Hagerstown and unincorporated Washington County.</li>
        <li>Where a job needs a permit or inspection, the contract states who arranges it. Work that fails inspection is corrected as the contract and the inspector require.</li>
        <li>You agree to give safe access to the work area, the panel and any equipment involved, and to tell us about hazards you know of, such as damaged wiring or previous unpermitted work.</li>
        <li>Some jobs, such as a service upgrade, involve the electric utility. The utility's schedule and rules are outside our control.</li>
      </ul>

      <h2 id="warranties">5. Warranties</h2>
      <p>Any workmanship warranty is stated in your contract. Manufacturer warranties on equipment such as panels, chargers, fixtures and generators come from those manufacturers and pass to you. Warranties do not cover damage from neglect, misuse, alteration by others, power surges or outages outside the equipment's ratings, or conditions that existed and were disclosed before the work.</p>

      <h2 id="payment">6. Payment</h2>
      <p>Payment terms, including any deposit, progress payments and the due date of the final balance, are set out in your contract. Past-due balances may carry interest to the extent <?php echo esc($companyState); ?> law allows.</p>

      <h2 id="cancellation">7. Cancellation</h2>
      <p>Cancellation terms are set out in your contract. In general, cancelling before materials are ordered or work begins costs less than cancelling afterward, and you owe payment for work already done and materials already ordered or installed.</p>

      <h2 id="liability">8. Limitation of liability</h2>
      <p>To the fullest extent <?php echo esc($companyState); ?> law allows, our total liability for any claim connected to this website or our services is limited to the amount you paid for the specific service that gave rise to the claim. We are not liable for indirect, incidental, special or consequential damages. Nothing in these terms limits liability that the law does not allow to be limited.</p>

      <h2 id="intellectual-property">9. Intellectual property</h2>
      <p>The text, graphics, photographs and logos on this website belong to <?php echo esc($companyName); ?> or are used with permission, and are protected by copyright. You may not reproduce, distribute or adapt them without written permission.</p>

      <h2 id="governing-law">10. Governing law and disputes</h2>
      <p>These terms are governed by the laws of the State of <?php echo esc($companyState); ?>, without regard to conflict-of-laws rules. Disputes will be heard in the state or federal courts that serve <?php echo esc($companyCounty); ?>, <?php echo esc($companyState); ?>.</p>

      <h2 id="changes">11. Changes to these terms</h2>
      <p>We may update these terms. The "Last Updated" date at the top shows the latest version, and using the website after an update means you accept the revised terms.</p>

      <h2 id="contact">12. Contact us</h2>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-contact.php'; ?>

    </article>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
