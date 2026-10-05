<?php
defined('ABSPATH') || exit;

get_header();
?>

<main class="container mx-auto px-4 py-10">

    <header class="mb-8">

        <?php
        do_action('woocommerce_archive_description');
        ?>

    </header>

    <?php if (woocommerce_product_loop()) : ?>

        <?php
        do_action('woocommerce_before_shop_loop');
        ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <?php
            while (have_posts()) :
                the_post();
                //یعنی برای هر محصول موجود در الگو یا تمپلیت،کوئری کارت محصول را اجرا کن

                wc_get_template_part('content', 'product');

            endwhile;
            ?>

        </div>

        <?php
        do_action('woocommerce_after_shop_loop');
        ?>

    <?php else : ?>

        <?php
        do_action('woocommerce_no_products_found');
        ?>

    <?php endif; ?>

</main>

<?php
get_footer();