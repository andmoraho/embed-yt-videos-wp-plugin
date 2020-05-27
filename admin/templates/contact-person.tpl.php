<?php
wp_nonce_field('vendor_contact_person_metabox', 'vendor_contact_person_metabox_nonce');
        $vendorContactPerson = get_post_meta($post->ID, '_vendor_contact_person', true);
?>
<div>
  <label for="vendor_contact_person"><?php _e('Contact Person:'); ?></label>
  <input type="text" name="vendor_contact_person" id="vendor_contact_person" value="<?php echo $vendorContactPerson; ?>" /> 
</div>