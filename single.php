
<?php get_header(); ?>
<div id="content">

    <?php if(have_posts()):while(have_posts()):the_post(); ?>
    <article class="full-post">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div id="featured-img"><?php the_post_thumbnail(); ?></div>
        <div class="full-content">
            <?php the_content(); ?>
            <p>Authored by
            <?php echo get_avatar(get_the_author_meta('ID'), 50, "Mystery Man"); ?>
            <?php the_author(); ?></p>
            <p><time datetime="<?php the_time('Y-m-d');?>"></time></p>
            <p>Listed in <?php the_category(","); ?></p>
           <?php if(get_tags()): ?> 
            <p><?php the_tags(); ?></p>
            <?php endif; ?>
            <?php comments_number("0 comments", "1 comment", "% comments"); ?>
            
            <?php comments_template(); ?>
            
            <ul class="postnav">
            <?php previous_post_link("<li class='prev'>%link</li>", "&lt;previous"); ?>
            <?php next_post_link("<li class='next'>%link</li>", "next &gt;"); ?>    
            </ul>
        </div>
    </article>
    <?php endwhile; else: ?>
    <p>Sorry, no posts</p>
    <?php endif; ?>
    
</div>

<?php get_footer(); ?>
 
