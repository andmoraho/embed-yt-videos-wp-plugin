<?php get_header();?>

<?php
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

$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;



$query_args = array(
        'post_type' => 'tutorial',
        'post_status' => 'publish',
        'paged' => $paged,
        'tax_query' => $tax_query
        );

$queryTutorial = new WP_Query($query_args);
?>

<section class="amhtuto_wrap">
        <?php if ($queryTutorial->have_posts()) : ?>
        <h1 class="amhtuto_archive-title">
            <?php echo post_type_archive_title('', false);            ?>
            </h1>
        <?php endif; ?>

        <div class="amhtuto_filter">
            <div class="amhtuto_filter__label">Filter: </div>
            <div class="amhtuto_filter__form">
                <form action="" method="GET" id="tutorialslist">
                    <select name="tutorialscat" id="tutorialscat" onchange="submit();">
                    <option value="">Show all</option>
                    <?php $categories = get_categories('taxonomy=tutorial-categories');
                    foreach ($categories as $category) :?>
                    <option value="<?php echo $category->name;?>" <?php echo (isset($_GET['tutorialscat']) && $_GET['tutorialscat'] == $category->name) ? ' selected="selected"' : '';?>>
                    <?php echo $category->name;?></option>
                    <?php endforeach;?>

                    </select>
                </form>
            </div>
        </div>
        <div class="amhtuto_tutorials">
            <?php while ($queryTutorial->have_posts()) { ?>
            <?php $queryTutorial->the_post(); ?>              
            <div class="amhtuto_tutorial">
                <div class="amhtuto_tutorial__container">
                    <div class="amhtuto_tutorial__video">
                        <?php $tutorialYoutubeId = get_post_meta($post->ID, '_tutorial_contact_person', true);?>
                        
                       <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $tutorialYoutubeID;?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="amhtuto_tutorial__content">
                        <h4 class="amhtuto_tutorial__content-title"><?php echo the_title();?></h4>
                        <div class="amhtuto_tutorial__content-description">
                            <?php the_content();?>
                        </div>                        
                    </div>
                                          
                </div>
            </div>

            <?php } ?>
        </div>

        <!-- Pagination Links -->
        <div class="amhtuto_pagination">
            <?php
                $big = 999999999; // need an unlikely integer
                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', get_pagenum_link($big)),
                    'total' => $queryTutorial->max_num_pages,
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged'))
                ));
            ?>
        </div>
</section>
<?php //wp_reset_postdata();?>
            
<?php get_footer();?>