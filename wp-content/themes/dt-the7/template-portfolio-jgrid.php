<?php
/* Template Name: 网格对齐布局作品集 */

/**
 * Portfolio justified grid layout.
 *
 * @package presscore
 * @since presscore 2.2
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

global $post;
$config = Presscore_Config::get_instance();
$config->set('template', 'portfolio');
$config->set('justified_grid', true);
$config->base_init();

// override some settings
$config->set('all_the_same_width', true);
$config->set('layout', 'grid');

add_action('presscore_before_main_container', 'presscore_page_content_controller', 15);

get_header(); ?>

		<?php if ( presscore_is_content_visible() ): ?>

			<!-- Content -->
			<div id="content" class="content" role="main">

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); // main loop ?>

					<?php do_action( 'presscore_before_loop' ); ?>

					<?php if ( !post_password_required() ) : ?>

					<?php
					$load_style = $config->get('load_style');
					$ajax_class = 'default' != $load_style ? ' with-ajax' : '';

					$full_width = $config->get('full_width');
					$item_padding = $config->get('item_padding');
					$target_height = $config->get('target_height');

					$ppp = $config->get('posts_per_page');
					$order = $config->get('order');
					$orderby = $config->get('orderby');
					$display = $config->get('display');
					$request_display = $config->get('request_display');
					// $layout = $config->get('layout');

					$all_terms = get_categories( array(
						'type'          => 'dt_portfolio',
						'hide_empty'    => 1,
						'hierarchical'  => 0,
						'taxonomy'      => 'dt_portfolio_category',
						'pad_counts'    => false
					) );

					$all_terms_array = array();
					foreach ( $all_terms as $term ) {
						$all_terms_array[] = $term->term_id;
					}

					$page_args = array(
						'post_type'		=> 'dt_portfolio',
						'post_status'	=> 'publish' ,
						'paged'			=> dt_get_paged_var(),
						'order'			=> $order,
						'orderby'		=> 'name' == $orderby ? 'title' : $orderby,
					);

					if ( $ppp ) {
						$page_args['posts_per_page'] = intval($ppp);
					}

					if ( 'all' != $display['select'] && !empty($display['terms_ids']) ) {

						$page_args['tax_query'] = array( array(
							'taxonomy'	=> 'dt_portfolio_category',
							'field'		=> 'term_id',
							'terms'		=> array_values($display['terms_ids']),
							'operator'	=> 'IN',
						) );

						if ( 'except' == $display['select'] ) {
							$terms_arr = array_diff( $all_terms_array, $display['terms_ids'] );
							sort( $terms_arr );

							if ( $terms_arr ) {
								$page_args['tax_query']['relation'] = 'OR';
								$page_args['tax_query'][1] = $page_args['tax_query'][0];
								$page_args['tax_query'][0]['terms'] = $terms_arr;
								$page_args['tax_query'][1]['operator'] = 'NOT IN';
							}

							add_filter( 'posts_clauses', 'dt_core_join_left_filter' );
						}

					}

					// filter
					if ( $request_display ) {

						// except
						if ( 0 == current($request_display['terms_ids']) ) {
							// ninjaaaa
							$request_display['terms_ids'] = $all_terms_array;
						}

						$page_args['tax_query'] = array( array(
							'taxonomy'	=> 'dt_portfolio_category',
							'field'		=> 'term_id',
							'terms'		=> array_values($request_display['terms_ids']),
							'operator'	=> 'IN',
						) );

						if ( 'except' == $request_display['select'] ) {
							$page_args['tax_query'][0]['operator'] = 'NOT IN';
						}
					}

					$page_query = new WP_Query($page_args);
					remove_filter( 'posts_clauses', 'dt_core_join_left_filter' );

					?>

					<?php
					// categorizer
					$filter_args = array();

					if ( !$config->get('show_ordering') ) {
						remove_filter( 'presscore_get_category_list', 'presscore_add_sorting_for_category_list', 15 );
					}

					if ( $config->get('show_filter') ) {

						$select = $display['select'];
						$terms_ids = isset($display['terms_ids']) ? $display['terms_ids'] : array();

						// categorizer args
						$filter_args = array(
							'taxonomy'	=> 'dt_portfolio_category',
							'post_type'	=> 'dt_portfolio',
							'select'	=> $select,
							'terms'		=> $terms_ids,
						);
					}

					// display categorizer
					presscore_get_category_list( array(
						// function located in /in/extensions/core-functions.php
						'data'	=> dt_prepare_categorizer_data( $filter_args ),
						'class'	=> 'filter without-isotope' . $ajax_class,
					) );
					?>

					<?php
					// masonry layout classes
					$masonry_container_classes = array( 'wf-container' . $ajax_class, 'portfolio-grid', 'jg-container' );

					// hover classes
					switch ( $config->get('description') ) {
						case 'on_hoover_centered':
							$masonry_container_classes[] = 'hover-style-two';

						case 'on_hoover':
							if ( 'dark' == $config->get('hover_bg_color') ) {
								$masonry_container_classes[] = 'hover-color-static';
							}

							if ( 'move_to' == $config->get('hover_animation') ) {
								$masonry_container_classes[] = 'cs-style-1';
							} else if ( 'direction_aware' == $config->get('hover_animation') ) {
								$masonry_container_classes[] = 'hover-grid';
							}
							break;

						case 'on_dark_gradient':
							$masonry_container_classes[] = 'hover-style-one';

							if ( 'always' == $config->get('hover_content_visibility') ) {
								$masonry_container_classes[] = 'always-show-info';
							}
							break;

						case 'from_bottom':
							$masonry_container_classes[] = 'hover-style-three';
							$masonry_container_classes[] = 'cs-style-3';

							if ( 'always' == $config->get('hover_content_visibility') ) {
								$masonry_container_classes[] = 'always-show-info';
							}
							break;
					}

					$masonry_container_classes = implode(' ', $masonry_container_classes);

					$masonry_container_data_attr = array(
						'data-padding="' . intval($item_padding) . 'px"',
						'data-target-height="' . intval($target_height) . 'px"',
						'data-cur-page="' . dt_get_paged_var() . '"'
					);

					if ( $config->get('hide_last_row') ) {
						$masonry_container_data_attr[] = 'data-part-row="false"';
					}

					// ninjaaaa!
					$masonry_container_data_attr = ' ' . implode(' ', $masonry_container_data_attr);
					?>

					<?php if ( $full_width ) : ?>

				<div class="full-width-wrap">

					<?php endif; ?>

					<div class="<?php echo esc_attr($masonry_container_classes); ?>"<?php echo $masonry_container_data_attr; ?>>

					<?php if ( $page_query->have_posts() ): while( $page_query->have_posts() ): $page_query->the_post(); ?>

						<?php dt_get_template_part('portfolio-masonry-content'); ?>

					<?php endwhile; wp_reset_postdata(); endif; ?>

					</div>

					<?php if ( $full_width ) : ?>

				</div>

					<?php endif; ?>

					<?php if ( presscore_is_load_more_pagination() ) : ?>

						<?php
						echo dt_get_next_page_button( $page_query->max_num_pages, 'paginator paginator-more-button with-ajax' );
						?>

					<?php else: ?>

						<?php
							dt_paginator(
								$page_query,
								array( 'class' => 'paginator' . $ajax_class )
							);
						?>

					<?php endif; ?>

					<?php else: // pass protected ?>

						<?php the_content(); ?>

					<?php endif; // pass protected ?>

					<?php do_action( 'presscore_after_loop' ); ?>

					<?php endwhile; ?>

				<?php endif; ?>

			</div><!-- #content -->

			<?php do_action('presscore_after_content'); ?>

		<?php endif; // if content visible ?>

<?php get_footer(); ?>