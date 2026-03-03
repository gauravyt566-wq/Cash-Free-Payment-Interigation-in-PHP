<?php

/*
API VERSION  : - 
 2022-09-01 : get the payment_session id for create your own custom checkout page
 2021-05-21 or 2022-01-01 : get the payment link for cashfree checkout system

 DIFFERENT date has different of way of pay 2021-05-21 or 2022-01-01 or 2022-09-01
*/
$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://sandbox.cashfree.com/pg/orders/".$_GET['order_id'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "x-api-version: 2021-05-21",
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
    $response = json_decode($response, true);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Free Payment Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
</head>
<style>
body {
    background-color:black;
}
</style>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class='col-12 my-2 d-flex justify-content-center mb-4'>
                <div class="spinner-border text-primary mx-2" role="status" style="width:1.8rem;height:1.8rem">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <h4 class='text-center text-primary'> Cash Free Payment Process Completed </h4>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4 text-success"><u>Order Payment Details</u></h3>
                        <?php if($response['order_status']!=='PAID'): ?>
                            <span class='my-2 text-light bg-danger d-flex justify-content-center'> Payment Incomplete, <a href="<?=$response['payment_link']?>" class='text-warning fw-bold mx-2'> click here </a>  to the proceed payment.. </span>
                        <?php endif; ?>
                        <div class='row'>
                            <div class="mb-3 col-md-6">
                                <label for="order_id" class="form-label">Order Status <span class='text-danger'>*</span></label>
                                <input type="text" class="form-control" value="<?= $response['order_status'] ?>" readonly>
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="order_id" class="form-label">Order Date <span class='text-danger'>*</span></label>
                                <input type="text" class="form-control" value="<?= date('l d-M-Y', strtotime($response['created_at'])) ?>" readonly>
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="order_id" class="form-label">Order ID <span class='text-danger'>*</span></label>
                                <input type="text" class="form-control" value="<?= $response['order_id'] ?>" readonly>
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="order_id" class="form-label">Order_CF Id <span class='text-danger'>*</span></label>
                                <input type="text" class="form-control" value="<?= $response['cf_order_id'] ?>" readonly>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="order_amount" class="form-label">Order Amount <span class='text-danger'>*</span></label>
                                <input type="text" class="form-control" value="<?= $response['order_amount'].' '.$response['order_currency']?>" readonly>
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="customer_name" class="form-label">Customer ID <span class='text-danger'>*</span></label>
                                <input type="text" class="form-control"  value="<?= $response['customer_details']['customer_id'] ?>" readonly >
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="customer_name" class="form-label">Customer Name <span class='text-danger'>*</span></label>
                                <input type="text" class="form-control"  value="<?= $response['customer_details']['customer_name'] ?>" readonly>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="customer_email" class="form-label">Customer Email <span class='text-danger'>*</span></label>
                                <input type="email" class="form-control" value="<?= $response['customer_details']['customer_email'] ?>" readonly>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="customer_phone" class="form-label">Customer Phone <span class='text-danger'>*</span></label>
                                <input type="tel" class="form-control"  value="<?= $response['customer_details']['customer_phone'] ?>" readonly>
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="customer_phone" class="form-label">Order Note <span class='text-danger'>*</span></label>
                                <input type="text" class="form-control" name="order_note" value="<?= $response['order_note'] ?>" readonly>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
