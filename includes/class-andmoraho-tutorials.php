<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/andmoraho/
 * @since      1.0.0
 *
 * @package    Andmoraho_Tutorials
 * @subpackage Andmoraho_Tutorials/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Andmoraho_Tutorials
 * @subpackage Andmoraho_Tutorials/includes
 * @author     Andres Morales <andmoraho@gmail.com>
 */
class Andmoraho_Tutorials
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Andmoraho_Tutorials_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $andmoraho_tutorials    The string used to uniquely identify this plugin.
     */
    protected $andmoraho_tutorials;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('ANDMORAHO_TUTORIALS_VERSION')) {
            $this->version = ANDMORAHO_TUTORIALS_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->andmoraho_tutorials = 'andmoraho-tutorials';

        $this->load_dependencies();
        //$this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Andmoraho_Tutorials_Loader. Orchestrates the hooks of the plugin.
     * - Andmoraho_Tutorials_i18n. Defines internationalization functionality.
     * - Andmoraho_Tutorials_Admin. Defines all hooks for the admin area.
     * - Andmoraho_Tutorials_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-andmoraho-tutorials-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        // require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-andmoraho-tutorials-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-andmoraho-tutorials-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-andmoraho-tutorials-public.php';

        $this->loader = new Andmoraho_Tutorials_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Andmoraho_Tutorials_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    // private function set_locale()
    // {
    //     $plugin_i18n = new Andmoraho_Tutorials_i18n();

    //     $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    // }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $andmoraho_tutorials_admin = new Andmoraho_Tutorials_Admin($this->get_andmoraho_tutorials(), $this->get_version());

        $this->loader->add_action('init', $andmoraho_tutorials_admin, 'create_post_type');
        $this->loader->add_action('add_meta_boxes', $andmoraho_tutorials_admin, 'add_tutorial_metaboxes');
        $this->loader->add_action('save_post', $andmoraho_tutorials_admin, 'tutorials_save_metabox_data');
        $this->loader->add_action('admin_enqueue_scripts', $andmoraho_tutorials_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $andmoraho_tutorials_admin, 'enqueue_scripts');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $andmoraho_tutorials_public = new Andmoraho_Tutorials_Public($this->get_andmoraho_tutorials(), $this->get_version());

        $this->loader->add_action('init', $andmoraho_tutorials_public, 'andmoraho_tutorials_register_shortcodes');
        $this->loader->add_action('wp_enqueue_scripts', $andmoraho_tutorials_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $andmoraho_tutorials_public, 'enqueue_scripts');
        $this->loader->add_filter('manage_tutorial_posts_columns', $andmoraho_tutorials_public, 'andmoraho_tutorials_shortcode_custom_column');
        $this->loader->add_action('manage_tutorial_posts_custom_column', $andmoraho_tutorials_public, 'andmoraho_tutorials_shortcode_custom_column_data', 10, 2);
        $this->loader->add_filter('single_template', $andmoraho_tutorials_public, 'andmoraho_tutorials_single_cpt_template');
        $this->loader->add_filter('archive_template', $andmoraho_tutorials_public, 'andmoraho_tutorials_archive_cpt_template');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_andmoraho_tutorials()
    {
        return $this->andmoraho_tutorials;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Andmoraho_Tutorials_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
