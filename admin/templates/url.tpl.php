<?php
wp_nonce_field('vendor_url_metabox', 'vendor_url_metabox_nonce');
        $vendorUrl = get_post_meta($post->ID, '_vendor_url', true);
?>
<div>
  <label for="vendor_url"><?php _e('URL: (eg: https://www.google.com)'); ?></label>
  <input type="text" name="vendor_url" id="vendor_url" value="<?php echo $vendorUrl; ?>" />
  <span class="vendor_url_error_message">URL Not Valid</span>
</div>