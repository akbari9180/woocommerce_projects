<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="<?php bloginfo("charset")?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head();?>
    <style>
        :root{
            --color-theme:<?php echo esc_attr(get_theme_mod('primary_color','#3496cf'));?>;
        }
    </style>
</head>
<body <?php body_class();?>>
    <header class="flex-center gap-20">
            <div class='logo'>
                <!-- متد زیر تگ a , img تولید میکنه -->
                <?php the_custom_logo();?>
            </div>
           <h1><?php bloginfo("name")?></h1>
        
        <nav>
            <?php wp_nav_menu(array('theme_location'=>'primary'));?>
        </nav>
    </header>