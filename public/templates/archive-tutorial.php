<?php get_header();?>

<?php
if (isset($_GET['vendorscat']) && '' != $_GET['vendorscat']) {
    $vendorscategory = $_GET['vendorscat'];
    $tax_query = array(
                array(
                'taxonomy' => 'vendor-categories',
                'field' => 'name',
                'terms' => empty($vendorscategory)?'':$vendorscategory,
                )
                );
} else {
    $vendorscategory = '';
    $tax_query = array();
}

$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;



$query_args = array(
        'post_type' => 'vendor',
        'post_status' => 'publish',
        'paged' => $paged,
        'tax_query' => $tax_query
        );

$queryVendor = new WP_Query($query_args);
?>

<section class="amhvndr_wrap">
        <?php if ($queryVendor->have_posts()) : ?>
        <h1 class="amhvndr_archive-title">
            <?php echo post_type_archive_title('', false);            ?>
            </h1>
        <?php endif; ?>

        <div class="amhvndr_filter">
            <div class="amhvndr_filter__label">Filter: </div>
            <div class="amhvndr_filter__form">
                <form action="" method="GET" id="vendorslist">
                    <select name="vendorscat" id="vendorscat" onchange="submit();">
                    <option value="">Show all</option>
                    <?php $categories = get_categories('taxonomy=vendor-categories');
                    foreach ($categories as $category) :?>
                    <option value="<?php echo $category->name;?>" <?php echo (isset($_GET['vendorscat']) && $_GET['vendorscat'] == $category->name) ? ' selected="selected"' : '';?>>
                    <?php echo $category->name;?></option>
                    <?php endforeach;?>

                    </select>
                </form>
            </div>
        </div>
        <div class="amhvndr_vendors">
            <?php while ($queryVendor->have_posts()) { ?>
            <?php $queryVendor->the_post(); ?>              
            <div class="amhvndr_vendor">
                <div class="amhvndr_vendor__container">
                    <div class="amhvndr_vendor__image">
                        <?php
                            $vendorContactPerson = get_post_meta($post->ID, '_vendor_contact_person', true);
                            $vendorEmail = get_post_meta($post->ID, '_vendor_email', true);
                            $vendorPhone = get_post_meta($post->ID, '_vendor_phone', true);
                            $vendorUrl = get_post_meta($post->ID, '_vendor_url', true);
                        ?>
                        
                        <a href="<?php echo $vendorUrl;?>" target="_blank"><?php
                        if (get_the_post_thumbnail($post, $size = 'large', $attr = '')) {
                            echo get_the_post_thumbnail($post, $size = 'large', $attr = '');
                        } else {
                            echo '<img src="'.plugins_url('../images/default-vendor-logo.png', __FILE__).'">';
                        }
                        ?>
                        </a>
                    </div>
                    <div class="amhvndr_vendor__content">
                        <h4 class="amhvndr_vendor__content-title"><?php echo the_title();?></h4>
                        <div class="amhvndr_vendor__content-description">
                            <?php the_content();?>
                        </div>
                        <div class="amhvndr_vendor__content-data">
                           
                            <?php if ($vendorContactPerson) {?>
                            <div class="amhvndr_vendor__content-data-item">
                                <span class="dashicons dashicons-admin-users" title="Contact Person"></span> 
                                <?php echo $vendorContactPerson;?>
                            </div>
                            <?php } ?>
                            <?php if ($vendorEmail) {?>
                            <div class="amhvndr_vendor__content-data-item">
                                <span class="dashicons dashicons-email" title="Email"></span> 
                                <a href="mailto:<?php echo $vendorEmail;?>"><?php echo $vendorEmail;?></a>
                            </div>
                            <?php } ?>
                            <?php if ($vendorPhone) {?>
                            <div class="amhvndr_vendor__content-data-item">
                                <span class="dashicons dashicons-smartphone" title="Phone"></span> 
                                <?php echo $vendorPhone;?>
                            </div>
                            <?php } ?>
                            <?php if ($vendorUrl) {?>
                            <div class="amhvndr_vendor__content-data-item">
                                <span class="dashicons dashicons-admin-site-alt3" title="Website"></span> 
                                <a href="<?php echo $vendorUrl;?>" target="_blank"><?php echo preg_replace('/(http(s)?:\/\/)/', '', $vendorUrl);?></a>
                            </div>
                            <?php } ?>
                        </div>
                        
                        
                    </div>
                                          
                </div>
            </div>

            <?php } ?>
        </div>

        <!-- Pagination Links -->
        <div class="amhvndr_pagination">
            <?php
                $big = 999999999; // need an unlikely integer
                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', get_pagenum_link($big)),
                    'total' => $queryVendor->max_num_pages,
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged'))
                ));
            ?>
        </div>
</section>
<?php //wp_reset_postdata();?>
            
<?php get_footer();?>