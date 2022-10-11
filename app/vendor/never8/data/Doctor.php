<?php

use Phalcon\Mvc\Model\Query;

/**
 * Class Doctor
 */
class Doctor
{

    /**
     * @param $app
     * @param JsonSerializable $inputJson Input parameters
     * @return array Records found
     */
    public static function Get($app, $inputJson)
    {

        //  { 
        //      "id":"0",
        //      "name":""
        //  }

        $returnedValue = [
            'error' => "Invalid input",
            'data' => ""
        ];

        try {

            $inputJsonArray = json_decode($inputJson);

            // If the input is valid
            if (!($inputJsonArray === null)) {

                if (version_compare(phpversion(), '7.3', '<')) {
                    $elementCount = count((is_countable($inputJsonArray) ? $inputJsonArray : []));
                } else {
                    $elementCount = count($inputJsonArray);
                }

                // Validate the right number of arguments
                if ($elementCount = 2) {

                    // Validate the input
                    $id = (int)$inputJsonArray->id;
                    $name = trim($inputJsonArray->name);

                    $inputIsValid = false;

                    if ($id > 0) {

                        $inputIsValid = true;
                    } else {

                        $id = 0;
                        $inputJsonArray->id = $id;
                    }

                    if (strlen($name) > 0) {

                        $inputIsValid = true;
                        $name = html_entity_decode($name);
                        $inputJsonArray->name = $name;
                    }

                    if ($inputIsValid = true) {

                        // Check if the zip code is in the coverage area
                        $sqlStatement = "CALL GetDoctor(:inputJson);";

                        $result = $app->db->fetchAll(
                            $sqlStatement,
                            Phalcon\Db::FETCH_ASSOC,
                            [
                                'inputJson' => json_encode($inputJsonArray),
                            ]
                        );

                        // Get the results
                        if (!empty($result)) {
                            $returnedValue["error"] = "";
                            $returnedValue["data"] = $result;
                        }
                    }
                }
            }
        } catch (Exception $myException) {

            // TODO: Log the error
            $returnedValue->error = $myException->getMessage();

            error_log($returnedValue->error);
        }

        return (array($returnedValue));
    }

    /**
     * Searches and returns data about existing Doctors.
     * All parameters must be specified.
     * Any date parameter must be set in ISO format: yyyy-MM-dd
     * The default value for dates is: 2000-01-01
     * For integer parameters the default value is zero.
     * For string parameters an empty string is accepted.
     *
     * Input Json:
     *   {
     *      "doctorId": 0,
     *      "nameId": "0",
     *      "fullName": "Name of the doctor - empty to return all",
     *      "lastModificationStart": "2000-01-01",
     *      "lastModificationEnd": "2000-01-01",
     *      "initialPosition": 0,
     *      "elementsToRetrieve": 0
     *   }
     *
     * Examples:
     *   http://localhost/api/doctor/catalog/{"doctorId": 0, "nameId": "", "fullName": "", "lastModificationStart": "2000-01-01", "lastModificationEnd": "2000-01-01", "initialPosition": 0, "elementsToRetrieve": 0}
     *   http://localhost/api/doctor/catalog/{"doctorId": 26214, "nameId": "", "fullName": "", "lastModificationStart": "2000-01-01", "lastModificationEnd": "2000-01-01", "initialPosition": 0, "elementsToRetrieve": 0}
     *   http://localhost/api/doctor/catalog/{"doctorId": 0, "nameId": "08733094", "fullName": "", "lastModificationStart": "2000-01-01", "lastModificationEnd": "2000-01-01", "initialPosition": 0, "elementsToRetrieve": 0}
     *   http://localhost/api/doctor/catalog/{"doctorId": 0, "nameId": "", "fullName": "JUVENTINO", "lastModificationStart": "2000-01-01", "lastModificationEnd": "2000-01-01", "initialPosition": 0, "elementsToRetrieve": 0}
     *   http://localhost/api/doctor/catalog/{"doctorId": 0, "nameId": "", "fullName": "", "lastModificationStart": "2019-11-08", "lastModificationEnd": "2000-01-01", "initialPosition": 0, "elementsToRetrieve": 0}
     *   http://localhost/api/doctor/catalog/{"doctorId": 0, "nameId": "", "fullName": "", "lastModificationStart": "2019-11-08", "lastModificationEnd": "2019-11-08 12:00:00", "initialPosition": 0, "elementsToRetrieve": 0}
     *   http://localhost/api/doctor/catalog/{"doctorId": 0, "nameId": "", "fullName": "", "lastModificationStart": "2000-01-01", "lastModificationEnd": "2000-01-01", "initialPosition": 0, "elementsToRetrieve": 10}
     *   http://localhost/api/doctor/catalog/{"doctorId": 0, "nameId": "", "fullName": "", "lastModificationStart": "2000-01-01", "lastModificationEnd": "2000-01-01", "initialPosition": 5, "elementsToRetrieve": 10}
     *
     * @param $app Global Phalcon Mvc\Micro\Application
     * @param JsonSerializable $inputJson Input parameters used to filter the results
     * @return array Records found
     */
    public static function GetCatalog($app, $inputJson)
    {

        //
        // EXAMPLE:
        //
        //

        $returnedValue = [
            'error' => "Invalid input",
            'data' => ""
        ];

        try {

            $inputJsonArray = json_decode($inputJson);

            // If the input is valid
            if (!($inputJsonArray === null)) {

                $elementCount = 0;

                if (version_compare(phpversion(), '7.3', '<')) {
                    $elementCount = count((is_countable($inputJsonArray) ? $inputJsonArray : []));
                } else {
                    $elementCount = count($inputJsonArray);
                }

                // Validate the right number of arguments
                if ($elementCount = 7) {

                    // Validate the input
                    $doctorId = (int)$inputJsonArray->doctorId;
                    $nameId = trim($inputJsonArray->nameId);
                    $fullName = trim($inputJsonArray->fullName);
                    $lastModificationStart = date_format(new DateTime($inputJsonArray->lastModificationStart), 'Y-m-d');
                    $lastModificationEnd = date_format(new DateTime($inputJsonArray->lastModificationEnd), 'Y-m-d');
                    $initialPosition = (int)$inputJsonArray->initialPosition;
                    $elementsToRetrieve = (int)$inputJsonArray->elementsToRetrieve;

                    error_log(sprintf("%s , %s, %s , %s, %s, %s , %s", $doctorId, $nameId, $fullName, $lastModificationStart, $lastModificationEnd, $initialPosition, $elementsToRetrieve));

                    if ($doctorId >= 0) {

                        if ($initialPosition >= 0) {

                            if ($elementsToRetrieve >= 0) {

                                // Check if the zip code is in the coverage area
                                $sqlStatement = "CALL GetDoctors(:doctorId, :nameId, :fullName, :lastModificationStart, :lastModificationEnd, :initialPosition, :elementsToRetrieve);";

                                $result = $app->db->fetchAll(
                                    $sqlStatement,
                                    Phalcon\Db::FETCH_ASSOC,
                                    [
                                        'doctorId' => $doctorId,
                                        'nameId' => $nameId,
                                        'fullName' => $fullName,
                                        'lastModificationStart' => $lastModificationStart,
                                        'lastModificationEnd' => $lastModificationEnd,
                                        'initialPosition' => $initialPosition,
                                        'elementsToRetrieve' => $elementsToRetrieve,
                                    ]
                                );

                                // Get the results
                                $returnedValue["error"] = "";
                                $returnedValue["data"] = $result;

                            }

                        }

                    }

                }

            }

        } catch (Exception $myException) {

            // TODO: Log the error
            $returnedValue->error = $myException->getMessage();

            error_log($returnedValue->error);
        }

        return (array($returnedValue));
    }

}
