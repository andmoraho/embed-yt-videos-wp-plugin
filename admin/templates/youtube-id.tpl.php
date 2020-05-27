<?php
wp_nonce_field('tutorial_youtube_id_metabox', 'tutorial_youtube_id_metabox_nonce');
        $tutorialYoutubeId = get_post_meta($post->ID, '_tutorial_youtube_id', true);
?>
<div>
  <label for="tutorial_youtube_id"><?php _e('Youtube Video ID:'); ?></label>
  <input type="text" name="tutorial_youtube_id" id="tutorial_youtube_id" value="<?php echo $tutorialYoutubeId; ?>" /> 
</div>