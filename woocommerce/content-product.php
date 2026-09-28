<?php
defined('ABSPATH') || exit;

global $product;

/*
 * اگر محصول وجود نداشت یا قابل مشاهده نبود،
 * چیزی نمایش نده.
 */
if (!$product || !$product->is_visible()) {
    return;
}
?>

<li <?php wc_product_class(
    'group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg transition duration-300',
    $product
); ?>>

    <!-- تصویر محصول -->
    <a
        href="<?php echo esc_url(get_permalink()); ?>"
        class="block overflow-hidden"
    >

        <?php
        echo $product->get_image(
            'woocommerce_thumbnail',
            array(
                'class' => 'w-full aspect-square object-cover group-hover:scale-105 transition duration-300'
            )
        );
        ?>

    </a>


    <!-- اطلاعات محصول -->
    <div class="p-4">


        <!-- نام محصول -->
        <h2 class="text-lg font-semibold text-gray-800 mb-3">

            <a
                href="<?php echo esc_url(get_permalink()); ?>"
                class="hover:text-red-500 transition"
            >
                <?php echo esc_html(get_the_title()); ?>
            </a>

        </h2>


        <!-- قیمت -->
        <div class="text-lg font-bold text-gray-900 mb-4">

            <?php echo $product->get_price_html(); ?>

        </div>


        <!-- دکمه سبد خرید -->
        <div>

            <?php
            woocommerce_template_loop_add_to_cart();
            ?>

        </div>


    </div>

</li>