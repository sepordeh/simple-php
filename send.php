<?php

$your_merchant = "XXXXXXXXXX:XXXXXXXXXXX";
$your_amount = 5000;//toman
$your_callback = "http://localhost/verify.php";

function send($merchant,$amount,$callback,$description=null,$orderId=null){
    $parameters = array(
        "merchant"=>$merchant,
        "amount"=>$amount,
        "callback"=>$callback,
        "description"=>$description,
        "orderId"=>$orderId
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://sepordeh.com/merchant/invoices/add");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    if(!!curl_errno($ch)){
        die("CURL ERROR:".curl_error($ch));
    }else{
        $result = json_decode($result);
        if($result->status==200)
            header('Location: https://sepordeh.com/merchant/invoices/pay:'.$result->information->invoice_id, true, 301);
        else
            die("WEBSERVICE ERROR:".$result->message);
    }
    curl_close($ch);
}


send($your_merchant,$your_amount,$your_callback);
