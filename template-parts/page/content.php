<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package HotBox_Magazine
 * @since 1.0
 * @version 1.0
 *
 * We have two types of views here.
 * full page views for pages.
 *
 */

$post_type = get_post_type();
$id        = get_the_ID();

?>


    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php
		//special header layouts can be used with acf, otherwise a fallback header is used.
		//Soon custom header acf-blocks for Gutenberg will be made
		//if this is a sidebar template, js is used to pop out this header and put above the article at full width.
		//this way its semantically placed inside properly, but moved out and looks nicely placed above the sidebar
		locate_template( 'template-parts/acf-blocks/header_sections.php', true );

		?>

        <div class="entry-content container-content">

			<?php

			//include sections made with acf or falls back on the_content.
			locate_template( 'template-parts/acf-blocks/sections.php', true );


			wp_link_pages( array(
				'before'      => '<div class="page-links">' . __( 'Pages:', 'hotbox-magazine' ),
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			) );
			?>
        </div><!-- .entry-content -->
    </article><!-- #page-## -->
<?php if ( comments_open() || get_comments_number() ) :?>
    <section class="after-article container-content">
		<?php
		// If comments are open or we have at least one comment, load up the comment template.
		comments_template();
		?>
    </section>

<?php endif;  ?>