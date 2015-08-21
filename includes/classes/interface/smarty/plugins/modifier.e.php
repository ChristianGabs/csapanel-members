<?php

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty escape modifier plugin
 *
 * Type:     modifier<br>
 * Name:     e<br>
 * Purpose:  Escape the string according to escapement type
 * @link http://smarty.php.net/manual/en/language.modifier.escape.php
 *          escape (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param html|htmlall|url|quotes|hex|hexentity|javascript
 * @return string
 */
function smarty_modifier_e($string, $esc_type = 'html', $char_set = 'ISO-8859-1')
{
    if(is_array($string) || is_object($string))
    {
        return $string;
    }
    if($esc_type == "html")
    {
        if(version_compare(PHP_VERSION, '5.2.0', '<'))
        {
            return htmlspecialchars($string, ENT_QUOTES, $char_set);
        }
        else
        {
            return filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
        }
    }
    else
    {
        include_once("modifier.escape.php");
        return smarty_modifier_escape($string, $esc_type, $char_set);
    }
    return $string;
}

/* vim: set expandtab: */
?>
