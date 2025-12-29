<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
  <title>Safe Storage Guide | EasyStorage</title>
</head>
<body>

  <section class="section__container faq__container">
    <a href="index.php" class="back__btn">
      <i class="ri-arrow-left-line"></i> Back to Homepage
    </a>

    <p class="section__subheader">RESOURCES</p>
    <h2 class="section__header">The Safe Storage Guide</h2>
    <p class="section__description">
      Everything you need to know about keeping your belongings secure at UNIMAS during the break.
    </p>

    <div class="guarantee__grid">
      <div class="guarantee__card">
        <h4><i class="ri-shield-check-line"></i> 24/7 Monitoring</h4>
        <p>Full CCTV coverage and security patrols at the Unijaya facility.</p>
      </div>
      <div class="guarantee__card">
        <h4><i class="ri-qr-code-line"></i> Digital Tagging</h4>
        <p>Every item is assigned a unique QR-coded tag upon pickup.</p>
      </div>
      <div class="guarantee__card">
        <h4><i class="ri-temp-hot-line"></i> Climate Control</h4>
        <p>Dry and ventilated warehouse to prevent moisture damage.</p>
      </div>
    </div>

    <h3 class="category__title">Booking & Logistics</h3>
    <div class="faq__item">
      <span class="faq__question">Can I access my items mid-break?</span>
      <p class="faq__answer">Yes! Simply book an "Access Appointment" via the portal 24 hours in advance.</p>
    </div>

    <h3 class="category__title">Safety & Items</h3>
    <div class="faq__item">
      <span class="faq__question">What items are prohibited?</span>
      <p class="faq__answer">For safety, we do not store food, liquids, flammables, or illegal items.</p>
    </div>

    <div style="text-align: center; margin-top: 4rem; padding: 2rem; background: #f0f7ff; border-radius: 15px;">
      <h4>Ready to store your items?</h4>
      <a href="index.php#price" class="btn">View Packages</a>
    </div>

  </section>

  <footer class="footer__bar" style="margin-top: 5rem;">
    SEG01-02 - TMF3973 Web Application Development
  </footer>

</body>
</html>
