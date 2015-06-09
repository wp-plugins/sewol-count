<?php
/*
Plugin Name: Sewol Count
Plugin URI: http://parkyong.com
Description: count day after Sewol Ferry Disaster
Version: 1.0.5
Author: Park Yong
Author URI: http://parkyong.com
License: GPLv2 or later
Text Domain: sewol-count
Domain Path: /languages
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

add_action( 'widgets_init', 'sewol_register_widgets' );
add_action('plugins_loaded', 'sewol_load_textdomain');

function sewol_load_textdomain() {
	load_plugin_textdomain( 'sewol-count', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

function sewol_register_widgets() {
	register_widget( 'sewol_widget' );
}

class sewol_widget extends WP_Widget {

	function sewol_widget () {
		$widget_ops = array( 'classname' => 'sewol_widget',
			'description' => __( 'Count day after Sewol Ferry Disaster', 'sewol-count' ));
		$this->WP_Widget( 'sewol_widget', __('Sewol Count Widget', 'sewol-count'), $widget_ops );
	}

	function form ( $instance ) {
		$defaults = array( 'title' => __('Sewol', 'sewol-count'));

		$instance = wp_parse_args( (array)$instance, $defaults );
		$title = strip_tags( $instance['title'] );
		?>
		<p>
			<?php _e('Title', 'pp-plugin' ) ?>:
			<input class="widefat"name="<?php echo $this->get_field_name('title'); ?>"
			type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
	<?php
	}

	function update ( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags(esc_attr($new_instance['title']));

		return $instance;
	}

	function widget ( $args, $instance ) {

		extract($args);
		echo '<aside id="sewol" class="widget">';

		$title = apply_filters('widget_title', $instance['title']);
		if ( !empty( $title ) ) { 
			echo $before_title . $title . $after_title;
		}

		$now = time(); 
		$dday = mktime(0,0,0,4,16,2014); 
		$xday = ceil(($now-$dday)/(60*60*24)); 
		echo '<p id="sewol" style="color:yellow">' . $xday . '</p>';

		echo '</aside>';
		
	}
}?>