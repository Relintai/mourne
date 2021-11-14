<?php  if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

//using different helper for images, so they can be easily relocated to like different servers etc...

if (! function_exists('isite_url')) {
    function isite_url($uri = '')
    {
        $CI =& get_instance();
        return $CI->config->site_url($uri);
    }
}

//addign img/prefix, so I don't have to in every call

if (! function_exists('ibase_url')) {
    function ibase_url($uri = '')
    {
        $muri = 'img/' . $uri;
        $CI =& get_instance();
        return $CI->config->base_url($muri);
    }
}
