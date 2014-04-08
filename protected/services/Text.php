<?php

class Text
{
    /**
     * Limits a phrase to a given number of words.
     *
     *     $text = Text::limit_words($text);
     *
     * @param   string  $str        phrase to limit words of
     * @param   integer $limit      number of words to limit to
     * @param   string  $end_char   end character or entity
     * @return  string
     */
    public static function limit_words($str, $limit = 100, $end_char = NULL)
    {
        $limit = (int) $limit;
        $end_char = ($end_char === NULL) ? '…' : $end_char;

        if (trim($str) === '')
            return $str;

        if ($limit <= 0)
            return $end_char;

        preg_match('/^\s*+(?:\S++\s*+){1,'.$limit.'}/u', $str, $matches);

        // Only attach the end character if the matched string is shorter
        // than the starting string.
        return rtrim($matches[0]).((strlen($matches[0]) === strlen($str)) ? '' : $end_char);
    }

    /**
     * Limits a phrase to a given number of characters.
     *
     *     $text = Text::limit_chars($text);
     *
     * @param   string  $str            phrase to limit characters of
     * @param   integer $limit          number of characters to limit to
     * @param   string  $end_char       end character or entity
     * @param   boolean $preserve_words enable or disable the preservation of words while limiting
     * @return  string
     * @uses    UTF8::strlen
     */
    public static function limit_chars($str, $limit = 100, $end_char = NULL, $preserve_words = FALSE)
    {
        $end_char = ($end_char === NULL) ? '…' : $end_char;

        $limit = (int) $limit;

        if (trim($str) === '' OR strlen($str) <= $limit)
            return $str;

        if ($limit <= 0)
            return $end_char;

        if ($preserve_words === FALSE)
            return rtrim(substr($str, 0, $limit)).$end_char;

        // Don't preserve words. The limit is considered the top limit.
        // No strings with a length longer than $limit should be returned.
        if ( ! preg_match('/^.{0,'.$limit.'}\s/us', $str, $matches))
            return $end_char;

        return rtrim($matches[0]).((strlen($matches[0]) === strlen($str)) ? '' : $end_char);
    }

    /**
     * @param $str
     * @param null $die
     */
    public static function pr($str, $die = null) {
        echo "<pre>";
        print_r($str);
        echo "</pre>";
        if ($die != null)
            die('Сарботал die');
    }

}