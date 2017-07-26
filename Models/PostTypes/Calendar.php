<?php

namespace GDCalendar\Models\PostTypes;

use GDCalendar\Core\PostTypeModel;

class Calendar extends PostTypeModel
{
    protected static $post_type = 'gd_calendar';

    public static $menu = array('event_tag', 'event_category', 'gd_venues', 'gd_organizers');

    public static $themes = array(
        'Default Theme'
    );

    /**
     * @var string
     */
    protected $select_events_by = 'event_category';

    /**
     * @var array
     */
    protected $cat = array();

    /**
     * @var array
     */
    protected $view_type = array();

    /**
     * @var string
     */
    protected $theme = 0;

    protected static $meta_keys = array(
        'select_events_by',
        'cat',
        'view_type',
        'theme'
    );

    /**
     * @return string
     */
    public function get_select_events_by(){
        return $this->select_events_by;
    }

    /**
     * @param $select_events_by
     * @return Calendar
     * @throws \Exception
     */
    public function set_select_events_by($select_events_by){
        if (!in_array($select_events_by, self::$menu)) {
            throw new \Exception('Wrong selected value given.');
        }

        $this->select_events_by = $select_events_by;
        return $this;
    }

    public function get_cat(){
        return $this->cat;
    }

    public function set_cat($cat){
        $this->cat = array_map('intval', $cat);
        return $this;
    }

    /**
     * @param $view_type
     * @return Calendar
     */
    public function set_view_type($view_type){
        $this->view_type = array_map('intval', $view_type);
        return $this;
    }

    /**
     * @return array
     */
    public function get_view_type(){
        return $this->view_type;
    }

    /**
     * @param $theme
     * @return Calendar
     */
    public function set_theme($theme){
        $this->theme = absint($theme);
        return $this->theme;
    }

    /**
     * @return string
     */
    public function get_theme(){
        return $this->theme;
    }

    /**
     * @return bool
     */
    public function save(){
        return $this->save_meta();
    }

}