<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/andmoraho/
 * @since      1.0.0
 *
 * @package    Andmoraho_Tutorials
 * @subpackage Andmoraho_Tutorials/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 *
 * @package    Andmoraho_Tutorials
 * @subpackage Andmoraho_Tutorials/admin
 * @author     Andres Morales <andmoraho@gmail.com>
 */
class Andmoraho_Tutorials_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $andmoraho_tutorials    The ID of this plugin.
     */
    private $andmoraho_tutorials;

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
     * @param      string    $andmoraho_tutorials       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($andmoraho_tutorials, $version)
    {
        $this->andmoraho_tutorials = $andmoraho_tutorials;
        $this->version = $version;
    }

    
    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->andmoraho_tutorials, plugin_dir_url(__FILE__) . 'css/andmoraho-tutorials-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->andmoraho_tutorials, plugin_dir_url(__FILE__) . 'js/andmoraho-tutorials-admin.js', array( 'jquery' ), $this->version, false);
    }


    /**
     * Register the Meta Boxes for the Tutorials in admin area.
     *
     * @since    1.0.0
     */
    public function add_tutorial_metaboxes()
    {
        add_meta_box('_andmoraho_tutorial_youtube_id-0', _('Youtube Video ID'), array( $this, 'andmoraho_tutorial_youtube_id_metabox_callback'), 'tutorial', 'normal', 'high');
    }

    /**
    * Template for contact person metabox.
    *
    * @since    1.0.0
    */

    public function andmoraho_tutorial_youtube_id_metabox_callback($post)
    {
        require_once plugin_dir_path(__FILE__) . 'templates/youtube-id.tpl.php';
    }

   
    /**
    * Save data from meta boxes in admin area.
    *
    * @since    1.0.0
    */
    public function tutorials_save_metabox_data($post_id)
    {
        // die(print_r(basename(__FILE__)));

        // YouTube ID field nonce
        if (!isset($_POST['tutorial_youtube_id_metabox_nonce']) || !wp_verify_nonce($_POST['tutorial_youtube_id_metabox_nonce'], 'tutorial_youtube_id_metabox')) {
            return $post_id;
        }

        // return if autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        // Check the user's permissions.
        if (! current_user_can('edit_post', $post_id)) {
            return;
        }

        // store custom fields values
        // Save YouTube ID
        if (isset($_POST['tutorial_youtube_id'])) {
            update_post_meta($post_id, '_tutorial_youtube_id', sanitize_text_field($_POST['tutorial_youtube_id']));
        }
    }

    /**
     * Create custom type
     *
     * Create Tutorials Post Type
     *
     * @since    1.0.0
     */


    public function create_post_type()
    {
        $name = 'Tutorials';
        $singular_name = 'Tutorial';
        $labels = array(
        'name'               => __($name),
        'singular_name'      => __($singular_name),
        'add_new'            => __('Add New '. $singular_name),
        'add_new_item'       => __('Add New '. $singular_name),
        'edit_item'          => __('Edit '. $singular_name),
        'new_item'           => __('Add New '. $singular_name),
        'view_item'          => __('View '. $singular_name),
        'search_items'       => __('Search '. $singular_name),
        'not_found'          => __('No '. strtolower($name) . ' found'),
        'not_found_in_trash' => __('No' . strtolower($name) . ' found in trash'),
        'all_items'          => __('All '. $name),
        );
        $supports = array(
        'title',
        'editor',
        );
        $rewrite = array(
        'with_front'    => false,
        'slug'          => strtolower($name),
        );
        $args = array(
        'rewrite'              => $rewrite,
        'labels'               => $labels,
        'supports'             => $supports,
        'public'               => true,
        'has_archive'          => true,
        'menu_icon'            => plugins_url('images/video-tutorial-icon.png', __FILE__),
        );
  
        register_post_type('tutorial', $args);

        // Tutorial Categories
        register_taxonomy(
            'tutorial-categories',
            array('tutorial'),
            array(
        'hierarchical' => true,
        'label' => 'Categories',
        'singular_label' => 'Category',
        'rewrite' => array( 'slug' => 'tutorial-categories', 'with_front'=> false )
        )
        );

        register_taxonomy_for_object_type('tutorial-categories', 'tutorial');
    }
}
