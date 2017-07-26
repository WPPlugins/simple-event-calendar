<?php
/**
 * @var $show Calendar Builder
 */
    $day = false;
    $week = false;

    $id = $show->get_post_id();
    $calendar = new \GDCalendar\Models\PostTypes\Calendar($id);
    $views = $calendar->get_view_type();
    foreach ($views as $view){
        switch ($view){
            case 0:
                $day = true;
                break;
            case 1:
                $week = true;
                break;
        }
    }
?>
    <div class="gd_calendar_wrapper gd_calendar_body">
        <?php
        if(has_post_thumbnail()){ ?>
            <div class="event_thumbnail">
                <?php echo the_post_thumbnail(); ?>
            </div>
        <?php
        } ?>
        <div class="gd_calendar_main">
            <form action="" method="get" name="search" id="search">
            <div class="gd_calendar_bar">
                <div class="gd_calendar_event_box_filter">
                    <input type="text" name="gd_calendar_month_event_filter" id="gd_calendar_month_event_filter" value="<?php if(isset($_GET['gd_calendar_month_event_filter'])){echo sanitize_text_field($_GET['gd_calendar_month_event_filter']);} ?>" placeholder="<?php _e("Date", "gd-calendar"); ?>" />
                    <input type="hidden" id="date_holder" />
                    <input type="hidden" id="post_id" value="<?php echo $id; // absint(get_post()->ID); ?>" />
                </div>
                <div class="gd_calendar_event_view_box">
                    <?php if(true === $day){ ?>
                    <button type="button" data-type="day" id="gd_calendar_day_view" class="gd_calendar_day_view"><?php _e('Day', 'gd-calendar'); ?></button>
                    <?php } ?>
                    <?php if(true === $week){ ?>
                    <button type="button" data-type="week" id="gd_calendar_week_view" class="gd_calendar_week_view"><?php _e('Week', 'gd-calendar'); ?></button>
                    <?php } ?>
                    <button type="button" data-type="month" id="gd_calendar_month_view" class="gd_calendar_month_view gd_calendar_active_view"><?php _e('Month', 'gd-calendar'); ?></button>
                    <input type="hidden" id="type_holder" name="type_holder" />
                </div>
                <div class="gd_calendar_search_box">
                    <input type="text" name="gd_calendar_search" id="gd_calendar_search" class="gd_calendar_search" placeholder="Search" value="">
                    <input type="submit" id="gd_calendar_search_icon" value="">
                </div>
                <div class="gd_loading"></div>
            </div>
            </form>
            <div id="gd_calendar">
                <?php
                    \GDCalendar\Helpers\View::render('frontend/calendar/month.php', array(
                        'month' => $show
                    ));
                ?>
            </div>
        </div>
    </div>
