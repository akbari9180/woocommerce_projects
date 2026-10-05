<!-- functions.php
├── Theme Setup
├── Menus
├── Enqueue
├── Custom Post Types
├── AJAX
├── WooCommerce
│   ├── Warranty
│   ├── Shipping
│   └── Product Extra Info
└── ... -->
<?php
require_once get_template_directory() . '/inc/woocommerce.php'; 
    //اضافه کردن استایل
    //اضافه کردن فایل خروجی تیلویند(اتصال تیلویند به وردپرس)
function my_theme_enqueue_styles() {
    wp_enqueue_style(
        'tailwind',
        get_template_directory_uri() . '/assets/css/output.css',
        array()
    );
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
function add_option_to_site(){
    //افزودن منو
    register_nav_menus(
        array(
            'primary' => 'Primary Menu'
        )
    );
    //افزودن تصویر شاخص برای هر پست
     add_theme_support('post-thumbnails');
     //شاسایی عنوان مناسب برای تب
      add_theme_support('title-tag');
      //قابلیت لوگوی سفارشی
      add_theme_support('custom-logo');
      //پس زمینه سفارشی
      add_theme_support('custom-background');
      //پشتیبانی از html5
      add_theme_support('html5');
    //*************** */ پشتیبانی از ووکامرس
    add_theme_support('woocommerce');

}
add_action('after_setup_theme','add_option_to_site');
// Widget Area
function nafas_widgets_init() {
   //Sidebar 
    register_sidebar(
        array(
            'name'          => 'Main Sidebar',
            'id'            => 'sidebar-1',
            'description'   => 'Sidebar اصلی سایت',
            'before_widget' => '<div class="widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        )
    );
    //Footer
    register_sidebar(
        array(
            'name'=>"Footer",
            'id'=>'footer-1',
            'description'=>'ناحیه ابزارک فوتر',
            'before_widget' => '<div class="widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'


        )
    );

}

add_action('widgets_init', 'nafas_widgets_init');
