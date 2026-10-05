<?php
global $product;
defined('ABSPATH') || exit;
?>

<div <?php wc_product_class(
    'rounded-xl border p-4 text-blue-600',$product); ?>>
<!-- $product->get_name(); -->
<!-- $product->get_id(); -->
<!-- $product->get_price(); -->

    <a href="<?php echo esc_url($product->get_permalink()); ?>">

        <?php
        //برای این از این متد استفاده میکنیم تا خود ووکامرس تصویر را بشکل مناسب نمایش دهد
        echo woocommerce_get_product_thumbnail();
        ?>

        <h2 class="text-lg font-bold mt-4">
            <?php echo esc_html($product->get_name()); ?>
        </h2>

    </a>

    <div class="mt-3">
        <?php
        // اگر محصول چند قیمت داشته باشه یا تخفیف داشته باشه
        //  فقط اولین قیمت را نمایش میده
        //  یا فقط تخفیف محصول را نمایش میده
        // echo esc_html($product->get_price());
        woocommerce_template_loop_price();
        ?>
    </div>

    <div class="mt-4">
        <?php
        woocommerce_template_loop_add_to_cart();
        ?>
    </div>

</div>
