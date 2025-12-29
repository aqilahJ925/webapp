<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
  <!-- Links to your team's shared styles -->
  <link rel="stylesheet" href="styles.css" /> 
  <title>Our Story | EasyStorage</title>
  
  <style>
    /* --- ELLSIA'S LOCAL FIXES --- */
    .story__container {
      padding-top: 100px; 
      max-width: 800px;
      margin: auto;
    }

    .story__text-block {
      line-height: 1.8;
      color: #555;
      margin-top: 30px;
    }

    .story__quote {
      font-size: 1.2rem;
      color: #0407da;
      font-weight: 600;
      margin: 30px 0;
      padding: 20px;
      border-left: 5px solid #0407da;
      background-color: #f0f7ff;
      font-style: italic;
    }

    /* THE OVERLAP FIX: Safe container for the return button */
    .return-btn-container {
      margin-top: 50px;
      text-align: center;
      padding: 40px 20px;
      border-top: 1px solid #eee;
    }

    .return-btn-container .btn {
      display: inline-block; /* Essential to stop overlapping */
    }

    .back__btn {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 30px;
      font-weight: 600;
      color: #333;
    }
  </style>
</head>
<body>

  <section class="section__container story__container">
    <!-- Back to Homepage -->
    <a href="index.php" class="back__btn">
      <i class="ri-arrow-left-line"></i> Back to Homepage
    </a>

    <p class="section__subheader">WHO WE ARE</p>
    <h2 class="section__header">Beyond The Code: Our Journey</h2>

    <div class="story__text-block">
      <p>
        EasyStorage didn't start in a boardroom. It started in a crowded UNIMAS hostel room during the 2024 semester break. 
        As students, we watched our friends struggle with a recurring problem: <strong>"Where do I put my stuff when I head home?"</strong>
      </p>

      <div class="story__quote">
        "We saw students paying expensive taxi fares just to move boxes to a friend's house, or worse, leaving valuable items in unlocked rooms. We knew there had to be a better way."
      </div>

      <p>
        That's when <strong>NetworkClan</strong> was formed. As a team of six FCSIT students, we decided to combine our technical skills with our understanding of campus life. 
        We didn't just want to build a website; we wanted to build a service that empowers the student community.
      </p>

      <p style="margin-top: 20px;">
        Located in <strong>Unijaya</strong>, our facility is monitored 24/7. When you choose EasyStorage, you are supporting a student-run startup 
        dedicated to making university life just a little bit easier for everyone.
      </p>
    </div>

    <!-- SAFE BUTTON AREA: Prevents footer/text overlap -->
    <div class="return-btn-container">
      <h3>Ready to head back?</h3>
      <a href="index.php" class="btn">Return to Homepage</a>
    </div>

  </section>

  <footer class="footer__bar">
    SEG01-02 - TMF3973 Web Application Development | NetworkClan Team
  </footer>

</body>
</html>