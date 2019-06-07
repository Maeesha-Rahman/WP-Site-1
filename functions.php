<?php 
    function university_files() {
        // js file load
        // third argument NULL - means it does not have any dependencies - other js files that need to be loaded for the current js file to work
        // 4th argument is version num - can put anything. use microtime to get a unique version to prevent caching. DON'T USE THIS FOR A LIVE WEBSITE ONLY FOR DEVELOPMENT MODE. 
        // 5th argument - state whether you want it to be loaded right before closing body tag - true means yes
        wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
        // the first arguments name does not matter - whatever we want to name it
        // the 2nd argument is the location that points to that file
        
        wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime());
    };
    // first argument tells wordpress what type of instructions we are giving - the name matters
    // load some css or js files
    // second argument - give wordpress the name of a function we want to run - the name does not matter
    // we don't call the function university_files() and that is why there are no parenthesis, we give it the name of the function to wordpress and it's up to wordpress to run it at the right moment
    add_action('wp_enqueue_scripts', 'university_files');

    function university_features() {
        // set up unique title for each page (title tag in head)
        add_theme_support('title-tag');
        // first argument can be named anything, 2nd argument is any human friendly name you want (text that will show up in wp admin screen), 
        // register_nav_menu('headerMenuLocation', 'Header Menu Location');
    };

    add_action('after_setup_theme', 'university_features');

    function university_adjust_queries($query) {
        if (!is_admin() && is_post_type_archive('program') && $query -> is_main_query()) {
            $query -> set('orderby', 'title');
            $query -> set('order', 'ASC');
            // to show all posts at once, use -1
            $query -> set('posts_per_page', -1);
        }
        // if we are not on admin page and the post type is an event, then apply the following to the event post
        // query is the post
        if (!is_admin() && is_post_type_archive('event') && $query -> is_main_query()) {
            $today = date('Ymd');
            $query -> set('meta_key', 'event_date');
            $query -> set('orderby', 'meta_value_num');
            $query -> set('order', 'ASC');
            $query -> set('meta_query', array(
                array(
                  // only render posts if the key (event_date) is greater than or equal to today's date 
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'numeric'
                )  
              ));
        }
    };
    // before you get the post, call the function to filter what post gets rendered
    add_action('pre_get_posts', 'university_adjust_queries');

?>