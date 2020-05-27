<?php get_header();?>

<?php while (have_posts()) { ?>
<?php the_post(); ?>  
    <section class="amhvndr_wrap">
        <div class="amhvndr_vendor-single">
            <div class="amhvndr_vendor-single__container">
                <div class="amhvndr_vendor-single__image">
                   <a href="<?php echo $vendorUrl;?>" target="_blank">
                   <?php
                        if (get_the_post_thumbnail($post, $size = 'large', $attr = '')) {
                            echo get_the_post_thumbnail($post, $size = 'large', $attr = '');
                        } else {
                            echo '<img src="'.plugins_url('../images/default-vendor-logo.png', __FILE__).'">';
                        }
                    ?>
                    </a>
                </div>
                <h2 class="amhvndr_vendor-single__title"><?php the_title();?></h2>               
                <div class="amhvndr_vendor-single__content">
                    <?php the_content();?>
                </div>
                <div class="amhvndr_vendor-single__content-data">
                            <?php
                            $vendorContactPerson = get_post_meta($post->ID, '_vendor_contact_person', true);
                            $vendorEmail = get_post_meta($post->ID, '_vendor_email', true);
                            $vendorPhone = get_post_meta($post->ID, '_vendor_phone', true);
                            $vendorUrl = get_post_meta($post->ID, '_vendor_url', true);
                            ?>
                            <?php if ($vendorContactPerson) {?>
                            <div class="amhvndr_vendor-single__content-data-item">
                                <span class="dashicons dashicons-admin-users" title="Contact Person"></span> 
                                <?php echo $vendorContactPerson;?>
                            </div>
                            <?php } ?>
                            <?php if ($vendorEmail) {?>
                            <div class="amhvndr_vendor-single__content-data-item">
                                <span class="dashicons dashicons-email" title="Email"></span> 
                                <a href="mailto:<?php echo $vendorEmail;?>"><?php echo $vendorEmail;?></a>
                            </div>
                            <?php } ?>
                            <?php if ($vendorPhone) {?>
                            <div class="amhvndr_vendor-single__content-data-item">
                                <span class="dashicons dashicons-smartphone" title="Phone"></span> 
                                <?php echo $vendorPhone;?>
                            </div>
                            <?php } ?>
                            <?php if ($vendorUrl) {?>
                            <div class="amhvndr_vendor-single__content-data-item">
                                <span class="dashicons dashicons-admin-site-alt3" title="Website"></span> 
                                <a href="<?php echo $vendorUrl;?>" target="_blank"><?php echo preg_replace('/(http(s)?:\/\/)/', '', $vendorUrl);?></a>
                            </div>
                            <?php } ?>
                        </div>
                
                
            </div>
        </div>
    </section>
    <!-- blog end -->
<?php } ?>

<?php get_footer();?>