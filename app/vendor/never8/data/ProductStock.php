<?php

use Phalcon\Mvc\Model\Query;

class ProductStock
{

    public static function UpdateFromExternalSource($app, $inputJson)
    {
        $returnedValue = null;
        if(!is_object($returnedValue))
        {
            $returnedValue = new stdClass;
        }

        $returnedValue->error = "";
        $returnedValue->data = "";

        try {

            $isJason = json_decode($inputJson);

            // If the JSON is invalid
            if ($isJason === null) {

                $returnedValue->error = "Invalid format";

            } else {

                // Update the stock
                $sqlStatement = "CALL UpdateProductStockFromExternalSource(:inputJson);";

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

    // Read the stock of a product
    public static function GetProductStock($app, $inputJson): array
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

                // Create the SQL statement to be executed in the database
                $sqlStatement = "CALL GetProductStock(:inputJson);";

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

}
