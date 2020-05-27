<?php
wp_nonce_field('vendor_email_metabox', 'vendor_email_metabox_nonce');
        $vendorEmail = get_post_meta($post->ID, '_vendor_email', true);
?>
<div>
  <label for="vendor_email"><?php _e('Email:'); ?></label>
  <input type="text" name="vendor_email" id="vendor_email" value="<?php echo $vendorEmail; ?>" />
  <span class="vendor_email_error_message">Email Not Valid</span>
</div>