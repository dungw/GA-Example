<?php namespace core;

class Utils
{

    public static function getCredential()
    {
        $iniFile = $_SERVER['DOCUMENT_ROOT'] . '/app.ini';
        $data = parse_ini_file($iniFile, true);

        return isset($data['credential']) ? $data['credential'] : [];
    }

}

