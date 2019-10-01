<?php

$post_item = get_post($em_post_id);

?>

<?php

// POST PREVIEW MEDIA (ON ARCHIVE OVERVIEW PAGE) 
// CAN BE ONE OF THE FOLLOWING MEDIA TYPES
// SELECTION IN BACKEND POSSIBLE FOR EACH POST VIA DROPDOWN
//  IMAGE
//  YOUTUBE VIDEO EMBED
//  * SLIDER

$preview_type = get_field('preview_type', $em_post_id);
$preview_image = get_field('preview_image', $em_post_id);
$preview_video = get_field('preview_video', $em_post_id);

$media = "";

if ($preview_type == "video" && !empty($preview_video)) {

    $media = get_video_embed_by_url($preview_video);

} elseif (!empty($preview_image) && !empty($preview_image)) {

    $media = '
        <figure>
            '.wp_get_attachment_image( $preview_image['ID'], 'img_500' ).'
        </figure>
    ';

} else {

    $media = '<div class="no-media"><i class="fa fa-file-image-o"></i></div>';

}

$custom_excerpt = get_field('custom_excerpt', $em_post_id);
if (!empty($custom_excerpt)) $excerpt = $custom_excerpt;
else $excerpt = apply_filters('the_content', get_the_excerpt($em_post_id));

// featured post
$featured = get_field('featured', $em_post_id);

?>

<article class="em-post-tile-mbc">
    <div class="box">
        <a href="<?php the_permalink($em_post_id) ?>">
            <div class="media">
                <?php echo $media; ?>
            </div>
            <div class="content">
                <div class="inner">
                    <header>
                        <div class="date">
                            <?php echo get_the_date('d.m.Y', $em_post_id); ?>
                        </div>
                        <h3>
                            <?php echo get_the_title($em_post_id); ?>
                        </h3>
                    </header>
                    <div class="txt">
                        <?php echo $excerpt; ?>
                    </div>
                    <div class="more btn-line-left">
                        <?php _e('Read more', 'eichmeister'); ?>
                    </div>
                </div>
            </div>
        </a>
    </div>
</article>  