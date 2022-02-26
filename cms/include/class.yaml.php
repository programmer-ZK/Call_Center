<?php
/*********************************************************************
    class.yaml.php

    Parses YAML data files into PHP associative arrays. Useful for initial
    data shipped with Ticket.

    Currently, this module uses the pure-php implementation Spyc, written by
        - Chris Wanstrath
        - Vlad Andersen
    and released under an MIT license. The software is available at
    https://github.com/mustangostang/spyc

**********************************************************************/

require_once "Spyc.php";
require_once "class.error.php";

class YamlDataParser {
    /* static */
    function load($file) {
        if (!file_exists($file)) {
            raise_error("$file: File does not exist", 'YamlParserError');
            return false;
        }
        return Spyc::YAMLLoad($file);
    }
}

class YamlParserError extends Error {
    static $title = 'Error parsing YAML document';
}
?>
