<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 1/24/18
 * Time: 9:41 AM
 */
/** Status Codes
 * -1   No action given
 *  1   Success
 *  2   Age not valid
 */
$testing = true;

$response['status'] = -1;
$response['error'] = "";
$response['result'] = "Null";

$host = getenv("RDS_HOSTNAME");
$user = getenv("RDS_USERNAME");
$pass = getenv("RDS_PASSWORD");
$dbN = "Conserve";

$db = new mysqli($host,$user,$pass,$dbN);

if(isset($_POST['action'])){
    $action = $_POST['action'];

    switch ($action){
        case "verifyAge":
            $age = $_POST['age'];

            if ($age > 18 && $age < 110){
                $response['result'] = "valid";
                $response['status'] = 1;
            } else {
                $response['result'] = "invalid";
                $response['status'] = 2;
                $response['age'] = $age;
            }
            break;

        case "newUser":
            try {
                $random = random_int(0, 3);
            } catch (Exception $e) {
                echo $e;
            }

            $treatment = ['A', 'B', 'C', 'D'];

            $sql = "INSERT INTO ConserveData (ID_number, treatment) VALUES (NULL, '".$treatment[$random]."')";

            if($db -> query($sql) === true) {
                $response['result'] = true;
                $response['status'] = 1;
                $response['id'] = $db->insert_id;
                $response['treatment'] = $treatment[$random];
            } else {
                $response['result'] = false;
                $response['error'] = $db -> error . "\t". $sql;
            }
            break;

        case "saveLocation":
            $location = $_POST['location'];
            $id = $_POST['id'];

            $sql = "UPDATE ConserveData SET location='$location' WHERE ID_number = $id";

            $db->query($sql);

            if ($db->affected_rows === 1 ){
                //for debugging
                $response['result'] = true;
                $response['status'] = 1;
            } else {
                $response['status'] = 2;
                $response['error'] =  $db -> error;
                $response['sql'] = $sql;
            }
            break;

        case "saveAnswers":
            $answers = $_POST['answers'];
            $id = $_POST['id'];

            $sql = "UPDATE ConserveData SET question_1_decision = '$answers[0]', question_2_decision = '$answers[1]', ".
                "question_3_decision = '$answers[2]', question_4_decision = '$answers[3]', ".
                "question_5_decision = '$answers[4]', question_6_decision = '$answers[5]', ".
                "question_7_decision = '$answers[6]', question_8_decision = '$answers[7]', ".
                "question_9_decision = '$answers[8]', question_10_decision = '$answers[9]', ".
                "question_11_decision = '$answers[10]', question_12_decision = '$answers[11]', ".
                "question_13_decision = '$answers[12]', question_14_decision = '$answers[13]', ".
                "question_15_decision = '$answers[14]' WHERE ID_number = $id";

            $db->query($sql);

            if ($db->affected_rows === 1 ){
                //for debugging
                $response['result'] = true;
                $response['status'] = 1;
            } else {
                $response['status'] = 2;
                $response['error'] =  $db -> error;
            }
            break;

        case "saveItems":
            $items = $_POST['items'];
            $id = $_POST['id'];

            $sql = "UPDATE ConserveData SET question_1_item = '$items[0]', question_2_item = '$items[1]', ".
                "question_3_item = '$items[2]', question_4_item = '$items[3]', ".
                "question_5_item = '$items[4]', question_6_item = '$items[5]', ".
                "question_7_item = '$items[6]', question_8_item = '$items[7]', ".
                "question_9_item = '$items[8]', question_10_item = '$items[9]', ".
                "question_11_item = '$items[10]', question_12_item = '$items[11]', ".
                "question_13_item = '$items[12]', question_14_item = '$items[13]', ".
                "question_15_item = '$items[14]' WHERE ID_number = $id";

            $db->query($sql);

            if ($db->affected_rows === 1 ){
                //for debugging
                $response['result'] = true;
                $response['status'] = 1;
            } else {
                $response['status'] = 2;
                $response['error'] =  $db -> error;
            }
            break;

        case "savePrices":
            $itemPrices = $_POST['prices'];
            $id = $_POST['id'];

            $sql = "UPDATE ConserveData SET question_1_price = '$itemPrices[0]', question_2_price = '$itemPrices[1]', ".
                "question_3_price = '$itemPrices[2]', question_4_price = '$itemPrices[3]', ".
                "question_5_price = '$itemPrices[4]', question_6_price = '$itemPrices[5]', ".
                "question_7_price = '$itemPrices[6]', question_8_price = '$itemPrices[7]', ".
                "question_9_price = '$itemPrices[8]', question_10_price = '$itemPrices[9]', ".
                "question_11_price = '$itemPrices[10]', question_12_price = '$itemPrices[11]', ".
                "question_13_price = '$itemPrices[12]', question_14_price = '$itemPrices[13]', ".
                "question_15_price = '$itemPrices[14]' WHERE ID_number = $id";

            $db->query($sql);

            if ($db->affected_rows === 1 ){
                //for debugging
                $response['result'] = true;
                $response['status'] = 1;
            } else {
                $response['status'] = 2;
                $response['error'] =  $db -> error;
            }
            break;
    }
}


//echo response data

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $testing){
    echo json_encode($response);
}