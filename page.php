<!-- page.php powers pages -->
<?php 

    get_header();
    while(have_posts()) {
        the_post(); ?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title(); ?></h1>
      <div class="page-banner__intro">
        <p>Don't forget to replace me later</p>
      </div>
    </div>  
  </div>

  <div class="container container--narrow page-section">

    <?php 
    // if current page is a child page, show the breadcrumb nav 
    // if it is a parent page the id will be 0 which is falsy and thus the code will not run
    // thus it will only run if the id has a number greater than 0 - truthy 
       $theParent = wp_get_post_parent_id(get_the_ID());
       if ($theParent) {
           ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
            </div>
            <?php
       }

        // echo  get_the_ID();
        // get parent page id of the current page 
        // the function p_get_post_parent_id will return 0 if page does not have a parent
        // if page has parent, we get the id
        // echo wp_get_post_parent_id(get_the_ID());
    ?>

   
    
    <!-- <div class="page-links">
      <h2 class="page-links__title"><a href="#">About Us</a></h2>
      <ul class="min-list">
        <li class="current_page_item"><a href="#">Our History</a></li>
        <li><a href="#">Our Goals</a></li>
      </ul>
    </div> -->

    <div class="generic-content">
      <?php the_content(); ?>
    </div>

  </div>
    
    <?php };

    get_footer();
?>