<?php

use Phalcon\Mvc\Model\Query;

class Coverage {

    public static function Validate($app, $zipCode) {

        // Default returned response
        //commit test
        $data[0] = [
            'inCoverage' => 'false'
        ];

        try {

            // Convert to integer the zip code
            $zipCode = (int) $zipCode;

            // If the zip code is valid
            if ($zipCode > 0) {

                // Check if the zip code is in the coverage area
                $sqlStatement = "CALL ValidateCoverage(:zipCode);";

                $result = $app->db->fetchAll(
                        $sqlStatement,
                        Phalcon\Db::FETCH_ASSOC,
                        [
                            'zipCode' => $zipCode,
                        ]
                );

                // Get the results
                if (!empty($result)) {
                    $data[0] = [
                        'inCoverage' => $result[0]['inCoverage']
                    ];
                }
            }
        } catch (Exception $myException) {

            error_log($myException->getMessage());
        }

        // Returned value
        return($data);
    }

}
