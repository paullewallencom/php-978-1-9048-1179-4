<?php

if (!defined('CALENDAR_ROOT')) {
  define('CALENDAR_ROOT', 'Calendar'.DIRECTORY_SEPARATOR);
}
require_once CALENDAR_ROOT.'Decorator.php';

class Calendar_Decorator_Holiday extends Calendar_Decorator 
{
  private $holiday;
  
  public function __construct($Calendar, $holiday) 
  {
    parent::Calendar_Decorator($Calendar);
    $this->holiday = $holiday;
  }
  
  public function getHoliday() 
  {
    return $this->holiday;
  }
}

?>