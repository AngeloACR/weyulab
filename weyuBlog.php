<?php
/* Template Name:weyuBlog */
?>

<?php
/*$pagedB = get_query_var('paged');
$pagedB = max( 1, $pagedB );

$offset_start = 1;
$offset = ( $pagedB - 1 ) * $per_page + $offset_start;
*/

$per_page = 4;

$args = array(
    'posts_per_page' => $per_page,
    //    'paged'          => $pagedB,
    //    'offset'         => $offset, // Starts with the second most recent post.
    'orderby'        => 'date',  // Makes sure the posts are sorted by date.
    'order'          => 'DESC',  // And that the most recent ones come first.
);

/*Setting up our custom query */
//query_posts($args);
$post_list = new WP_Query($args);

/*$total_rows = max( 0, $post_list->found_posts - $offset_start );
$total_pages = ceil( $total_rows / $per_page );
*/
if ($post_list->have_posts()) :
?>
<div class="bigBox">
    <?php
        while ($post_list->have_posts()) :


            $post_list->the_post();
        ?>
    <div class="postItem">
        <div class="postImage">
            <a href="<?php the_permalink(); ?>"
                title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('full'); ?></a>
        </div>
        <div class="postTitle">
            <p><?php the_title(); ?></p>
        </div>

        <div class="postExcerpt">
            <p><?php the_excerpt(); ?></p>
            <a class="postLink" href="<?php the_permalink() ?>">Leer más</a>
        </div>

    </div>

    <?php

        endwhile;
        ?>
    <div class="pagination clearfix">
        <?php // next_posts_link( '' );
            ?>
        <?php //previous_posts_link( '' ); 
            ?>
        <?php

            /*            $pag_args1 = array(
    'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
    //            'total'   => $total_pages,
    'total'   => $post_list->max_num_pages,
    'current' => $pagedB,
    'format'       => '?pagedB=%#%',
            'show_all'     => false,
            'type'         => 'plain',
            'prev_next'    => true,
            'prev_text'    => sprintf( '<div class="alignleft"></div>', __( 'Newer Posts', 'text-domain' ) ),
            'next_text'    => sprintf( '<div class="alignright"></div>', __( 'Older Posts', 'text-domain' ) ),
            'add_args'     => false,
        );

            echo paginate_links($pag_args1);
            */    ?>
    </div>
</div>

<?php
endif;
?>

<style>
.bigBox {
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    flex-wrap: wrap;
    align-items: flex-start;
}

.postItem {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 40%;
    margin-bottom: 15px;
}

.postImage {
    text-align: center;
    width: 100%;
}

.postImage img {
    width: 100%;
}

.postTitle p {
    text-align: center;
    color: black;
    width: 100%;
    font-size: 20px;
    white-space: initial;
}

.postExcerpt p {
    text-align: left;
    color: black;
    width: 100%;
    font-size: 16px;
    white-space: initial;
}

.postLink {
    background-color: #d91887;
    border-color: #d91887;
    border-width: 2px;
    border-style: solid;
    border-radius: 23px;
    color: white;
    font-size: 16px;
    font-weight: bold;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 108px;
    height: 33px;
}

.postLink:hover {
    background-color: white;
    color: #d91887;
}
</style>