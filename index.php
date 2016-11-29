<?php get_header();?>
<?php get_sidebar(); ?>
<div id="content">
<!--the loop-->
        <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
        <div class="entry">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div id="content">
                <?php the_content(); ?>
                        <div class="post-metadata">
                        
                                <span class="author">By <?php the_author_posts_link(); ?></span>
                                <span class="date"><?php the_time('F jS, Y'); ?></span>
                                <span class="categories">See more in: <?php the_category(' &middot; '); ?></span>              
                        </div>
                        </div>
        </div> 
                <?php endwhile; else: ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
        <?php endif; ?>
<!--end loop-->

</div>
<?php get_footer(); ?>