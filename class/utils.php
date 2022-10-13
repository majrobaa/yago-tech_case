<?php

class utils
{
    private $retData;

    function __construct()
    {
        $this->retData = '';
    }

    function getRetData()
    {
        return $this->retData;
    }

    function s($index, $def = "", $uresis = false)
    {
        if (isset($_SESSION[$index])) {
            if ($uresis && trim($_SESSION[$index]) == "") {
                $res = $def;
            } else {
                $res = $_SESSION[$index];
            }
        } else {
            $res = $def;
        }
        return $res;
    }

    function ga($array, $index, $defvalue = "", $uresis = false)
    {
        if (is_array($array)) {
            if (array_key_exists($index, $array)) {
                if ($array[$index] == "" && $uresis) {
                    return $defvalue;
                } else {
                    return $array[$index];
                }
            } else {
                return $defvalue;
            }
        } else {
            return $defvalue;
        }
    }

    function apiCall($headers, $data, $apikey = '', $apiurl = '')
    {
        if ($apikey == '') $apikey = API_KEY;
        if ($apiurl == '') $apiurl = API_URL;
        $curl = curl_init($apiurl);

        $headers = array(
            "X-Api-Key: " . $apikey,
            "Content-Type: application/json",
        );

        curl_setopt($curl, CURLOPT_URL, $apiurl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $this->retData = curl_exec($curl);
        curl_close($curl);
        return $this;
    }

}