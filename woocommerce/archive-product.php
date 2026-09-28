<?php
defined('ABSPATH') || exit;

get_header();
?>

<main class="container px-5 py-10">

    <!-- عنوان فروشگاه -->
    <header class="mb-10">
        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">
            <?php woocommerce_page_title(); ?>
        </h1>
    </header>


    <?php if (woocommerce_product_loop()) : ?>

        <!-- مرتب سازی و تعداد محصولات -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">

            <div>
                <?php do_action('woocommerce_before_shop_loop'); ?>
            </div>

        </div>


        <!-- محصولات -->
        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <?php while (have_posts()) : the_post(); ?>

                <?php
                /*
                 * این فایل:
                 * woocommerce/content-product.php
                 * برای هر محصول اجرا می شود.
                 */
                wc_get_template_part('content', 'product');
                ?>

            <?php endwhile; ?>

        </ul>


        <!-- پایان Loop -->
        <?php do_action('woocommerce_after_shop_loop'); ?>


    <?php else : ?>

        <!-- اگر محصولی وجود نداشت -->
        <?php do_action('woocommerce_no_products_found'); ?>

    <?php endif; ?>

</main>

<?php
get_footer();?>