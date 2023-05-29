<?php

namespace web\App\ParcelUrl;
//require_once '../Core/utilities/dd.php';

//$ch = curl_init();
//
//curl_setopt($ch, CURLOPT_URL, "172.18.0.1");
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//
//$response = curl_exec($ch);
//
//curl_close($ch);


class ParcelUrl {

    private $url;
    private $response;
    private $error = false;

    public function __construct($url) {
        $this->url = $url;
    }

    public function fetch() {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36');
        curl_setopt($curl, CURLOPT_REFERER, 'https://google.ru');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept-Language: ru-RU,ru;q=0.8;charset=UTF-8'));
        $this->response = curl_exec($curl);
        if ($this->response === false) {
            $this->error = true;
        }
        curl_close($curl);
        return $this->response;
    }

    public function isError() {
        return $this->error;
    }

}
