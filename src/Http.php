<?php

namespace Prosms;


class Http{

    private array $auth;
    private string $baseUri;
    private array $response;
    public function __construct(array $auth=[])
    {
        $this->auth = $auth;
        $this->baseUri = 'https://new.prosms.pro/api/';   
        
    }

    public function init(){
        $this->response = [
            'status' => 0,
            'data' => null,
        ];
    }

    public function post(string $path, array $data=[]){
        $this->init();
        $curl = curl_init($this->baseUri. $path);
        $options = [
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => array_merge($this->auth, $data),
            CURLOPT_TIMEOUT => 30,
        ];
        curl_setopt_array($curl, $options);
        $content = curl_exec($curl);
        $hasError = curl_errno($curl);
        if($hasError == 0){
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $this->response = [
                'status' => $status,
                'data' => $content ? $content: null
            ];
        }else{
            $this->response = [
                'status' => 0,
                'data' => curl_error($curl)
            ];
        }
        curl_close($curl);
    }


    public function getStatus(){
        return $this->response['status'];
    }

   

    public function getData(){
        return $this->response['data'];
    }
}




?>