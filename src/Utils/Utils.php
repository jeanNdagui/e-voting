<?php
// respect strict des types déclarés des paramètres de foctions
declare(strict_types=1);

namespace App\Utils;

class Utils
{
    /**
     * Renvoi une chaine comportant $length 0.
     * @param int $length
     * @return string
     */
    public static function zeros(int $length): string
    {
        $msg = "";
        for ($i = 0; $i < $length; $i++) {
            $msg .= "0";
        }
        return $msg;
    }
}
