<?php
/**
 * HotBox Magazine: Customizer
 *
 * @package HotBox Magazine
 * @since 1.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function hotbox_magazine_customize_register( $wp_customize )
{
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

    $wp_customize->selective_refresh->add_partial( 'blogname', array(
        'selector' => '.site-title a',
        'render_callback' => 'hotbox_magazine_customize_partial_blogname',
    ) );

    $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
        'selector' => '.site-description',
        'render_callback' => 'hotbox_magazine_customize_partial_blogdescription',
    ) );


    /**
     * Theme options.
     */
    $wp_customize->add_section( 'theme_options', array(
        'title' => __( 'Theme Options', 'hotbox-magazine' ),
        'priority' => 130, // Before Additional CSS.
    ) );

    $wp_customize->add_section( 'post_types', array(
        'title' => __( 'Post Type Archives', 'hotbox-magazine' ),
        'priority' => 130, // Before Additional CSS.
    ) );


    /**
     * Layout of Site top
     */
    $wp_customize->add_setting( 'site_top_use_customizer',
        array(
            'default' => 'yes'
        ) );

    // Add a control to choose yes/no
    $wp_customize->add_control( 'site_top_use_customizer',
        array(
            'label' => __( 'Use the customizer?' ),
            'section' => 'theme_options',
            'type' => 'radio',
            'description' => __('You can make your own layout in header.php and ignore all this.', 'hotbox-magazine'),
            'choices' => array(
                'yes' => 'yes',
                'no' => 'no'
            )
        ) );


    /**
     * Nav Menu and Logo Options
     */
    $wp_customize->add_setting( 'site_top_contained',
        array(
            'default' => 'container',
            'transport' => 'postMessage',
        ) );


    $wp_customize->add_control( 'site_top_contained',
        array(
            'label' => __( 'Contain the site top items', 'hotbox-magazine' ),
            'section' => 'theme_options',
            'type' => 'select',
            'choices' => array(
                'container' => 'contained',
                'container-fluid' => 'full width'
            ),
            'description' => __('You can set contained size via $container in scss', 'hotbox-magazine')
        ) );


    /**
     * Layout of Site top
     */
    $wp_customize->add_setting( 'site_top_layout',
        array(
            'default' => 'logo-left',
            'transport' => 'postMessage'
        ) );

    // Add a control to upload the logo
    $wp_customize->add_control( 'site_top_layout',
        array(
            'label' => __( 'Logo Position' ),
            'section' => 'theme_options',
            'type' => 'select',
            'description' => __('You can make your own layout in php in header.php and ignore presets and manual settings.', 'hotbox-magazine'),
            'choices' => array(
                'logo-left' => 'logo-left',
                'logo-right' => 'logo-right',
                'logo-center' => 'logo-center',
                'logo-center-under' => 'logo-center-under',
                'logo-in-middle' => 'logo-in-middle',
                'no-logo' => 'no-logo'
            )
        ) );


    /*
     $wp_customize->selective_refresh->add_partial( 'site_top_layout', array(
        'selector'  => '.site-top-inner-container',
    ) );
    */


    /**
     * Add cool menu capability. app like menu on mobile
     *
     */
    $wp_customize->add_setting( 'app_menu',
        array(
            'default' => false,
        ) );

    $wp_customize->add_control( 'app_menu',
        array(
            'label' => __( 'Enable App-like Menu' ),
            'section' => 'theme_options',
            'type' => 'checkbox'
        ) );


    $wp_customize->add_setting( 'menu_icon',
        array(
            'default' => 'regular',
        ) );

    $wp_customize->add_control( 'menu_icon',
        array(
            'label' => __( 'Menu Icon' ),
            'section' => 'theme_options',
            'type' => 'select',
            'choices' => array(
                'regular' => '= to x',
                'menu' => 'menu'
            )
        ) );


//add post type header page
    $hotbox_magazine_post_types = get_post_types( array('_builtin' => false, 'has_archive' => true), 'objects' );
    $hotbox_magazine_post_types[] = get_post_type_object( 'post' );
    foreach ($hotbox_magazine_post_types as $post_type) {

        $wp_customize->add_setting( 'ign_archive_' . $post_type->name,
            array(
                'default' => '',
            ) );

        if( $post_type->name == 'post'){
        	$description = __( 'Set a pages sections to be used for the post. The blog must be set to a static page', 'hotbox-magazine');
        }else{
        	$description = __( 'Set a page to be used to display the archive For this post type. Note: Post type must have an archive page.', 'hotbox-magazine' );
        }

        $wp_customize->add_control( 'ign_archive_' . $post_type->name, array(
            'label' => __( 'Archive Page For ', 'hotbox-magazine' ) . ucwords( $post_type->labels->singular_name ),
            'type' => 'dropdown-pages',
//  'allow_addition' => true,
            'section' => 'post_types',
            'description' => $description
        ) );
    }
}

add_action( 'customize_register', 'hotbox_magazine_customize_register' );


/**
 * Render the site title for the selective refresh partial.
 *
 * @since Ignition 1.0
 * @see hotbox_magazine_customize_register()
 *
 * @return void
 */
function hotbox_magazine_customize_partial_blogname()
{
    bloginfo( 'name' );
}


/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Ignition 1.0
 * @see hotbox_magazine_customize_register()
 *
 * @return void
 */
function hotbox_magazine_customize_partial_blogdescription()
{
    bloginfo( 'description' );
}



/**
 * Bind JS handlers to instantly live-preview changes.
 */
function hotbox_magazine_customize_preview_js()
{
    wp_enqueue_script( 'hotbox-magazine-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js'
    ), array('jquery', 'customize-preview'), '1.0', true );
}

add_action( 'customize_preview_init', 'hotbox_magazine_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function hotbox_magazine_panels_js()
{
    wp_enqueue_script( 'hotbox-magazine-customize-controls', get_theme_file_uri( '/assets/js/customize-controls.js' ), array(), '1.0', true );
}
//add_action( 'customize_controls_enqueue_scripts', 'hotbox_magazine_panels_js' );