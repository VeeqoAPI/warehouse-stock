<?php

$api_key = htmlentities($_POST['api-key']);
$warehouse_id = htmlentities($_POST[ 'warehouse_id']);

function prepare_products($response) {
    $products = $response;
    foreach ($products as $index => $product) {
        $products[$index] = array_merge([
            'infoUrl' => '#'
        ], $product);
    }
    return $products;
}


// CURL Request

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.veeqo.com/products?warehouse_id=".$warehouse_id."&page_size=100");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, TRUE);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "x-api-key: $api_key"
));

$response = curl_exec($ch);

$responseSize = curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD);
$time = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
$responseCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($response, 0, $header_size);
$body = substr($response, $header_size);

$err = curl_error($ch);

curl_close($ch);
echo ("\n\nResponse: ".$body);

//$response = json_decode($response, true);
//$headerData = $response[0];

echo ("\n\nBody: ".$body);
echo ("\n\nHeader: ".$headers);
echo ("\n\nResponse[9]: ".$headers[9]);
echo ("\n\nX-Total-Count: ".$headers['X-Total-Count']);

$results = [
    'products' => [],
    'error' => false,
    'time' => $time,
    'responseSize' => $responseSize,
    'responseCode' => $responseCode
];




// Error Handling
// TODO refactor this mess

if ($warehouse_id == null){
    if ($responseCode == '200'){
        $results = [
            'error' => "No Warehouse ID",
            'products' => []
        ];
    } else {
        $results = [
            'error' => "API error: " .$responseCode." ". $body['error_messages'],
            'products' => []
        ];
    }
} elseif ($err) {
    $results['error'] = "cURL Error #:" . $err ;
} elseif(isset($body['error_messages'])) {
    $results['error'] = "API error: " .$responseCode." ". $body['error_messages'];
} elseif($responseCode != '200'){
    $results['error'] = "API error: " .$responseCode." ". $body['error_messages'];
} else {
    $results['products'] = prepare_products($body);

}

return $results;