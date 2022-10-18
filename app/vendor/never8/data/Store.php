<?php

use Phalcon\Mvc\Model\Query;

class Store
{

    //get sellers list
    public static function GetSellers($app, $inputJson)
    {
        $returnedValue = null;
        if (!is_object($returnedValue)) {
            $returnedValue = new stdClass;
        }

        $returnedValue->error = "";
        $returnedValue->data = "";

        try {

            $isJason = json_decode($inputJson);

            // If the zip code is valid
            if ($isJason === null) {

                $returnedValue->error = "Invalid format";

            } else {

                // Check if the zip code is in the coverage area
                $sqlStatement = "CALL GetSellerStores(:inputJson);";

                $result = $app->db->fetchAll(
                    $sqlStatement,
                    Phalcon\Db::FETCH_ASSOC,
                    [
                        'inputJson' => $inputJson,
                    ]
                );

                // Get the results
                if (!empty($result)) {
                    $returnedValue->error = "";
                    $returnedValue->data = $result;
                }
            }
        } catch (Exception $myException) {

            // TODO: Log the error
            $returnedValue->error = $myException->getMessage();
        }

        return (array($returnedValue));
    }

    public static function GetSellersListOnly($app, $inputJson)
    {

        $returnedValue = null;
        if (!is_object($returnedValue)) {
            $returnedValue = new stdClass;
        }

        $returnedValue->error = "";
        $returnedValue->data = "";

        try {

            $isJason = json_decode($inputJson);

            // If the zip code is valid
            if ($isJason === null) {

                $returnedValue->error = "Invalid format";

            } else {

                // Check if the zip code is in the coverage area
                $sqlStatement = "CALL GetSellerStoresListOnly(:inputJson);";

                $result = $app->db->fetchAll(
                    $sqlStatement,
                    Phalcon\Db::FETCH_ASSOC,
                    [
                        'inputJson' => $inputJson,
                    ]
                );

                // Get the results
                if (!empty($result)) {
                    $returnedValue->error = "";
                    $returnedValue->data = $result;
                }
            }
        } catch (Exception $myException) {

            // TODO: Log the error
            $returnedValue->error = $myException->getMessage();
        }

        return (array($returnedValue));
    }

    public static function GetSellersListOnlyInDeliveryZone($app, $inputJson)
    {

        $returnedValue = null;
        if (!is_object($returnedValue)) {
            $returnedValue = new stdClass;
        }

        $returnedValue->error = "";
        $returnedValue->data = "";

        try {

            $isJason = json_decode($inputJson);

            // If the zip code is valid
            if ($isJason === null) {

                $returnedValue->error = "Invalid format";

            } else {

                // Check if the zip code is in the coverage area
                $sqlStatement = "CALL GetSellerStoresListOnlyInDeliveryZone(:inputJson);";

                $result = $app->db->fetchAll(
                    $sqlStatement,
                    Phalcon\Db::FETCH_ASSOC,
                    [
                        'inputJson' => $inputJson,
                    ]
                );

                // Get the results
                if (!empty($result)) {
                    $returnedValue->error = "";
                    $returnedValue->data = $result;
                }
            }
        } catch (Exception $myException) {

            // TODO: Log the error
            $returnedValue->error = $myException->getMessage();
        }

        return (array($returnedValue));
    }

    public static function GetSellersRouting($app, $inputJson)
    {

        $returnedValue = null;
        if (!is_object($returnedValue)) {
            $returnedValue = new stdClass;
        }

        $returnedValue->error = "";
        $returnedValue->data = "";

        try {

            $isJason = json_decode($inputJson);

            // If the zip code is valid
            if ($isJason === null) {

                $returnedValue->error = "Invalid format";

            } else {

                // Check if the zip code is in the coverage area
                $sqlStatement = "CALL GetSellerStoresRouting(:inputJson);";

                $result = $app->db->fetchAll(
                    $sqlStatement,
                    Phalcon\Db::FETCH_ASSOC,
                    [
                        'inputJson' => $inputJson,
                    ]
                );

                // Get the results
                if (!empty($result)) {
                    $returnedValue->error = "";
                    $returnedValue->data = $result;
                }
            }
        } catch (Exception $myException) {

            // TODO: Log the error
            $returnedValue->error = $myException->getMessage();
        }

        return (array($returnedValue));
    }

    public static function GetCallCenterStores($app, $inputJson)
    {

        $returnedValue = null;

        if (!is_object($returnedValue)) {
            $returnedValue = new stdClass;
        }

        $returnedValue->error = "";
        $returnedValue->data = "";

        try {

            $isJason = json_decode($inputJson);

            // If the zip code is valid
            if ($isJason === null) {

                $returnedValue->error = "Invalid format";

            } else {

                // Check if the zip code is in the coverage area
                $sqlStatement = "CALL GetCallCenterStores(:inputJson);";

                $result = $app->db->fetchAll(
                    $sqlStatement,
                    Phalcon\Db::FETCH_ASSOC,
                    [
                        'inputJson' => $inputJson,
                    ]
                );

                // Get the results
                if (!empty($result)) {
                    $returnedValue->error = "";
                    $returnedValue->data = $result;
                }
            }
        } catch (Exception $myException) {

            // TODO: Log the error
            $returnedValue->error = $myException->getMessage();
        }

        return (array($returnedValue));
    }

    public static function GetCallCenterStoresSad($app, $inputJson)
    {

        $returnedValue = null;

        if (!is_object($returnedValue)) {
            $returnedValue = new stdClass;
        }

        $returnedValue->error = "";
        $returnedValue->data = "";

        try {

            $isJason = json_decode($inputJson);

            // If the zip code is valid
            if ($isJason === null) {

                $returnedValue->error = "Invalid format";

            } else {

                // Check if the zip code is in the coverage area
                $sqlStatement = "CALL GetCallCenterStoresSad(:inputJson);";

                $result = $app->db->fetchAll(
                    $sqlStatement,
                    Phalcon\Db::FETCH_ASSOC,
                    [
                        'inputJson' => $inputJson,
                    ]
                );

                // Get the results
                if (!empty($result)) {
                    $returnedValue->error = "";
                    $returnedValue->data = $result;
                }
            }
        } catch (Exception $myException) {

            // TODO: Log the error
            $returnedValue->error = $myException->getMessage();
        }

        return (array($returnedValue));
    }

    public static function GetStoreSad($app, $inputJson)
    {

        $returnedValue = null;
        if (!is_object($returnedValue)) {
            $returnedValue = new stdClass;
        }

        $returnedValue->error = "";
        $returnedValue->data = "";

        try {

            $isJason = json_decode($inputJson);

            // If the zip code is valid
            if ($isJason === null) {

                $returnedValue->error = "Invalid format";

            } else {

                // Check if the zip code is in the coverage area
                $sqlStatement = "CALL GetStoresSADType(:inputJson);";

                $result = $app->db->fetchAll(
                    $sqlStatement,
                    Phalcon\Db::FETCH_ASSOC,
                    [
                        'inputJson' => $inputJson,
                    ]
                );

                // Get the results
                if (!empty($result)) {
                    $returnedValue->error = "";
                    $returnedValue->data = $result;
                }
            }
        } catch (Exception $myException) {

            // TODO: Log the error
            $returnedValue->error = $myException->getMessage();
        }

        return (array($returnedValue));
    }

    public static function GetStore($app, $inputJson)
    {
        $returnedValue = null;

        if( !is_object($returnedValue) ){
            $returnedValue = new stdClass;
        }

        $returnedValue->error = "";
        $returnedValue->data = "";

        try{
            $isJason = json_decode($inputJson);

            if ($isJason === null) {
                $returnedValue->error = "Invalid format";
                return (array($returnedValue));
            }

            $sqlStatement = "CALL GetStore(:inputJson);";
            $result = $app->db->fetchAll(
                $sqlStatement,
                Phalcon\Db::FETCH_ASSOC,
                [
                    'inputJson' => $inputJson,
                ]
            );

            if( empty($result) ){
                $returnedValue->error = "No data";
                return (array($returnedValue));
            }

            $returnedValue->error = "";
            $returnedValue->data = $result;
        }
        catch (Exception $myException) {
            $returnedValue->error = $myException->getMessage();
        }

        return (array($returnedValue));
    }
}