<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /privacy-policy/ — Privacy Policy (Phase 5, legal-compliance.md privacy template adapted to this build).
 * What this page describes is what the site actually does: forms post to the Page One leads endpoint (not Formsubmit),
 * a first-party attribution cookie (p1_ft, includes/attribution.php) is set on the first pageview, fonts are self-hosted,
 * and Google Analytics is loaded only once a measurement ID is set in config.php. Update this page if any of that changes.
 * Footer "Do Not Sell or Share My Personal Information" links to #ccpa-rights below.
 */
$companyName       = $siteName;
$companyEntityType = 'Limited Liability Company';
$companyState      = 'Maryland';   // state of operation from the business address; state of formation was not collected at intake
$companyEmail      = $email;
$companyPhone      = formatPhone($phone);
$companyPhoneE164  = $phoneRaw;
$companyAddress    = $address['street'] . ', ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
$lastUpdated       = 'October 21, 2026';

$pageTitle       = 'Privacy Policy | All Connected Electric | Hagerstown, MD';
$pageDescription = 'How All Connected Electric LLC in Hagerstown, MD collects, uses and protects your information on this website and its contact forms. Read your privacy rights.';
$canonicalUrl    = $siteUrl . '/privacy-policy/';
$ogImage         = '';
$currentPage     = 'privacy-policy';
$pageType        = 'other';
$heroPreload     = [];

$schemaMarkup = [
    ['@type' => 'WebPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => $pageTitle, 'description' => $pageDescription,
     'dateModified' => '2026-10-21', 'isPartOf' => ['@id' => rtrim($siteUrl, '/') . '/#website']],
    generateBreadcrumbSchema([
        ['name' => 'Home',           'url' => $siteUrl . '/'],
        ['name' => 'Privacy Policy', 'url' => $canonicalUrl],
    ]),
];

$legalTitle = 'Privacy Policy';
$legalLede  = 'What ' . $siteName . ' collects when you use this website or send a request, why, and what you can do about it.';
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

<section class="legal-section" aria-label="Privacy Policy text">
  <div class="container">
    <article class="legal-prose content-narrow">

      <nav class="legal-toc" aria-label="On this page">
        <p>On this page</p>
        <ol>
          <li><a href="#introduction">Introduction</a></li>
          <li><a href="#information-we-collect">Information we collect</a></li>
          <li><a href="#how-we-use">How we use your information</a></li>
          <li><a href="#how-we-share">How we share your information</a></li>
          <li><a href="#your-rights">Your privacy rights</a></li>
          <li><a href="#sms-and-phone">Phone, text and email</a></li>
          <li><a href="#cookies">Cookies and analytics</a></li>
          <li><a href="#retention">Data retention</a></li>
          <li><a href="#security">Data security</a></li>
          <li><a href="#children">Children's privacy</a></li>
          <li><a href="#third-party-links">Third-party links</a></li>
          <li><a href="#changes">Changes to this policy</a></li>
          <li><a href="#contact">Contact us</a></li>
        </ol>
      </nav>

      <h2 id="introduction">1. Introduction</h2>
      <p>This Privacy Policy explains how <?php echo esc($companyName); ?>, a <?php echo esc($companyState); ?> <?php echo esc($companyEntityType); ?> ("we", "us", "our"), collects, uses and protects personal information when you visit <?php echo esc($domain); ?> or ask us about electrical work. By using this website or sending us a request, you agree to the practices described here.</p>

      <h2 id="information-we-collect">2. Information we collect</h2>
      <ul>
        <li><strong>Information you give us:</strong> your name, phone number, email address, the town or ZIP code of the job, the service you are asking about and anything you type in the message box, whether through our request forms, by phone, by email or in person.</li>
        <li><strong>Your consent choices:</strong> which consent boxes you checked on a form, the version of the consent wording shown, and the page you were on. We keep this so we can show what you agreed to.</li>
        <li><strong>Information collected automatically:</strong> your IP address, browser and device type, the pages you view, the page that referred you, and the time of your visit. This comes from our web server and, once enabled, from Google Analytics 4.</li>
        <li><strong>Where you came from:</strong> on your first page view we note the page you landed on, the site or ad that sent you (including campaign tags in the link), a random session number and whether you are on a phone, tablet or computer. We store this in a first-party cookie for up to 30 days and attach it to any request you send, so we know which page earned the inquiry.</li>
        <li><strong>Cookies and similar technologies:</strong> see section 7 and our <a href="/cookie-policy/">Cookie Policy</a>.</li>
      </ul>

      <h2 id="how-we-use">3. How we use your information</h2>
      <ul>
        <li>To answer your request, give you an estimate and schedule a visit</li>
        <li>To perform electrical work you hire us for and to communicate with you while we do</li>
        <li>To call, text or email you where you have given consent (section 6)</li>
        <li>To understand which pages and ads bring in inquiries, and to improve this website and our services</li>
        <li>To keep records of consent and prevent spam or misuse of our forms</li>
        <li>To meet legal obligations such as licensing, permitting, insurance, tax and warranty records</li>
      </ul>

      <h2 id="how-we-share">4. How we share your information</h2>
      <p>We do <strong>not</strong> sell your personal information, and we do not share it with third parties for their own marketing. We share it only as follows:</p>
      <ul>
        <li><strong>Page One Insights, LLC</strong>, the company that designs and hosts this website. Its lead-management system receives the requests submitted through our forms, stores them, filters spam and emails them to us, and Page One Insights receives a copy of each submission for lead tracking and customer service.</li>
        <li><strong>Website hosting and email providers</strong> that store or deliver the information above on our behalf.</li>
        <li><strong>Google</strong>, if you use a Google link on our site such as directions, or through Google Analytics once enabled (see section 7).</li>
        <li><strong>Permit offices, inspectors and utilities</strong>, such as the City of Hagerstown, Washington County or the electric utility, when a job needs a permit, an inspection or a service connection, limited to what that work requires.</li>
        <li><strong>Suppliers and subcontractors</strong>, only as needed to complete your project.</li>
        <li><strong>Legal and safety reasons:</strong> where <?php echo esc($companyState); ?> or federal law requires it, or to protect rights, property or safety.</li>
        <li><strong>Business transfers:</strong> if the business or its assets are sold, merged or reorganized.</li>
      </ul>

      <h2 id="your-rights">5. Your privacy rights</h2>
      <h3 id="state-rights"><?php echo esc($companyState); ?> residents</h3>
      <p>You may ask us what personal information we hold about you, ask us to correct it, and ask us to delete it. Maryland has a consumer data privacy law, the Maryland Online Data Privacy Act, that applies to larger data-handling businesses; whether or not it applies to us, we honor these requests from <?php echo esc($companyState); ?> residents. Use the contact details in section 13.</p>

      <h3 id="ccpa-rights">California residents (CCPA / CPRA) and Do Not Sell or Share</h3>
      <p>If you are a California resident, you have these rights under the California Consumer Privacy Act and California Privacy Rights Act:</p>
      <ul>
        <li><strong>Right to know</strong> what personal information we collect, use and disclose.</li>
        <li><strong>Right to delete</strong> personal information we have collected from you, subject to legal exceptions.</li>
        <li><strong>Right to correct</strong> inaccurate personal information.</li>
        <li><strong>Right to opt out of sale or sharing.</strong> We do not sell or share personal information for cross-context behavioral advertising. You can still send an opt-out request and we will record it and confirm to you that it was honored.</li>
        <li><strong>Right to limit</strong> the use of sensitive personal information. We do not collect it for purposes that need limiting.</li>
        <li><strong>Right to non-discrimination.</strong> We will not deny you service or charge you a different price for using these rights.</li>
      </ul>
      <p><strong>How to use these rights:</strong> email <a href="mailto:<?php echo esc($companyEmail); ?>"><?php echo esc($companyEmail); ?></a> or call <a href="tel:<?php echo esc($companyPhoneE164); ?>"><?php echo esc($companyPhone); ?></a>. We may need to confirm your identity first, and we will respond within 45 days.</p>

      <h3>Residents of other states</h3>
      <p>Residents of Colorado, Connecticut, Virginia, Utah, Texas and other states with consumer privacy laws have similar rights. Contact us the same way to use them.</p>

      <h2 id="sms-and-phone">6. Phone, text and email communications</h2>
      <p>On our request forms, the consent boxes are separate and none is pre-checked. If you tick the SMS box, you agree to receive text messages from <?php echo esc($companyName); ?> at the number you gave, such as appointment reminders and service updates. Message frequency varies. Message and data rates may apply. Reply STOP at any time to unsubscribe, or HELP for help. Consent is not a condition of purchase. If you tick the email box, you agree to receive emails from us, and every email includes a way to unsubscribe or you can email <a href="mailto:<?php echo esc($companyEmail); ?>"><?php echo esc($companyEmail); ?></a>.</p>
      <p>We do not sell or share your mobile number or your text-message consent with third parties or affiliates for their marketing purposes. Sending a request does not require you to agree to marketing texts or emails; the box that is required is the one confirming you have read this Privacy Policy and our <a href="/terms/">Terms of Service</a>. We will contact you about your request using the phone number or email address you give us. You can ask us to stop calling you by telling us on a call or by emailing us.</p>

      <h2 id="cookies">7. Cookies and analytics</h2>
      <p>This website sets one first-party cookie, named <code>p1_ft</code>, on your first visit. It holds the attribution details described in section 2 for up to 30 days. The cookie banner records only that you dismissed it, in your browser's local storage. Our fonts are served from this website, not from Google Fonts. When Google Analytics 4 is switched on, it sets its own cookies (beginning <code>_ga</code>) to measure traffic. Details and how to opt out are in the <a href="/cookie-policy/">Cookie Policy</a>.</p>

      <h2 id="retention">8. Data retention</h2>
      <p>We keep request-form records and customer records for as long as we need them to respond to you, perform and warranty work, and meet business, tax and legal record-keeping requirements. When we no longer need information, we delete it or remove what identifies you.</p>

      <h2 id="security">9. Data security</h2>
      <p>Our forms are sent over an encrypted (HTTPS) connection, and we use reasonable administrative, technical and physical safeguards on the systems that hold your information. No system is completely secure, so we cannot guarantee absolute security, but we work to limit the risk.</p>

      <h2 id="children">10. Children's privacy</h2>
      <p>This website is not directed to children under 13, and we do not knowingly collect information from them. If you believe a child has given us information, contact us and we will delete it.</p>

      <h2 id="third-party-links">11. Third-party links</h2>
      <p>This website links to other sites, such as Google Maps and our Google Business Profile. We are not responsible for their privacy practices. Read their policies before you give them information.</p>

      <h2 id="changes">12. Changes to this policy</h2>
      <p>We may update this Privacy Policy. The "Last Updated" date at the top shows the most recent change, and we will post material changes on this page.</p>

      <h2 id="contact">13. Contact us</h2>
      <p>For privacy questions or to use your rights:</p>
      <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/legal-contact.php'; ?>

    </article>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
