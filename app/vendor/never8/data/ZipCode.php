<?php

use Phalcon\Mvc\Model\Query;

class ZipCode {
    public static function GetList($app, $inputJson) {
        $returnedValue = new stdClass;
        $returnedValue->error = "";
        $returnedValue->data = "";
        
        try {
            $requestData = json_decode($inputJson, true);

            if (empty($requestData) || empty($requestData['zip_code'])) {
                // empty value, get list
                $sqlStatement = "CALL get_zip_codes_list();";

                $result = $app->db->fetchAll(
                    $sqlStatement,
                    Phalcon\Db::FETCH_ASSOC,
                    []
                );

                // Get the results
                if (!empty($result)) {
                    $returnedValue->error = "";
                    $returnedValue->data = $result;
                }
            } else {
                // zip code value, get single data
                $sqlStatement = "CALL get_zip_code(:zipcode);";

                $result = $app->db->fetchAll(
                    $sqlStatement,
                    Phalcon\Db::FETCH_ASSOC,
                    ['zipcode' => (int)$requestData['zip_code']]
                );

                // Get the results
                if (!empty($result)) {
                    $returnedValue->error = "";
                    $returnedValue->data = $result;
                }
            }
        } catch(Exception $exception) {
            $returnedValue->error = $myException->getMessage();
        }

        return (array($returnedValue));
    }
}
