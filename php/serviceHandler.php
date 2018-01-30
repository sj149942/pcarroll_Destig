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

use gburtini\Distributions\Normal;

include 'gburtini/Distributions/Normal.php';

$testing = true;

$response['status'] = -1;
$response['error'] = "";
$response['result'] = "Null";

$host = getenv("RDS_HOSTNAME");
$user = getenv("RDS_USERNAME");
$pass = getenv("RDS_PASSWORD");
$dbN = "Conserve";

$db = new mysqli($host, $user, $pass, $dbN);

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case "verifyAge":
            $age = $_POST['age'];

            if ($age > 18 && $age < 110) {
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

            $sql = "INSERT INTO ConserveData (ID_number, treatment) VALUES (NULL, '" . $treatment[$random] . "')";

            if ($db->query($sql) === true) {
                $response['result'] = true;
                $response['status'] = 1;
                $response['id'] = $db->insert_id;
                $response['treatment'] = $treatment[$random];
            } else {
                $response['result'] = false;
                $response['error'] = $db->error . "\t" . $sql;
            }
            $db->close();
            break;

        case "saveLocation":
            $location = $_POST['location'];
            $id = $_POST['id'];

            $sql = "UPDATE ConserveData SET location='$location' WHERE ID_number = $id";

            $db->query($sql);

            if ($db->affected_rows === 1) {
                //for debugging
                $response['result'] = true;
                $response['status'] = 1;
            } else {
                $response['status'] = 2;
                $response['error'] = $db->error;
                $response['sql'] = $sql;
            }
            $db->close();
            break;

        case "saveAnswers":
            $answers = $_POST['answers'];
            $id = $_POST['id'];

            $sql = "UPDATE ConserveData SET question_1_decision = '$answers[0]', question_2_decision = '$answers[1]', " .
                "question_3_decision = '$answers[2]', question_4_decision = '$answers[3]', " .
                "question_5_decision = '$answers[4]', question_6_decision = '$answers[5]', " .
                "question_7_decision = '$answers[6]', question_8_decision = '$answers[7]', " .
                "question_9_decision = '$answers[8]', question_10_decision = '$answers[9]', " .
                "question_11_decision = '$answers[10]', question_12_decision = '$answers[11]', " .
                "question_13_decision = '$answers[12]', question_14_decision = '$answers[13]', " .
                "question_15_decision = '$answers[14]' WHERE ID_number = $id";

            $db->query($sql);

            if ($db->affected_rows === 1) {
                //for debugging
                $response['result'] = true;
                $response['status'] = 1;
            } else {
                $response['status'] = 2;
                $response['error'] = $db->error;
            }
            $db->close();
            break;

        case "saveItems":
            $items = $_POST['items'];
            $id = $_POST['id'];

            $sql = "UPDATE ConserveData SET question_1_item = '$items[0]', question_2_item = '$items[1]', " .
                "question_3_item = '$items[2]', question_4_item = '$items[3]', " .
                "question_5_item = '$items[4]', question_6_item = '$items[5]', " .
                "question_7_item = '$items[6]', question_8_item = '$items[7]', " .
                "question_9_item = '$items[8]', question_10_item = '$items[9]', " .
                "question_11_item = '$items[10]', question_12_item = '$items[11]', " .
                "question_13_item = '$items[12]', question_14_item = '$items[13]', " .
                "question_15_item = '$items[14]' WHERE ID_number = $id";

            $db->query($sql);

            if ($db->affected_rows === 1) {
                //for debugging
                $response['result'] = true;
                $response['status'] = 1;
            } else {
                $response['status'] = 2;
                $response['error'] = $db->error;
            }
            $db->close();
            break;

        case "savePrices":
            $itemPrices = $_POST['prices'];
            $id = $_POST['id'];

            $sql = "UPDATE ConserveData SET question_1_price = '$itemPrices[0]', question_2_price = '$itemPrices[1]', " .
                "question_3_price = '$itemPrices[2]', question_4_price = '$itemPrices[3]', " .
                "question_5_price = '$itemPrices[4]', question_6_price = '$itemPrices[5]', " .
                "question_7_price = '$itemPrices[6]', question_8_price = '$itemPrices[7]', " .
                "question_9_price = '$itemPrices[8]', question_10_price = '$itemPrices[9]', " .
                "question_11_price = '$itemPrices[10]', question_12_price = '$itemPrices[11]', " .
                "question_13_price = '$itemPrices[12]', question_14_price = '$itemPrices[13]', " .
                "question_15_price = '$itemPrices[14]' WHERE ID_number = $id";

            $db->query($sql);

            if ($db->affected_rows === 1) {
                //for debugging
                $response['result'] = true;
                $response['status'] = 1;
            } else {
                $response['status'] = 2;
                $response['error'] = $db->error;
            }
            $db->close();
            break;

        case "saveSurvey":
            $answers = $_POST['answers'];
            $id = $_POST['id'];

            $sql = "";

            $db->query($sql);
            if ($db->affected_rows === 1) {
                //for debugging
                $response['result'] = true;
                $response['status'] = 1;
            } else {
                $response['status'] = 2;
                $response['error'] = $db->error;
            }
            $db->close();
            break;

        case "retrieveTreatmentInfo":
            $treatment = $_POST['treatment'];

            if ($treatment === "B") {
                $response['result'] = true;
                $response['html'] = "<div style=\"text-align: center;\"><video><source src='../video/crazykitty_512kb.mp4'></video></div>";
            }
            if ($treatment === "C") {
                $response['result'] = true;
                $response['html'] = "<p><em>In previous studies, 95% of participants were willing to pay for food 
                        produced with recycled irrigation water. </em></p>";
            }
            break;

        case "retrieveQuestions":
            $question = [
                "<img src='../images/bottled_water.jpg'><p>Do you want to purchase 6oz. of bottled </p>",
                "<img src='../images/spinach.jpg'><p>Do you want to purchase 1 lb of spinach irrigated with </p>",
                "<img src='../images/milk.jpg'><p>Do you want to purchase 1 gallon milk from a cow that ate feed irrigated with </p>",
                "<img src='../images/lamb.jpg' <p>Do you want to purchase 1 lb of lamb that ate feed irrigated with </p>",
                "<img src='../images/cheddar.jpg'><p>Do you want to purchase 1 lb of cheese made with milk from a cow that ate feed irrigated with </p>"
            ];

            $waterTypes = [
                "<p style='display: inline'><b>groundwater</b></p>",
                "<p style='display: inline'><b>recycled</b></p>",
                "<p style='display: inline'><b>groundwater from an aquifer recharged with recycled water</b></p>"
            ];

            shuffle($question);
            shuffle($waterTypes);

            $price = [[]];

            $mean = [
                0.38,//bottle
                4.04,//spinach
                2.59,//milk
                4.00,//lamb
                4.22//cheese
            ];

            $std_dev = [
                0.19,//bottle
                2.02,//spinach
                1.30,//milk
                2.00,//lamb
                2.11//cheese
            ];

            $completedQuestions = "";
            $k = 0;
            for ($i = 0; $i < count($question); $i++) {

                for ($j = 0; $j < count($waterTypes); $j++) {
                    $rand = (float)mt_rand() / (float)mt_getrandmax();
                    $d = new Normal($mean[$i], $std_dev[$i], 0, 0);
                    $price[$i][$j] = $d->icdf($rand);

                    if ($price[$i][$j] < 0) {
                        $price[$i][$j] = 0;
                    }

                    $completedQuestions .= "<div>" . $question[$i] . $waterTypes[$j] . " for $" .
                        round($price[$i][$j], 2) .
                        "<div class=\"radio-item\">
                            <input title=\"\" type=\"radio\" name=\"question" . $k . "\" value=\"yes\" onfocus='submitExperiment()'> Yes
                        </div>
                        <div class=\"radio-item\">
                            <input title=\"\" type=\"radio\" name=\"question" . $k . "\" value=\"no\" onfocus='submitExperiment()'> No
                        </div>" .
                        "</div>";
                    //todo fix this here
                    if (!($i == 4 && $j = 2)) {
                        $completedQuestions .= "<hr>";
                    }
                    $k++;
                }
            }

            $response['result'] = true;
            $response['html'] = $completedQuestions;
            break;

        case "retrieveSurveySliders":
            $sliders[0] = [
                "<li>
                    <div class=\"slider\">
                        <p>Recycled Water: <strong>
                            <output for=\"recycledWater1\" id=\"recycledWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"recycledWater1\" type=\"range\" min=\"1\" max=\"5\" step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#recycledWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>Reused Water: <strong>
                            <output for=\"reusedWater1\" id=\"reusedWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"reusedWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\"
                               step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#reusedWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>Treated Water: <strong>
                            <output for=\"treatedWater1\" id=\"treatedWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"treatedWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\"
                               step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#treatedWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>Pure Water: <strong>
                            <output for=\"pureWater1\" id=\"pureWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"pureWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\" step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#pureWaterPref0').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>NEWater: <strong>
                            <output for=\"NEWater1\" id=\"NEWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"NEWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\" step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#NEWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>Nontraditional Water: <strong>
                            <output for=\"nonTradWater1\" id=\"nonTradWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"nonTradWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\"
                               step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#nonTradWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>Low Footprint Water: <strong>
                            <output for=\"lFootWater1\" id=\"lFootWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"lFootWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\"
                               step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#lFootWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>Sustainable Water: <strong>
                            <output for=\"sustainableWater1\" id=\"sustainableWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"sustainableWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\"
                               step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#sustainableWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>Advanced Purified Water: <strong>
                            <output for=\"advPurifiedWater1\" id=\"advPurifiedWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"advPurifiedWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\"
                               step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#advPurifiedWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>Advanced Purified Recycled Water: <strong>
                            <output for=\"advPurifiedRecycledWater1\" id=\"advPurifiedRecycledWaterPref1\">3
                            </output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"advPurifiedRecycledWater1\" type=\"range\" value=\"3\" min=\"1\"
                               max=\"5\" step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#advPurifiedRecycledWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>Green Water: <strong>
                            <output for=\"greenWater1\" id=\"greenWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"greenWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\"
                               step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#greenWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>Reclaimed Water: <strong>
                            <output for=\"reclaimedWater1\" id=\"reclaimedWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"reclaimedWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\"
                               step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#reclaimedWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>Pure Recycled Water: <strong>
                            <output for=\"pureRecycledWater1\" id=\"pureRecycledWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"pureRecycledWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\"
                               step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#pureRecycledWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>100% Fresh Water: <strong>
                            <output for=\"percentFreshWater1\" id=\"percentFreshWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"percentFreshWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\"
                               step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#percentFreshWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>All Natural Water: <strong>
                            <output for=\"naturalWater1\" id=\"naturalWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"naturalWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\"
                               step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#naturalWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>All Fresh Water: <strong>
                            <output for=\"allFreshWater1\" id=\"allFreshWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"allFreshWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\"
                               step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#allFreshWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>Eco-Friendly Water: <strong>
                            <output for=\"ecoFriendlyWater1\" id=\"ecoFriendlyWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"ecoFriendlyWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\"
                               step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#ecoFriendlyWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>EcoWater: <strong>
                            <output for=\"ecoWater1\" id=\"ecoWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"ecoWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\" step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#ecoWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>EnviroWater: <strong>
                            <output for=\"enviroWater1\" id=\"enviroWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"enviroWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\"
                               step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#enviroWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>",
                "<li>
                    <div class=\"slider\">
                        <p>ReNew Water: <strong>
                            <output for=\"reNewWater1\" id=\"reNewWaterPref1\">3</output>
                        </strong></p>
                        <br>
                        <span><strong>Definitely not</strong></span>
                        <input title=\"other\" id=\"reNewWater1\" type=\"range\" value=\"3\" min=\"1\" max=\"5\"
                               step=\"1\"
                               data-show-value=\"true\"
                               oninput=\"$('#reNewWaterPref1').val(this.value)\">
                        <span><strong>Definitely would</strong></span>
                    </div>
                </li>"
            ];


    }
}


//echo response data

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $testing) {
    echo json_encode($response);
}