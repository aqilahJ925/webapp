<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
    />
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
          <button class="btn">Login</button>
        </ul>
      </nav>
      <div class="section__container header__container" id="home">
        <div class="header__content">
          <h1>Professional. Secure. Convenient.</h1>
          <div class="header__btn">
            <button class="btn">Read More</button>
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
        <img src="assets/banner.jpg" alt="banner" />
      </div>
    </section>

    <section class="section__container experience__container" id="about">
      <div class="experience__image">
        <img src="assets/experience.jpg" alt="experience" />
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
        <button class="btn">Read More</button>
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
            <img src="assets/service-1.jpg" alt="service" />
            <h4>Flexible Packages</h4>
            <p>
              Choose from three packages with duration options for short-term, mid-semester, or full semester breaks.
            </p>
          </div>
          <div class="service__card">
            <img src="assets/service-2.jpg" alt="service" />
            <h4>Campus Pickup & Delivery</h4>
            <p>
              Convenient pickup and return at designated on-campus collection points 
              at UNIMAS without needing to transport items yourself.
            </p>
          </div>
          <div class="service__card">
            <img src="assets/service-3.jpg" alt="service" />
            <h4>Secure Facility</h4>
            <p>
              Climate-controlled warehouse at UNIJAYA with CCTV security and basic damage/loss guarantee for complete peace of mind.
            </p>
          </div>
          <div class="service__card">
            <img src="assets/service-4.jpg" alt="service" />
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
          <h3><sup>$</sup>35</h3>
          <p>Routine Maintenance</p>
          <p>Diagnostic Services</p>
          <p>Wheel Alignment</p>
          <p>Brake and Suspension</p>
          <p>Air Conditioning</p>
          <p>Scheduled Maintenance</p>
          <button class="btn">Go Basic</button>
        </div>
        <div class="price__card">
          <div class="price__card__ribbon">BESTSELLER</div>
          <h4>PLATINUM PACKAGE</h4>
          <h3><sup>$</sup>69</h3>
          <p>Routine Maintenance</p>
          <p>Diagnostic Services</p>
          <p>Engine Tune-Ups</p>
          <p>Tire Sales and Services</p>
          <p>Exhaust System Repairs</p>
          <p>Scheduled Maintenance</p>
          <button class="btn">Go Premium</button>
        </div>
        <div class="price__card">
          <h4>GOLD PACKAGE</h4>
          <h3><sup>$</sup>39</h3>
          <p>Routine Maintenance</p>
          <p>Diagnostic Services</p>
          <p>Brake and Suspension</p>
          <p>Scheduled Maintenance</p>
          <p>Wheel Alignment</p>
          <p>Air Conditioning</p>
          <button class="btn">Go Standard</button>
        </div>
      </div>
    </section>

    <section class="contact">
      <div class="section__container contact__container">
        <div class="contact__content">
          <p class="section__subheader">CONTACT US</p>
          <h2 class="section__header">Imagine Your Car Feeling New Again</h2>
          <p class="section__description">
            Experience the magic of a rejuvenated ride as we pamper your car
            with precision care, leaving it feeling as good as new.
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
              <img src="assets/testimonial-1.jpg" alt="testimonial" />
              <p>
                I couldn't believe my eyes when I got my car back from the
                service. It looked and drove like it had just rolled off the
                assembly line. The team did an incredible job, and I'm a
                customer for life!
              </p>
              <h4>- Sarah T.</h4>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="testimonial__card">
              <img src="assets/testimonial-2.jpg" alt="testimonial" />
              <p>
                I've been bringing my car here for years, and they never
                disappoint. Their attention to detail and commitment to quality
                service is unmatched. My car always feels brand new after a
                visit.
              </p>
              <h4>- John P.</h4>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="testimonial__card">
              <img src="assets/testimonial-3.jpg" alt="testimonial" />
              <p>
                As a car enthusiast, I'm extremely particular about who touches
                my prized possession. Their team's expertise and passion for
                cars truly shine through in their work. My car has never looked
                better.
              </p>
              <h4>- David S.</h4>
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
          <ul class="footer__socials">
            <li>
              <a href="#"><i class="ri-facebook-fill"></i></a>
            </li>
            <li>
              <a href="#"><i class="ri-google-fill"></i></a>
            </li>
            <li>
              <a href="#"><i class="ri-instagram-line"></i></a>
            </li>
            <li>
              <a href="#"><i class="ri-youtube-line"></i></a>
            </li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>Our Services</h4>
          <ul class="footer__links">
            <li><a href="#">Skilled Mechanics</a></li>
            <li><a href="#">Routine Maintenance</a></li>
            <li><a href="#">Customized Solutions</a></li>
            <li><a href="#">Competitive Pricing</a></li>
            <li><a href="#">Satisfaction Guaranteed</a></li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>Contact Info</h4>
          <ul class="footer__links">
            <li>
              <p>
                Experience the magic of a rejuvenated ride as we pamper your car
                with precision care
              </p>
            </li>
            <li>
              <p>Phone: <span>+91 9876543210</span></p>
            </li>
            <li>
              <p>Email: <span>info@carserving.com</span></p>
            </li>
          </ul>
        </div>
      </div>
    </footer>
    <div class="footer__bar">
      Copyright © 2023 Web Design Mastery. All rights reserved.
    </div>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="main.js"></script>
  </body>
</html>
