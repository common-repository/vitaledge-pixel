<?php 

namespace VitalEdgeInc\VeApi;
use GuzzleHttp\Client;


class VePixelApi {
    //public $base = "https://api-dev.vitaledge.io";
    //public $base = "https://api-staging.vitaledge.io";
    public $base = "https://api.vitaledge.io";
    public $pixel = "/pixel-service";
    public $wordpress = "/wordpress-service";
    public $optionId = 've_wp_id';
    public $pixelId = 've_px_id';
    public $script1 = 've_script_1';
    public $script2 = 've_script_2';
    
    public $client;
    public $domain;

    public function __construct() {
        $this->client = new Client([
            'base_uri' => $this->base
        ]);
        $this->domain = get_option( 'siteurl' );
    }

    public function install(){
        try{
            $res = $this->client->request('POST', $this->wordpress . "/install", [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode([
                    'domainURL' => $this->domain,
                ])
            ]);
            $arrayRes = json_decode($res->getBody());
            if ($arrayRes->status == 'success'){
                //save wp_options ve_wp_id
                get_option( $this->optionId );
                $this->createOrUpdateOption($this->optionId, $arrayRes->data->id);
            }
        }catch(\GuzzleHttp\Exception\RequestException $e){
            if ($e->hasResponse()) {
                $this->logResponse($e->getResponse()->getReasonPhrase());
            }
        }
    }

    public function uninstall(){
        $id = get_option( $this->optionId );
        try{
            $res = $this->client->request('POST', $this->wordpress . "/uninstall", [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode([
                    'id' => $id,
                ])
            ]);
            delete_option($this->pixelId);
            delete_option($this->script1);
            delete_option($this->script2);
        }catch(\GuzzleHttp\Exception\RequestException $e){
            if ($e->hasResponse()) {
                $this->logResponse($e->getResponse()->getReasonPhrase());
            }
        }
        
    }

    public function getInstallation(){
        $id = get_option( $this->optionId );
        try{
            $res = $this->client->request('GET', $this->wordpress . "/get?id=" . $id);
            $this->logResponse($res->getBody());
            return json_decode($res->getBody());
        }catch(\GuzzleHttp\Exception\RequestException $e){
            if ($e->hasResponse()) {
                $this->logResponse($e->getResponse()->getReasonPhrase());
            }
        }
    }

    
    public function getPixel($id){
        try{
            $res = $this->client->request('GET', $this->pixel . "/pixelById?id=" . urlencode($id));
            $this->logResponse($res->getBody());
            return json_decode($res->getBody());
        }catch(\GuzzleHttp\Exception\RequestException $e){
            if ($e->hasResponse()) {
                $this->logResponse($e->getResponse()->getReasonPhrase());
            }
        }
    }

    public function savePixel($pixelId){
        $id = get_option( $this->optionId );
        try{
            $res = $this->client->request('PUT', $this->wordpress . "/add-pixel", [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode([
                    'id' => $id,
                    'pixelId' => $pixelId
                ])
            ]);
            $resBody = json_decode($res->getBody());
            $this->logResponse($res->getBody());
            
            $scripthead = $resBody->data->pixel->head;
            $scriptbody = $resBody->data->pixel->body;

            //save db
            $this->createOrUpdateOption($this->pixelId, $pixelId);
            $this->createOrUpdateOption($this->script1, $scripthead);
            $this->createOrUpdateOption($this->script2, $scriptbody);

            return json_decode($res->getBody());
        }catch(\GuzzleHttp\Exception\RequestException $e){
            if ($e->hasResponse()) {
                $this->logResponse($e->getResponse()->getReasonPhrase());
            }
        }
        
    }

    public function logResponse($log){
        //error handler do nothing for now
        echo '<script>console.log('.$log.') </script>';
    }

    public function createOrUpdateOption($option, $value){
        get_option( $option );
        if (empty(get_option( $option ))){
             add_option($option, $value);
        }else{
            update_option($option, $value);
        }
    }

}