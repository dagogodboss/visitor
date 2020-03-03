<?php


use App\Setting;

    function settings()
    {
        $settings = Setting::find(1);

        return $settings;
    }

