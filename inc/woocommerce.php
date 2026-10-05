<!--اضافه کردن بخش اختصاصی برای هر محصول -->
<?php
function nafas_product_extra_info() {
    $warranty=get_post_meta(get_the_ID(),'product_warranty',true);
    $product = wc_get_product(get_the_ID());
    $free_shipping = get_post_meta(
    get_the_ID(),
    'product_shipping',
    true
);
    ?>
    
    <div class="product-extra-info">
        
        <h2>مشخصات</h2>
        <p>مشخصات محصول</p>

        <h2>ویژگی‌ها</h2>
        <?php

        if ($product) {

            $attributes = $product->get_attributes();

            if (!empty($attributes)) {

                echo '<ul>';

                foreach ($attributes as $attribute) {

                    $name = $attribute->get_name();

                    echo '<li>';
                    echo '<strong>';
                    echo esc_html($name);
                    echo ':</strong> ';

                    if ($attribute->is_taxonomy()) {

                        $terms = wc_get_product_terms(
                            $product->get_id(),
                            $name,
                            array(
                                'fields' => 'names'
                            )
                        );

                        echo esc_html(
                            implode('، ', $terms)
                        );

                    } else {

                        echo esc_html(
                            implode('، ', $attribute->get_options())
                        );

                    }

                    echo '</li>';
                }

                echo '</ul>';

            } else {

                echo '<p>ویژگی‌ای برای این محصول ثبت نشده است.</p>';

            }
        }
        ?>


        <h2>گارانتی</h2>
        <?php if($warranty):?>
        <p>
         <?php echo esc_html($warranty);?>  
        </p>
        <?php else:?>
            <p>بدون گارانتی</p>
        <?php endif;?>
        <h2>هزینه ارسال</h2>

<?php if ($free_shipping === 'yes') : ?>

    <p>✓ ارسال این محصول رایگان است.</p>

<?php else : ?>

    <p>هزینه ارسال بر اساس مقصد محاسبه می‌شود.</p>

<?php endif; ?>
        
    </div>
    
    <?php
}
add_action('woocommerce_after_single_product_summary', 'nafas_product_extra_info', 10);

//customField افزودن
//فیلد سفارشی برای گارانتی
function nafas_product_warranty_metabox(){
    add_meta_box('product_warranty','گارانتی محصول','nafas_product_warranty_callback','product','side');

}
add_action('add_meta_boxes','nafas_product_warranty_metabox');
//تابعی که محتوای متاباکس رو ایجاد میکنه
function nafas_product_warranty_callback($post){
    $warranty=get_post_meta($post->ID,'product_warranty',true);?>
    <label for="product_warranty">مدت گارانتی</label>
    <input type="text" id='product_warranty' name='product_warranty'  value="<?php echo esc_attr($warranty); ?>"
        style="width:100%;">

<?php
}
//ذخیره در دیتابیس
function nafas_save_product_warranty($post_id) {

    if (isset($_POST['product_warranty'])) {

        update_post_meta(
            $post_id,
            'product_warranty',
            sanitize_text_field($_POST['product_warranty'])//امنیتی
        );

    }

}

add_action(
    'save_post_product',
    'nafas_save_product_warranty'
);
//فیلد سفارشی برای حمل و نقل
function nafas_product_shipping_metabox(){
    add_meta_box('product_shipping','ارسال رایگان','nafas_product_shipping_callback','product','side');

}
add_action('add_meta_boxes','nafas_product_shipping_metabox');

function nafas_product_shipping_callback($post) {

    $free_shipping = get_post_meta(
        $post->ID,
        'product_shipping',
        true
    );

    ?>

    <label>
        <input
            type="checkbox"
            name="product_shipping"
            value="yes"
            <?php checked($free_shipping, 'yes'); ?>
        >

        ارسال رایگان
    </label>

    <?php
}
function nafas_save_product_shipping($post_id) {

    $free_shipping = isset($_POST['product_shipping'])
        ? 'yes'
        : 'no';

    update_post_meta(
        $post_id,
        'product_shipping',
        $free_shipping
    );

}

add_action(
    'save_post_product',
    'nafas_save_product_shipping'
);
// شخصی سازی عنوان محصول
// حذف عنوان محصول که خود ووکامرس قرار میده با الویت اجرای 5
remove_action('woocommerce_single_product_summary','woocommerce_template_single_title',5);
// اضافه کردن عنوان شخصی خودمان
function nafas_custom_product_title() {

    ?>

    <h1 class="text-2xl lg:text-3xl font-bold mb-4 hover:text-gray-400">
        <?php the_title(); ?>
    </h1>

    <?php
}

add_action(
    'woocommerce_single_product_summary',
    'nafas_custom_product_title',
    5
);
// شخصی سازی قیمت محصول
function nafas_custom_price_html($price) {

    return '<div class="text-xl font-bold text-green-600 mb-4">'
        . $price .
        '</div>';

}

add_filter(
    'woocommerce_get_price_html',
    'nafas_custom_price_html'
);
// شخصی سازی قیمت محصول
remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);
function sadaf_custom_add_to_cart() {

    woocommerce_template_single_add_to_cart();

}

add_action(
    'woocommerce_single_product_summary',
    'sadaf_custom_add_to_cart',
    30
);
//شخصی سازی دکمه اضافه به سبد خرید
//ظاهر دکمه
function nafas_custom_add_to_cart_class($args) {

    $args['class'] .= ' nafas-add-to-cart';

    return $args;
}
add_filter('woocommerce_loop_add_to_cart_args',
'nafas_custom_add_to_cart_class');
// تغییر متن دکمه
// function nafas_custom_add_to_cart_text() {
//     return 'افزودن به سبد';
// }

// add_filter(
//     'woocommerce_product_add_to_cart_text',
//     'nafas_custom_add_to_cart_text'
// );