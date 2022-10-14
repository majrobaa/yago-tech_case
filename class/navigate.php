<?php

class navigate
{
    private $isadmin;
    private $utils;
    private $csvlist;
    private $retdata;
    private $userdata;

    public function __construct()
    {
        $this->setInit();
    }

    function setInit()
    {
        $this->utils = new utils();
        $this->isadmin = $this->utils->ga($_GET, 'a') ? true : false;
        $this->csvlist = [];
        $this->retData = ['error' => []];
        $this->userdata = [];
        if ($this->utils->s('uid') === '' || $this->utils->ga($_GET, 'u') !== $this->utils->s('uid')) $_SESSION['uid'] = $this->utils->ga($_GET, 'u', 1, true);

        $this->loadUserData($this->utils->s('uid'));
    }

    function render()
    {
        require_once "static/header.html";

        if ($this->isadmin) {
            $this->loadCsvContent('files/NACEBEL_2008.csv')->getCsvCodes(5)->getRetData('csv');
            if (count($_POST) > 0) {
                $this->retData['error'] = $this->utils->validate($_POST, ['revenue', 'enumber', 'lname', 'codes']);
                if (!isset($_POST['codes'])) $this->retData['error']['codes'] = 'Nacabel Codes not given';
                if (substr($_POST['enumber'], 0, 1) != 0 || strlen($_POST['enumber']) !== 10) $this->retData['error']['enumber'] = 'Wrong enumber format';
                if (count($this->retData['error']) == 0) {
                    $response = $this->utils->ga($this->utils->ga($this->loadApiResult()->getRetdata('call'), 'data'), 'grossPremiums');
                    foreach ($response as $key => $cover) {
                        $details = $this->utils->getCoverDetails($key);
                        $details['price'] = $cover;
                        $this->retData['covers'][] = $details;
                    }
                    $insert[$this->utils->s('uid')] = [
                        'post' => $_POST,
                        'covers' => $this->retData['covers']];
                    $this->utils->writeContents('user/users.json', $insert);
                    $this->userdata = $insert[$this->utils->s('uid')];
                }
            }

            require_once "content/admin_page.php";
        } else {
            foreach ($this->getUserData('covers') as $key => $cover) {
                $this->retData['covers'][] = $cover;
            }

            foreach ($this->getUserData('post') as $key => $post) {
                $this->retData['post'][] = $post;
            }

            require_once "content/user_page.php";
        }

        $this->checkEmail();
        require_once "static/footer.php";
    }

    function getRetData($key = '')
    {
        return $key === '' ? $this->retData : $this->retData[$key];
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
	                "annualRevenue": ' . $this->utils->ga($_POST, 'revenue') . ',
	                "enterpriseNumber": "' . $this->utils->ga($_POST, 'enumber') . '",
	                "legalName": "' . $this->utils->ga($_POST, 'lname') . '",
	                "naturalPerson": ' . ($this->utils->ga($_POST, 'nperson') === 'on' ? 'true' : 'false') . ',
	                "nacebelCodes": ' . $codes . ',
	                "deductibleFormula": "' . $this->utils->ga($_POST, 'dformula') . '",
	                "coverageCeilingFormula": "' . $this->utils->ga($_POST, 'cformula') . '"
                  }';

        $this->retData['call'] = json_decode($this->utils->apiCall($data)->getRetData(), true);
        return $this;
    }

    function loadUserData($uid)
    {
        $users = $this->utils->readContents('user/users.json');
        foreach ($users as $key => $value) {
            if ($key == $uid) {
                $this->userdata = $value;
                break;
            }
        }
        return $this;
    }

    function getUserData($key = '')
    {
        return $key == '' ? $this->userdata : (isset($this->userdata[$key]) ? $this->userdata[$key] : []);
    }

    function checkEmail()
    {
        if ($this->utils->ga($_GET, 'send')) {
            $user = $this->utils->ga($this->loadUserData($this->utils->s('uid'))->getUserData(), 'post');
            $message = 'Click on the link to load your details: https://' . $this->utils->ga($_SERVER, 'HTTP_HOST');
            $headers = 'From: Robert Majnik Test Case <r.majnik@vtx.hu>' . PHP_EOL;
            if (mail($this->utils->ga($user, 'email'), 'Reminder', $message, $headers)) {
                echo 'message sent';
            } else {
                echo 'Not send';
            }
        }
    }
}