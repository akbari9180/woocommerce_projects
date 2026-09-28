<?php get_header(); ?>

<main>

    <h1>
        <?php
        if ( function_exists('is_shop') && is_shop() ) {
            echo 'SHOP';
        } elseif ( function_exists('is_product') && is_product() ) {
            echo 'PRODUCT';
        } elseif ( function_exists('is_product_category') && is_product_category() ) {
            echo 'PRODUCT CATEGORY';
        } elseif ( function_exists('is_product_tag') && is_product_tag() ) {
            echo 'PRODUCT TAG';
        } else {
            echo 'NORMAL WORDPRESS PAGE';
        }
        ?>
    </h1>

</main>

<?php get_footer(); ?>