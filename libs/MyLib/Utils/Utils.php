<?php

//require_once LIBS_DIR.'/dibi/dibi.php';
require_once LIBS_DIR . '/Nette/Utils/Object.php';

abstract class Utils extends NObject {

    /**
     * @desc stores something to session
     */
    static function saveVariable($key, $value, $sessionName) {
        $s = NEnvironment::getSession($sessionName);
        $s[$key] = $value;
    }
    
    
    /**
     * clears variable from session
     * @param type $key
     * @param type $sessionName 
     * 
     */
    static function clearVariable($key, $sessionName) {
        $s = NEnvironment::getSession($sessionName);
        $s->__unset($key);
    }
    

    /**
     * @desc returns value from session, throws NotFoundException if not defined.
     */
    static function loadVariable($key, $sessionName) {
        $s = NEnvironment::getSession($sessionName);
        if (isset($s[$key])) {
            return $s[$key];
        } else {
            throw new NotFoundException();
        }
    }

    /**
     * adds an emtpy first row to the array
     * @param $array
     * @return array
     */
    static function addEmptyRowToArray(array $array, $key = NULL) {
        return array_combine(array_merge(array($key), array_keys($array)),
                array_merge(array(DependentSelectBox::$emptyValueTitle), array_values($array)));
    }

    /**
     * returns true if user has privilege to resource 
     * @param string $resource
     * @param string $privilege
     * @return boolean
     */
    static function userAllowed($resource = null, $privilege = null) {
        return NEnvironment::getUser()->isAllowed($resource, $privilege);
    }

    /**
     * @desc removes all special characters from given string
     */
    static function removeSpecialCharacters($str) {
        return strtr($str, array('á' => 'a',
            'ä' => 'a',
            'č' => 'c',
            'ď' => 'd',
            'é' => 'e',
            'ě' => 'e',
            'ë' => 'e',
            'í' => 'i',
            'ň' => 'n',
            'ó' => 'o',
            'ö' => 'o',
            'ř' => 'r',
            'š' => 's',
            'ť' => 't',
            'ú' => 'u',
            'ů' => 'u',
            'ü' => 'u',
            'ý' => 'y',
            'ž' => 'z',
            'Á' => 'A',
            'Ä' => 'A',
            'Č' => 'C',
            'Ď' => 'D',
            'É' => 'E',
            'Ě' => 'E',
            'Ë' => 'E',
            'Í' => 'I',
            'Ň' => 'N',
            'Ó' => 'O',
            'Ö' => 'O',
            'Ř' => 'R',
            'Š' => 'S',
            'Ť' => 'T',
            'Ú' => 'U',
            'Ů' => 'U',
            'Ü' => 'U',
            'Ý' => 'Y',
            'Ž' => 'Z',
            ',' => '',
            ';' => '',
            '#' => '',
            '$' => '',
            '%' => '',
            '^' => '',
            '&' => '',
            '~' => '',
            '`' => '',
            '.' => '',
            '?' => '',
            '<' => '',
            '>' => '',
            '-' => ''));
    }

    /**
     * @desc returns datetime in nice format
     */
    static function getNiceDatetime($datetime) {
        return self::transformDatetime($datetime, "j. n. Y, h:i");
    }

    /**
     * @desc returns datetime in nice format
     */
    static function getNiceDate($datetime) {
        return self::transformDatetime($datetime, "j. n. Y");
    }

    /**
     * @desc returns custom date format acc. to datetime & format string
     */
    static function transformDatetime($datetime, $string) {
        $DT = new DateTime($datetime);
        return $DT->format($string);
    }

    /**
     * @returns file extension or empty string if no extension
     * @param $file
     * @return unknown_type
     */
    static function getFileExtension($file) {
        $ar = explode('.', $file);
        if (count($ar) > 1) {
            return end($ar);
        } else {
            return "";
        }
    }

}

