<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 1/31/17
 * Time: 5:07 PM
 *
 * This Page should be used to test the survey questions separately from the rest of the experiment
 */

/*
 * This section of code gets the data from the html and assigns them to a respective var for access later
 * it collects data using the 'name' field which groups together radio buttons for one input
 */
$ID_num = 1; /* This variable declaration is solely for testing purposes and should be removed for actual experiments */
$age = $_POST['age'];
$gender = $_POST['gender'];
$live = $_POST['live'];
$zip = $_POST['zip'];
$profession = $_POST['profession_'];
$political = $_POST['political_'];
$race = $_POST['ethnicity'];
$income = $_POST['income'];
$education = $_POST['education'];
$grapes = $_POST['GrapeConsume'];
$almonds = $_POST['AlmondsConsume'];
$carrots = $_POST['CarrotConsume'];
$primaryShopper = $_POST['primShop'];
$freshCons = $_POST['freshCons'];
$freshACons = $_POST['freshACons'];
$homegrown = $_POST['HomeGrown'];
$foodPrice = $_POST['foodPrice'];
$foodTime = $_POST['foodTime'];
$foodOrganic = $_POST['foodOrganic'];
$foodNonGMO = $_POST['foodNonGMO'];
$foodWater = $_POST['foodWater'];
$foodLocal = $_POST['foodLocal'];
$waterPref = $_POST['waterPref_'];
$waterSource = $_POST['waterSource'];
$waterCommunity = $_POST['waterCommunity'];
$waterState = $_POST['waterState'];
$waterUS = $_POST['waterUS'];
$waterWorld = $_POST['waterWorld'];
$present = $_POST['present'];
$tenYears = $_POST['tenYears'];
$thirtyYears = $_POST['thirtyYears'];
$fiftyYears = $_POST['fiftyYears'];
$climateCommunity = $_POST['climateCommunityValue'];
$climateState = $_POST['climateStateValue'];
$climateUS = $_POST['climateUSValue'];
$climateWorld = $_POST['climateWorldValue'];
$climatePresent = $_POST['climatePresentValue'];
$climateTenYears = $_POST['climateTenYearsValue'];
$climateThirtyYears = $_POST['climateThirtyYearsValue'];
$climateFiftyYears = $_POST['climateFiftyYearsValue'];
$heardPro = $_POST['heardPro'];
$heardB = $_POST['heardB'];
$heardG = $_POST['heardG'];
$reuseWater = $_POST['reuseWater'];
$YNDiffValue = $_POST['YNDiffValue'];
$YNDiffAValue = $_POST['YNDiffAValue'];
$YNDiffBValue = $_POST['YNDiffBValue'];
$Fed = $_POST['Fed'];
$StateGov = $_POST['StateGov'];
$LocalGov = $_POST['LocalGov'];
$Farm = $_POST['Farm'];
$Np = $_POST['Np'];
$plantA = $_POST['PlantA'];
$plant = $_POST['Plant'];

/*
 * Setting up the database connection
 * $db = new myqsli('hostURL', 'user' 'password' 'database');
 */
@$db = new mysqli('localhost', 'ceae', '025', 'ceae');

//testing the connection
if (mysqli_connect_errno()) {
    echo "<p>Error: Could not connect to database.</p>";
} else {

    //if test passes then move onto setting up a query format
    $query = "INSERT INTO ConserveSurvey VALUES (
                                   ?,?,?,?,?,?,?,
                                   ?,?,?,?,?,?,?,
                                   ?,?,?,?,?,?,?,
                                   ?,?,?,?,?,?,?,
                                   ?,?,?,?,?,?,?,
                                   ?,?,?,?,?,?,?,
                                   ?,?,?,?,?,?,?,
                                   ?,?,?,?,?,?)";

    //prepare the @$query statement
    $stmt = $db->prepare($query);

    //data type parameter must be in same order as in the database
    //int = i; double = d; string = s;
    $stmt->bind_param('idssdsssssdddssssddddddssddddddddddddddddssssdddddddddd',
        $ID_num,$age, $gender, $live, $zip, $profession, $political, $race,
        $income, $education, $grapes, $almonds, $carrots, $primaryShopper, $freshCons,
        $freshACons, $homegrown, $foodPrice, $foodTime, $foodOrganic, $foodNonGMO, $foodWater,
        $foodLocal, $waterPref, $waterSource, $waterCommunity, $waterState, $waterUS, $waterWorld,
        $present, $tenYears, $thirtyYears, $fiftyYears, $climateCommunity, $climateState, $climateUS,
        $climateWorld, $climatePresent, $climateTenYears, $climateThirtyYears, $climateFiftyYears,
        $heardPro, $heardB, $heardG, $reuseWater, $YNDiffValue, $YNDiffAValue, $YNDiffBValue, $Fed,
        $StateGov, $LocalGov, $Farm, $Np, $plant, $plantA
    );

// execute the MYSQL query
    echo "<p>Executing query...</p>";
    $stmt->execute();

//Display message if it works or display the error that occurred
    if ($stmt->affected_rows > 0) {
        echo "<p>It worked!</p>";
    } else {
        echo "<p>An error has occurred.<br>
            The item(s) not added " . $db->error . "</p>"; /* Display error code if it doesn't go into the db */
    }
}
//close the db
$db->close();