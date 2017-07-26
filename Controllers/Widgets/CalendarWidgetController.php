<?php

namespace GDCalendar\Controllers\Widgets;

use GDCalendar\Models\PostTypes\Calendar;

class CalendarWidgetController extends \WP_Widget
{

    public function __construct() {
        parent::__construct(
            'CalendarWidgetController',
            __( 'GrandWP Calendar', 'gd-calendar' ),
            array( 'description' => __( 'GranWP Calendar', 'gd-calendar' ), )
        );
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        extract( $args );

        if ( isset( $instance['gd_calendar_id'] ) ) {
            $gd_calendar_id = $instance['gd_calendar_id'];

            $title = apply_filters( 'widget_title', $instance['title'] );

            echo $before_widget;
            if ( ! empty( $title ) ) {
                echo $before_title . $title . $after_title;
            }

            echo do_shortcode( "[gd_calendar_sidebar id='{$gd_calendar_id}']" );
            echo $after_widget;
        }
    }

    /**
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance             = array();
        $instance['gd_calendar_id'] = strip_tags( $new_instance['gd_calendar_id'] );
        $instance['title']    = strip_tags( $new_instance['title'] );

        return $instance;
    }

    /**
     * @param array $instance
     */
    public function form( $instance ) {
        $calendar_instance = ( isset( $instance['gd_calendar_id'] ) ? $instance['gd_calendar_id'] : 0 );
        $title        = ( isset( $instance['title'] ) ? $instance['title'] : '' );
        ?>
        <p>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>"/>
        </p>
        <label for="<?php echo $this->get_field_id( 'gd_calendar_id' ); ?>"><?php _e( 'Select calendar:', 'gd-calendar' ); ?></label>
        <select id="<?php echo $this->get_field_id( 'gd_calendar_id' ); ?>" name="<?php echo $this->get_field_name( 'gd_calendar_id' ); ?>">
            <?php
            $calendars = Calendar::get();

            if( $calendars ){
                foreach( $calendars as $calendar ){
                    ?>
                    <option <?php echo selected( $calendar_instance, $calendar->get_id() ); ?> value="<?php echo $calendar->get_id(); ?>"><?php echo $calendar->get_post_data()->post_title; ?></option>
                    <?php
                }
            }
            ?>
        </select>
        </p>
        <?php
    }

}