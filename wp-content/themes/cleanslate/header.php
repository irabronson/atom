<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package CleanSlate
 * @since CleanSlate 0.1
 */
?>

<!DOCTYPE html>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width" />
        <title>
            <?php
            /*
             * Print the <title> tag based on what is being viewed.
             */
            global $page, $paged;

            wp_title( '|', true, 'right' );

            // Add the blog name.
            bloginfo( 'name' );

            // Add the blog description for the home/front page.
            $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) )
                echo " | $site_description";
            
            ?>
        </title>
        <meta name="description" content="<?php echo $site_description; ?>" />
        
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/style.css" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        
        <!--[if lt IE 9]>
            <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
        <![endif]-->
        
        <?php wp_enqueue_scripts(); ?>
        
        <?php wp_head(); ?>
        
        <?php /*Custom JS Files*/ ?>
            <script type="text/javascript">
                var $j = jQuery.noConflict();
                var templateDirectoryUrl = '<?php echo get_template_directory_uri(); ?>';
            </script>
            <!-- <script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.js" type="text/javascript"></script> -->
            
    </head>
    
    <body <?php body_class();?>>
        
    <?php include_once('analytics/ga.php'); ?>
    
    <!-- Outer body wrapper: #page -->
    <div id="page">
        
        <header id="branding" role="banner">
            <div id="logo">
                <!-- Main Title -->
                <h1 id="site-title">
                    <a href="<?php echo esc_url(home_url( '/' )); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                        <?php
                            // Retrieve header image
                            $header_image = get_header_image();
                            
                            // BEGIN: Header Image Conditional
                            if ( ! empty( $header_image ) ) :
                        ?>
                            <!-- Header Image and Link -->
                            <img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
                            
                        <?php
                            // END: Header Image Conditional
                            endif;
                        ?>
                        
                        <!-- Include header text for SEO but hide this <span> with CSS -->
                        <span><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></span>
                    </a>
                </h1>
                
                <!-- Page Title -->
                <h2>
                    <?php
                        if( is_home() || is_page('home') ) :
                            echo 'Home';
                        else :
                            wp_title('');
                        endif;
                    ?>
                </h2>
            </div>
            
            <nav id="main-menu" role="navigation">
                <?php
                    // default menu
                    wp_nav_menu( array( 'theme_location' => 'primary' ) );
                ?>
            </nav>
        </header>
        
        <!-- Main content wrapper: #main -->
        <div id="main">