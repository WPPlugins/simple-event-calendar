<?php
/**
 * @var $post_id
 * @var $calendar
 */
?>
<h2><?php _e('Select Theme', 'gd-calendar'); ?>:</h2>
<select name="theme" id="theme">
    <?php foreach ($calendar::$themes as $key => $theme) {
        ?>
        <option value='<?php echo $key; ?>' <?php selected($calendar->get_theme(), $key); ?> ><?php echo $theme; ?></option>
    <?php } ?>
</select>