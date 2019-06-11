
<?php 
    get_header();
    
    while(have_posts()) {
        the_post(); 
        pageBanner();
        ?>
        

        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a> <span class="metabox__main"><?php the_title(); ?></span></p>
            </div>

            <div class="generic-content">
                <?php the_content(); ?>
            </div>

            <?php  
            $relatedProfessors = new WP_Query(array(
              'posts_per_page' => -1,
              'post_type' => 'professor',
              'orderby' => 'title',
              'order' => 'ASC',
              'meta_query' => array(
                array(
                  // if the array of related programs contains the id number of the current program 
                  'key' => 'related_programs',
                  'compare' => 'LIKE',
                  // concat as the id are in string
                  'value' => '"' . get_the_ID() . '"'
                ),   
              )
            ));
  
            if ($relatedProfessors -> have_posts()) {
              echo '<hr class="section-break">';
              echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';
              
              echo '<ul class="professor-cards">';
              while($relatedProfessors -> have_posts()) {
                $relatedProfessors -> the_post(); ?>
                  <li class="professor-card__list-item">
                    <a class="professor-card" href="<?php the_permalink(); ?>">
                      <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape') ?>" alt="<?php the_title(); ?>">
                      <span class="professor-card__name"><?php the_title(); ?></span>
                    </a>
                  </li>
                <?php }
                echo '</ul>';
            }

            // to ensure both related professor and related events render onto the page 
            // we use get_the_ID() to return the id of the page we are on for our events custom query below, however, while loop for the professors hijacked the get the id function, so it was set to the id of relatedprofessors post which broke the query below.
            // wp_reset_postdata(); function resets the global post object back to the default url based query  
            wp_reset_postdata();

          $today = date('Ymd');
          $homepageEvents = new WP_Query(array(
            'posts_per_page' => 2,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
              array(
                // only render posts if the key (event_date) is greater than or equal to today's date 
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
              ),
              array(
                // if the array of related programs contains the id number of the current program 
                'key' => 'related_programs',
                'compare' => 'LIKE',
                // concat as the id are in string
                'value' => '"' . get_the_ID() . '"'
              ),   
            )
          ));

          if ($homepageEvents -> have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';
  
            while($homepageEvents -> have_posts()) {
              $homepageEvents -> the_post(); 
              get_template_part('template-parts/content-event');
              }
          }
        ?> 

        </div>
    <?php };

    get_footer();
?>