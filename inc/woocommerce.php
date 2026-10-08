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
//اضافه کردن اصالت کالا قبل از فرم اضافه به سبد خرید
function nafas_add_text() {

    echo '<p class="text-amber-600 font-bold text-lg mb-4">
        ضمانت اصالت کالا
    </p>';

}

add_action(
    'woocommerce_before_add_to_cart_form',
    'nafas_add_text'
);
// checkout , cart از نوع بلاک هستن
// اضافه کردن فیلد نام پدر به بخش پرداخت یا order در checkout
add_action( 'woocommerce_init', function() {

    if ( ! function_exists( 'woocommerce_register_additional_checkout_field' ) ) {
        return;
    }

    woocommerce_register_additional_checkout_field(
        array(
            'id'       => 'my-store/father-name',
            'label'    => 'نام پدر',
            'location' => 'order',
            'type'     => 'text',
            'required' => true,
        )
    );

} );
//checkout حذف یک فیلد از فیلد های اصلی در 
// ولی حذف فیلد های اصلی توصیه نمیشود

// add_filter( 'woocommerce_get_country_locale', function( $locale ) {

//     foreach ( $locale as $country_code => $country_fields ) {

//         $locale[ $country_code ]['first_name'] = array(
//             'required' => false,
//             'hidden'   => true,
//         );

//     }

//     return $locale;
// } );
// تغییر موضوع ایمیل برای سفارش جدید
// new order برای مدیر ارسال میشه
// یعنی موضوع یا متن موضوع ایمیلی که برای سفارش جدید میشه رو تغییر میدهد
function nafas_custom_email_subject($subject, $order) {

    return 'سفارش جدید از سایت صدف';

}

add_filter(
    'woocommerce_email_subject_new_order',
    'nafas_custom_email_subject',
    10,
    2
);
//تغییر لوگو و رنگ و... داخل خود پیکربندی ووکامرس انجام میشود و نیاز به کدنویسی نیس
// شخصی سازی پیام تشکر
// woocommerce_thankyou_order_received_textمتن تشکر بعد از ثبت سفارش
function nafas_custom_thankyou_message(
    $text,
    $order
) {

    return 'از خرید شما از فروشگاه صدف متشکریم. سفارش شما با موفقیت ثبت شد.';

}

add_filter(
    'woocommerce_thankyou_order_received_text',
    'nafas_custom_thankyou_message',
    10,
    2
);
//میخوایم مشخصات فنی،مزایا و سوالات متداول را برای هر محصول اضافه کنیم
function nafas_add_other_things(){
     $technical=get_post_meta(get_the_ID(),'product_technical',true);
     $benefits=get_post_meta(get_the_ID(),'product_benefits',true);
     $faq=get_post_meta(get_the_ID(),'product_faq',true);
?>
<div>
    <section class="mt-12">
        <h2 class="text-red-400 font-bold text-2xl">مشخصات فنی</h2>
        <?php if($technical):?>
        <p class="whitespace-pre-line">
         <?php echo esc_html($technical);?>  
        </p>
        <?php else:?>
            <p>مشخصات فنی محصول درج نگردیده است.</p>
        <?php endif;?>
    </section>
    <section class="mt-12">
        <h2 class="text-green-400 font-bold text-2xl">مزایا</h2>
         <?php if($benefits):?>
        <p class="whitespace-pre-line">
         <?php echo esc_html($benefits);?>  
        </p>
        <?php else:?>
            <p>مزایای این محصول درج نگردیده است.</p>
        <?php endif;?>
    </section>
    <section class="mt-12">
        <h2 class="text-pink-400 font-bold text-2xl">سوالات متداول</h2>
        <?php if($faq):?>
        <p class="whitespace-pre-line">
         <?php echo esc_html($faq);?>  
        </p>
        <?php else:?>
            <p>برای این محصول سوالی درج نگردیده است.</p>
        <?php endif;?>
    </section>
</div>
<?php
}
add_action('woocommerce_after_single_product_summary','nafas_add_other_things',20);
// *************************************************************
//کاستوم فیلد برای مشخصات فنی محصول
function nafas_product_technical_metabox(){
    add_meta_box('product_technical','مشخصات فنی محصول','nafas_product_technical_callback','product','normal');

}
add_action('add_meta_boxes','nafas_product_technical_metabox');
//تابعی که محتوای متاباکس رو ایجاد میکنه
function nafas_product_technical_callback($post){
    $technical=get_post_meta($post->ID,'product_technical',true);?>
    <label for="product_technical">مشخصات فنی محصول</label>
<textarea
    id="product_technical"
    name="product_technical"
    rows="8"
    style="width:100%;"
><?php echo esc_textarea($technical); ?></textarea>
<?php
}
//ذخیره در دیتابیس
function nafas_save_product_technical($post_id) {

    if (isset($_POST['product_technical'])) {

        update_post_meta(
            $post_id,
            'product_technical',
            sanitize_textarea_field($_POST['product_technical'])//امنیتی
        );

    }

}

add_action(
    'save_post_product',
    'nafas_save_product_technical'
);
// *************************************************************
// *************************************************************
//کاستوم فیلد برای مزایای محصول
function nafas_product_benefits_metabox(){
    add_meta_box('product_benefits','مزایای محصول','nafas_product_benefits_callback','product','normal');

}
add_action('add_meta_boxes','nafas_product_benefits_metabox');
//تابعی که محتوای متاباکس رو ایجاد میکنه
function nafas_product_benefits_callback($post){
    $benefits=get_post_meta($post->ID,'product_benefits',true);?>
    <label for="product_benefits">مزایا</label>
<textarea
    id="product_benefits"
    name="product_benefits"
    rows="8"
    style="width:100%;"
><?php echo esc_textarea($benefits); ?></textarea>
<?php
}
//ذخیره در دیتابیس
function nafas_save_product_benefits($post_id) {

    if (isset($_POST['product_benefits'])) {

        update_post_meta(
            $post_id,
            'product_benefits',
            sanitize_textarea_field($_POST['product_benefits'])//امنیتی
        );

    }

}

add_action(
    'save_post_product',
    'nafas_save_product_benefits'
);
// *************************************************************
// *************************************************************
//کاستوم فیلد برای سوالات متداول
function nafas_product_faq_metabox(){
    add_meta_box('product_faq','سوالات متداول','nafas_product_faq_callback','product','normal');

}
add_action('add_meta_boxes','nafas_product_faq_metabox');
//تابعی که محتوای متاباکس رو ایجاد میکنه
function nafas_product_faq_callback($post){
    $faq=get_post_meta($post->ID,'product_faq',true);?>
    <label for="product_faq">سوالات پرتکرار</label>
<textarea
    id="product_faq"
    name="product_faq"
    rows="8"
    style="width:100%;"
><?php echo esc_textarea($faq); ?></textarea>
<?php
}
//ذخیره در دیتابیس
function nafas_save_product_faq($post_id) {

    if (isset($_POST['product_faq'])) {

        update_post_meta(
            $post_id,
            'product_faq',
            sanitize_textarea_field($_POST['product_faq'])//امنیتی
        );

    }

}

add_action(
    'save_post_product',
    'nafas_save_product_faq'
);
// *************************************************************