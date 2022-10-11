<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro\MiddlewareInterface;
use Phalcon\Mvc\Micro;

class AuthMiddleware implements MiddlewareInterface
{
    public function beforeExecuteRoute(Event $event, Micro $app)
    {
        $authorizeExceptions = [
            'doc'
        ];
        if (!in_array($app->router->getMatchedRoute()->getName(), $authorizeExceptions)) {
            $result = $this->authorize($app);
            if (is_null($result)) {
                $app->response->setStatusCode(401,'Please authorize with valid API token!');
                $app->response->setContent('Please authorize with valid API token!');
                $app->response->send();
                die();
                //return false;
            }
        }

        if (in_array($app->request->getMethod(), ['POST', 'PUT']) AND $app->request->getHeader('Content-Type') != 'application/json') {
            $app->response->setStatusCode(400,'Only application/json is accepted for Content-Type in POST requests.');
            $app->response->send();
            die();
            //return false;
        }

        return true;
    }

    private function authorize(Micro $app)
    {
        $app->token = null;
        $authorizationHeader = $app->request->getHeader('api-token');
        $allowtokens =$app->config->api->access_token->toArray();

        if(!in_array($authorizationHeader ,$allowtokens)) {  //check token validity and find from database what user has the token
            $app->token = $authorizationHeader;
        }

        return $app->token;
    }

    public function call(Micro $app)
    {
        return true;
    }
}
