<?php
/**
 * Front Page Template
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 * @version 4.3
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>
	<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "LocalBusiness",
		"address": {
		"@type": "PostalAddress",
		"addressLocality": "Knoxville",
		"addressRegion": "TN"
		},
		"description": "WhisperRoom manufactures and shippes Sound Isolation Enclosures around the world.",
		"name": "WhisperRoom Inc.",
		"telephone": "(865) 936-2264",
		"email": "sales@ljprotile.com",
        "image": "<?php $custom_logo_id = get_theme_mod( 'custom_logo' ); $image = wp_get_attachment_image_src( $custom_logo_id , 'full' ); echo $image[0]; ?>",
        "priceRange": "$$$", 	
		"sameAs" : ["https://www.facebook.com/Ljprotile/"]
	}
	</script>
	<!-- Add. SEO END -->
<div class='custom_parallax' title="Parallax image of bathroom with tile work.">
	<style>
		#main .custom_parallax{
			height: 54vh;
			overflow-y: hidden;
			background: url(<?php echo wp_get_attachment_image_src(get_theme_mod("home-page-banner"), 'large', false)[0]; ?>);
			background-size: cover;
			background-repeat: no-repeat;
			display:flex;
			flex-flow: column nowrap;
			justify-content: center;
		}
		/* Medium Devices, Desktops */
		@media only screen and (min-width : 992px) {
			#main .custom_parallax{
				background-attachment: fixed;
				background-size: 100% auto;
			}
		}
	</style>
	<div>
	</div>
	<a href="<?php echo get_home_url().'/contact'; ?>">
		<h1>KNOXVILLE'S BEST TILING COMPANY</h1>
		<button>CONTACT</button>
	</a>
</div>
<div class="gallery-links">
	<?php 
		$galArgs = [
			'post_type'      => 'gal_links',
			'posts_per_page' => 10,
			'order' => 'ASC'
		];
		$galLoop = new WP_Query($galArgs);
		while ($galLoop->have_posts()) :
			$galLoop->the_post();?>
			<a href="<?php $galCustomField = get_post_custom(); echo $galCustomField['url'][0]; ?>">
				<div class="link" style="background:url(<?php echo get_the_post_thumbnail_url(null,'full'); ?>)">
					<div></div>
					<p><?php echo preg_replace('#\s+#','<br/>',trim(get_the_title())); ?></p>
				</div>
			</a>
			<?php
		endwhile;
	?>
</div>
<div class="testimonials">
	<div>
	<?php 
		$testiArgs = [
			'post_type'      => 'hp-testimonials',
			'posts_per_page' => 10,
			'order' => 'ASC'
		];
		$testiLoop = new WP_Query($testiArgs);
		while ($testiLoop->have_posts()) :
			$testiLoop->the_post();?>
			<div class="slide" title="Review for work done">
				<?php the_content(); ?>
				<h5><?php the_title(); ?></h5>
			</div>
			<?php
		endwhile;
	?>
	</div>
	<img src="<?php echo get_template_directory_uri(); ?>/assets/images/5_star_x279x60.png" style="display:block;margin:auto; margin-bottom:1em;" alt="Image of 5 star rating for 5 star reviews"/>
</div>
	<div id="content-wrap" class="container clr">

		<?php wpex_hook_primary_before(); ?>

		<div id="primary" class="content-area clr">

			<?php wpex_hook_content_before(); ?>

			<div id="content" class="site-content clr">

				<?php wpex_hook_content_top(); 
				// Start loop
					while ( have_posts() ) : the_post();
					// Single Page
					if ( is_singular( 'page' ) ) {

						wpex_get_template_part( 'page_single_blocks' );

					}

					// Single posts
    				elseif ( is_singular( 'post' ) ) {

    					wpex_get_template_part( 'blog_single_blocks' );

    				}

					// Portfolio Posts
					elseif ( is_singular( 'portfolio' ) && WPEX_PORTFOLIO_IS_ACTIVE ) {

						wpex_get_template_part( 'portfolio_single_blocks' );

					}

					// Staff Posts
					elseif ( is_singular( 'staff' ) && WPEX_STAFF_IS_ACTIVE ) {

						wpex_get_template_part( 'staff_single_blocks' );

					}

					// Testimonials Posts
					elseif ( is_singular( 'testimonials' ) && WPEX_TESTIMONIALS_IS_ACTIVE ) {

						wpex_get_template_part( 'testimonials_single_blocks' );

					}

					// All other post types - when customizing your custom post types it's best to create
					// a new singular-{post_type}.php file to prevent any possible conflicts in the future
					// rather then altering the template part.
					else {

						wpex_get_template_part( 'cpt_single_blocks', get_post_type() );

  					}

				endwhile; ?>

				<?php wpex_hook_content_bottom(); ?>

			</div><!-- #content -->

			<?php wpex_hook_content_after(); ?>

		</div><!-- #primary -->

		<?php wpex_hook_primary_after(); ?>

	</div><!-- .container -->

<?php get_footer(); ?>