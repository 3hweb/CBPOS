<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RefDineTypeModel
 *
 * @author elperez
 */
class RefDineTypeModel extends CFormModel{
   static $_DINEIN;
   static $_TAKEOUT;
   static $_DELIVERY;
   static $_BULK;
   
   public function __construct() {
       self::$_DINEIN = 1;
       self::$_TAKEOUT = 2;
       self::$_DELIVERY = 3;
       self::$_BULK = 4;
   }
}

?>
