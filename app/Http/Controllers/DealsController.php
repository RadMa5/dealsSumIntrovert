<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Pest\Mutate\Event\Events\Test\Outcome\Timeout;


const apiKey = "23bc075b710da43f0ffb50ff9e889aed";
const dateBefore = "2025-01-01";
const dateAfter = "2019-01-01";

function getClients() {
    return [
        [
            "id" => 1,
            "name" =>"intrdev",
            "api" => apiKey,
        ],
        [
            "id" => 2,
            "name" => "artedegrass0",
            "api" => "bad_key",
        ],
    ];
}


class DealsController extends Controller
{
    public function index() {
        $clients = getClients();
        $guzzClient = new Client([
            'base_uri' => 'https://api.s1.yadrocrm.ru/tmp/crm/',
            'timeout'  => 120.0,
        ]);
        $resultArr = [];
        foreach ($clients as $client){
            $pages = 0;
            $status = "Success";
            $pagesAvailable = true;
            $sum = 0;
            while ($pages < 50) {
                try {
                    $request = $guzzClient->request('GET', 'lead/list?status[]=142&count=50&offset=' . $pages . '&key=' . $client["api"] );
                    
                    
                } catch (Exception $e) {
                    $status = "Error";
                    break;
                }
                $pages += 50;
                $decodedRequest = json_decode($request->getBody(), true);
                $result = $decodedRequest["result"];

                if ($result) {
                    foreach ($result as $lead) {
                        $dateClose = date("Y-m-d", $lead["date_close"]);
                        if ($dateClose < dateBefore && $dateClose > dateAfter) {
                            $strPrice = $lead["price"];
                            
                            $numPrice = (int)$strPrice;
                    
                            $sum += $numPrice;
                        }
                    }
                    usleep(500000);
                } else {
                    $pagesAvailable = false;
                    $status = "Error";
                }  
            }
            array_push($resultArr, ["name" => $client["name"], "sum" => $sum, "id" => $client["id"], "status" => $status]);
        }
        return view('welcome', ['deals' => $resultArr]);
    }
}
