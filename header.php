<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title>
                <?php bloginfo('name'); ?> <?php wp_title(); ?>
        </title>
       
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
       
         <?php wp_head(); ?>
</head>

<!-- #site-navigation -->   
    		<nav id="site-navigation" class="main-navigation" role="navigation">               
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'phagens' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class' => 'nav-menu' ) ); ?>
		</nav><!-- #site-navigation -->

<body <?php body_class(); ?>>
     
    
        <div id="page">


  <header id="masthead" class="site-header" role="banner">

<div id="header">
                        
<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                        <h4><?php bloginfo('description'); ?></h4>
                </div>
		

		

	</header><!-- #masthead -->  
            
           




