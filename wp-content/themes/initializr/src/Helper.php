<?php


namespace App;


class Helper
{
    public static function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function getThumbUrl($size)
    {
        global $post;

        $thumb    = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size);
        $thumbUrl = $thumb['0'];

        return $thumbUrl;
    }

    public static function dump($data)
    {
        if (is_array($data)) {
            print "<pre>-----------------------\n";
            print_r($data);
            print "-----------------------</pre>";
        } elseif (is_object($data)) {
            print "<pre>==========================\n";
            var_dump($data);
            print "===========================</pre>";
        } else {
            print "=========&gt; ";
            var_dump($data);
            print " &lt;=========";
        }
    }

    public static function dd($data)
    {
        self::dump($data);
        die;
    }

    public static function asset($file)
    {
        return Config::get('general')['asset-uri'] . '/' . $file;
    }

    public static function file($file)
    {
        return get_template_directory() . '/' . $file;
    }
}