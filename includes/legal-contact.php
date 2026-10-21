<?php
/**
 * includes/legal-contact.php — the standard "Contact Us" block closing every legal page.
 * Reads the page's $companyName, $companyEmail, $companyPhone, $companyPhoneE164, $companyAddress.
 */
?>
<address>
  <strong><?php echo esc($companyName); ?></strong><br>
  Email: <a href="mailto:<?php echo esc($companyEmail); ?>"><?php echo esc($companyEmail); ?></a><br>
  Phone: <a href="tel:<?php echo esc($companyPhoneE164); ?>"><?php echo esc($companyPhone); ?></a><br>
  Address: <?php echo esc($companyAddress); ?>
</address>
