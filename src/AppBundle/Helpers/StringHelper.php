<?php

namespace AppBundle\Helpers;

use Doctrine\ORM\EntityManager;

class StringHelper
{
    static public function currency($money)
    {
        if ($money > 0) {
            return number_format($money, 0, ' ', '.') . ' VND';    
        }
        
        return null;
    }

    static public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    static public function shortString($text, $limit = 50)
    {
        $result = $text;
        
        //$pos=strpos($text, ' ', $limit);

        // Check if length is larger than the character limit
        if (strlen($text) > $limit)
        {
            $newText = substr($text, 0, $limit);

            // Trim off white space
            $result = trim($newText);
        }
        return $result;
        //return substr($text, 0, $pos);
    }
}