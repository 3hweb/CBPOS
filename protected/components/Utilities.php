<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utilities
 *
 * @author elperez
 */
class Utilities {
    public static function removeComma($money) {
        return str_replace(',', '', $money);
    }
}

?>
