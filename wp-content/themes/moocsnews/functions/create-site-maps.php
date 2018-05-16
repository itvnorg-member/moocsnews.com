<?php

add_action( "save_post", "itvndocorg_create_sitemap" );   
add_action( "clean_term_cache", "itvndocorg_create_sitemap_taxonomies" );   
function itvndocorg_create_sitemap() {
    $postsForSitemap = get_posts( array(
        'numberposts' => -1,
        'orderby'     => 'modified',
        'post_type'   => array( 'course' ),
        'order'       => 'DESC'
    ) );
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
    $sitemap .= "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";    
    foreach( $postsForSitemap as $post ) {
        setup_postdata( $post );   
        $postdate = explode( " ", $post->post_modified );   
        $sitemap .= "\t" . '<url>' . "\n" .
            "\t\t" . '<loc>' . get_permalink( $post->ID ) . '</loc>' .
            "\n\t\t" . '<lastmod>' . $postdate[0] . '</lastmod>' .
            "\n\t\t" . '<changefreq>weekly</changefreq>' .
            "\n\t" . '</url>' . "\n";
    }     
    $sitemap .= '</urlset>';     
    $fp = fopen( ABSPATH . "sitemap.xml", 'w' );
    fwrite( $fp, $sitemap );
    fclose( $fp );
    itvndocorg_create_sitemap_taxonomies();
}

/* function to create/update sitemap-categories.xml/sitemap-tags.xml file in root directory of site  */ 
function itvndocorg_create_sitemap_taxonomies(){
    $taxonomies = [
        'post_tag',
        'subject',
        'provider',
        'institution',
    ];

    foreach ($taxonomies as $item) {
        if($_POST['taxonomy'] === $item){
            itvndocorg_create_sitemap_taxonomy($item);
        }
    }
	
	
}

/* function to create/update sitemap-categories.xml file in root directory of site  */  
function itvndocorg_create_sitemap_taxonomy($taxonomy){
    $terms = get_terms( array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
        'orderby'   => 'count',
        'order'     =>  'DESC',
    ) );

    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
    $sitemap .= "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";    
    foreach( $terms as $item ) { 
        $sitemap .= "\t" . '<url>' . "\n" .
            "\t\t" . '<loc>' . get_category_link( $item ) . '</loc>' .
            "\n\t\t" . '<lastmod>' . date('Y-m-d') . '</lastmod>' .
            "\n\t\t" . '<changefreq>weekly</changefreq>' .
            "\n\t" . '</url>' . "\n";
    }     
    $sitemap .= '</urlset>'; 

    $fp = fopen( ABSPATH . "sitemap-".$taxonomy.".xml", 'w' );
    fwrite( $fp, $sitemap );
    fclose( $fp );
}