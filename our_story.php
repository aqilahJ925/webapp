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
  <title>Our Story | EasyStorage</title>
</head>
<body>

  <section class="section__container story__container">
    <a href="index.php" class="back__btn">
      <i class="ri-arrow-left-line"></i> Back to Homepage
    </a>

    <p class="section__subheader">WHO WE ARE</p>
    <h2 class="section__header">Beyond The Code: Our Journey</h2>
    
    <div class="story__content">
      <p>EasyStorage started in a crowded UNIMAS hostel room during the 2024 semester break. We saw students struggling with a recurring problem: "Where do I put my stuff when I head home?"</p>

      <div class="story__highlight">
        "We knew there had to be a better way for the UNIMAS community."
      </div>

      <div class="vision__grid">
        <div class="vision__card">
          <i class="ri-map-pin-user-line"></i>
          <h4>Hyper-Local</h4>
          <p>We live in Kolej Allamanda and Sakura too. We know exactly what you need.</p>
        </div>
        <div class="vision__card">
          <i class="ri-computer-line"></i>
          <h4>Tech-Driven</h4>
          <p>Our digital tracking system ensures professional-grade security for every box.</p>
        </div>
      </div>

      <div class="team__note">
        <h3>A Message from NetworkClan</h3>
        <p>We are dedicated to making university life just a little bit easier for everyone. Support a student-run startup and travel light!</p>
        <div style="margin-top: 2rem;">
            <a href="index.php" class="btn">Return to Home</a>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer__bar" style="margin-top: 5rem;">
    SEG01-02 - TMF3973 Web Application Development | NetworkClan Team
  </footer>

</body>
</html>