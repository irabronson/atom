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
                
                $tourDates = get_field('tour_dates');
                
                if( $tourDates ) {
                    
                    // Create new array to filter through data
                    $newTourDates = array();
                    
                    $i = 0;
                    foreach( $tourDates as $tourDate ) :
                        
                        $date = $tourDate['tour_date'];
                        $dateFormatted = date('M d', strtotime($date));
                        $location = $tourDate['tour_location'];
                        
                        // Only add to array if there is content
                        if ( $date != '' && $location != '' ) {
                            
                            // Add clean data to new array
                            $newTourDates[$i] = array(
                                'tour_date' => $dateFormatted,
                                'tour_location' => $location
                            );
                        }
                        
                        $i++;
                        
                    endforeach;
                    
                    // Overwrite old array with new, filtered one
                    $tourDates = $newTourDates;
                    
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