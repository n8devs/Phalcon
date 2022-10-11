<?php
use Phalcon\Mvc\Model\Query;
use Phalcon\Http\Client;

class MageCategory{

    /**
     * @param JsonSerializable $inputJson Input parameters
     * @return array Records found
     */

    public static function getCategoryTree(\Phalcon\Mvc\Micro $app,$inputJson){

        try {
            $dataArray = json_decode($inputJson,true);
            switch ($dataArray['categories']['version']){
                case 2:
                    $provider =  Client\Request::getProvider();
                    $provider->setBaseUri($app->config->magecon->api_base_url);
                    $provider->header->set('Accept', 'application/json');
                    $provider->header->set('Content-Type', 'application/json');
                    $provider->header->set('Authorization', 'Bearer '.$app->config->magecon->api_access_token);
                    $response = $provider->get("categories?rootCategoryId=".$dataArray['categories']['id']."&depth=".$dataArray['categories']['depth']);
                    $app->response->setStatusCode($response->header->statusCode);
                    $app->response->send();

                    if($response->header->statusCode === 200) {
                        return json_decode($response->body, true);
                    }else{
                        $errorResponse =  json_decode($response->body, true);
                        if(is_null($errorResponse["trace"]) || isset($errorResponse["trace"])){
                            unset($errorResponse["trace"]);
                        }
                        return $errorResponse;
                    }
                    break;
                case 1:
                    //todo: call magento 1 web services
                    break;
                default:
                    $app->response->setStatusCode(400);
                    $app->response->send();

                    return ['message'=>"version ".$dataArray['collection']['version']."not found"];
                    break;
            }
        }catch (\HttpRequestException $e){
            return [$e->getMessage()['message']];
        }
    }
}