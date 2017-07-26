<?php

namespace GDCalendar\Controllers\Frontend;


class ShortcodeController
{

    public function __construct()
    {
        add_shortcode( 'gd_calendar', array( $this, 'run_shortcode' ) );
		add_shortcode( 'gd_calendar_sidebar', array( $this, 'run_shortcode' ) );
    }

    /**
     * Run the shortcode on front-end
     * @param $attrs
     * @return string
     * @throws \Exception
     */
    public function run_shortcode( $attrs, $content = null, $tag ) {
        $attrs = shortcode_atts( array(
            'id' => false,
        ), $attrs );

        if ( ! $attrs['id'] || absint( $attrs['id'] ) != $attrs['id'] ) {
            throw new \Exception( '"id" parameter is required and must be not negative integer.' );
        }

        do_action( 'gd_calendar_frontend_css', $attrs['id'] );

        if($tag === 'gd_calendar'){
            return $this->initFrontend( $attrs['id'] );
        }elseif($tag === 'gd_calendar_sidebar'){
            return $this->initFrontendSidebar( $attrs['id'] );
        }else{
            throw new \Exception('Something went wrong while showing shortcode');
        }
    }

    /**
     * Initialize the front end
     * @param $id int
     * @return string
     */
    private function initFrontend( $id ) {
        ob_start();
        $calendar = new CalendarsController();
        $calendar->show($id);
        return ob_get_clean();
    }

    /**
     * Initialize sidebar
     * @param $id
     * @return string
     */
    private function initFrontendSidebar( $id ) {
        $br = new CalendarsController();
        ob_start();
        $br->sidebarShow($id);
        return ob_get_clean();
    }

}