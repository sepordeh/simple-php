<?php

$your_merchant = "XXXXXXXXXX:XXXXXXXXXXX";

function verify($merchant,$successful_function){
    $orderId = $_GET["orderId"];
    if(isset($_GET["authority"])){
        $parameters = array(
            "merchant"=>$merchant,
            "authority"=>$_GET["authority"],
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://sepordeh.com/merchant/invoices/verify");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if(!!curl_errno($ch)){
            die("CURL ERROR:".curl_error($ch));
        }else{
            $result = json_decode($result);
            if($result->status==200){
                $successful_function($result);
            }else{
                die("WEBSERVICE ERROR:".$result->message);
            }
        }
        curl_close($ch);
    }else{
        die("ERROR:invalid request");
    }
}

verify($your_merchant,function($response){ 
 echo "paid";
});
