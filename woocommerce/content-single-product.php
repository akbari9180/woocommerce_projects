<?php
defined('ABSPATH') || exit;
// do_action('woocommerce_before_single_product');
?>

<div
    id="product-<?php the_ID(); ?>"
    <?php wc_product_class('container mx-auto px-4', $product); ?>
>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

        <!-- تصویر محصول -->
        <div class="product-gallery">

            <?php
            do_action('woocommerce_before_single_product_summary');
            ?>

        </div>


        <!-- اطلاعات محصول -->
        <div class="summary entry-summary">

            <?php
            do_action('woocommerce_single_product_summary');
            ?>

        </div>
        <?php do_action('woocommerce_after_single_product_summary');?>
    </div>

</div>