<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /contact/ — full lead form + office details (Phase 5).
 * The form posts to the Page One leads endpoint ($formAction = build-plan form_action, verbatim). Contact keeps the FULL form
 * (v6.3 placement rule): three separate, unbundled, never-pre-checked consent checkboxes (email opt-in, SMS opt-in,
 * required terms acceptance). The estimate dialog is turned off here ($noEstimateDialog) because this page has its own form.
 * Hours come from config.php $businessHours (build-plan business_hours). The map renders from $gbpMapEmbed (build-plan gbp
 * map_embed_url, or a pasted iframe snippet); without it a directions card shows.
 */
$pageTitle       = 'Contact All Connected Electric LLC | Hagerstown, MD';
$pageDescription = 'Call (301) 704-6333 or send a request to All Connected Electric LLC on Leitersburg Pike in Hagerstown, MD, for home, business and industrial electrical work.';
$canonicalUrl    = $siteUrl . '/contact/';
$ogImage         = '';
$currentPage     = 'contact';
$pageType        = 'contact';
$heroPreload     = [];
$noEstimateDialog = true;

$contactReady = [
    ['icon' => 'map-pin',        'title' => 'Where the job is',          'text' => 'The street address or at least the town and ZIP. Permit rules differ between the City of Hagerstown and unincorporated Washington County.'],
    ['icon' => 'clipboard-list', 'title' => 'What you are seeing',       'text' => 'Which breaker trips, which outlet is dead, what you want to add. A sentence or two is enough.'],
    ['icon' => 'zap',            'title' => 'The panel, if you can see it','text' => 'The number on the main breaker, the brand on the label and how many open slots are left. A phone photo of the open door works too.'],
    ['icon' => 'calendar-check', 'title' => 'When it needs to happen',   'text' => 'A fixed date, a deadline from an inspector, or no rush. It helps to know before a time is set.'],
];

// Map source: accept either a bare URL or a pasted <iframe> snippet; only https Google Maps sources are rendered.
$contactMapSrc = '';
if (!empty($gbpMapEmbed)) {
    $contactMapSrc = preg_match('/src="([^"]+)"/i', (string) $gbpMapEmbed, $contactMapMatch) ? $contactMapMatch[1] : trim((string) $gbpMapEmbed);
    if (!preg_match('#^https://(www\.|maps\.)?google\.[a-z.]+/maps[/?]#i', $contactMapSrc)) $contactMapSrc = '';
}

$schemaMarkup = [
    ['@type' => 'ContactPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => $pageTitle, 'description' => $pageDescription,
     'about' => ['@id' => rtrim($siteUrl, '/') . '/#organization'], 'isPartOf' => ['@id' => rtrim($siteUrl, '/') . '/#website'],
     'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer']]],
    generateBreadcrumbSchema([
        ['name' => 'Home',    'url' => $siteUrl . '/'],
        ['name' => 'Contact', 'url' => $canonicalUrl],
    ]),
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   Contact — page-specific: the form "work order" card (signature section), the office details column, the ready-list.
   Tokens only.
   ========================================================================== */
.ct-hero .hero-copy { max-width: 62ch; }
.ct-main__grid { display: grid; grid-template-columns: minmax(0, 1.25fr) minmax(0, .85fr); gap: clamp(2rem, 5vw, 4rem); align-items: start; }
.ct-form { position: relative; padding: var(--space-xl) var(--space-xl) var(--space-lg); border-radius: var(--radius-lg); background: var(--color-surface); border: 1px solid var(--color-line); box-shadow: var(--shadow-lg); }
.ct-form::before { content: ""; position: absolute; inset: 0 0 auto 0; height: var(--space-1); border-radius: var(--radius-lg) var(--radius-lg) 0 0; background: var(--color-accent); }
.ct-form h2 { font-size: var(--fs-h2); margin-bottom: var(--space-xs); }
.ct-form__lede { margin: 0 0 var(--space-lg); color: var(--color-ink-2); max-width: 54ch; }
.ct-form .form-grid { margin-bottom: var(--space-md); }
.ct-form .form-consent-fieldset { margin: var(--space-md) 0 0; padding: var(--space-md) var(--space-md) var(--space-xs); border: 1px solid var(--color-line); border-radius: var(--radius); background: var(--color-paper); }
.ct-form .form-consent-legend { padding-inline: var(--space-xs); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); }
.ct-form .form-consent-item { margin: 0 0 var(--space-sm); }
.ct-form .required-star { color: var(--color-danger); font-weight: 700; }
.ct-form .form-consent-item a { color: var(--color-ink); font-weight: 600; text-decoration: underline; text-decoration-color: var(--color-accent); text-decoration-thickness: 2px; text-underline-offset: 3px; }
.ct-form .btn { margin-top: var(--space-md); }
.ct-form__foot { margin: var(--space-sm) 0 0; font-size: var(--fs-small); color: var(--color-muted); }

.ct-aside { display: grid; gap: var(--space-md); position: sticky; top: calc(var(--nav-height) + var(--space-lg)); }
.ct-details { padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-primary); color: color-mix(in srgb, var(--color-white) 86%, transparent); box-shadow: var(--shadow); }
.ct-details h2 { font-size: var(--fs-h3); color: var(--color-white); margin-bottom: var(--space-sm); }
.ct-details .nap { margin-top: 0; gap: var(--space-sm); }
.ct-details .nap svg { color: var(--color-accent-bright); }
.ct-details .nap a { color: var(--color-white); text-decoration: underline; text-decoration-color: var(--color-accent); text-decoration-thickness: 2px; text-underline-offset: 3px; }
.ct-details .btn { margin-top: var(--space-md); }
.ct-ready { padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-card-tint-3); border: 1px solid var(--color-line); }
.ct-ready h2 { font-size: var(--fs-h3); margin-bottom: var(--space-sm); }
.ct-ready ul { display: grid; gap: var(--space-sm); margin: 0; padding: 0; list-style: none; }
.ct-ready li { display: grid; grid-template-columns: auto 1fr; gap: var(--space-xs) var(--space-sm); }
.ct-ready svg { color: var(--color-accent-dark); margin-top: var(--space-1); }
.ct-ready b { display: block; font-family: var(--font-heading); color: var(--color-ink); font-size: .95rem; }
.ct-ready span { color: var(--color-ink-2); font-size: .88rem; }

.ct-office__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr); gap: clamp(2rem, 5vw, 4rem); align-items: center; }
.ct-office .map-embed { box-shadow: var(--shadow-lg); border: 1px solid var(--color-line); }
.ct-office__card { display: grid; gap: var(--space-sm); padding: var(--space-xl); border-radius: var(--radius-lg); background: var(--color-surface); border: 1px solid var(--color-line); box-shadow: var(--shadow); }
.ct-office__card address { font-style: normal; font-family: var(--font-heading); font-size: var(--fs-h3); line-height: 1.3; color: var(--color-ink); }
.ct-office__card p { margin: 0; color: var(--color-ink-2); }
.ct-office__actions { display: flex; flex-wrap: wrap; gap: var(--space-sm); margin-top: var(--space-xs); }
@media (max-width: 900px) { .ct-main__grid, .ct-office__grid { grid-template-columns: 1fr; } .ct-aside { position: static; } .ct-form { padding: var(--space-lg) var(--space-md); } }
</style>

<!-- ============ 1. HERO (type-led, no form card: the full form is the next section) ============ -->
<section class="hero hero--interior sp-hero ct-hero" aria-labelledby="ct-hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">Contact</span></li>
      </ol>
    </nav>
    <div class="hero-copy">
      <span class="eyebrow">Contact &middot; <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?></span>
      <h1 class="hero-title" id="ct-hero-title">Contact <span class="text-accent">All Connected Electric LLC</span> in Hagerstown, MD</h1>
      <p class="hero-answer">Call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a>, email <a href="mailto:<?php echo esc($email); ?>"><?php echo esc($email); ?></a> or send the form below. <?php echo esc($siteName); ?> is at <?php echo esc($address['street']); ?>, <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?> <?php echo esc($address['zip']); ?>.</p>
      <div class="hero-actions">
        <a class="btn btn-primary btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
        <a class="link-call" href="#contact-form"><?php echo icon('send', 18); ?>or send the form</a>
      </div>
      <ul class="hero-chips">
        <li><?php echo icon('phone', 16); ?>Call</li>
        <li><?php echo icon('mail', 16); ?>Email</li>
        <li><?php echo icon('route', 16); ?>Directions</li>
      </ul>
    </div>
  </div>
</section>

<!-- ============ 2. FORM + OFFICE DETAILS ============ -->
<section class="section ct-main" aria-labelledby="contact-form-title">
  <div class="container">
    <div class="ct-main__grid">

      <div class="ct-form reveal-left" id="contact-form">
        <span class="eyebrow-label">Estimate request</span>
        <h2 id="contact-form-title">How do I get an estimate from All Connected Electric?</h2>
        <p class="ct-form__lede">Tell the office what you need and where the job is. Your request goes straight to <?php echo esc($siteName); ?>, which follows up by phone or email to set a time to look at the work.</p>

        <form action="<?php echo esc($formAction); ?>" method="POST" class="estimate-form">
          <?php echo p1_lead_hidden_fields('contact'); ?>
          <!-- Honeypot (bots fill it, people never see it) -->
          <input type="text" name="_honeypot" style="display:none" tabindex="-1" autocomplete="off" aria-hidden="true">
          <!-- Consent record: arrives with the lead -->
          <input type="hidden" name="_consent_version" value="v2.1">
          <input type="hidden" name="_consent_page" value="<?php echo esc($_SERVER['REQUEST_URI'] ?? '/contact/'); ?>">

          <div class="form-grid">
            <div class="field"><label for="contact-name">Your name *</label><input id="contact-name" type="text" name="name" autocomplete="name" required></div>
            <div class="field"><label for="contact-phone">Phone *</label><input id="contact-phone" type="tel" name="phone" autocomplete="tel" inputmode="tel" required></div>
            <div class="field full"><label for="contact-email">Email *</label><input id="contact-email" type="email" name="email" autocomplete="email" required></div>
            <div class="field full"><label for="contact-service">Service needed</label><select id="contact-service" name="service"><?php echo p1_service_options(); ?></select></div>
            <div class="field"><label for="contact-city">Town where the job is</label><input id="contact-city" type="text" name="address_city" autocomplete="address-level2"></div>
            <div class="field"><label for="contact-zip">ZIP code</label><input id="contact-zip" type="text" name="address_zip" autocomplete="postal-code" inputmode="numeric" maxlength="10"></div>
            <div class="field full"><label for="contact-message">What is going on?</label><textarea id="contact-message" name="message" rows="5" placeholder="For example: the breaker for the kitchen keeps tripping, the house was built in the 1960s"></textarea></div>
          </div>

          <fieldset class="form-consent-fieldset">
            <legend class="form-consent-legend">Communication consent</legend>
            <label class="form-consent-item" for="contact-email-opt-in">
              <input id="contact-email-opt-in" type="checkbox" name="email_opt_in" value="yes" class="consent-checkbox">
              <span class="consent-label"><strong>Email updates (optional):</strong> I agree to receive emails from <?php echo esc($siteName); ?> about my inquiry, services, promotions, and news. I understand I can unsubscribe anytime via the link in any email or by emailing <?php echo esc($email); ?>. Message frequency varies.</span>
            </label>
            <label class="form-consent-item" for="contact-sms-opt-in">
              <input id="contact-sms-opt-in" type="checkbox" name="sms_opt_in" value="yes" class="consent-checkbox">
              <span class="consent-label"><strong>SMS/Text messages (optional):</strong> I agree to receive text messages from <?php echo esc($siteName); ?> at the phone number I provided. Message types may include appointment reminders, service updates, and promotional offers. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe, HELP for help. <strong>Consent is not a condition of purchase.</strong></span>
            </label>
            <label class="form-consent-item form-consent-required" for="contact-terms">
              <input id="contact-terms" type="checkbox" name="terms_accepted" value="yes" class="consent-checkbox" required>
              <span class="consent-label">I have read and agree to the <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and <a href="/terms/" target="_blank" rel="noopener">Terms of Service</a>. <span class="required-star">*</span></span>
            </label>
          </fieldset>

          <button type="submit" class="btn btn-accent btn-lg btn-block">Send my request</button>
          <p class="ct-form__foot">Prefer to talk it through? Call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a>.</p>
        </form>
      </div>

      <aside class="ct-aside reveal-right" aria-label="Office details">
        <div class="ct-details">
          <h2>Reach the office</h2>
          <div class="nap">
            <div><?php echo icon('phone', 18); ?><a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a></div>
            <div><?php echo icon('mail', 18); ?><a href="mailto:<?php echo esc($email); ?>"><?php echo esc($email); ?></a></div>
            <div><?php echo icon('map-pin', 18); ?><span><?php echo esc($address['street']); ?><br><?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?> <?php echo esc($address['zip']); ?></span></div>
<?php if (is_string($businessHours) && $businessHours !== ''): ?>
            <div><?php echo icon('clock', 18); ?><span><?php echo esc($businessHours); ?></span></div>
<?php endif; ?>
          </div>
          <a class="btn btn-accent" href="<?php echo esc($directionsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('route', 18); ?>Get directions</a>
        </div>

        <div class="ct-ready">
          <h2>What helps the first call go faster</h2>
          <ul>
<?php foreach ($contactReady as $contactReadyItem): ?>
            <li><?php echo icon($contactReadyItem['icon'], 18); ?><div><b><?php echo esc($contactReadyItem['title']); ?></b><span><?php echo esc($contactReadyItem['text']); ?></span></div></li>
<?php endforeach; ?>
          </ul>
        </div>
      </aside>

    </div>
  </div>
</section>

<!-- ============ 3. FIND THE OFFICE ============ -->
<section class="section ct-office section--light" aria-labelledby="ct-office-title">
  <div class="container">
    <div class="ct-office__grid">
      <div class="reveal-left">
        <span class="eyebrow-label">Find the office</span>
        <h2 id="ct-office-title">Where is All Connected Electric LLC located?</h2>
        <p class="answer-block"><?php echo esc($siteName); ?> is at <?php echo esc($address['street']); ?> on Leitersburg Pike in <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?> <?php echo esc($address['zip']); ?>. The company serves <?php echo esc($address['city']); ?> and the surrounding area of Washington County. Call ahead before you stop by.</p>
      </div>
<?php if ($contactMapSrc !== ''): ?>
      <div class="map-embed reveal-right">
        <iframe src="<?php echo esc($contactMapSrc); ?>" title="Map showing the <?php echo esc($siteName); ?> office on Leitersburg Pike in Hagerstown, MD" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
      </div>
<?php else: ?>
      <div class="ct-office__card reveal-right">
        <span class="eyebrow-label">Office address</span>
        <address><?php echo esc($address['street']); ?><br><?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?> <?php echo esc($address['zip']); ?></address>
        <p>Open the route in Google Maps from wherever you are, or see the company's Google Business Profile.</p>
        <div class="ct-office__actions">
          <a class="btn btn-primary" href="<?php echo esc($directionsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('route', 18); ?>Get directions</a>
<?php if (!empty($gbpMapsUrl)): ?>
          <a class="btn btn-secondary" href="<?php echo esc($gbpMapsUrl); ?>" target="_blank" rel="noopener"><?php echo icon('external-link', 18); ?>View on Google</a>
<?php endif; ?>
        </div>
      </div>
<?php endif; ?>
    </div>
  </div>
</section>

<!-- ============ 4. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Call the office</span>
      <h2 id="sp-cta-title">Would you rather just call about your electrical work?</h2>
      <p>Call <a href="tel:<?php echo esc($phoneRaw); ?>"><?php echo esc(formatPhone($phone)); ?></a>, say what is going on and where. <?php echo esc($siteName); ?> will tell you what it would look at first.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc(formatPhone($phone)); ?></a>
      <a class="btn btn-outline-white btn-lg" href="mailto:<?php echo esc($email); ?>"><?php echo icon('mail', 18); ?>Email the office</a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
