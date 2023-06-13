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
    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    // Метод для генерации карты сайта.
    public function generateSitemap($siteUrl) {
        $url = "https://api.mysitemapgenerator.com/v1/generate?url=" . urlencode($siteUrl);

        $headers = array(
            'Authorization: Basic ' . base64_encode($this->apiKey . ':'),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        curl_close($ch);
        //echo getcwd(); // покажет текущую директорию
        //die();
        $file = fopen("fff/sitemap.xml", "r");
        fwrite($file, $response);
        fclose($file);

        return "Карта сайта успешно сгенерирована.";
    }
}
