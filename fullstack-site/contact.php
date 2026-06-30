<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$seo = get_seo('contact');
$c   = get_page_content('contact', [
    'intro_text'    => 'Jess welcomes enquiries about art therapy, community projects, workshops, or any other aspect of her work. Please get in touch using the details below.',
    'referral_text' => "Referrals can be made by the individual themselves, by a family member or carer, or by a professional such as a GP, teacher, social worker or other health professional.\n\nJess works with adults and young people (12+). She offers a free 20-minute phone consultation before any commitment is made.",
]);

$email = get_contact('email', 'jess.a.linton@gmail.com');
$phone = get_contact('phone', '+44 (0) 7834 686838');
$hcpc  = get_contact('hcpc_number', 'AS14954');
$dbs   = get_contact('dbs_number',  '004178606999');
$fee   = get_contact('session_fee', '£35–£60 per hour');
$loc   = get_contact('address', 'Sussex, UK');

$page_title = $seo['title']            ?? 'Contact — Jess Linton';
$meta_desc  = $seo['meta_description'] ?? 'Get in touch with Jess Linton — HCPC registered Art Psychotherapist and Creative Practitioner based in Sussex, UK.';

require_once __DIR__ . '/includes/header.php';
?>

  <header class="page-header">
    <div class="container">
      <span class="eyebrow reveal">Get in Touch</span>
      <h1 class="reveal d1">Contact</h1>
    </div>
  </header>

  <section class="section--lg">
    <div class="container">
      <div class="contact-split reveal">
        <div class="contact-col">
          <span class="eyebrow">General Enquiries</span>
          <h2>Say hello</h2>
          <div class="rich-text">
            <p><?= nl2br_h($c['intro_text']) ?></p>
          </div>
          <ul class="info-list" style="list-style:none;padding:0;margin-top:1.5rem;">
            <li style="margin-bottom:.75rem;"><strong>Email:</strong> <a href="mailto:<?= h($email) ?>"><?= h($email) ?></a></li>
            <li style="margin-bottom:.75rem;"><strong>Phone:</strong> <a href="tel:<?= h(preg_replace('/[^+\d]/', '', $phone)) ?>"><?= h($phone) ?></a></li>
            <li style="margin-bottom:.75rem;"><strong>Location:</strong> <?= h($loc) ?></li>
            <li style="margin-bottom:.75rem;"><strong>Session fee:</strong> <?= h($fee) ?></li>
          </ul>
        </div>
        <div class="contact-col">
          <span class="eyebrow">Therapy Referrals</span>
          <h2>Making a referral</h2>
          <div class="rich-text">
            <?php foreach (explode("\n\n", $c['referral_text']) as $p): ?>
              <?php if (trim($p)): ?><p><?= nl2br_h(trim($p)) ?></p><?php endif; ?>
            <?php endforeach; ?>
          </div>
          <div class="registration-box">
            <p><strong>HCPC Registration:</strong> <?= h($hcpc) ?></p>
            <p><strong>DBS Certificate:</strong> <?= h($dbs) ?></p>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
