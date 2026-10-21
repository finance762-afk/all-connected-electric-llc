<?php
/**
 * includes/cta-band.php — the ONE mid-page compact lead form for About and FAQ (v6.3 placement rule).
 * Never used on pages that already carry the hero form or the full contact form.
 * Set before including:
 *   $ctaBandTitle (H2) · $ctaBandCopy (one or two plain sentences) · $ctaBandService (optional preselected service name)
 * Form id on the page is "cta-band" (unique per page: hero | cta-band | dialog | contact).
 * Layout: copy column ~1/3, form card ~2/3, fields three-up. Tokens only; CSS is emitted once per request.
 */
$ctaBandService = $ctaBandService ?? '';
if (empty($GLOBALS['__cta_band_css'])):
    $GLOBALS['__cta_band_css'] = 1; ?>
<style>
.cta-band { padding-block: var(--space-3xl); }
.cta-band__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 2fr); gap: clamp(1.5rem, 4vw, 3rem); align-items: center; }
.cta-band__copy h2 { font-size: var(--fs-h2); max-width: 18ch; margin-bottom: var(--space-xs); }
.cta-band__copy p { margin: 0 0 var(--space-md); max-width: 38ch; }
.cta-band__call { display: inline-flex; align-items: center; gap: var(--space-xs); color: var(--color-white); font-weight: 600; text-decoration: underline; text-decoration-color: var(--color-accent); text-decoration-thickness: 2px; text-underline-offset: 3px; }
.cta-band__call svg { color: var(--color-accent-bright); }
.cta-band__card { background: var(--color-surface); color: var(--color-ink); border-radius: var(--radius-lg); padding: var(--space-lg); box-shadow: var(--shadow-lg); border-top: var(--space-1) solid var(--color-accent); }
.cta-band__fields { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-sm); align-items: end; }
.cta-band__fields .field label { color: var(--color-ink-2); }
.cta-band__fields .cta-band__consent { grid-column: span 2; margin: 0; }
.cta-band__fields .cta-band__consent .consent { margin: 0; color: var(--color-ink-2); }
.cta-band__card .consent a { color: var(--color-ink); font-weight: 600; }
.cta-band__foot { margin: var(--space-xs) 0 0; font-size: var(--fs-eyebrow); color: var(--color-muted); }
@media (max-width: 900px) { .cta-band__grid { grid-template-columns: 1fr; } .cta-band__copy h2, .cta-band__copy p { max-width: none; } }
@media (max-width: 640px) { .cta-band__fields { grid-template-columns: 1fr; } .cta-band__fields .cta-band__consent { grid-column: auto; } }
</style>
<?php endif; ?>
<section class="section cta-band texture-grain" id="estimate" aria-labelledby="cta-band-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-band__grid">
      <div class="cta-band__copy reveal-left">
        <span class="eyebrow">Estimate request</span>
        <h2 id="cta-band-title"><?php echo esc($ctaBandTitle); ?></h2>
        <p><?php echo esc($ctaBandCopy); ?></p>
        <a class="cta-band__call" href="tel:<?php echo esc($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo esc(formatPhone($phone)); ?></a>
      </div>
      <div class="cta-band__card reveal-right">
        <form action="<?php echo esc($formAction); ?>" method="POST" class="estimate-form">
          <?php echo p1_lead_hidden_fields('cta-band'); ?>
          <div class="cta-band__fields">
            <div class="field"><label for="cta-band-name">Your name *</label><input id="cta-band-name" type="text" name="name" autocomplete="name" required></div>
            <div class="field"><label for="cta-band-phone">Phone *</label><input id="cta-band-phone" type="tel" name="phone" autocomplete="tel" inputmode="tel" required></div>
            <div class="field"><label for="cta-band-email">Email *</label><input id="cta-band-email" type="email" name="email" autocomplete="email" required></div>
            <div class="field"><label for="cta-band-service">Service needed</label><select id="cta-band-service" name="service"><?php echo p1_service_options($ctaBandService); ?></select></div>
            <div class="cta-band__consent"><?php echo p1_consent_row('cta-band'); ?></div>
            <button type="submit" class="btn btn-accent">Send my request</button>
          </div>
          <p class="cta-band__foot">Goes straight to <?php echo esc($siteName); ?>, not a lead marketplace.</p>
        </form>
      </div>
    </div>
  </div>
</section>
