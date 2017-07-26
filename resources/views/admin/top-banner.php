<?php
/**
 * @var $taxonomy
 * @var $current_screen
 */
$post_type = $current_screen->post_type;
$add_new_url = admin_url('post-new.php?post_type=' . $post_type );
?>
<div class="gd_calendar_top_banner_container">
    <div class="gd_calendar_top_banner">
        <i class="gd_calendar_banner_logo"></i>
        <?php
        if(!$taxonomy){
            $post = get_post_type_object($post_type);
            $name = $post->label;
            $item = $post->labels->add_new;
        }
        else{
            $term = get_taxonomy($taxonomy);
            $name = $term->label;
        }
        ?>
        <span><?php _e($name,'gd-calendar');?></span>
        <ul>
            <li>
                <a href="http://grandwp.com/grandwp-forms-user-manual" target="_blank"><?php _e('Help','gd-calendar');?></a>
            </li>
        </ul>
    </div>

    <?php if($taxonomy === '' && !($current_screen->base === 'post' && $current_screen->action === 'add' ) ): ?>
    <div class="gd_calendar_new_list_header">
        <div>
            <a href="<?php echo $add_new_url; ?>" id="gd_calendar_new"><?php _e($item,'gd-calendar');?></a>
        </div>
    </div>
    <?php endif; ?>
</div>