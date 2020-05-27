<?php get_header();?>

<?php while (have_posts()) { ?>
<?php the_post(); ?> 
<?php
    $tutorialYoutubeId = get_post_meta($post->ID, '_tutorial_youtube_id', true);
?> 
    <section class="amhtuto_wrap">
        <div class="amhtuto_tutorial-single">
            <div class="amhtuto_tutorial-single__container">
                <div class="amhtuto_tutorial-single__video">
                   <iframe src="https://www.youtube.com/embed/<?php echo $tutorialYoutubeId;?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <h2 class="amhtuto_tutorial-single__title"><?php the_title();?></h2>               
                <div class="amhtuto_tutorial-single__content">
                    <?php the_content();?>
                </div>                
            </div>
        </div>
    </section>
    <!-- blog end -->
<?php } ?>

<?php get_footer();?>