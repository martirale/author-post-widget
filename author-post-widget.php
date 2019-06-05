<?php
/*
Plugin Name: Author Post Widget
Plugin URI: https://alemartir.com
Description: Muestra el autor de un post o página en el área de widgets.
Version: 1.0
Author: MAR.AL
Author URI: https://alemartir.com
License: MIT
*/

// register Author_Post_Widget
add_action( 'widgets_init', function(){
	register_widget( 'Author_Post_Widget' );
});

class Author_Post_Widget extends WP_Widget {
	// class constructor
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'Author_Post_Widget',
			'description' => 'Muestra el autor de un post o página en el sidebar.',
		);
		parent::__construct( 'Author_Post_Widget', 'Author Post Widget', $widget_ops );
	}
	
	// output the widget content on the front-end
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
	if ( ! empty( $instance['title'] ) ) {
		echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
	}

	?>

	<style>
		.author_avatar_widget{
			display: block;
			margin-bottom: 32px;
			max-width: 100%;
    		height: auto;
		}

		.author_subtitle_widget{
			font-size: 14px;
			font-weight: 400;
			color: #788193;
		}

		.author_description_widget{
			font-size: 16px;
			font-weight: 400;
		}
	</style>

	<div class="author_avatar_widget" itemprop="image">
		<?php
		echo get_avatar( get_the_author_meta( 'user_email' ), 512 );
		?>
	</div><!-- author_avatar -->

	<div>
		<span class="author_subtitle_widget">Escrito por:</span>
		<h3 class="author_title" itemprop="name">
			<a class="author_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php
				// Translators: Add the author's name in the <span>
				echo wp_kses_data( sprintf( get_the_author() ) );
				?>
			</a>
		</h3>

		<div class="author_description_widget" itemprop="description">
			<?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?>
			<?php do_action( 'gutentype_action_user_meta' ); ?>
		</div><!-- author_bio -->
	</div><!-- author_description -->

	<?php

	echo $args['after_widget'];
	}

	// output the option form field in admin Widgets screen
	public function form( $instance ) {}

	// save options
	public function update( $new_instance, $old_instance ) {
		$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
	$selected_posts = ( ! empty ( $new_instance['selected_posts'] ) ) ? (array) $new_instance['selected_posts'] : array();
	$instance['selected_posts'] = array_map( 'sanitize_text_field', $selected_posts );

	return $instance;
	}
}

?>