<?php
use Phalcon\Mvc\Model\Query;
use Phalcon\Http\Client;

class MageOrder{

    /**
     * @param JsonSerializable $inputJson Input parameters
     * @return array Records found
     */

    public static function getOrderList(\Phalcon\Mvc\Micro $app ,$inputJson){
        try {
            $dataArray = json_decode($inputJson,true);
            switch ($dataArray['collection']['version']){
                case 2:
                    $provider =  Client\Request::getProvider();

                    $provider->setBaseUri($app->config->magecon->api_base_url);
                    $provider->header->set('Accept', 'application/json');
                    $provider->header->set('Content-Type', 'application/json');
                    $provider->header->set('Authorization', 'Bearer '.$app->config->magecon->api_access_token);
                    $response = $provider->post('orderCollection',$inputJson);

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
            return [$e->getMessage()];
        }
    }

    /**
     * @return array Records found
     */
    public static function putOrder(\Phalcon\Mvc\Micro $app){
        try {
            $dataArray = json_decode($app->request->getRawBody(),true);
            switch ($dataArray['entity']['extension_attributes']['version']){
                case 2:

                    $provider =  Client\Request::getProvider();

                    $provider->setBaseUri($app->config->magecon->api_base_url);
                    $provider->header->set('Accept', 'application/json');
                    $provider->header->set('Content-Type', 'application/json');
                    $provider->header->set('Authorization', 'Bearer '.$app->config->magecon->api_access_token);
                    $response = $provider->post('orders',$app->request->getRawBody());
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
                    $app->response->setStatusCode(404);
                    $app->response->send();
                    return ['message'=>"version ".$dataArray['version']."can't be found"];
                    break;
            }
        }catch (\HttpRequestException $e){
            return [$e->getMessage()];
        }
    }
}