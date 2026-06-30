
</main>

<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="/" class="footer-wordmark">Jess Linton</a>
        <p class="footer-tagline">HCPC Registered Art Psychotherapist,
          Visual Artist &amp; Creative Practitioner. Sussex, UK.</p>
      </div>
      <div>
        <span class="footer-col-label">Pages</span>
        <ul class="footer-links">
          <li><a href="/about.php">About</a></li>
          <li><a href="/what-is-art-therapy.php">Art Therapy</a></li>
          <li><a href="/artist.php">Art</a></li>
          <li><a href="/overview.php">Community</a></li>
          <li><a href="/blog.php">Blog</a></li>
          <li><a href="/articles.php">Articles</a></li>
          <li><a href="/contact.php">Contact</a></li>
        </ul>
      </div>
      <div>
        <span class="footer-col-label">Social</span>
        <ul class="footer-links">
          <li><a href="https://www.flickr.com/people/132257489@N03/" target="_blank" rel="noopener">Flickr</a></li>
          <li><a href="https://www.pinterest.com/JessLint0n/" target="_blank" rel="noopener">Pinterest</a></li>
          <li><a href="https://www.linkedin.com/in/jess-linton-9a38ab78" target="_blank" rel="noopener">LinkedIn</a></li>
          <li><a href="https://www.instagram.com/jess.a.linton" target="_blank" rel="noopener">Instagram</a></li>
          <li><a href="https://www.theplotstanmer.org.uk/" target="_blank" rel="noopener">The Plot</a></li>
        </ul>
      </div>
      <div>
        <span class="footer-col-label">Contact</span>
        <ul class="footer-links">
          <?php
          // Use contact_settings from DB if available, else fall back to defaults
          $email = get_contact('email', 'jess.a.linton@gmail.com');
          $phone = get_contact('phone', '+44 (0) 7834 686838');
          ?>
          <li><a href="mailto:<?= h($email) ?>"><?= h($email) ?></a></li>
          <li><a href="tel:<?= h(preg_replace('/[^+\d]/', '', $phone)) ?>"><?= h($phone) ?></a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <?php
      $hcpc = get_contact('hcpc_number', 'AS14954');
      $dbs  = get_contact('dbs_number',  '004178606999');
      $year = get_contact('copyright_year', date('Y'));
      ?>
      <p>&copy; <?= h($year) ?> Jess Linton
        &nbsp;&middot;&nbsp; HCPC Registration: <?= h($hcpc) ?>
        &nbsp;&middot;&nbsp; DBS: <?= h($dbs) ?>
      </p>
    </div>
  </div>
</footer>

<script src="/public/js/main.js"></script>
</body>
</html>
