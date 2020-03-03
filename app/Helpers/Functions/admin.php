<?php

/**
 * @param string $path
 * @return string
 */
function admin_uri($path = '')
{
    $path = str_replace(url('admin'), '', $path);
    $path = ltrim($path, '/');

    if (!empty($path)) {
        $path = 'admin' . '/' . $path;
    } else {
        $path = 'admin';
    }

    return $path;
}

/**
 * @param string $path
 * @return string
 */
function admin_url($path = '')
{
    return url(admin_uri($path));
}
