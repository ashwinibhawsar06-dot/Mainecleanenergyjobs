<?php
//Template Name: Archive Event Page

get_header();

?>
<div id="tribe-events-content" class="tribe-events-single">

	<p class="tribe-events-back">
		<a href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php printf( '&laquo; ' . esc_html_x( 'All %s', '%s Events plural label', 'the-events-calendar' ), $events_label_plural ); ?></a>
	</p>

	<h2 class="mht_eve">Upcoming events</h2>

	<?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!-- Event featured image, but exclude link -->
			<?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>

			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
			<div class="tribe-events-single-event-description tribe-events-content">
				<?php the_content(); ?>
			</div>
			<!-- .tribe-events-single-event-description -->
			<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

			<!-- Event meta -->
			<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
			<?php tribe_get_template_part( 'modules/meta' ); ?>
			<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
		</div> <!-- #post-x -->
		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>

	<div class="content-left-wrap col-md-9">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <?php
                $args = array(
                    'post_type' => 'tribe_events',
                    'posts_per_page' => -1,
                );
				$custom_query = new WP_Query($args);

				if ($custom_query->have_posts()) {
				    while ($custom_query->have_posts()) {
				        $custom_query->the_post();
				        the_title();
				        the_content();
				    }
				    wp_reset_postdata();
				} else {
				    echo "No data found";
				}
                ?>
            </main>
        </div>
    </div>

</div><!-- #tribe-events-content -->

<?php get_footer(); ?>