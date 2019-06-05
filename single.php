<!-- single.php powers posts -->

<?php 
    get_header();
    
    while(have_posts()) {
        the_post(); ?>
        <h2><?php the_title(); ?></h2>
        <?php the_content(); ?>
    
    <?php };

    get_footer();
?>

// echo  get_the_ID();
        // get parent page id of the current page 
        // the function p_get_post_parent_id will return 0 if page does not have a parent
        // if page has parent, we get the id
        // echo wp_get_post_parent_id(get_the_ID());