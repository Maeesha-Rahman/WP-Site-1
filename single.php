<!-- single.php powers posts -->

<?php 
    get_header();
    
    while(have_posts()) {
        the_post(); 
        pageBanner();
        ?>
        

        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Blog Home</a> <span class="metabox__main">Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?></span></p>
            </div>

            <div class="generic-content">
                <?php the_content(); ?>
            </div>
        </div>
    <?php };

    get_footer();
?>

// echo  get_the_ID();
        // get parent page id of the current page 
        // the function p_get_post_parent_id will return 0 if page does not have a parent
        // if page has parent, we get the id
        // echo wp_get_post_parent_id(get_the_ID());