<?php

if (! function_exists('normalize_phone_number')) {
    function normalize_phone_number($number) {
        return str($number)
                ->replaceMatches('/[^0-9]+/', '')
                ->replaceMatches('/^9?0/', '');
    }
}
