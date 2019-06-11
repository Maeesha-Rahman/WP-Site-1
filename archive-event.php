<?php 

get_header(); 
// associative array in which we make our own parameters, unlike the associative arrays we have made so far that used built-in parameters. 
pageBanner(array(
  'title' => 'All Events',
  'subtitle' => 'See what is going on in our world.'
));
?> 

  <div class="container container--narrow page-section">
    <?php 
  while(have_posts()) {
    the_post();  
    get_template_part('template-parts/content-event');
  }
    // pagination for blog links
    echo paginate_links();
    
  ?>
    <hr class="section-break">
    <p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events'); ?>">Check out our past events archive.</a></p>


  </div>

<?php get_footer();

?>