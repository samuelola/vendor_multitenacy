<?php

namespace App\Repositories;

use App\Interface\ConsumeApiInterface;

class ApiConsumeRepository implements ConsumeApiInterface {
    
    private $url;
    private $key;
    private $fields;
    public function __construct($url,$key=null,$fields=null){
        $this->url = $url;
        $this->key = $key;
        $this->fields = $fields;
    }

    public function getApi(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache"
        ),
        ));
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        return $result;
    }

    public function postApi(){
        $data_string = json_encode($this->fields);
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data_string,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',  
            "Authorization: $this->key"
        ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $ress = json_decode($response);
        return $ress;
    }
}