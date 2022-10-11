/**************************************************************************************************
 * Name          : GetStoresSADType
 * Project       : Farmacias del Ahorro - Call Center POS
 * Description   : Returns the sellers stores (without the stores data) based on quadrants
 * Copyright     : Never8 2021-2024. All rights reserved.
 * Company       : Never8 (http://www.never8.com/)
 * Author        : Never8 (info@never8.com)
 **************************************************************************************************/

DROP PROCEDURE IF EXISTS GetStoresSADType;

DELIMITER //

CREATE PROCEDURE GetStoresSADType (IN _jsonInput json)
BEGIN

    /*
    -- SET @inputJson = '{
    --  "zipCode": 6400,
    --  "latitude": 25.566574,
    --  "longitude": -100.240606,
    --  "maxDistanceInKm": 25,
    --  "maxStores": 10
    -- }';
    */

    DECLARE _jsonLenght int;
    DECLARE _zipCode int;
    DECLARE _latitude float;
    DECLARE _longitude float;
    DECLARE _maxDistanceInKm float;
    DECLARE _maxStores int;
    DECLARE _rowCounter int;

    -- Get the JSON lenght
    SET _jsonLenght = JSON_LENGTH(_jsonInput);

    -- Variables initialization
    SET _zipCode = 0;
    SET _maxDistanceInKm = 0;
    SET _maxStores = 0;
    SET _rowCounter = 0;

    -- If the lenght is valid
    IF _jsonLenght = 5 THEN

        -- Get the zip code
        SET _zipCode = JSON_EXTRACT(_jsonInput, '$.zipCode');
        SET _latitude = JSON_EXTRACT(_jsonInput, '$.latitude');
        SET _longitude = JSON_EXTRACT(_jsonInput, '$.longitude');
        SET _maxDistanceInKm = CONVERT(JSON_EXTRACT(_jsonInput, '$.maxDistanceInKm'), SIGNED int);
        SET _maxStores = CONVERT(JSON_EXTRACT(_jsonInput, '$.maxStores'), SIGNED int);

        -- If the zip is valid
        IF _zipCode > 0 THEN

            -- If the latitude contains a value
            IF _latitude != 0 THEN

                -- If the longitude contains a value
                IF _longitude != 0 THEN

                    /**************************************
                        Get the nearest stores with stock
                    ***************************************/

                    SELECT
                        __locationGroupId,
                        __storeId,
                        __storeZipCode,
                        __storeLatitude,
                        __storeLongitude,
                        __sad,
                        __statusFlags,
                        __storeDistanceToTarget,
                        __sortOrder,
                        __storeName
                    FROM (
                    SELECT
                        locationGroupId AS __locationGroupId,
                        nameId AS __storeId,
                        zipCode AS __storeZipCode,
                        latitude AS __storeLatitude,
                        longitude AS __storeLongitude,
                        sad AS __sad,
                        statusFlags AS __statusFlags,
                        distanceInKm AS __storeDistanceToTarget,
                        sortOrder AS __sortOrder,
                        name AS __storeName
                    FROM (
                    SELECT
                    LocationGroup.locationGroupId,
                    Store.nameId,
                    Store.zipCode,
                    Store.latitude,
                    Store.longitude,
                    Store.sad,
                    Store.statusFlags,
                    GetDistanceInKm1(Store.latitude, Store.longitude, _latitude, _longitude) AS distanceInKm,
                    LocationGroupStore.sortOrder,
                    Store.name
                    FROM Store,
                    LocationGroupStore,
                    LocationGroup,
                    LocationGroupZipCode,
                    ZipCode
                    WHERE Store.statusFlags IN (0,1)
                    AND NOT Store.longitude IS NULL
                    AND NOT Store.latitude IS NULL
                    AND LocationGroupStore.storeId = Store.storeId
                    AND LocationGroupStore.locationGroupId = LocationGroup.locationGroupId
                    AND LocationGroupZipCode.locationGroupId = LocationGroup.locationGroupId
                    AND LocationGroupZipCode.zipCodeId = ZipCode.zipCodeId
                    AND NOT LocationGroupZipCode.statusFlags = 16
                    AND NOT LocationGroupStore.statusFlags = 16
                    AND ZipCode.zipCode = _zipCode
                    HAVING distanceInKm <= _maxDistanceInKm
                    ORDER BY sortOrder, distanceInKm
                    LIMIT _maxStores) AS InnerOne) AS _NearestStoresTemporaryDeliveryZone2
                    ORDER BY __sortOrder, __storeDistanceToTarget ASC;
                END IF;
            END IF;
        END IF;
    END IF;
END//

DELIMITER ;