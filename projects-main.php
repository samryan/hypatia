<?php
/*
Template Name: /Projects main page/

Page template for the main projects page.
*/
?>

<?php get_header(); ?>

  <section class="bg-default">
    <div class="container">
      <h2 class="entry-title">Projects</h2>
      <p>I&rsquo;m a professional user experience designer and a self-taught front-end web developer. I&rsquo;ve taken graduate classes in information architecture, project management, and UX design. I&rsquo;m good at working with diverse groups of people to execute complex projects at scale. This page has links to some of the recent projects I&rsquo;ve done that I can talk about!</p>
    </div>
  </section>
  <section class="bg-gray projects-list">
    <div class="container">
      <h3><b>Amazon</b></h3>
      <p>I work for Amazon&rsquo;s <a href="https://www.amazon.jobs/axt">Advertising Experience &amp; Technology</a> group, making our ad business more interesting and better for customers. Some of my projects at Amazon include:</p>
      <a class="project" href="/projects/ad-landing-pages">
        <b>Ad Landing Pages</b>
        <br>
        <span>An internal tool for Amazon designers to make landing pages without writing any code.</span>
      </a>
      <a class="project" href="/projects/advertise-your-app">
        <b>Advertise Your App</b>
        <br>
        <span>Do-it-yourself ad campaigns for app developers. Featured in TechCrunch!</span>
      </a>
      <a class="project" href="/projects/amazon-mobile-ad-placements">
        <b>Amazon Mobile ad placements</b>
        <br>
        <span>Scaling a worldwide ads business as our customers migrate to mobile shopping.</span>
      </a>
      <a class="project" href="/projects/mobile-add-to-cart">
        <b>Mobile Add to Cart ad format</b>
        <br>
        <span>A new eCommerce-enabled ad format, unique to Amazon.</span>
      </a>
      <a class="project" href="/projects/mobile-interstitial-ads">
        <b>Mobile interstitial ad format</b>
        <br>
        <span>Iterative design and development of a full screen ad format for third-party apps.</span>
      </a>
      <a class="project" href="/projects/fit-ratings">
        <b>Fit ratings (internship project)</b>
        <br>
        <span>A detail page feature that helps you pick the right size for clothes.</span>
      </a>
      <small>This section doesn&rsquo;t include in-progress or unreleased projects.</small>
    </div>
  </section>
  <section class="bg-default projects-list">
    <div class="container">
      <h3><b>Older projects</b></h3>
      <hr style="width:100%;visibility:hidden;height:0;margin:0;">
      <a class="project" href="/projects/haas">
        <b>Haas School of Business</b>
        <br>
        <span>My first job was as a front-end web developer, coding for UC Berkeley&rsquo;s world-renowned business school.</span>
      </a>
      <a class="project" href="/projects/thesis">
        <b>&ldquo;A Man in Time of War&rdquo;: How Colonial Boys became American Men, 1765–1775</b>
        <br>
        <span>I self-published my undergraduate history thesis on Amazon&rsquo;s Kindle store in 2011.</span>
      </a>
      <a class="project" href="/projects/american-orpheus">
        <b>American Orpheus: The Life &amp; Work of Bob Dylan</b>
        <br>
        <span>In my final year at Berkeley, I taught a class about Bob Dylan in the English department.</span>
      </a>
    </div>
  </section>


  <?php
get_footer();
