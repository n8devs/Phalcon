<?php

/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 *
 *  HTTP method:
 *
 *      GET to retrieve and search data
 *      POST to add data
 *      PUT to update data
 *      DELETE to delete data
 *
 */

use Phalcon\Mvc\Model\Query;
use Phalcon\Events\Manager;
use Phalcon\Http\Client\Request;

$eventsManager = new Manager();
$eventsManager->attach('micro', new AuthMiddleware());
$app->before(new AuthMiddleware());
$app->after(new AuthMiddleware());
$app->setEventsManager($eventsManager);

////////////////////////
//
// MAIN
// 
////////////////////////

/**
 * Add your routes here
 */
$app->get('/', function () {
    echo $this['view']->render('index');
});

// Validates if the Zip code is in the coverage area
$app->get(
    '/api/coverage/{zipCode:[0-9]{5}}',
    function ($zipCode) use ($app) {

        // Validate the zip code
        echo json_encode(Coverage::Validate($app, $zipCode));
    }
);

////////////////////////
//
// ZIP CODE
//
////////////////////////

// Get the allowed Zip Codes
$app->get(
    '/api/zipCode/allowed/{inputJson}',
    function ($inputJson) use ($app) {

        // Returns the nearest stores to a zip code with products and its stocks
        echo json_encode(ZipCode::GetAllowed($app, $inputJson));
    }
);

// Get list of all Zip Codes allowed
$app->get(
    '/api/zipCode/list/{inputJson}',
    function ($inputJson) use ($app) {

        // Returns a list of zip codes
        echo json_encode(ZipCode::GetList($app, $inputJson));
    }
);

////////////////////////
//
// STORE
// 
////////////////////////

// Returns the seller stores for a product list
$app->get(
    '/api/store/seller/{inputJson}',
    function ($inputJson) use ($app) {

        // Returns the nearest stores to a zip code with products and its stocks
        echo json_encode(Store::GetSellers($app, $inputJson));
    }
);

// Returns the seller stores for a product list
$app->get(
    '/api/store/seller/listOnly/{inputJson}',
    function ($inputJson) use ($app) {

        // Returns the nearest stores to a zip code
        echo json_encode(Store::GetSellersListOnly($app, $inputJson));
    }
);

// Returns the seller stores for a product list
$app->get(
    '/api/store/seller/listOnlyInDeliveryZone/{inputJson}',
    function ($inputJson) use ($app) {

        // Returns the nearest stores to a zip code
        echo json_encode(Store::GetSellersListOnlyInDeliveryZone($app, $inputJson));
    }
);

// Returns the seller stores WITH ROUTING
$app->get(
    '/api/store/seller/routing/{inputJson}',
    function ($inputJson) use ($app) {

        // Returns the nearest stores to a zip code with products and its stocks
        echo json_encode(Store::GetSellersRouting($app, $inputJson));
    }
);

// Returns the stores from a Call Center
$app->get(
    '/api/callCenter/stores/{inputJson}',
    function ($inputJson) use ($app) {

        // Returns the nearest stores to a zip code with products and its stocks
        echo json_encode(Store::GetCallCenterStores($app, $inputJson));
    }
);

// Returns the stores from a Call Center sad or not sad
$app->get(
    '/api/callCenter/stores/sad/{inputJson}',
    function ($inputJson) use ($app) {

        // Returns the nearest stores to a zip code with products and its stocks
        echo json_encode(Store::GetCallCenterStoresSad($app, $inputJson));
    }
);

// Returns the seller stores WITH ROUTING
$app->get(
    '/api/store/sad/{inputJson}',
    function ($inputJson) use ($app) {

        // Returns the nearest stores to a zip code with products and its stocks
        echo json_encode(Store::GetStoreSad($app, $inputJson));
    }
);

// Returns the data of a store
$app->get(
    '/api/store/get/{inputJson}',
    function ($inputJson) use ($app){
        // returns the data of a store
        echo json_encode(Store::GetStoreId($app, $inputJson));
    }
);

////////////////////////
//
// DOCTOR
// 
////////////////////////

// Returns the doctors searched
$app->get(
    '/api/doctor/{inputJson}',
    function ($inputJson) use ($app) {

        // Returns the doctors
        echo json_encode(Doctor::Get($app, $inputJson));
    }
);

$app->get(
    '/api/doctor/catalog/{inputJson}',
    function ($inputJson) use ($app) {

        // Returns the doctors
        echo json_encode(Doctor::GetCatalog($app, $inputJson));
    }
);

////////////////////////
//
// PRODUCT STOCK
// 
////////////////////////

// Updates the product stock based on the JSON provided by FdA WS
$app->get(
    '/api/product/stock/import/{inputJson}',
    function ($inputJson) use ($app) {

        // Updates the stocks
        echo json_encode(ProductStock::UpdateFromExternalSource($app, $inputJson));
    }
);

// Read the stock of a product
$app->get(
    '/api/product/stock/{inputJson}',
    function ($inputJson) use ($app) {

        // Updates the stocks
        echo json_encode(ProductStock::GetProductStock($app, $inputJson));
    }
);

////////////////////////
//
// STORE INTEGRATION (APP)
//
////////////////////////

$app->get(
    '/api/customer/search/{inputJson}',
    function ($inputJson) use ($app) {
        echo json_encode(MageCustomer::getCustomerList($app, $inputJson));
    }
);

$app->put(
    '/api/customer/create',
    function () use ($app) {
        echo json_encode(MageCustomer::putCustomer($app));
    }
);

$app->get(
    '/api/address/search/{inputJson}',
    function ($inputJson) use ($app) {
        echo json_encode(MageCustomer::getAddressList($app, $inputJson));
    }
);

$app->put(
    '/api/address/create',
    function () use ($app) {
        echo json_encode(MageCustomer::putAddress($app));
    }
);

$app->get(
    '/api/order/search/{inputJson}',
    function ($inputJson) use ($app) {
        echo json_encode(MageOrder::getOrderList($app, $inputJson));
    }
);

$app->put(
    '/api/order/create',
    function () use ($app) {
        echo json_encode(MageOrder::putOrder($app));
    }
);

$app->get(
    '/api/product/search/{inputJson}',
    function ($inputJson) use ($app) {
        echo json_encode(MageProduct::getProductList($app, $inputJson));
    }
);

$app->get(
    '/api/price/list/{inputJson}',
    function ($inputJson) use ($app) {
        echo json_encode(MageProduct::getPriceList($app, $inputJson));
    }
);

$app->get(
    '/api/category/tree/{inputJson}',
    function ($inputJson) use ($app) {
        echo json_encode(MageCategory::getCategoryTree($app, $inputJson));
    }
);

////////////////////////
//
// OTHERS
// 
////////////////////////

/**
 * Not found handler
 */
$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});
