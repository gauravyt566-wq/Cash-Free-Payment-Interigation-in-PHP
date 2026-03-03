<?php

/*
DOCS : https://docs.cashfree.com/reference/orderpay
API VERSION  : - 
 2022-09-01 : get the payment_session id for create your own custom checkout page
 2021-05-21 or 2022-01-01 : get the payment link for cashfree checkout system

 DIFFERENT date has different of way of pay 2021-05-21 or 2022-01-01 or 2022-09-01
*/

/*
$postData =  json_encode([
    'order_id' => 'order_id_'.$_GET['order_id'],
    'order_amount' => 200,
    'order_currency' => 'INR',
    'customer_details' => [
        'customer_id' => '7112AAA812234',
        'customer_name' => 'SAJID ALI',
        'customer_email' => 'john@cashfree.com',
        'customer_phone' => '9908734801'
    ],
    'order_meta' => [
        'return_url' => 'https://www.shipmiles.com/test/response.php?order_id={order_id}'
    ],
    'order_note' => 'Test order'
  ]);*/
  
if($_SERVER['REQUEST_METHOD']=='POST'){ 
    
    $postData = json_encode($_POST);
    $curl = curl_init();
    
    curl_setopt_array($curl, [
      CURLOPT_URL => "https://sandbox.cashfree.com/pg/orders",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $postData,
      CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "content-type: application/json",
        "x-api-version: 2022-01-01",
        "x-client-id: 1170052b61c54908e97f92f79352500711",
        "x-client-secret: cfsk_ma_prod_cb02f3c3912ac1ed672692ff54748862_ae628e1e"
      ],
    ]);
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
        $payment_link = json_decode($response, true);
        if(isset($payment_link['payment_link'])){
            echo "<script>location.href='".$payment_link['payment_link']."';</script>";
            exit;   
        }else {
            echo "Error : Payment Link Not Found";
            echo "<pre>";
            print_r(json_decode($response, true));
            echo "</pre>";
            exit;
        }
    }
}else {
    echo "<script>location.href='start.php';</script>";
}

?>
