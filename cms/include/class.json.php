<?php
/*********************************************************************
    class.json.php

**********************************************************************/

include_once "JSON.php";

class JsonDataParser {
    function parse($stream) {
        if (is_resource($stream)) {
            $contents = '';
            while (!feof($stream))
                $contents .= fread($stream, 8192);
        } else
            $contents = $stream;
        return self::decode($contents);
    }

    function decode($contents) {
        if (function_exists("json_decode")) {
            return json_decode($contents, true);
        } else {
            # Create associative arrays rather than 'objects'
            $decoder = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
            return $decoder->decode($contents);
        }
    }
    function lastError() {
        if (function_exists("json_last_error")) {
            $errors = array(
            JSON_ERROR_NONE => __('No errors'),
            JSON_ERROR_DEPTH => __('Maximum stack depth exceeded'),
            JSON_ERROR_STATE_MISMATCH => __('Underflow or the modes mismatch'),
            JSON_ERROR_CTRL_CHAR => __('Unexpected control character found'),
            JSON_ERROR_SYNTAX => __('Syntax error, malformed JSON'),
            JSON_ERROR_UTF8 => __('Malformed UTF-8 characters, possibly incorrectly encoded')
            );
            if ($message = $errors[json_last_error()])
                return $message;
            return __("Unknown error");
        } else {
            # Doesn't look like Servies_JSON supports errors for decode()
            return __("Unknown JSON parsing error");
        }
    }
}

class JsonDataEncoder {
    function encode($var) {
        if (function_exists('json_encode'))
            return json_encode($var);
        else {
            $decoder = new Services_JSON();
            return $decoder->encode($var);
        }
    }
}
