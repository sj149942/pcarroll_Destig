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
                $random = random_int(0, 2);
            } catch (Exception $e) {
                echo $e;
            }
            /**
             * Treatments:
             * A:   No information given
             * B:   watch celebrity videos
             * C:   Get info
             */

            $treatment = ['A', 'B', 'C'];

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
            $db->close();
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
            $db->close();
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
            $db->close();
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
            $db->close();
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
            $db->close();
            break;

        case "saveSurvey":
            $answers = $_POST['answers'];
            $id = $_POST['id'];

            $sql = "";

            $db->query($sql);
            if ($db->affected_rows === 1 ){
                //for debugging
                $response['result'] = true;
                $response['status'] = 1;
            } else {
                $response['status'] = 2;
                $response['error'] =  $db -> error;
            }
            $db->close();
            break;

        case "retrieveTreatmentInfo":
            $treatment = $_POST['treatment'];

            switch ($treatment){
                case "A":
                    break;
                case "B":
                    $response['result'] = true;
                    $response['html'] = "<div style=\"text-align: center;\"><video><source src='../video/crazykitty_512kb.mp4'></video></div>";
                    break;
                case "C":
                    $response['result'] = true;
                    $response['html'] = "<p><em>In previous studies, 95% of participants were willing to pay for food 
                        produced with recycled irrigation water. </em></p>";
            }
            break;

        case "retrieveQuestions":
            $question = [
                "<img src='../images/'><p>Do you want to purchase bottled water</p>",
                "<p>Do you want to purchase spinach irrigated with </p>",
                "<p>Do you want to purchase lamb that ate feed irrigated with </p>",
                "<p>Do you want to purchase milk from a cow that ate feed irrigated with </p>",
                "<p>Do you want to purchase cheese made with milk from a cow that ate feed irrigated with </p>"
            ];

            $waterTypes = [
                "<p><b>groundwater</b></p>",
                "<p><b>recycled water</b></p>",
                "<p><b>groundwater from an aquifer recharged with recycled water</b></p>",
            ];

            shuffle($question);
            shuffle($waterTypes);

            for ($i = 0; $i < count($question); $i++){
                for ($j = 0; $j < count($waterTypes); $j++){
                    echo "hi";
                }
            }
    }
}


//echo response data

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $testing){
    echo json_encode($response);
}