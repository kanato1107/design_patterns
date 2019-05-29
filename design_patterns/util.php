<?php

class Util
{
    const RED         = '0;31';
    const PURPLE      = '0;35';
    const LIGHT_RED   = '1;31';
    const LIGHT_GREEN = '1;32';
    const YELLOW      = '1;33';
    const CYAN        = '1;36';
    const WHITE       = '1;37';


    /**
     * 改行付表示
     *
     * @param string $string
     * @param int    $new_line_num
     */
    public static function echo(string $string = '', int $new_line_num = 1)
    {
        echo $string;
        if ($new_line_num > 0) {
            for ($i = 1; $i <= $new_line_num; $i++) {
                echo PHP_EOL;
            }
        }
    }


    /**
     * 色付文字取得
     *
     * @param        $string
     * @param string $color
     *
     * @return string
     */
    public static function color($string, $color = self::WHITE)
    {
        return "\033[{$color}m{$string}\033[0m";
    }
}