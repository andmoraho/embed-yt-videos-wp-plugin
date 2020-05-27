<?php
wp_nonce_field('vendor_phone_metabox', 'vendor_phone_metabox_nonce');
        $vendorPhone = get_post_meta($post->ID, '_vendor_phone', true);
?>
<div>
  <label for="vendor_phone"><?php _e('Phone:'); ?></label>
  <input type="text" name="vendor_phone" id="vendor_phone" value="<?php echo $vendorPhone; ?>" />
  <span class="vendor_phone_error_message">Invalid Phone Number</span> 
</div>