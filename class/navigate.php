<?php

class navigate
{
    private $isadmin;
    private $utils;
    private $csvlist;
    private $retdata;

    public function __construct()
    {
        $this->utils = new utils();
        $this->isadmin = $this->utils->s('isadmin');
        $this->csvlist = [];
        $this->retData = [];
    }

    function render()
    {
        require_once "static/header.html";

        if ($this->isadmin) {
            require_once "content/admin_page.php";
        } else {
            // var_dump($_POST);
            $this->loadCsvContent('files/NACEBEL_2008.csv')->getCsvCodes(5)->getRetData('csv');
            require_once "content/user_page.php";
        }

        require_once "static/footer.php";
    }

    function getRetData($key)
    {
        return $this->retData[$key];
    }

    function getCsvCodes($level = 0)
    {
        foreach ($this->csvlist as $row) {
            if (($level > 0 && $this->utils->ga($row, 'Level nr') == $level)) {
                $this->retData['csv'][] = $row;
            }
        }
        return $this;
    }

    function loadCsvContent($path, $nameRelated = 'medical')
    {
        $file = fopen($path, 'r');
        $fields = fgetcsv($file, 10000, ';');
        $csv = [];
        while (($data = fgetcsv($file, 10000, ';')) !== FALSE) {
            if ($data[6] !== '' && strpos($data[6], $nameRelated)) {
                for ($i = 0; $i < count($data); $i++) {
                    $csv[$fields[$i]] = $data[$i];
                }
                $this->csvlist[] = $csv;
            }
        }
        fclose($file);
        return $this;
    }

    function loadApiResult()
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $codes = '[';
        if ($this->utils->ga($_POST, 'codes')) {
            $chosen = '';
            foreach ($this->utils->ga($_POST, 'codes') as $code) {
                $chosen .= ',' . $code . '"';
            }
            $codes .= '"' . str_replace(',', ',"', substr($chosen, 1));
        }
        $codes .= ']';

        $data = '{
	                "annualRevenue": ' . $this->utils->ga($_POST, 'salary') . ',
	                "enterpriseNumber": "' . $this->utils->ga($_POST, 'enumber') . '",
	                "legalName": "' . $this->utils->ga($_POST, 'lname') . '",
	                "naturalPerson": ' . ($this->utils->ga($_POST, 'nperson') === 'on' ? 'true' : 'false') . ',
	                "nacebelCodes": ' . $codes . ',
	                "deductibleFormula": "' . $this->utils->ga($_POST, 'dformula') . '",
	                "coverageCeilingFormula": "' . $this->utils->ga($_POST, 'cformula') . '"
                  }';

        echo $data;

        $this->retData['call'] = json_decode($this->utils->apiCall($headers, $data)->getRetData(), true);

        return $this;
    }
}