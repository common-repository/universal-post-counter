<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.presstigers.com
 * @since      1.0.0
 *
 * @package    Universal_Post_Counter
 * @subpackage Universal_Post_Counter/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Universal_Post_Counter
 * @subpackage Universal_Post_Counter/admin
 * @author     Presstigers <info@presstigers.com>
 */
class Universal_Post_Counter_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action( 'wp_dashboard_setup', array($this,'dashboard_meta_box_universal_post_counter' ));
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/universal-post-counter-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/universal-post-counter-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function dashboard_meta_box_universal_post_counter() {
		add_meta_box('universal-post-counter', 'Universal Post Counter', array($this,'widget_render_universal_post_counter'), 'dashboard', 'side', 'high' );
	}
	public function widget_render_universal_post_counter() {
		?>
		<div class="posts-tab">
			<?php  $this->posttypes_tab_universal_post_counter();  /*   PostType Tab Widget Calling */ ?>	
		</div>

	<?php
	}
	/*
	@   PostType Tab Function
	*	Get Name of all Post Types
	*   Count Published/Draft/Trash posts
	*/
	public function posttypes_tab_universal_post_counter() {
        ?>
        	<div id="post-stats" class="tabcontent" style="display:block">
                <h3 class="summary"><?php esc_html_e('Summary', 'universal-post-counter');?></h3>
                    <?php 
						/* 
						@Getting Default Post Types 
						*/
						$get_default_post_types = array(
						'public'   => true,
						'_builtin' => true );
						$get_custom_post_types = array(
						/* 
						@Getting Custom Post Types  
						*/
						'public'   => true,
						'_builtin' => false 
					);
                        $post_types = array();          

                        $default_post_types = get_post_types( $get_default_post_types, 'object' );
                        foreach ( $default_post_types as $post_key => $post_val ){
                            $post_types[$post_val->name] = $post_val->label;
                        }
                
                        $default_post_types = get_post_types( $get_custom_post_types, 'object' );

                        foreach ( $default_post_types as $post_key => $post_val ){
                        		$post_types[$post_val->name] = $post_val->label;
                        }
                	 ?>
                        <ul>
                            <li class="post-title header"><h3><?php esc_html_e('Title', 'universal-post-counter');?></h3></li>
                            <li class="publish-posts header"><?php esc_html_e('Published', 'universal-post-counter');?></li>
                            <li class="draft-posts header"><?php esc_html_e('Draft', 'universal-post-counter');?></li>
                            <li class="trash-posts header"><?php esc_html_e('Trash', 'universal-post-counter');?></li>
                        <?php
						/*
						@Extracting PostType from Array $post_types
						*/
                        foreach ( $post_types as $post_key => $post_val ){
                            if($post_val == 'Media') continue;
                            $publish_count = wp_count_posts( $post_key )->publish;
                            $draft_count = wp_count_posts( $post_key )->draft;
                            $trash_count = wp_count_posts( $post_key )->trash;
                            
                                echo '<li class="post-title"><a href="'.admin_url( 'edit.php?post_type='.$post_key ).'">'. esc_html($post_val).'</a></li>'; 
                                echo '<li class="publish-posts">'. esc_html($publish_count).'</li>'; 
                                echo '<li class="draft-posts">'. esc_html($draft_count).'</li>'; 
                                echo '<li class="trash-posts">'. esc_html($trash_count).'</li>'; 
                        }
                        echo '</ul>';
					?>
			</div>
        <?php
    }
}
