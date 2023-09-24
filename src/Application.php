<?php


namespace Prosms;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;

class Application{
   
    private bool $successful;
    private string $error;
    private  $data;
    private int $statusCode;
    private Http $http;

    public function __construct(string $apiKey='', string $apiPass='')
    {
        $this->http = new Http([
            'API_KEY' => $apiKey,
            'API_PASS' => $apiPass
        ]);
    }

    public function init(){
        $this->successful = false;
        $this->error = "";
        $this->data = null;
        $this->statusCode = 0;
    }

    public function getCredit(){
        $this->init();
        $path = 'app/credit';
        $this->http->post($path);
        $this->statusCode = $this->http->getStatus();
        if($this->http->getStatus() == 200){
            $this->successful = true;
            $this->data = json_decode($this->http->getData());
        }elseif($this->http->getStatus() == 401){
            $output = json_decode($this->http->getData());
            $this->error = $output->message;
        }else{
            $this->error = $this->http->getData();
        }
    }


    public function getReloadCreditHistoric(){
        $this->init();
        $path = 'app/historic/credit';
        $this->http->post($path);
        $this->statusCode = $this->http->getStatus();
        if($this->http->getStatus() == 200){
            $this->successful = true;
            $this->data = json_decode($this->http->getData());
        }elseif($this->http->getStatus() == 401){
            $output = json_decode($this->http->getData());
            $this->error = $output->message;
        }else{
            $this->error = $this->http->getData();
        }
    }


    /**
     * @param string $dateStart date in format Y-m-d
     * @param string $dateEnd date in format Y-m-d
     */
    public function getSentMessagesHistoric(string $dateStart, string $dateEnd){
        $this->init();
        $path = 'app/historic/sms';
        $this->http->post($path, [
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd
        ]);
        $this->statusCode = $this->http->getStatus();
        if($this->http->getStatus() == 200){
            $this->successful = true;
            $this->data = json_decode($this->http->getData());
        }elseif($this->http->getStatus() == 400){
            $this->error = $this->http->getData();
        }elseif($this->http->getStatus() == 401){
            $output = json_decode($this->http->getData());
            $this->error = $output->message;
        }else{
            $this->error = $this->http->getData();
        }
    }


    public function addSenderId(string $senderId, string $description=''){
        $this->init();
        $path = 'app/senderId/create';
        $this->http->post($path, [
            'senderId' => $senderId,
            'description' => $description
        ]);
        $this->statusCode = $this->http->getStatus();
        if($this->http->getStatus() == 200){
            $this->successful = true;
            $this->data = json_decode($this->http->getData());
        }elseif($this->http->getStatus() == 400){
            $this->error = $this->http->getData();
        }elseif($this->http->getStatus() == 401){
            $output = json_decode($this->http->getData());
            $this->error = $output->message;
        
        }elseif($this->http->getStatus() == 403){
            $this->error = $this->http->getData();
        }else{
            $this->error = $this->http->getData();
        }
    }


    public function listSenderId(){
        $this->init();
        $path = 'app/senderId/list';
        $this->http->post($path);
        $this->statusCode = $this->http->getStatus();
        if($this->http->getStatus() == 200){
            $this->successful = true;
            $this->data = json_decode($this->http->getData());
        }elseif($this->http->getStatus() == 401){
            $output = json_decode($this->http->getData());
            $this->error = $output->message;
        }else{
            $this->error = $this->http->getData();
        }
    }


    public function sendSms(string $senderId, string $message, string $numero, string $date=''){
        $this->init();
        $path = 'campagne/new';
        $this->http->post($path, [
            'senderId' => $senderId,
            'message' => $message,
            'numero' => $numero,
            'date' => $date
        ]);
        $this->statusCode = $this->http->getStatus();
        if($this->http->getStatus() == 200){
            $this->successful = true;
            $this->data = json_decode($this->http->getData());
        }elseif($this->http->getStatus() == 400){
            $this->error = $this->http->getData();
        }elseif($this->http->getStatus() == 401){
            $output = json_decode($this->http->getData());
            $this->error = $output->message;
        }else{
            $this->error = $this->http->getData();
        }
    }


    public function isSuccessful(): bool{
        return $this->successful;
    }

    public function getError(): string{
        return $this->error;
    }

    public function getStatusCode(): int{
        return $this->statusCode;
    }
    public function getData(): mixed{
        return $this->data;
    }
}



?>