<?php
/**
 * The main template file
 *
 *
 * It is used to display a page when nothing more specific matches a query.
 * It's also used for archive post type pages, unless a set page is specified in the WP Customizer.
 *
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package HotBox Magazine
 * @since 1.0
 * @version 1.0
 *
 *
 * If using a page to represent this archive, an archive page will be found and its section will be output instead of
 * the loop.
 */


get_header();
?>

<?php
/*
 * You can use the WP Customizer to choose a page to show its sections for an archive page
 * If you do that then a page will be queried instead of the info below
 */
global $post;
$page_archive_id = ign_get_archive_page();

//set if there is a sidebar, add the proper divs
$has_sidebar = false;
if ( $page_archive_id ) {
	if ( strpos( get_page_template_slug( $page_archive_id ), 'sidebar-left' ) !== false ) {
		echo '<div class="sidebar-template header-above container-fluid">';
		echo '<div class="flex sidebar-left">';
		$has_sidebar = true;
	}
	if ( strpos( get_page_template_slug( $page_archive_id ), 'sidebar-right' ) !== false ) {
		echo '<div class="sidebar-template header-above container-fluid">';
		echo '<div class="flex sidebar-right">';
		$has_sidebar = true;
	}
}

?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

			<?php
			if ( $page_archive_id ) :

				$post = get_post( $page_archive_id );
				setup_postdata( $post );

				locate_template( 'template-parts/acf-blocks/header_sections.php', true );
				?>

                <div class="entry-content container-content">
					<?php

					//include sections made with acf or falls back on the_content.
					locate_template( 'template-parts/acf-blocks/sections.php', true );

					?>
                </div>
				<?php wp_reset_postdata(); ?>

			<?php
			//basic archive
			else:
				?>

                <header class="page-header layout-center-content text-center">


                    <div class="header-content container-fluid">
                        <h1>
							<?php
							if ( is_home() ) {
								echo __( 'Blog', 'hotbox-magazine' );
							} else {
								echo get_the_archive_title();
							} ?>
                        </h1>

                    </div>
                </header>

                <div class="container">
                    <section class="card-grid">
						<?php
						//default to one section fo cards
						while ( have_posts() ) : the_post();

							//if get post type is a page get the card content for pages, a special file when showing many pages as an archive
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


                    <div class="container card-pagination text-center">
						<?php
						the_posts_pagination( array(
							'prev_text'          => ign_get_svg( array( 'icon' => 'angle-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'cmlaw' ) . '</span>',
							'next_text'          => '<span class="screen-reader-text">' . __( 'Next page', 'cmlaw' ) . '</span>' . ign_get_svg( array( 'icon' => 'angle-right' ) ),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'cmlaw' ) . ' </span>',
						) );
						?>
                    </div>


                </div>
			<?php endif; ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
if ( $has_sidebar ) {
	get_sidebar();
	echo '</div></div><!-- #sidebar-template -->';
}
?>
<?php
get_footer();
