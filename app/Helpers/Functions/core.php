<?php
/**
 * iNiLabs - Visitor Pass Management System
 * Copyright (c) iNiLabs. All Rights Reserved
 *
 * Website: http://www.inilabs.net
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

/**
 * Check if an update is available
 *
 * @return bool
 */
function updateIsAvailable()
{
    // Check if the '.env' file exists
    if (!file_exists(base_path('.env'))) {
        return false;
    }

    $updateIsAvailable = false;

    // Get eventual new version value & the current (installed) version value
    $lastVersionInt = strToInt(config('inilabs.iniconfig.item_version'));
    $currentVersionInt = strToInt(getCurrentVersion());
    // Check the update
    if ($lastVersionInt > $currentVersionInt) {
        $updateIsAvailable = true;
    }

    return $updateIsAvailable;
}

/**
 * Extract only digit characters and Convert the result in integer.
 *
 * @param $value
 * @return mixed
 */
function strToInt($value)
{
    $value = preg_replace('/[^0-9]/', '', $value);
    $value = (int)$value;

    return $value;
}
/**
 * Get the current version value
 *
 * @return null|string
 */
function getCurrentVersion()
{
    // Get the Current Version
    $currentVersion = null;
    if (DotenvEditor::keyExists('APP_VERSION')) {
        try {
            $currentVersion = DotenvEditor::getValue('APP_VERSION');
        } catch (\Exception $e) {
        }
    }

    // Forget the subversion number
    if (!empty($currentVersion)) {
        $tmp = explode('.', $currentVersion);
        if (count($tmp) > 1) {
            if (count($tmp) >= 3) {
                $tmp = \Illuminate\Support\Arr::only($tmp, [0, 1]);
            }
            $currentVersion = implode('.', $tmp);
        }
    }
    return $currentVersion;
}
/**
 * Redirect (Prevent Browser cache)
 *
 * @param $url
 * @param int $code (301 => Moved Permanently | 302 => Moved Temporarily)
 */
function headerLocation($url, $code = 301)
{
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Location: " . $url, true, $code);
    exit();
}
/**
 * Get the script possible URL base
 *
 * @return mixed
 */
function getRawBaseUrl()
{
    // Get the Laravel's App public path name
    $laravelPublicPath = trim(public_path(), '/');
    $laravelPublicPathLabel = last(explode('/', $laravelPublicPath));

    // Get Server Variables
    $httpHost = (trim(request()->server('HTTP_HOST')) != '') ? request()->server('HTTP_HOST') : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
    $requestUri = (trim(request()->server('REQUEST_URI')) != '') ? request()->server('REQUEST_URI') : (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '');

    // Clear the Server Variables
    $httpHost = trim($httpHost, '/');
    $requestUri = trim($requestUri, '/');
    $requestUri = (mb_substr($requestUri, 0, strlen($laravelPublicPathLabel)) === $laravelPublicPathLabel) ? '/' . $laravelPublicPathLabel : '';


    // Get the Current URL
    $currentUrl = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://') . $httpHost . strtok($requestUri, '?');
    $currentUrl = head(explode('/' . admin_uri(), $currentUrl));
    // Get the Base URL
    $baseUrl = head(explode('/install', $currentUrl));
    $baseUrl = rtrim($baseUrl, '/');

    return $baseUrl;
}

/**
 * Check if the app is installed
 *
 * @return bool
 */
function appIsInstalled()
{
    // Check if the '.env' file exists
    if (!file_exists(base_path('.env'))) {
        return false;
    }
    // Check if the 'storage/installed' file exists
    if (!file_exists(storage_path('installed'))) {
        return false;
    }

    // Check Installation Setup
    $properly = true;
    try {
        // Check if all database tables exists
        $namespace  = 'App\\Models\\';
        $modelsPath = app_path('Models');
        $modelFiles = array_filter(glob($modelsPath . '/' . '*.php'), 'is_file');

        if (count($modelFiles) > 0) {
            foreach ($modelFiles as $filePath) {
                $filename = last(explode('/', $filePath));
                $modelname = head(explode('.', $filename));

                if (
                    !Str::contains(strtolower($filename), '.php')
                    || Str::contains(strtolower($modelname), 'base')
                ) {
                    continue;
                }

                eval('$model = new ' . $namespace . $modelname . '();');

                if (!\Illuminate\Support\Facades\Schema::hasTable($model->getTable())) {
                    $properly = false;
                }
            }

        }
        // Check Settings table
        if (\App\Setting::count() <= 0) {
            $properly = false;
        }
    } catch (\PDOException $e) {
        $properly = false;
    } catch (\Exception $e) {
        $properly = false;
    }

    return $properly;
}

/**
 * Check if json string is valid
 *
 * @param $string
 * @return bool
 */
function isValidJson($string)
{
    try {
        json_decode($string);
    } catch (\Exception $e) {
        return false;
    }

    return (json_last_error() == JSON_ERROR_NONE);
}
/**
 * Run artisan config cache
 *
 * @return mixed
 */
function artisanConfigCache()
{
    // Artisan config:cache generate the following two files
    // Since config:cache runs in the background
    // to determine if it is done, we just check if the files modified time have been changed
    $files = ['bootstrap/cache/config.php', 'bootstrap/cache/services.php'];
    // get the last modified time of the files
    $last = 0;
    foreach ($files as $file) {
        $path = base_path($file);
        if (file_exists($path)) {
            if (filemtime($path) > $last) {
                $last = filemtime($path);
            }
        }
    }
    // Prepare to run (5 seconds for $timeout)
    $timeout = 5;
    $start = time();
    // Actually call the Artisan command
    $exitCode = Artisan::call('config:cache');
    // Check if Artisan call is done
    while (true) {
        // Just finish if timeout
        if (time() - $start >= $timeout) {
            echo "Timeout\n";
            break;
        }

        // If any file is still missing, keep waiting
        // If any file is not updated, keep waiting
        // @todo: services.php file keeps unchanged after artisan config:cache
        foreach ($files as $file) {
            $path = base_path($file);
            if (!file_exists($path)) {
                sleep(1);
                continue;
            } else {
                if (filemtime($path) == $last) {
                    sleep(1);
                    continue;
                }
            }
        }

        // Just wait another extra 3 seconds before finishing
        sleep(3);
        break;
    }

    return $exitCode;
}
/**
 * Check if function is enabled
 *
 * @param $name
 * @return bool
 */
function func_enabled($name)
{
    try {
        $disabled = array_map('trim', explode(',', ini_get('disable_functions')));

        return !in_array($name, $disabled);
    } catch (\Exception $ex) {
        return false;
    }
}
/**
 * Get file/folder permissions.
 *
 * @param $path
 * @return string
 */
function getPerms($path)
{
    return substr(sprintf('%o', fileperms($path)), -4);
}

/**
 * Localized URL
 *
 * @param null $path
 * @param array $attributes
 * @param null $locale
 * @return bool|\Illuminate\Contracts\Routing\UrlGenerator|mixed|null|string
 */
function lurl($path = null, $attributes = [], $locale = null)
{
    if (empty($locale)) {
        $locale = config('app.locale');
    }

    if (request()->segment(1) == admin_uri()) {
        return url($locale . '/' . $path);
    }

    return \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($locale, $path, $attributes);
}

/**
 * Get domain (host without sub-domain)
 *
 * @param null $url
 * @return string
 */
function getDomain($url = null)
{
    if (!empty($url)) {
        $host = parse_url($url, PHP_URL_HOST);
    } else {
        $host = getHost();
    }

    $tmp = explode('.', $host);
    if (count($tmp) > 2) {
        $itemsToKeep = count($tmp) - 2;
        $tlds = config('tlds');
        if (isset($tmp[$itemsToKeep]) && isset($tlds[$tmp[$itemsToKeep]])) {
            $itemsToKeep = $itemsToKeep - 1;
        }
        for ($i = 0; $i < $itemsToKeep; $i++) {
            \Illuminate\Support\Arr::forget($tmp, $i);
        }
        $domain = implode('.', $tmp);
    } else {
        $domain = @implode('.', $tmp);
    }

    return $domain;
}

/**
 * Get host (domain with sub-domain)
 *
 * @param null $url
 * @return array|mixed|string
 */
function getHost($url = null)
{
    if (!empty($url)) {
        $host = parse_url($url, PHP_URL_HOST);
    } else {
        $host = (trim(request()->server('HTTP_HOST')) != '') ? request()->server('HTTP_HOST') : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
    }

    if ($host == '') {
        $host = parse_url(url()->current(), PHP_URL_HOST);
    }

    return $host;
}
/**
 * Default translator (e.g. en/global.php)
 *
 * @param $string
 * @param array $replace
 * @param string $file
 * @param null $locale
 * @return string|\Symfony\Component\Translation\TranslatorInterface
 */
function t($string, $replace = [], $file = 'global', $locale = null)
{
    if (is_null($locale)) {
        $locale = config('app.locale');
    }

    return trans($file . '.' . $string, $replace, $locale);
}

/**
 * Get all countries from PHP array (umpirsky)
 *
 * @return array|null
 */
function getCountriesFromArray()
{
    $countries = new App\Helpers\Localization\Helpers\Country();
    $countries = $countries->all();

    if (empty($countries)) return null;

    $arr = [];
    foreach ($countries as $code => $value) {
        if (!file_exists(storage_path('database/geonames/countries/' . strtolower($code) . '.sql'))) {
            continue;
        }
        $row = ['value' => $code, 'text' => $value];
        $arr[] = $row;
    }

    return $arr;
}
function getHostByUrl($url)
{
    // in case scheme relative URI is passed, e.g., //www.google.com/
    $url = trim($url, '/');

    // If scheme not included, prepend it
    if (!preg_match('#^http(s)?://#', $url)) {
        $url = 'http://' . $url;
    }

    $urlParts = parse_url($url);

    // remove www
    $domain = preg_replace('/^www\./', '', $urlParts['host']);

    return $domain;
}
