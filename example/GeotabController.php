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