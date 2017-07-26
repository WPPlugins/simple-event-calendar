<?
/**
 * @var $location
 */
?>
<div class="venue_box">
    <table id="venue_info" class="venue_info">
    <tr class="venue_field">
        <td><?php _e('Address', 'gd-calendar'); ?></td>
    <td><input type="text" name="address" id="address" autocomplete="off" placeholder="<?php _e('Address...', 'gd-calendar'); ?>" value="<?php if(!empty($location->get_address())) echo esc_html($location->get_address()); ?>"></td>
    </tr>
    </table>
</div>