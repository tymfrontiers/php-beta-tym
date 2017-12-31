<?php
namespace Tymfrontiers;

class BetaTym{
  # default tym format strings
  const MYSQL_DATETYM_STRING    = "%Y-%m-%d %H:%M:%S"; # MySQL tym format
  const SHORT_WEEK_DAY          =	"%a"; # Sun through Sat
  const FULL_WEEK_DAY           =	"%A"; # Sunday through Saturday
  const DAY_LEADING_ZERO        =	"%d"; # 01 to 31
  const DAY                     =	"%e"; # 1 to 31
  const DAY_OF_YEAR_WITH        = "%j"; # 001 to 366
  const WEEK_DAY_NUMBER         = "%u"; # 1 (for Monday) though 7 (for Sunday)
  const WEEK_OF_YEAR            = "%U"; # 13 (for the 13th full week of the year)
  const ISO_WEEK_OF_YEAR        = "%V"; # 01 through 53 (where 53 accounts for an overlapping week)
  const SHORT_MONTH_NAME        = "%b"; # Jan through Dec
  const MONTH_NAME              = "%B"; # January through December
  const MONTH_NUMBER            = "%m"; # 01 (for January) through 12 (for December)
  const YEAR_CENTURY            = "%C"; # 19 for the 20th Century
  const YEAR                    = "%Y"; # Example: 2038
  const SHORT_YEAR_NUMBER       = "%y"; # Example: 09 for 2009, 79 for 1979
  const FULL_HOUR               = "%H"; # 00 through 23
  const HALF_HOUR               = "%l"; # 1 through 12
  const MINUTE                  = "%M"; # 00 through 59
  const AM_PM                   = "%P"; # Example: AM for 00:31, PM for 22:23
  const AM_PM_TYM               = "%r"; # Example: 09:34:17 PM for 21:34:17
  const SECOND                  = "%S"; # 00 through 59
  # for more options reffer to PHP website >> http://php.net/manual/en/function.strftime.php

  static $STAMP;

  function __construct(){
    self::$STAMP = strftime(self::MYSQL_DATETYM_STRING,time());
  }
  public static function get(string $format,string $tym=''){
    # get datetym format from given datetym string.
    $unix = !empty($tym) ? strtotime($tym) : time();
    return strftime( $format, strtotime($unix)  );
  }
  public function day(string $dateTym=""){
    # nice day writing format e.g 21st
    $unix = !empty($dateTym) ? strtotime($dateTym) : time();
    $day = strftime(self::DAY, $unix);
    if( in_array($day,['1','21','31']) ){
      $day = $day.'st';
    }elseif( in_array($day,['3','23']) ){
      $day = $day.'rd';
    }elseif( in_array($day,['2','22']) ){
      $day = $day.'nd';
    }else{
      $day = $day.'th';
    }
    return $day;
  }
  public function monthDay( string $dateTym=''){
    # e.g April 7th
    return $this->month($dateTym).' '.$this->day($dateTym);
  }
  public function month($dateTym=""){
    # e.g January
    $unix = !empty($dateTym) ? strtotime($dateTym) : time();
    return strftime(self::MONTH_NAME, $unix);
  }
  public function year($dateTym=""){
    # e.g 2018
    $unix = !empty($dateTym) ? strtotime($dateTym) : time();
    return strftime(self::YEAR, $unix);
  }
  public function shortMonth($dateTym=""){
    # e.g Jan
    $unix = !empty($dateTym) ? strtotime($dateTym) : time();
    return strftime(self::SHORT_MONTH_NAME, $unix);
  }
  public function MDY($dateTym=''){
    return $this->monthDay($dateTym).', '.$this->year($dateTym);
  }
  public function hour( string $dateTym="", $hour_12=false){
    $unix = !empty($dateTym) ? strtotime($dateTym) : time();
    $hour = (bool)$hour_12 ?
      strftime(self::HALF_HOUR, $unix) :
      strftime(self::FULL_HOUR, $unix);
    return $hour;
  }
  public function tym(){ return time(); }
  public function HMS($dateTym=""){
    $unix = !empty($dateTym) ? strtotime($dateTym) : time();
    return $this->hour($dateTym).':'.strftime(self::MINUTE.':'.self::SECOND, $unix);
  }
  public function dataTym($dateTym=""){
    return $this->MDY($dateTym).' by '.$this->HMS($dateTym);
  }
  public function week($dateTym=""){
    $unix = !empty($dateTym) ? strtotime($dateTym) : time();
    return strftime(self::WEEK_OF_YEAR, $unix);
  }
  public function weekDay($dateTym=""){
    $unix = !empty($dateTym) ? strtotime($dateTym) : time();
    return strftime(self::FULL_WEEK_DAY, $unix);
  }
  public function weekDateTym($dateTym=""){
    return $this->weekDay($dateTym).' '.$this->day($dateTym).' '.$this->month($dateTym).' '.$this->year();
  }
}
