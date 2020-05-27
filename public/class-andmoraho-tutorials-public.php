<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/andmoraho/
 * @since      1.0.0
 *
 * @package    Andmoraho_Tutorials
 * @subpackage Andmoraho_Tutorials/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 *
 * @package    Andmoraho_Tutorials
 * @subpackage Andmoraho_Tutorials/public
 * @author     Andres Morales <andmoraho@gmail.com>
 */
class Andmoraho_Tutorials_Public
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
     * @param      string    $andmoraho_tutorials       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($andmoraho_tutorials, $version)
    {
        $this->andmoraho_tutorials = $andmoraho_tutorials;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->andmoraho_tutorials, plugin_dir_url(__FILE__) . 'css/andmoraho-tutorials-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->andmoraho_tutorials, plugin_dir_url(__FILE__) . 'js/andmoraho-tutorials-public.js', array( 'jquery' ), $this->version, false);
    }

    /**
     * Adds a default single view template for a tutorial opening
     *
     * @since    1.0.0
     */
    public function andmoraho_tutorials_single_cpt_template($single_template)
    {
        global $post;

        if ($post->post_type == 'tutorial') {
            $single_template = plugin_dir_path(__FILE__) . 'templates/single-tutorial.php';
        }

        return $single_template;
    }

    /**
     * Adds a default archive view template for a tutorial opening
     *
     * @since    1.0.0
     */
    public function andmoraho_tutorials_archive_cpt_template($archive_template)
    {
        global $post;

        if (is_post_type_archive('tutorial')) {
            $archive_template = plugin_dir_path(__FILE__) . 'templates/archive-tutorial.php';
        }

        return $archive_template;
    }

    /**
    * Registers all shortcodes at once
    *
    * @return [type] [description]
    */
    public function andmoraho_tutorials_register_shortcodes()
    {
        add_shortcode('tutorials', array( $this, 'andmoraho_tutorials_list_tutorials' ));
    }

    /**
    * Tutorials shortcode
    *
    */
    public function andmoraho_tutorials_list_tutorials($atts = array())
    {
        global $post;

        if (is_multisite()) {
            $current_blog_id = get_current_blog_id();
            $blogid = $current_blog_id;
        } else {
            $blogid = 1;
        }

        $atts = shortcode_atts(
            array(
            'id' => '',
            'blogID' => $blogid,
        ),
            $atts,
            'tutorials'
        );

        if (is_multisite()) {
            switch_to_blog($blogid);
        }

        if (isset($_GET['tutorialscat']) && '' != $_GET['tutorialscat']) {
            $tutorialscategory = $_GET['tutorialscat'];
            $tax_query = array(
                array(
                'taxonomy' => 'tutorial-categories',
                'field' => 'name',
                'terms' => empty($tutorialscategory)?'':$tutorialscategory,
                )
                );
        } else {
            $tutorialscategory = '';
            $tax_query = array();
        }


        if (is_numeric(esc_attr($atts['id'])) && esc_attr($atts['id'])!='') {
            $query_args = array(
            'p' => esc_attr($atts['id']),
            'post_type' => 'tutorial',
            'post_status' => 'publish',
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
            'tax_query' => $tax_query
            
            );
        } else {
            $query_args = array(
            'post_type' => 'tutorial',
            'post_status' => 'publish',
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
            'tax_query' => $tax_query
            );
        }
       
        
        $html = '<section class="amhtuto_wrap">';
        $html .= '<div class="amhtuto_filter">
            <div class="amhtuto_filter__label">Filter: </div>
            <div class="amhtuto_filter__form">
        <form action="" method="GET" id="tutorialslist">
        <select name="tutorialscat" id="tutorialscat" onchange="submit();">
        <option value="">Show all</option>';

        $categories = get_categories('taxonomy=tutorial-categories');
        foreach ($categories as $category) :
        $html .='<option value="'.$category->name.'"';
        $html .= ($_GET['tutorialscat'] == ''.$category->name.'') ? ' selected="selected"' : '';
        $html .= '>'.$category->name.'</option>';
        endforeach;

        $html .= '</select>
            </form>
         </div>
        </div>';

        $html .= '<div class="amhtuto_tutorials">';
        $shortcodeTutorial = new WP_Query($query_args);
        
        while ($shortcodeTutorial->have_posts()) :
            $shortcodeTutorial->the_post();

        $tutorialYoutubeID = get_post_meta($post->ID, '_tutorial_youtube_id', true);
        

        $html .= '<div class="amhtuto_tutorial">
                    <div class="amhtuto_tutorial__container">
                        <div class="amhtuto_tutorial__video">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/'.$tutorialYoutubeID.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <div class="amhtuto_tutorial__content">
                            <h4 class="amhtuto_tutorial__content-title">'.get_the_title().'</h4>
                            <div class="amhtuto_tutorial__content-description">
                                <p>'.get_the_content().'</p>
                            </div>                        
                        </div>                    
                    </div>
                </div>';
        // TODO: organizar el html que se va a mostrar con el shortcode
        endwhile;
        $html .= '</div>';
        $big = 999999999; // need an unlikely integer
        $html .= '<div class="amhtuto_pagination">';
        $html .= paginate_links(array(
                'base' => str_replace($big, '%#%', get_pagenum_link($big)),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $shortcodeTutorial->max_num_pages
            ));
        $html .= '</div>
        </section>';
        wp_reset_postdata();
        return $html;
    }

    /**
     * Adds a custom column title
     *
     * @since    1.0.0
     */
    public function andmoraho_tutorials_shortcode_custom_column($columns)
    {
        $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Title'),
        'shortcode' => __('Shortcode <strong>[tutorials]</strong>'),
        'date' => __('Date')
        );
        return $columns;
    }

    /**
     * Adds shortcode and thumbnail
     *
     * @since    1.0.0
     */
    public function andmoraho_tutorials_shortcode_custom_column_data($column_name, $post_id)
    {
        if ($column_name == 'shortcode') {
            echo '[tutorials id="'.$post_id.'"]';
        }
    }
}
