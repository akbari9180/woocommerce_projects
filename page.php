<?php get_header(); ?>

<main class="container mx-auto px-4 py-10">

    <?php
    while (have_posts()) :
        the_post();
        the_title();
        the_content();

    endwhile;
    ?>

</main>

<?php get_footer(); ?>