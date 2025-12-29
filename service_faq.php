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
  
  <style>
    .faq__container {
      padding-top: 100px; 
      max-width: 800px;
      margin: auto;
    }

    .btn-container {
      margin-top: 40px;
      text-align: center;
      padding-bottom: 50px; 
    }

    .btn-container .btn {
      display: inline-block; 
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

  <section class="section__container faq__container">
    <!-- Back to Homepage -->
    <a href="index.php" class="back__btn">
      <i class="ri-arrow-left-line"></i> Back to Homepage
    </a>

    <p class="section__subheader">RESOURCES</p>
    <h2 class="section__header">The Safe Storage Guide</h2>

    <div style="margin-top: 30px;">
        <div style="margin-bottom: 25px;">
          <span style="font-weight:bold; color:#0407da; display:block;">Can I access my items mid-break?</span>
          <p style="color:#666;">Yes! Simply book an appointment 24 hours in advance via our portal.</p>
        </div>

        <div style="margin-bottom: 25px;">
          <span style="font-weight:bold; color:#0407da; display:block;">What items are prohibited?</span>
          <p style="color:#666;">For safety, we do not store food, liquids, flammables, or illegal items.</p>
        </div>
        
        <div style="margin-bottom: 25px;">
          <span style="font-weight:bold; color:#0407da; display:block;">Is there a weight limit?</span>
          <p style="color:#666;">We ask that boxes don't exceed 20kg so our team can handle them safely.</p>
        </div>
    </div>

    <div class="btn-container">
      <a href="index.php#price" class="btn">View Packages</a>
    </div>

  </section>

  <footer class="footer__bar">
    SEG01-02 - TMF3973 Web Application Development
  </footer>

</body>
</html>
