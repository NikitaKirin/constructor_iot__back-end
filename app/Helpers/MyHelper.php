<?php

if (!function_exists('get_educational_programs_ciphers_string')) {
    function get_educational_programs_ciphers_string(array $educationalPrograms) {
        $resultString = '';
        foreach ($educationalPrograms as $educationalProgram){
            if (preg_match('/\d{2}\.\d{2}\.\d{2}/', $educationalProgram['educational_direction'], $mathes)) {
                $resultString .= $mathes[0] . ', ';
            }
        }
        return substr($resultString, 0, strlen($resultString) - 2);
    }
}
