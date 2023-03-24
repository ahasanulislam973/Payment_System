<?php
session_start();
$id = $_SESSION['userid'];
//session_destroy();
if (isset($_POST['mobile_number']) && isset($_POST['amount']) && isset($_POST['payment_code'])) {

    $mobile_number = $_POST['mobile_number'];
    $amount = $_POST['amount'];
    $payment_code = $_POST['payment_code'];
    $transaction_id = rand(1111, 9999);


    if (!empty($mobile_number) && !empty($amount) && !empty($payment_code)) {

        $url = "http://localhost/login/validation.php?payment_code=$payment_code";
        $response = file_get_contents($url);
        $decoded = json_decode($response);
        $code = $decoded->code;
        if ($code == 20) {

            $url = "http://localhost/login/callback.php?mobile_number=$mobile_number&amount=$amount&payment_code=$payment_code&transaction_id=$transaction_id";
            $response = file_get_contents($url);
            $decoded = json_decode($response);
            $code = $decoded->code;

            if ($code == 1) {
                $message = $decoded->message;
                echo $message . "<br>";
            } else {
                $message = $decoded->message;
                echo $message . "<br>";
            }

            $url1 = "http://localhost/login/balance_validation.php?id=$id&amount=$amount";
            $response1 = file_get_contents($url1);
            $decoded1 = json_decode($response1);

            $code5 = $decoded1->code;

            if ($code5 == 52) {
                $data = array(
                    "toStatus" => "Active",
                    "userInfo" => array(
                        "msisdn" => $mobile_number,
                        "operator" => "gp"
                    )

                );
                $post_Data = json_encode($data);
                $ch = curl_init();
                $options = array(
                    CURLOPT_URL => "http://localhost/login/subscription.php",
                    CURLOPT_POST => 1,
                    CURLOPT_POSTFIELDS => $post_Data,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_HTTPHEADER => array('Content-Type:application/json')
                );

                curl_setopt_array($ch, $options);
                $result = curl_exec($ch);
                curl_close($ch);
                $test = json_decode($result);

                $message = $test->message;
                echo $message . "<br>";

            } else {

                $showMessage = $decoded1->message;
                echo $message . "<br>";

                $data = array(
                    "toStatus" => "Deactive",
                    "userInfo" => array(
                        "msisdn" => $mobile_number,
                        "operator" => "gp"
                    )

                );
                $post_Data = json_encode($data);
                $ch = curl_init();
                $options = array(
                    CURLOPT_URL => "http://localhost/login/subscription.php",
                    CURLOPT_POST => 1,
                    CURLOPT_POSTFIELDS => $post_Data,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_HTTPHEADER => array('Content-Type:application/json')
                );

                curl_setopt_array($ch, $options);
                $result = curl_exec($ch);
                curl_close($ch);

                $test = json_decode($result);
                $message = $test->message;
                echo $message . "<br>";
            }


        } else {

            $message = $decoded->message;
            echo $message . "<br>";
        }
    } else {

        $responseArray['status'] = "Failed";
        $responseArray['code'] = "0";
        $responseArray['message'] = "Fillup all the filed";
        echo json_encode($responseArray);


    }
}


?>