<?php
    
    // TOUR DATES
    // Check for manually entered tour dates
    
    require_once('../../../../wp-load.php');
    
    function get_tour_dates_manual($id) {
        
        $args = array(
            'p' => $id,
            'post_type' => 'post',
            'post_status' => 'publish'
        );
        
        $tour_dates_query = new WP_Query($args);
        
        if ( $tour_dates_query->have_posts() ) :
            
            // The Loop
            while ( $tour_dates_query->have_posts() ) : $tour_dates_query->the_post();
                
                $tourDates = get_field('tour');
                
                // Send info back to tourDatesManualCheck
                if( $tourDates ) {
                    echo json_encode($tourDates);
                } else {
                    echo '';
                }
                
            endwhile;
            
        else :
            echo '';
        endif;
        
    }
    
    $id = urldecode($_GET['id']);
    get_tour_dates_manual($id);
    
?>