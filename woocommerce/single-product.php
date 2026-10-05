<?php
//بررسی میکنه آیا وردپرس خودش این فایل را اجرا کرده یک خط امنیتی است
defined('ABSPATH') || exit;

get_header('shop');
?>

<main class="container py-10">
    

    <?php
    while (have_posts()) :
        the_post();
        //بخش اصلی محتوا را خود ووکامرس میاورد
        wc_get_template_part('content', 'single-product');
    endwhile;
    ?>

</main>

<?php
get_footer('shop');