<?php
/**
* Template Name: Gallery Page
*
* @package WordPress
* @subpackage total-modified
* @since Total 4.4
*/
?>
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
                <div id="gallery-cont" >
                    <?php
						wp_reset_postdata();
                        //Custom loop Start 
                        function custom_gallery_page_loop(){
                            $testiArgs = [
                                'post_type'      => 'gallery-items',
								'posts_per_page' => 10,
								'paged' => get_query_var('paged') ? get_query_var('paged') : 1 ,
								'meta_query' => array(
									array(
										'key'     => 'gallery_type',
										'value'   => array(getSlug()),
										'compare' => 'IN',
									)
								),
								'order' => 'DESC'
							];
                            $testiLoop = new WP_Query($testiArgs);
							$loopCount = 0;
							echo get_previous_posts_link('<div class="previous-link">▲  Previous Images  ▲</div>');
							while ($testiLoop->have_posts()) :
                                $testiLoop->the_post();?>
                                <div class="photo" postid="<?php the_ID(); ?>" title="<?php the_title(); ?>">
                                    <?php echo get_the_post_thumbnail(); ?>
                                </div>
                                <?php
								$loopCount++;
							endwhile;
							echo get_next_posts_link('<div class="more-link">▼  More Images  ▼</div>', $testiLoop->max_num_pages );
							wp_reset_postdata();//resets post data
							?>
							<style>
								.page-header{
									margin-bottom: 0px;
								}
                                #gallery-cont{
									height: auto;
									display: flex;
									flex-flow: column nowrap;
                                }
								#gallery-cont .photo{
									width: 100vw;
									height: auto;
									margin-bottom: .05em;
								}
								#gallery-cont .photo:hover{
									opacity: .65;
								}
								#gallery-cont .photo img{
										width: 100%;
								}
								#gallery-cont>a{
									display:block;
									width: 100%;
								}
								#gallery-cont .previous-link{
									position: absolute;
									background: rgba(255,255,255,.5);
									width: 100%;
									height: 2em;
									top: 0;
									color: #000;
									text-align: center;
								}
								#gallery-cont .more-link{
									position: absolute;
									background: rgba(255,255,255,.5);
									width: 100%;
									height: 2em;
									bottom: 0;
									color: #000;
									text-align: center;
								}
								#gallery-cont .more-link:hover, #gallery-cont .previous-link:hover{
									background: rgba(255,255,255,1);
								}
								@media only screen and (min-width : 768px) {
									#gallery-cont>a{
										position: absolute;
										height: 6vw;
										left: 0em;
										bottom: 0em;
									}
									#gallery-cont>a:first-child{
										position: absolute;
										left: 0em;
										top: 0em;
									}
									#gallery-cont .photo:hover{
										opacity: unset;
										cursor: pointer;
									}
									#gallery-cont .previous-link, #gallery-cont .more-link{
										height: 6vw;
										line-height: 6vw;
										font-size: 3em;
									}
									#gallery-cont .more-link:hover{
										background: #f7f7f7;
										color: #002c52;
									}
								}
								/* Medium Devices, Desktops 
								@media only screen and (min-width : 992px) {
									#gallery-cont{
										height:100vh;
									}
									#gallery-cont .photo{
										width: 50vw;
									}
								}*/
                            </style>
							<?php
							if($loopCount > 2): //has enough content
							?>
                            <style>
								/*SM*/
								@media only screen and (min-width : 768px) {
									#gallery-cont{
										flex-flow: column wrap;
										justify-content: flex-start;
									}
									#gallery-cont .photo{
										width: 48vw;
										margin: .75vw .5vw;
										margin-bottom: unset;
									}
								}
								/* Medium Devices, Desktops*/
								@media only screen and (min-width : 992px) {
									#gallery-cont .photo{
										width: 33vw;
										margin: .15vw;
										margin-bottom: unset;
									}
								}
                            </style>
							<script>
								var enoughCont = true;
							</script>
							<?php else: ?>
							<style>
                                /*SM*/
								@media only screen and (min-width : 768px) {
									#gallery-cont{
										flex-flow: row nowrap;
										justify-content: space-around;
									}
									#gallery-cont .photo:first-child{
										width: 50vw;
										margin: .5vw;
									}
									#gallery-cont .photo{
										width: 50vw;
										margin: .5vw;
										margin-bottom: unset;
									}
								}
                            </style>
							<script>
								var enoughCont = false;
							</script>
						<?php
							endif;
                        }
                        custom_gallery_page_loop();
                    ?>
					<!--ImageModal Start-->
					<div id="custom-modal">
						<span>x</span>
						<div>
							<!-- Modal Content -->
						</div>
					</div>
					<script>
						var ajaxUrl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
						jQuery(function($) {
							var modal = $('#custom-modal');
							$('#gallery-cont .photo').click(function() {
								var clickID = $(this).attr('postid');
								var data = {
									'action': 'load_posts_by_ajax',
									'id': clickID ,
									'security': '<?php echo wp_create_nonce("open_gallery_item_data"); ?>'
								};
								$.post(ajaxUrl, data, function(response) {
									console.log(response);
									modal.css('display','block');
									//html generation
									var content = "<h1>".concat(response.title, "</h1>\
													<div class='img-cont'>", response.image, "</div>\
													<div class='content'>", response.content, "</div>\
													<a href='<?php echo home_url('/contact?clickTitle='); ?>", response.title, "&page=<?php echo getSlug() ; ?>'>\
														<span>ASK US ABOUT THIS DESIGN >></span>\
														<button>CONTACT</button>\
													</a>");
									//html insertion
									modal.children('div').html(content);
								}, 'json');
							});
							//close
							$('#custom-modal>span').click(function () {
								modal.css('display','none');
								modal.children('div').html('');
							});
						});
					</script>
					<style>
						#custom-modal{
							display: none;
							position: fixed;
							top: 0em;
							width: 100%;
							height: 100%;
							background: rgba(0, 0, 0, .65);
							z-index: 1000;
						}
						#custom-modal>span{
							display: block;
							position: absolute;
							height: 2em;
							width: 2em;
							right: 0em;
							top: 0em;
							font-family: sans-serif;
							font-size: 2em;
							line-height: 2em;
							text-align: center;
							color: #FFF;
						}
						#custom-modal>span:hover{
							cursor: pointer;
						}
						#custom-modal>div>h1{
							font-family: adobe-hebrew, sans-serif;
							font-weight: 600;
							font-style: normal;
							text-align: center;
							font-size: 2em;
							color: #FFF;
							margin-top: 2em;
						}
						#custom-modal>div .img-cont{
							width: auto;
							max-width: 90vw;
							margin:auto;
						}
						#custom-modal>div .img-cont img{
							display: block;
							width: auto;
							max-height: 40vh;
							margin: auto;
						}
						#custom-modal>div .content{
							width: 90vw;
							height: 30vh;
							overflow-y: scroll;
							margin:auto;
							font-size: 1.25em;
							color: #FFF !important;
						}
						#custom-modal>div .content h1, #custom-modal>div .content h2, #custom-modal>div .content h3, #custom-modal>div .content h4, #custom-modal>div .content h5{
							margin-top: .5em;
						}
						#custom-modal>div .content h1, #custom-modal>div .content h2, #custom-modal>div .content h3, #custom-modal>div .content h4, #custom-modal>div .content h5, #custom-modal>div .content p{
							color: #FFF !important;
						}
						#custom-modal>div>a{
							display: block;
							width: auto;
							max-width: 90vw;
							margin:auto;
						}
						#custom-modal>div>a>span{
							display:none;
						}
						#custom-modal>div>a button{
							display: block;
							background: transparent;
							height: 6vh;
							line-height: 1.5em;
							color: #FFF;
							border: Solid #FFF .15em;
							margin: auto;
							margin-top: 1em;
						}
						/* Medium Devices, Desktops*/
						@media only screen and (min-width : 992px) {
							#custom-modal>div{
								background: rgba(192,192,192,.35);
								width: 80vw;
								height: 76vh;
								margin: auto;
							}
							#custom-modal>div>h1{
								font-size: 3em;
								margin-top: 8vh;
							}
							#custom-modal>div .img-cont{
								width: 40vw;
								max-width: 40vw;
								height: 50vh;
								max-height: 90vh;
								margin:auto;
								float: left;
							}
							#custom-modal>div .img-cont img{
								width: auto;
								height: 100%;
								max-height: unset;
								margin: auto;
							}
							#custom-modal>div .content{
								float:right;
								width: 36vw;
								height: 50vh;
								margin-right: 4vw;
							}
							#custom-modal>div>a{
								position: absolute;
								display: flex;
								flex-flow: row nowrap;
								justify-content: space-around;
								align-items: center;
								width: 80vw;
								max-width: unset;
								clear: both;
								height: 8vh;
								text-decoration: none;
    							bottom: 18vh;
							}
							#custom-modal>div>a>span{
								display: inline-block;
								text-align: center;
								font-size: 1.4em;
								color: #FFF;
							}
							#custom-modal>div>a button{
								display: inline-block;
								width: 8em;
								height: 2.4em;
								font-size: 1.4em;
								margin: unset;
								padding: 0em 1em 0em 1em;
								margin-top: unset;
							}
						}
					</style>
					<!-- Image Modal End -->
                </div>
		    </div><!-- #content -->
			<?php wpex_hook_content_after(); ?>
		</div><!-- #primary -->
		<?php wpex_hook_primary_after(); ?>
	</div><!-- .container -->

<?php get_footer(); ?>
<style>
    #main .page-header-title span{
        display: block;
        text-align: center;
    }
</style>