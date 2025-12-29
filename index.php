<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <link rel="stylesheet" href="styles.css" />
  <title>EasyStorage | Online Storage Service</title>
</head>

<body>
  <header class="header">
    <nav>
      <div class="nav__bar">
        <div class="logo nav__logo">
          <a href="#"><img src="assets/logo.png" alt="logo" /></a>
        </div>
        <div class="nav__menu__btn" id="menu-btn">
          <i class="ri-menu-3-line"></i>
        </div>
      </div>
      <ul class="nav__links" id="nav-links">
        <li><a href="#home">HOME</a></li>
        <li><a href="#about">ABOUT</a></li>
        <li><a href="#service">SERVICE</a></li>
        <li><a href="#price">PRICE</a></li>
        <li><a href="#client">REVIEW</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li>
            <a href="profile.php" class="links user-name">
              <i class="ri-user-line"></i>
              <span class="name-text">
                <?php echo htmlspecialchars($_SESSION['user_name']); ?>
              </span>
            </a>
          </li>
          <li>
            <a href="logout.php" class="btn btn--outline">Logout</a>
          </li>
        <?php else: ?>
          <li>
            <a href="logincustomer.php" class="btn">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
    <div class="section__container header__container" id="home">
      <div class="header__content">
        <h1>Professional. Secure. Convenient.</h1>
        <div class="header__btn">
          <a href="service_faq.php" class="btn">Read More</a>
        </div>
      </div>
    </div>
  </header>

  <section class="banner__container">
    <div class="banner__card">
      <h4>Item Protection Guaranteed For Your Peace of Mind.</h4>
    </div>
    <div class="banner__card">
      <h4>Caring For Your Belongings The Way You Would.</h4>
    </div>
    <div class="banner__image">
      <img src="assets/banner-new.jpg" alt="banner" />
    </div>
  </section>

  <section class="section__container experience__container" id="about">
    <div class="experience__image">
      <img src="assets/experience-new.jpg" alt="experience" />
    </div>
    <div class="experience__content">
      <p class="section__subheader">WHO WE ARE</p>
      <h2 class="section__header">
        Student-Built Storage Solution For UNIMAS Community
      </h2>
      <p class="section__description">
        Easy Storage was founded by UNIMAS students who experienced firsthand
        the challenge of finding reliable storage durinng semester breaks. That's
        why we created Easy Storage, a professional, transparent, and student-friendly
        platform that combines secure physical storage at UNIJAYA (less than 10 minutes from campus)
        with easy online booking and affordable rates designed for student budgets.
      </p>
      <a href="about.php" class="btn">Read More</a>
    </div>
  </section>

  <section class="service" id="service">
    <div class="section__container service__container">
      <p class="section__subheader">WHY CHOOSE US</p>
      <h2 class="section__header">Professional Storage Service</h2>
      <p class="section__description">
        We provide secure, transparent, and convenient storage designed specifically for student needs.
      </p>
      <div class="service__grid">
        <div class="service__card">
          <img src="assets/service-1new.jpg" alt="service" />
          <h4>Flexible Packages</h4>
          <p>
            Choose from three packages with duration options for short-term, mid-semester, or full semester breaks.
          </p>
        </div>
        <div class="service__card">
          <img src="assets/service-2new.jpg" alt="service" />
          <h4>Campus Pickup & Delivery</h4>
          <p>
            Convenient pickup and return at designated on-campus collection points
            at UNIMAS without needing to transport items yourself.
          </p>
        </div>
        <div class="service__card">
          <img src="assets/service-3new.jpg" alt="service" />
          <h4>Secure Facility</h4>
          <p>
            Climate-controlled warehouse at UNIJAYA with CCTV security and basic damage/loss guarantee for complete
            peace of mind.
          </p>
        </div>
        <div class="service__card">
          <img src="assets/service-4new.jpg" alt="service" />
          <h4>Transparent Online Booking</h4>
          <p>
            Clear pricing, easy scheduling, and secure payment options all on one user-friendly platform.
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="section__container price__container" id="price">
    <p class="section__subheader">BEST PACKAGES</p>
    <h2 class="section__header">Our Storing Plans</h2>
    <p class="section__description">
      We offer flexible and affordable storage packages designed for students.
    </p>
    <div class="price__grid">
      <div class="price__card">
        <h4>STARTER PACK</h4>
        <h3><sup>From RM</sup>30</h3>
        <p>Up to 3 items</p>
        <p>Short-term Duration (RM30)</p>
        <p>Mid-Semester Break Option (RM45)</p>
        <p>Full Semester Break Option (RM60)</p>
        <p>Campus Pickup & Delivery</p>
        <p>Digital Inventory Receipt</p>
        <a href="booking.php?package=1">
          <button class="btn">Book Starter</button>
        </a>
      </div>
      <div class="price__card">
        <div class="price__card__ribbon">BESTSELLER</div>
        <h4>STANDARD PACK</h4>
        <h3><sup>From RM</sup>45</h3>
        <p>Up to 5 Items</p>
        <p>Short-term Duration (RM45)</p>
        <p>Mid-Semester Break Option (RM65)</p>
        <p>Full Semester Break Option (RM85)</p>
        <p>Campus Pickup & Delivery</p>
        <p>Digital Inventory Receipt</p>
        <a href="booking.php?package=2">
          <button class="btn">Book Standard</button>
        </a>
      </div>
      <div class="price__card">
        <h4>MAX PACK</h4>
        <h3><sup>From RM</sup>60</h3>
        <p>Up to 7 items</p>
        <p>Short-term Duration (RM 60)</p>
        <p>Mid-Semester Break Option (RM85)</p>
        <p>Full Semester Break Option (RM110)</p>
        <p>Campus Pickup & Delivery</p>
        <p>Digital Inventory Receipt</p>
        <p>Maximum Capacity</p>
        <a href="booking.php?package=3">
          <button class="btn">Book Max</button>
        </a>
      </div>
    </div>
  </section>

  <section class="contact">
    <div class="section__container contact__container">
      <div class="contact__content">
        <p class="section__subheader">CONTACT US</p>
        <h2 class="section__header">Store Your Items With Complete Peace of Mind</h2>
        <p class="section__description">
          Experience the convenience of hassle-free storage as we take care of your Belongings
          with professional handling, leaving them safe and secure until you need them again.
        </p>
        <div class="contact__btns">
          <button class="btn">Our Services</button>
          <button class="btn">Contact Us</button>
        </div>
      </div>
    </div>
  </section>

  <section class="section__container testimonial__container" id="client">
    <p class="section__subheader">CLIENT TESTIMONIALS</p>
    <h2 class="section__header">100% Approved By Customers</h2>
    <!-- Slider main container -->
    <div class="swiper">
      <!-- Additional required wrapper -->
      <div class="swiper-wrapper">
        <!-- Slides -->
        <div class="swiper-slide">
          <div class="testimonial__card">
            <img src="assets/testimonial-new1.jpg" alt="testimonial" />
            <p>
              I am so thankful to Easy Storage for keeping my belongings
              secured during semester break since my college management
              did not allow students to leave their stuffs in college.
            </p>
            <h4>- Siti Zen</h4>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="testimonial__card">
            <img src="assets/testimonial-new2.jpg" alt="testimonial" />
            <p>
              I wanted to go back to Sabah for the long semester break, but it is
              too much hassle to pack many bags. Besides, I will still be staying in
              campus next semester anyway. Thank goodness I found Easy Storage to help me keep
              my stuffs safely.
            </p>
            <h4>- Mark Sagan</h4>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="testimonial__card">
            <img src="assets/testimonial-new3.jpg" alt="testimonial" />
            <p>
              Good and recommended service. I do not need to worry about my belongings
              when I need to travel back home again. Will definitely use Easy Storage
              again in the future.
            </p>
            <h4>- Josiah T.</h4>
          </div>
        </div>
      </div>
      <!-- If we need pagination -->
      <div class="swiper-pagination"></div>
    </div>
  </section>

  <footer class="footer">

    <div class="section__container footer__container">
      <div class="footer__col">
        <div class="logo footer__logo">
          <a href="#"><img src="assets/logo.png" alt="logo" /></a>
        </div>
      </div>

      <div class="footer__col">
        <h4>Storage Tips</h4>
        <ul class="footer__links">
          <li>
            <p>Pack Smart: Use Boxes</p>
          </li>
          <li>
            <p>Label Everything Clearly</p>
          </li>
          <li>
            <p>Avoid Storing Perishables</p>
          </li>
          <li>
            <p>Use Bubble Wrap for Fragiles</p>
          </li>
          <li>
            <p>Stack Heaviest Items Below</p>
          </li>
        </ul>
      </div>
      <div class="footer__col">
        <h4>Contact Info</h4>
        <ul class="footer__links">
          <li>
            <p>
              Travel Light, Store Smart This Semester Break
            </p>
          </li>
          <li>
            <p>Phone: <span>+60 178109462</span></p>
          </li>
          <li>
            <p>Email: <span>info@easystorage.com</span></p>
          </li>
        </ul>
      </div>
    </div>
  </footer>
  <div class="footer__bar">
    SEG01-02 - TMF3973 Web Application Development
  </div>

  <script src="https://unpkg.com/scrollreveal"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <script src="main.js"></script>
</body>

</html>