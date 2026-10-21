<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /faq/ — Electrician FAQ, All Connected Electric LLC (Phase 5). Directory + index.php so the canonical /faq/ URL resolves;
 * the footer ("Company" column) and mobile menu link here automatically because siteHas('/faq/') is now true.
 * 19 questions in four categories. The permit, panel, EV charger, cost and license answers follow the research brief; the rest
 * are general electrical-code knowledge or facts from config.php. Nothing answers for the company on: license number, insurance, free estimates, prices,
 * hours, callback time, towns beyond Hagerstown, brands or 24/7 service (all unconfirmed — see /content-confirmations.json).
 * FAQPage schema is an AI-comprehension aid only; FAQ rich results are deprecated.
 */
$pageTitle       = 'Electrician FAQ | Hagerstown, MD | All Connected Electric LLC';
$pageDescription = 'Answers about electrical permits, panel upgrades, EV chargers, generators, pricing and how a job runs in Hagerstown and Washington County, MD.';
$canonicalUrl    = $siteUrl . '/faq/';
$ogImage         = '';
$currentPage     = 'faq';
$pageType        = 'faq';
$heroPreload     = [];

$phoneText = formatPhone($phone);

/* Each item: q, a (plain text, also used in the FAQPage schema), optional link => [href, label]. */
$faqCategories = [
    [
        'id' => 'general', 'icon' => 'info', 'title' => 'General questions about All Connected Electric LLC',
        'intro' => 'Who the company is, who it works for and where, and how to check any electrician in Maryland.',
        'items' => [
            ['q' => 'Who is All Connected Electric LLC and where is it based?',
             'a' => $siteName . ' is an electrical contractor in Hagerstown, MD, owned by ' . $ownerName . ' and in business since ' . $yearEstablished . '. The office is at ' . $address['street'] . ', ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'] . ', and the phone number is ' . $phoneText . '.',
             'link' => ['/about/', 'About the company']],
            ['q' => 'Does All Connected Electric work on businesses and industrial sites, or only homes?',
             'a' => $siteName . ' works on all three: houses, commercial buildings such as offices and storefronts, and industrial sites such as warehouses and shops. The same company handles a kitchen circuit, a storefront lighting upgrade and a dedicated circuit for shop equipment in the Hagerstown area.',
             'link' => ['/services/', 'See all services']],
            ['q' => 'What area does All Connected Electric LLC serve?',
             'a' => $siteName . ' serves ' . $address['city'] . ', ' . $address['state'] . ' and the surrounding area of Washington County. If your property is outside Hagerstown, call ' . $phoneText . ' with the address and ask whether the office covers it.'],
            ['q' => 'Are your electricians licensed and insured?',
             'a' => 'Maryland requires electrical contractors to be licensed, so ask any electrician for the license number and look it up with the Maryland State Board of Master Electricians, part of the Maryland Department of Labor. Also ask for proof of general liability and workers\' compensation coverage. Ask ' . $siteName . ' for those details when you call, and have them before work starts.'],
            ['q' => 'How do I contact All Connected Electric LLC?',
             'a' => 'Call ' . $phoneText . ', email ' . $email . ', or send the request form on the contact page. Requests go to the Hagerstown office, which follows up by phone or email.',
             'link' => ['/contact/', 'Go to the contact page']],
        ],
    ],
    [
        'id' => 'services', 'icon' => 'zap', 'title' => 'Questions about electrical services',
        'intro' => 'Panels, EV chargers, rewiring, generators and what to do when something looks wrong.',
        'items' => [
            ['q' => 'What electrical services does All Connected Electric LLC offer?',
             'a' => $siteName . ' offers ' . count($services) . ' services: residential, commercial and industrial electrical work, panel upgrades, EV charger installation, lighting installation, wiring and rewiring, ceiling fan installation, generator installation, outlet and switch repair, and emergency electrician calls.',
             'link' => ['/services/', 'See all services']],
            ['q' => 'How do I know if my home needs an electrical panel upgrade?',
             'a' => 'Breakers that trip often, lights that dim when large appliances start, a panel that feels warm or buzzes, and outlets that stop working are the common signs. Adding an EV charger, a heat pump or an addition can also need more capacity. A load calculation by an electrician shows whether an upgrade is needed.',
             'slug' => 'panel-upgrades', 'label' => 'Panel upgrades in Hagerstown'],
            ['q' => 'Can an EV charger be installed in an older home?',
             'a' => 'In many cases, yes. The electrician first checks the panel\'s capacity and the condition of the wiring, then sizes a dedicated circuit for the charger. If the service is too small, a panel or service upgrade may be needed before the charger goes in. A permit and inspection are usually required.',
             'slug' => 'ev-charger-installation', 'label' => 'EV charger installation'],
            ['q' => 'How do I know if an older house needs rewiring?',
             'a' => 'Frequent tripped breakers, dead outlets, flickering lights, a burning smell and two-prong ungrounded outlets are the usual signs, and so is original cloth-covered wiring in a very old house. An inspection shows which circuits can stay and which should be replaced, so rewiring does not have to be all or nothing.',
             'slug' => 'wiring-rewiring', 'label' => 'Wiring and rewiring'],
            ['q' => 'What does a generator installation involve?',
             'a' => 'A standby generator is connected through a transfer switch, which keeps generator power and utility power from meeting on the same wires. The electrician sizes the circuits you want covered, installs the switch at the panel, and the job normally needs a permit and an inspection. A natural gas or propane unit also needs a gas line, which is separate work.',
             'slug' => 'generator-installation', 'label' => 'Generator installation'],
            ['q' => 'What should I do if an outlet is warm, scorched or buzzing, or I smell burning?',
             'a' => 'Stop using the outlet and, if you can reach the panel safely, turn off its breaker. If you see smoke or flames or the panel itself is hot, leave the building and call 911. Do not keep resetting a breaker that trips again. Then call an electrician, and ask ' . $siteName . ' what availability looks like at that moment.',
             'slug' => 'emergency-electrician', 'label' => 'Emergency electrician'],
        ],
    ],
    [
        'id' => 'pricing', 'icon' => 'clipboard-list', 'title' => 'Questions about electrician pricing',
        'intro' => 'What drives the price of electrical work, and what to ask before a visit is scheduled.',
        'items' => [
            ['q' => 'How much does it cost to hire an electrician in Hagerstown?',
             'a' => 'Cost depends on the scope of the work, the age of the building, the materials and whether a permit is needed. The reliable way to get a number is to have the job looked at. Call ' . $siteName . ' at ' . $phoneText . ' to describe the work and ask how pricing works for your job.'],
            ['q' => 'Should I ask about a service-call fee before booking an electrician?',
             'a' => 'Yes. Ask any electrician, including ' . $siteName . ', whether a service-call or diagnostic fee applies and whether it is credited toward the repair, before the visit is scheduled. It is the simplest way to avoid a surprise on the first bill.'],
            ['q' => 'What makes one panel upgrade or EV charger install cost more than another?',
             'a' => 'Scope. The main factors are the size of the service, the condition of the existing panel and wiring, how far the new circuit has to run from the panel, whether the meter base needs replacing, and the permit and inspection requirements. A look at the job turns those into a price.',
             'slug' => 'panel-upgrades', 'label' => 'How panel upgrades are scoped'],
            ['q' => 'How can I get an accurate price over the phone?',
             'a' => 'Give the office the address, what you want done, the age of the building and, for panel work, the number on the main breaker. Photos of the panel help. Many jobs still need a look in person, because the wiring behind the wall decides the price.',
             'link' => ['/contact/', 'Send the details']],
        ],
    ],
    [
        'id' => 'process', 'icon' => 'route', 'title' => 'Questions about permits and how a job runs',
        'intro' => 'What happens after you call, whether the work needs a permit, and what to expect on the day.',
        'items' => [
            ['q' => 'What happens after I call or send the request form?',
             'a' => 'The request goes to the Hagerstown office, not to a lead marketplace, and the office follows up by phone or email to ask about the job and where it is. For most jobs the electrician then needs to see the panel and wiring before giving a price.'],
            ['q' => 'Do I need a permit for electrical work in Hagerstown or Washington County?',
             'a' => 'Many electrical jobs need a permit and an inspection, including new circuits, service or panel upgrades, and most generator and EV charger installations. Requirements differ between the City of Hagerstown and unincorporated Washington County, so ask ' . $siteName . ' which rules apply to your address before the work is scheduled.'],
            ['q' => 'Will the power be off during the work?',
             'a' => 'For a panel replacement or service upgrade, yes: power to the building is off while the old panel comes out and the new one goes in, and a service upgrade usually involves Potomac Edison, the utility, disconnecting and reconnecting the service. For one circuit, outlet or fixture, only that circuit is turned off. Ask how long the outage will last so you can plan around it.'],
            ['q' => 'What should I check on my electrical panel before I call?',
             'a' => 'Five things make the first call faster: the number on the main breaker, the brand on the label, how many open slots are left, any breaker that is tripped or warm, and whether the panel still has its circuit list. A phone photo of the open panel door works just as well.',
             'slug' => 'panel-upgrades', 'label' => 'Panel upgrade checklist'],
        ],
    ],
];

// Resolve service links against what is built on disk; flatten for the schema and the count.
$faqFlat = [];
foreach ($faqCategories as $faqCatKey => $faqCat) {
    foreach ($faqCat['items'] as $faqItemKey => $faqItem) {
        if (!empty($faqItem['slug'])) {
            $faqUrl = serviceUrl($faqItem['slug']);
            $faqCategories[$faqCatKey]['items'][$faqItemKey]['link'] = $faqUrl !== '' ? [$faqUrl, $faqItem['label']] : null;
        } elseif (!empty($faqItem['link']) && !siteHas($faqItem['link'][0])) {
            $faqCategories[$faqCatKey]['items'][$faqItemKey]['link'] = null;
        }
        $faqFlat[] = ['q' => $faqItem['q'], 'a' => $faqItem['a']];
    }
}
$faqTotal = count($faqFlat);

$schemaMarkup = [
    ['@type' => 'WebPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => $pageTitle, 'description' => $pageDescription,
     'about' => ['@id' => rtrim($siteUrl, '/') . '/#organization'], 'isPartOf' => ['@id' => rtrim($siteUrl, '/') . '/#website'],
     'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer']]],
    generateBreadcrumbSchema([
        ['name' => 'Home', 'url' => $siteUrl . '/'],
        ['name' => 'FAQ',  'url' => $canonicalUrl],
    ]),
    generateFAQSchema($faqFlat),
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?></style>
<style>
/* ==========================================================================
   FAQ — page-specific: sticky category index beside the accordions (signature section). Tokens only.
   ========================================================================== */
.fq-hero .hero-copy { max-width: 64ch; }
.fq-layout { display: grid; grid-template-columns: minmax(0, 15rem) minmax(0, 1fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.fq-index { position: sticky; top: calc(var(--nav-height) + var(--space-lg)); display: grid; gap: var(--space-xs); padding: var(--space-lg); border: 1px solid var(--color-line); border-radius: var(--radius-lg); background: var(--color-surface); box-shadow: var(--shadow-sm); }
.fq-index p { margin: 0 0 var(--space-xs); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .16em; text-transform: uppercase; color: var(--color-muted); }
.fq-index ol { display: grid; gap: var(--space-1); margin: 0; padding: 0; list-style: none; counter-reset: fq; }
.fq-index li { counter-increment: fq; }
.fq-index ol a { display: grid; grid-template-columns: auto 1fr; gap: var(--space-xs); align-items: center; min-height: 44px; padding: 0 var(--space-xs); border-radius: var(--radius-sm); color: var(--color-ink-2); font-weight: 600; font-size: var(--fs-small); text-decoration: none; transition: background var(--transition), color var(--transition); }
.fq-index ol a::before { content: counter(fq, decimal-leading-zero); font-family: var(--font-accent); font-size: 1.05rem; color: var(--color-accent-dark); }
.fq-index ol a:hover { background: color-mix(in srgb, var(--color-accent) 14%, var(--color-surface)); color: var(--color-ink); }
.fq-index .fq-count { margin: var(--space-sm) 0 0; padding-top: var(--space-sm); border-top: 1px solid var(--color-line); font-size: var(--fs-small); letter-spacing: 0; text-transform: none; font-family: var(--font-body); }

.fq-cat { padding-block: 0; scroll-margin-top: calc(var(--nav-height) + var(--space-lg)); }
.fq-cat + .fq-cat { margin-top: var(--space-3xl); }
.fq-cat__head { display: grid; grid-template-columns: auto 1fr; gap: var(--space-xs) var(--space-md); align-items: center; margin-bottom: var(--space-md); }
.fq-cat__icon { display: grid; place-items: center; width: var(--space-12); height: var(--space-12); border-radius: var(--radius); background: var(--color-primary); color: var(--color-accent); }
.fq-cat__head h2 { font-size: var(--fs-h3); text-wrap: balance; }
.fq-cat__head p { grid-column: 1 / -1; margin: 0; color: var(--color-ink-2); max-width: 58ch; }
.fq-list .faq { padding-inline: var(--space-xs); transition: background var(--transition); }
.fq-list .faq[open] { background: color-mix(in srgb, var(--color-accent) 6%, var(--color-surface)); border-top-color: var(--color-accent); }
.fq-list .faq summary { text-wrap: balance; min-height: 44px; }
.fq-list .faq-answer { max-width: 66ch; }
.fq-list .faq-more { display: inline-flex; align-items: center; gap: var(--space-xs); margin: var(--space-xs) 0 0; font-weight: 600; font-size: var(--fs-small); color: var(--color-ink); text-decoration: underline; text-decoration-color: var(--color-accent); text-decoration-thickness: 2px; text-underline-offset: 3px; }
.fq-list .faq-more svg { color: var(--color-accent-dark); }
.fq-list .faq-answer a { color: var(--color-ink); font-weight: 600; text-decoration-color: var(--color-accent); text-decoration-thickness: 2px; text-underline-offset: 3px; }
@media (max-width: 900px) {
  .fq-layout { grid-template-columns: 1fr; }
  .fq-index { position: static; }
  .fq-index ol { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 520px) { .fq-index ol { grid-template-columns: 1fr; } }
</style>

<!-- ============ 1. HERO (type-led, no form: the mid-page band carries the lead form) ============ -->
<section class="hero hero--interior sp-hero fq-hero" aria-labelledby="fq-hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li><li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><span aria-current="page">FAQ</span></li>
      </ol>
    </nav>
    <div class="hero-copy">
      <span class="eyebrow">FAQ &middot; <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?></span>
      <h1 class="hero-title" id="fq-hero-title">Electrician <span class="text-accent">FAQ</span> for Hagerstown, MD</h1>
      <p class="hero-answer"><?php echo (int) $faqTotal; ?> answers from <?php echo esc($siteName); ?> on electrical permits, panel upgrades, EV chargers, generators, pricing and how a job runs in Hagerstown and Washington County.</p>
      <div class="hero-actions">
        <a class="btn btn-primary btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc($phoneText); ?></a>
        <a class="link-call" href="#estimate"><?php echo icon('send', 18); ?>or send your question</a>
      </div>
      <ul class="hero-chips">
        <li><?php echo icon('info', 16); ?>General</li>
        <li><?php echo icon('zap', 16); ?>Services</li>
        <li><?php echo icon('clipboard-list', 16); ?>Pricing and permits</li>
      </ul>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="fq-hero-title">

<?php foreach ($faqCategories as $faqCatIdx => $faqCat): ?>
<?php if ($faqCatIdx === 0): ?>
<!-- ============ 2. QUESTIONS: INDEX + FIRST CATEGORY ============ -->
<section class="section fq-body" aria-label="Frequently asked questions">
  <div class="container">
    <div class="fq-layout">
      <nav class="fq-index reveal-left" aria-label="FAQ categories">
        <p>Jump to</p>
        <ol>
<?php foreach ($faqCategories as $faqNavCat): ?>
          <li><a href="#<?php echo esc($faqNavCat['id']); ?>"><?php echo esc(ucfirst($faqNavCat['id'])); ?></a></li>
<?php endforeach; ?>
        </ol>
        <p class="fq-count"><?php echo (int) $faqTotal; ?> questions, answered in plain language. Not finding yours? <a href="/contact/">Ask the office</a>.</p>
      </nav>
      <div class="fq-content">
<?php endif; ?>
        <section class="fq-cat" id="<?php echo esc($faqCat['id']); ?>" aria-labelledby="fq-<?php echo esc($faqCat['id']); ?>-title">
          <div class="fq-cat__head reveal-up">
            <span class="fq-cat__icon"><?php echo icon($faqCat['icon'], 22); ?></span>
            <h2 id="fq-<?php echo esc($faqCat['id']); ?>-title"><?php echo esc($faqCat['title']); ?></h2>
            <p><?php echo esc($faqCat['intro']); ?></p>
          </div>
          <div class="fq-list reveal-up">
<?php foreach ($faqCat['items'] as $faqItemIdx => $faqItem): ?>
            <details class="faq"<?php echo ($faqCatIdx === 0 && $faqItemIdx === 0) ? ' open' : ''; ?>>
              <summary><?php echo esc($faqItem['q']); ?></summary>
              <p class="faq-answer"><?php echo esc($faqItem['a']); ?></p>
<?php if (!empty($faqItem['link'])): ?>
              <a class="faq-more" href="<?php echo esc($faqItem['link'][0]); ?>"><?php echo esc($faqItem['link'][1]); ?> <?php echo icon('arrow-right', 14); ?></a>
<?php endif; ?>
            </details>
<?php endforeach; ?>
          </div>
        </section>
<?php if ($faqCatIdx === count($faqCategories) - 1): ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
<?php endforeach; ?>

<?php /* The ONE mid-page form band: placed right after the question body (the page's first content section) so the sticky index and accordions stay one unbroken column. */ ?>
<?php
$ctaBandTitle = 'Still have a question about your electrical work?';
$ctaBandCopy  = 'Describe the job and where it is. ' . $siteName . ' will follow up by phone or email, and for most jobs the next step is a look at the panel and wiring.';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php';
?>

<div class="container"><p class="sp-updated">Last updated: <?php echo date('F Y'); ?> &middot; <?php echo esc($siteName); ?>, <?php echo esc($address['street']); ?>, <?php echo esc($address['city']); ?>, <?php echo esc($address['state']); ?></p></div>
</article>

<!-- ============ 3. FINAL CTA ============ -->
<section class="section cta-banner texture-grain edge-curve-top sp-cta" aria-labelledby="sp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="reveal-left">
      <span class="eyebrow">Talk to the office</span>
      <h2 id="sp-cta-title">Would a person answer your electrical question faster?</h2>
      <p>Call <?php echo esc($phoneText); ?> and describe what is going on. <?php echo esc($siteName); ?> serves Hagerstown and the surrounding area of Washington County.</p>
    </div>
    <div class="actions reveal-right">
      <a class="btn btn-accent btn-lg" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo esc($phoneText); ?></a>
      <a class="btn btn-outline-white btn-lg" href="/contact/">Send the details</a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
