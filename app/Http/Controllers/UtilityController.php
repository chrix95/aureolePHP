<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilityController extends Controller
{
    // get the external books from Ice and Fire
    public function getExternalBooks ($url) {
        $resp = array(
            'status' =>  -1
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $response = curl_exec($ch);
        if(curl_errno($ch)) {
            $resp['message'] = 'Curl request failed'; 
        } else {
            if ($response) {
                $result = json_decode($response, true);
                $data = array();
                foreach ($result as $key => $value) {
                    $item = array(
                        'name'              => $value['name'],
                        'isbn'              => $value['isbn'],
                        'authors'           => $value['authors'],
                        'number_of_pages'   => $value['numberOfPages'],
                        'publisher'         => $value['publisher'],
                        'country'           => $value['country'],
                        'release_date'      => substr($value['released'], 0, 10)
                    );
                    array_push($data, $item);
                }
                $resp['status'] = '0';
                $resp['data'] = $data;
            } else {
                $resp['message'] = 'Curl request failed'; 
            }
        }
        curl_close($ch);
        return $resp;
    }
}
