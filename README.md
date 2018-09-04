Laravel + Geotab
======================
Provides a PHP client that can easily make API requests to a MyGeotab server. 
Forked from:   [Geotab](https://github.com/Geotab)/**[mygeotab-php](https://github.com/Geotab/mygeotab-php)**

How to install
------------
Just execute in console:

`composer require geotab/mygeotab-php`

Create a geotab class in  `app/Geotab`

`php artisan make:controller GeotabController`

This should have created:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Geotab;
use Carbon\Carbon;

class GeotabController extends Controller
{
    //
}
```

Adding  functions in the controller:

```php
<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Geotab;

class GeotabController extends Controller
{
    //function to get the method GetFeed -  typeName = TRIP
    public function getTrips()
    {

        $api = new Geotab\API("user", "password", "DB", "my.geotab.com");
        $api->authenticate();

        //Doing mehtod API call
        $parameters = [
            "credentials"  => $api->authenticate(),
            "typeName"     => "Trip",
            "resultsLimit" => 2,
            "fromVersion"  => "0000000000000000",
            "search"       => [
                "toDate"   => Carbon::now()->toIso8601ZuluString(),
                "fromDate" => Carbon::now()->subWeek()->toIso8601ZuluString(), //Last week
            ],
        ];
        $api->call("GetFeed", $parameters, function ($trips) {
            //Print the trips as json
            dd(json_encode($trips));

        }, function ($error) {
            var_dump($error);
        });
    }

    //Doing object API get
    public function getDevice()
    {
	    $api = new Geotab\API("user", "password", "DB", "my.geotab.com");
        $api->authenticate();
        
        $parameters = [
            "credentials"  => $api->authenticate(),
            "resultsLimit" => 2,
        ];

        $api->get("Device", $parameters, function ($device) {
            //Print the device data as json
            dd(json_encode($device));
        }, function ($error) {
            var_dump($error);
        });
        //End object API get
    }
}
```
Remember to put your routes on `routes\web.php`:

```php 
Route::get('/data-feeds', "GeotabController@getTrips" )->name("getTrips") ;
Route::get('/get-device', "GeotabController@getDevice" )->name("getDevice") ;
```
## Documentation

Oficial Api reference: 
[https://geotab.github.io/sdk/software/api/reference/](https://geotab.github.io/sdk/software/api/reference/)

