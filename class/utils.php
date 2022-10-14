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

    function apiCall($data, $apikey = '', $apiurl = '')
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
        //var_dump($this->retData);
        return $this;
    }

    function validate($array, $notempty = [])
    {
        $error = [];
        foreach ($array as $key => $value) {
            if (in_array($key, $notempty)) {
                if (is_array($value)) {
                    if (count($value) == 0) $error[$key . '_error'] = $key . ' Field cannot be empty';
                } else {
                    if ($value == '') $error[$key . '_error'] = $key . ' Field cannot be empty';
                }
            }
        }
        return $error;
    }

    function getCoverDetails($cover)
    {
        $details = [];
        switch ($cover) {
            case 'afterDelivery':
                $details = [
                    'name' => "After Delivery",
                    'description' => "covers damage arising after delivery of or completion of work (ex: new machines 
                    recently installed at the client's office start a fire).",
                ];
                break;
            case 'publicLiability':
                $details = [
                    'name' => "Public Liability",
                    'description' => "cover compensation claims for injury or damage (ex: you spill a cup of coffee over 
                    a client’s computer equipment).",
                ];
                break;
            case 'professionalIndemnity':
                $details = [
                    'name' => "Professional Indemnity",
                    'description' => "cover compensation claims for a mistake that you make during your work 
                    (ex: accidentally forwarded confidential client information to third parties).",
                ];
                break;
            case 'entrustedObjects':
                $details = [
                    'name' => "Entrusted Objects",
                    'description' => " objects that don't belong to you, and are entrusted to you. You are obviously liable 
                    for any damage to these goods. (ex: you break the super expensive computer that was provided to you as an IT consultant).",
                ];
                break;
            case 'legalExpenses':
                $details = [
                    'name' => "Legal Expenses",
                    'description' => "Also known as legal insurance, is an insurance which facilitates access to law and 
                    justice by providing legal advice and covering legal costs of a dispute. (ex: a client asks you for a 
                    financial compensation for a mistake you made in your work and you consider it's absolutely not you 
                    fault considering the context and you thus want to hire a lawyer to defend you).",
                ];
                break;
        }
        $details['key'] = $cover;
        return $details;
    }

    function readContents($filename)
    {
        if (is_file($filename)) {
            $raw_content = file_get_contents($filename);
            return json_decode($raw_content, true);
        } else {
            fopen($filename, 'w');
            return [];
        }
    }

    function writeContents($filename, $contents)
    {
        return file_put_contents($filename, json_encode($contents));
    }
}