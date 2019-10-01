<?php
/**
 * Template Name: Single Post
 */

$preview_type = get_field('preview_type');
$preview_image = get_field('preview_image');
$preview_video = get_field('preview_video');

$topic = get_field('topic');
$custom_excerpt = get_field('custom_excerpt');
$author = get_field('author');
$post_source = get_field('sources');
$post_source_links = get_field('source_links');
$post_source_files = get_field('source_files');
$post_photo_copyrights = get_field('photo_copyrights');

$featured = get_field('featured');

$media = "";

if ($preview_type == "image") {
    
    if (!empty($preview_image['caption'])) {
        $figcaption = '<div class="darken"></div><figcaption><i class="ti-image"></i> '.$preview_image['caption'].'</figcaption>';
    }
    
    if (!empty($preview_image)) {
    
        $media = '
            <figure>
                <img src="'.$preview_image['sizes']['bg_img'].'" />
                '.$figcaption.'
            </figure>
        ';
        
    }
    
} elseif ($preview_type == "video") {

    $media = get_video_embed_by_url($preview_video);

}

?>  

<?php get_header(); ?>
    
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    <section id="intro"> 
        <div class="em-hero-simple" <?php EM()->Template->bg_cover(get_field('preview_image')); ?> >

            <div class="inner-full">

                <div class="inner-wrapper">

                    <span class="categories">
                        <?php 

                        $categories = get_the_category(); 

                        foreach( $categories as $category ) {
                            echo $category->name;
                        }

                        ?>
                    </span>

                    <header>
                        <h1>
                            <?php the_title(); ?>
                        </h1>
                    </header>

                </div>

        </div>
    </section>

    <section id="post-content">
        <div class="wrapper-1200 padding-bot-50">

            <?php // ---------- POST ---------- ?>
           
            <article id="post">

                <div class="box">

                    <div class="meta">

                        Gepostet am <span><?php echo get_the_date('d.m.Y'); ?></span>

                        <?php if (!empty($author)): echo $author; else: ?>

                            von
                            <span>
                                <?php echo get_the_author_meta('first_name').' '.get_the_author_meta('last_name'); ?>
                            </span>

                        <?php endif; ?> 

                    </div>

                    <?php if (!empty($topic)) { ?>
                        <div class="topic margin-bot-15">
                            <?php echo $topic; ?>
                        </div>
                    <?php } ?>
                        
                    <?php // EM CONTENT BLOCKS ?>
                    <?php EM()->Template->content_blocks( get_field('content')['content_blocks'] ); ?>

                    <?php if ( have_rows('source_files') || have_rows('source_links') || have_rows('sources') ): ?>

                        <div class="sources">
                           
                            <?php if ( have_rows('source_files') ): ?>

                                <div class="files">
                                    <h4><?php _e('Files', 'eichmeister'); ?></h4>

                                    <?php

                                    // loop through the rows of data
                                    while ( have_rows('source_files') ) : the_row();

                                        // display a sub field value
                                        $title = get_sub_field('title');
                                        $file = get_sub_field('item');
                                        $url = $file['url'];

                                        ?>

                                        <div class="item">
                                            <a href="<?php echo $url; ?>" target="_blank">
                                                <i class="ti-file"></i> <?php echo $title; ?>
                                            </a>
                                        </div>

                                    <?php endwhile; ?>

                                </div>

                            <?php endif; ?>
                           
                            <?php

                            // check if the repeater field has rows of data
                            if ( have_rows('source_links') ): ?>

                                <div class="links margin-top-25">
                                    <h4><?php _e('External Links', 'eichmeister'); ?></h4>

                                    <?php

                                    // loop through the rows of data
                                    while ( have_rows('source_links') ) : the_row();

                                        // display a sub field value
                                        $title = get_sub_field('title');
                                        $url = get_sub_field('url');

                                        ?>

                                        <div class="item">
                                            <a href="<?php echo $url; ?>" target="_blank">
                                                <i class="ti-new-window"></i> <?php echo $title; ?>
                                            </a>
                                        </div>

                                    <?php endwhile; ?>

                                </div>

                            <?php endif; ?>
                            
                            <?php
                        
                            // check if the repeater field has rows of data
                            if ( have_rows('sources') ): ?>
                                
                                <div class="txts margin-top-25">
                                    <h4><?php _e('Quellen', 'eichmeister'); ?></h4>

                                    <?php

                                    // loop through the rows of data
                                    while ( have_rows('sources') ) : the_row();

                                        // display a sub field value
                                        $item = get_sub_field('item');

                                        ?>

                                        <div class="item">
                                            <i class="fa fa-angle-right"></i> <?php echo $item; ?>
                                        </div>

                                    <?php endwhile; ?>

                                </div>

                            <?php endif; ?>

                        </div>

                    <?php endif; ?>
                    
                    <?php if ( have_rows('photo_copyrights') ): ?>

                        <div class="photo-copyright">
                                
                                <div class="txts">
                                    <h4><?php _e('Image Copyrights', 'eichmeister'); ?></h4>

                                    <?php

                                    // loop through the rows of data
                                    while ( have_rows('photo_copyrights') ) : the_row();

                                        // display a sub field value
                                        $item = get_sub_field('item');

                                        ?>

                                        <div class="item">
                                            &copy; <?php echo $item; ?>
                                        </div>

                                    <?php endwhile; ?>

                                </div>
                            
                        </div>

                    <?php endif; ?>
                    
                </div>
            </article>

            <div id="related-posts">
                    
                <?php include_once( locate_template('includes/related-posts.php')); ?>
                    
            </div>

        </div>      
    </section>
    
<?php endwhile; endif; ?>

<?php get_footer(); ?>