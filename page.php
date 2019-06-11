<!-- page.php powers pages -->
<?php 

    get_header();
    while(have_posts()) {
        the_post(); 
        pageBanner();
        ?>

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

   
    <?php 
    // get_pages() is identical to wp_list_pages function but it returns pages in memory instead of echoing 
    // if current page has children the function get_pages will return a collection of children pages 
    // if current page does not have children, it will return NULL
    $testArray = get_pages(array(
      'child_of' => get_the_ID(),
    ));
    
    // $theParent - is a child page
    // testArray will only run if page has children
    // thus the code will only run if a page is either a child or a parent
    if ($theParent or $testArray) { ?>
    <div class="page-links">
      <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent); ?></a></h2>
      <ul class="min-list">
        <?php 
        // only if current page has a parent (not a value of 0)
          if ($theParent) {
            // get id of child page
            $findChildrenOf = $theParent;
          } else {
            // get the ID since it is parent page
            $findChildrenOf = get_the_ID();
          }

          wp_list_pages(array(
            // to get rid of "pages" text
            'title_li' => NULL,
            'child_of' => $findChildrenOf,
            'sort_column' => 'menu_order',
          ));
        ?>
      </ul>
    </div>
    <?php } ?>

    <div class="generic-content">
      <?php the_content(); ?>
    </div>

  </div>
    
    <?php };

    get_footer();
?>