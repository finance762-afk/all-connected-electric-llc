<?php
/**
 * includes/config.php — site-wide configuration for All Connected Electric LLC.
 * All pages: require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php'; before head.php.
 * Generated Phase 1 (scaffold) from build-plan.json (research brief generated 2026-10-21).
 * Pages set their own $canonicalUrl, $pageType, $serviceSlug / $citySlug — never here.
 */

/* ---------------------------------------------------------------------------
 * Identity
 * ------------------------------------------------------------------------- */
$slug            = 'all-connected-electric-llc';            // exact build directory name
$siteName        = 'All Connected Electric LLC';
$tagline         = '';                                      // none supplied at intake — do not invent one
$ownerName       = 'Andrew Porter';
$phone           = '(301) 704-6333';
$phoneRaw        = '+13017046333';                          // tel: friendly (E.164)
$phoneSecondary  = '';
$email           = 'allconn4electric@gmail.com';
$tier            = 'premium';

$address = [
    'street' => '19813 Leitersburg Pike Ste 301',
    'city'   => 'Hagerstown',
    'state'  => 'MD',
    'zip'    => '21742',
];
$addressPublic = true;

/* ---------------------------------------------------------------------------
 * Domain / URL
 *   build-plan.json has no production_domain → default to the preview domain.
 *   $domain must NEVER be blank; $siteUrl must always be a valid absolute URL.
 * ------------------------------------------------------------------------- */
$domain   = $slug . '.pageone.cloud';                       // all-connected-electric-llc.pageone.cloud
$siteUrl  = 'https://' . $domain;                           // absolute site root, no trailing slash
$industry = 'Electrician';

/* ---------------------------------------------------------------------------
 * Keywords
 *   build-plan seo.primary_keyword is "commercial" (a service category, not a
 *   search phrase), so the primary keyword is the industry + home city.
 * ------------------------------------------------------------------------- */
$primaryKeyword = 'electrician Hagerstown MD';
$secondaryKeywords = [
    'commercial electrician Hagerstown',
    'residential electrician Hagerstown',
    'industrial electrician Hagerstown',
    'panel upgrades',
    'EV charger installation',
    'lighting installation',
    'wiring & rewiring',
    'ceiling fan installation',
    'generator installation',
    'outlet & switch repair',
    'emergency electrician',
    'electrical wiring repair',
    'electrical outlet repair',
    'light switch repair',
    'circuit breaker repair',
    'electrical panel repair',
    'faulty wiring repair',
    'power outage troubleshooting',
    'short circuit repair',
    'electrical fault detection',
    'indoor lighting repair',
    'outdoor lighting repair',
    'ceiling fan repair',
    'generator repair',
    'electrical inspection services',
    'home electrical services',
    'residential electrical repairs',
    'home rewiring services',
    'house electrical inspections',
    'electrical upgrades',
    'home lighting installation',
    'kitchen electrical services',
    'bathroom electrical wiring',
    'new home electrical installation',
    'smart home wiring',
    'home surge protection',
    'electrical safety inspections',
];

/* ---------------------------------------------------------------------------
 * Services — build-plan "services" is empty; this list is the intake service
 *   list carried in seo.primary_keyword + seo.secondary_keywords (11 services,
 *   under the premium cap of 16). Each: name, slug (dir under /services/),
 *   description, keywords. Descriptions are factual placeholders — the
 *   copywriter owns final client-facing copy.
 *   NOTE: hours/after-hours availability is not in intake — confirm before any
 *   "24/7" or "same-day" claim on Emergency Electrician.
 * ------------------------------------------------------------------------- */
$services = [
    [
        'name'        => 'Commercial Electrical',
        'slug'        => 'commercial-electrical',
        'description' => 'Electrical installation, repair and upgrades for offices, storefronts and other commercial buildings in Hagerstown and Washington County.',
        'keywords'    => ['commercial electrician Hagerstown', 'commercial electrical contractor MD', 'business electrical repair', 'commercial lighting'],
    ],
    [
        'name'        => 'Residential Electrical',
        'slug'        => 'residential-electrical',
        'description' => 'Home electrical repairs, upgrades, inspections and new installations, from kitchens and bathrooms to smart home wiring and surge protection.',
        'keywords'    => ['residential electrician Hagerstown', 'home electrical services', 'residential electrical repairs', 'electrical safety inspections', 'kitchen electrical services', 'bathroom electrical wiring', 'smart home wiring', 'home surge protection', 'new home electrical installation', 'house electrical inspections'],
    ],
    [
        'name'        => 'Industrial Electrical',
        'slug'        => 'industrial-electrical',
        'description' => 'Electrical work for industrial facilities, warehouses and shops, including power distribution, equipment circuits and repairs.',
        'keywords'    => ['industrial electrician Hagerstown', 'industrial electrical contractor MD', 'warehouse electrical', 'electrical inspection services'],
    ],
    [
        'name'        => 'Panel Upgrades',
        'slug'        => 'panel-upgrades',
        'description' => 'Electrical panel replacement, service upgrades and breaker repair for homes and buildings that need more capacity or a safer panel.',
        'keywords'    => ['panel upgrade Hagerstown', 'electrical panel replacement MD', 'electrical panel repair', 'circuit breaker repair', 'electrical upgrades'],
    ],
    [
        'name'        => 'EV Charger Installation',
        'slug'        => 'ev-charger-installation',
        'description' => 'Level 2 EV charger installation, with a check of panel capacity and a dedicated circuit sized for the charger.',
        'keywords'    => ['EV charger installation Hagerstown', 'Level 2 charger install MD', 'home EV charger electrician', 'electric car charger installation'],
    ],
    [
        'name'        => 'Lighting Installation',
        'slug'        => 'lighting-installation',
        'description' => 'Indoor and outdoor lighting installation and repair, including fixtures, recessed lighting and exterior lights.',
        'keywords'    => ['lighting installation Hagerstown', 'home lighting installation', 'indoor lighting repair', 'outdoor lighting repair', 'recessed lighting install'],
    ],
    [
        'name'        => 'Wiring & Rewiring',
        'slug'        => 'wiring-rewiring',
        'description' => 'New wiring, whole-home rewiring and faulty wiring repair for older homes and renovations.',
        'keywords'    => ['rewiring Hagerstown', 'home rewiring services', 'electrical wiring repair', 'faulty wiring repair'],
    ],
    [
        'name'        => 'Ceiling Fan Installation',
        'slug'        => 'ceiling-fan-installation',
        'description' => 'Ceiling fan installation and repair, including new boxes rated for fan weight and wall controls.',
        'keywords'    => ['ceiling fan installation Hagerstown', 'ceiling fan repair', 'ceiling fan electrician MD'],
    ],
    [
        'name'        => 'Generator Installation',
        'slug'        => 'generator-installation',
        'description' => 'Standby and portable generator hookups, transfer switches and generator repair to keep power on during outages.',
        'keywords'    => ['generator installation Hagerstown', 'whole home generator MD', 'transfer switch installation', 'generator repair'],
    ],
    [
        'name'        => 'Outlet & Switch Repair',
        'slug'        => 'outlet-switch-repair',
        'description' => 'Repair and replacement of dead outlets, faulty switches, GFCI outlets and short circuits.',
        'keywords'    => ['outlet repair Hagerstown', 'electrical outlet repair', 'light switch repair', 'short circuit repair', 'GFCI outlet installation'],
    ],
    [
        'name'        => 'Emergency Electrician',
        'slug'        => 'emergency-electrician',
        'description' => 'Troubleshooting for power loss, tripping breakers, burning smells and other urgent electrical problems at homes and businesses.',
        'keywords'    => ['emergency electrician Hagerstown', 'power outage troubleshooting', 'electrical fault detection', 'electrician near me Hagerstown'],
    ],
];

/* ---------------------------------------------------------------------------
 * Service areas — build-plan service_areas holds Hagerstown only. The research
 *   brief's town list (Williamsport, Smithsburg, ...) is an unverified
 *   hypothesis — add a town here only after the client confirms it.
 * ------------------------------------------------------------------------- */
$serviceAreas = [
    ['name' => 'Hagerstown', 'slug' => 'hagerstown', 'zip' => '21742', 'county' => 'Washington', 'primary' => true],
];
$targetRadiusMiles = 25;   // build-plan seo.target_radius

/* ---------------------------------------------------------------------------
 * Social links (only platforms the client uses; none supplied at intake)
 * ------------------------------------------------------------------------- */
$socialLinks = [];

/* ---------------------------------------------------------------------------
 * Analytics (placeholder — replace with client GA4 ID post-launch)
 * ------------------------------------------------------------------------- */
$googleAnalyticsId = 'G-XXXXXXXXXX';

/* ---------------------------------------------------------------------------
 * Brand colors — build-plan design.colors has no values yet (no logo on file;
 *   logo_analysis is empty). Phase 2 logo analysis fills these. Until then the
 *   framework.css :root defaults render.
 * ------------------------------------------------------------------------- */
$colors = [   // Phase 2: industry palette (no logo yet) — mirrors framework.css :root
    'primary'   => '#11151a',
    'secondary' => '#4b5563',
    'accent'    => '#fed530',
];
$archetype = 'minimal-tech';   // build-plan design.archetype

/* ---------------------------------------------------------------------------
 * Company age — intake: "in business since 2016" (content.years = 10)
 * ------------------------------------------------------------------------- */
$yearEstablished = 2016;
$yearsInBusiness = (int) date('Y') - $yearEstablished;

/* ---------------------------------------------------------------------------
 * Hours — build-plan business_hours (plan regenerated 2026-10-21). $businessHours is the
 *   visible line (footer + contact); $openingHoursSpec mirrors it in the Electrician schema.
 * ------------------------------------------------------------------------- */
$businessHours = 'Mon–Fri 7:30 AM–5:00 PM · Sat 9:00 AM–1:00 PM · Sun Closed';
$openingHoursSpec = [
    ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'], 'opens' => '07:30', 'closes' => '17:00'],
    ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => ['Saturday'], 'opens' => '09:00', 'closes' => '13:00'],
];

/* ---------------------------------------------------------------------------
 * Credentials — build-plan content.certifications. license_rules: show ONLY this
 *   credential; never claim a Maryland state license; never show the Greencastle PA address.
 * ------------------------------------------------------------------------- */
$licenseLabel = 'Hagerstown Master Electrician EM-1096';

/* ---------------------------------------------------------------------------
 * CSS cache-bust — SINGLE source of truth. Pages MUST NOT set their own.
 * Bump this on every framework.css change.
 * ------------------------------------------------------------------------- */
$cssVersion = '5';

/* ---------------------------------------------------------------------------
 * Forms — Page One leads endpoint (build-plan form_action, verbatim)
 * ------------------------------------------------------------------------- */
$formAction       = 'https://db.pageone.cloud/functions/v1/leads/all-connected-electric-llc';
$leadsFormSecret  = 'bac7714a8f41505ab12d75311ccbb11a6374e38b1a010d69111c84a652cfa0f3'; // spam-shield HMAC (matches leads fn LEADS_FORM_SECRET)
$leadNotificationEmail = 'allconn4electric@gmail.com';
$leadNotificationPhone = '(301) 704-6333';

/* ---------------------------------------------------------------------------
 * Google Business Profile (build-plan gbp + integrations). Map embed and geo come from
 *   build-plan gbp (cid embed URL, lat/lng) — never guessed.
 * ------------------------------------------------------------------------- */
$gbpName          = 'All Connected Electric';               // GBP listing name (schema alternateName; $siteName is the legal name)
$gbpPlaceId       = 'ChIJ8fq1qxOTyYkR47kOuL3zo7E';
$gbpMapsUrl       = 'https://share.google/Q0gkYiNIyGUER6Zwm';
$directionsUrl    = 'https://www.google.com/maps/dir/?api=1&destination=place_id:ChIJ8fq1qxOTyYkR47kOuL3zo7E';
$reviewRequestUrl = 'https://search.google.com/local/writereview?placeid=ChIJ8fq1qxOTyYkR47kOuL3zo7E';
$gbpMapEmbed      = 'https://maps.google.com/maps?cid=12800342562079422947&output=embed';
$geo              = ['lat' => 39.679318, 'lng' => -77.679471];
$acceptsSms       = false;

/* ---------------------------------------------------------------------------
 * v8 component variables (2026-10-09) — copied from build-plan "integrations".
 *   Empty = component renders nothing. Never fill these without the plan.
 * ------------------------------------------------------------------------- */
$estimateTool   = [];   // integrations.estimate_tool.authorized = false
$bookingWindows = [];   // integrations.booking.authorized = false
$textUsNumber   = '';   // integrations.text_us_number = null
$financing      = [];   // integrations.financing = null
$serviceZips    = [];   // integrations.service_zips not present

/* ---------------------------------------------------------------------------
 * Lead attribution (v6.3) — MUST be last. Sets first-touch cookie and
 * provides p1_attribution_fields(). Never edit includes/attribution.php.
 * ------------------------------------------------------------------------- */
require_once __DIR__ . '/attribution.php';
