<?php
/**
 * The template for displaying search results pages
 * If you want to have this display with a sidebar, uncomment the sidebar out at the bottom.
 * Add the class .page-template-sidebar-right or left to the main element
 * Or just add the pull in sidebar
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package HotBox_Magazine
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <header class="page-header layout-center-content text-center">

                <div class="header-content container-fluid">
                    <?php if ( have_posts() ) : ?>
                        <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'hotbox-magazine' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                    <?php else : ?>
                        <h1 class="page-title"><?php _e( 'Nothing Found', 'hotbox-magazine' ); ?></h1>
                    <?php endif; ?>
                    <div class="container-content">
                        <?php
                        get_search_form();
                        ?>
                    </div>
                </div>
            </header>


	        <div class="container">
		        <section class="card-grid">
			        <?php
			        //default to one section fo cards
			        while ( have_posts() ) : the_post();

				        //if get post type is a page get the card content for pages, a special file when showing many pages on an archive
				        if ( get_post_type() == 'page' ) {
					        include( locate_template( 'template-parts/page/card-content.php' ) );
				        }

				        //if folder of post type doesn't exist, use basic post content.
                        elseif ( ! file_exists( locate_template( 'template-parts/' . get_post_type() ) ) ) {
					        include( locate_template( 'template-parts/post/content.php' ) );
				        } else {
					        if ( get_post_format() && file_exists( locate_template( 'template-parts/' . get_post_type() . '/content-' . get_post_format() . '.php' ) ) ) {
						        include( locate_template( 'template-parts/' . get_post_type() . '/content-' . get_post_format() . '.php' ) );
					        } else {
						        include( locate_template( 'template-parts/' . get_post_type() . '/content.php' ) );
					        }
				        }

			        endwhile; // End of the loop.
			        ?>
		        </section><!-- .entry-content -->

		        <div class="container">
			        <?php

			        the_posts_pagination( array(
				        'prev_text'          => ign_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'hotbox-magazine' ) . '</span>',
				        'next_text'          => '<span class="screen-reader-text">' . __( 'Next page', 'hotbox-magazine' ) . '</span>' . ign_get_svg( array( 'icon' => 'arrow-right' ) ),
				        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'hotbox-magazine' ) . ' </span>',
			        ) );

			        ?>

		        </div>
	        </div>

        </main><!-- #main -->
    </div><!-- #primary -->



<?php get_footer();
