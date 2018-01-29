$(document).ready(function(){
    //getUserID();
    newUser();
});

var images = [], x = -1;

for (var i = 0; i < 15; i++) {
    images[i] = "../images/die" + (i + 1).toString() + ".png";
}

var ageVerify = function () {
    if(document.getElementById("age").value.length > 2){
        if(parseInt(document.getElementById("age").value) < 18){
            document.getElementById("submitSurvey").style.display = "none";
            alert("Please enter an age above 18.");
        }
        else{
            document.getElementById("submitSurvey").style.display = "initial";
        }
    }
};

function saveLocation($location) {
    var $id = document.getElementById("ID_num").value;

    $.post("../php/serviceHandler.php", {action: "saveLocation", location: $location, id: $id})
        .done( function(data){
            var $obj = JSON.parse(data);
            if($obj.result === true){
                console.log($id + ":\tLocation: " + $location + " was saved.")
            } else {
                console.log($id + ":\tLocation: "+ $location +" was not saved. An error occurred.\n");
                console.log("error: " + $obj.error);
            }
        })
}

function newUser(){
    $.post("../php/serviceHandler.php", {action: "newUser"})
        .done(function(data){
            var $obj = JSON.parse(data);
            if($obj.result === true){
                $("#ID_num").val($obj.id);
                $("#idOutput").val($obj.id);
                $("#treatment").val($obj.treatment);
            } else {
                console.log("Error: could not create new user.\n" + $obj.error)
            }
        });
}

function saveAnswers(){
    var $id = document.getElementById("ID_num").value;

    var $answers = [];
    for (var i = 0; i < 15; i++){
        $answers[i] = document.getElementById("treatment_" + i + "_decision").value;
    }

    $.post("../php/serviceHandler.php", {action: "saveAnswers", answers: $answers, id: $id})
        .done( function(data){
            var $obj = JSON.parse(data);
            if ($obj.result === true){
                console.log($id + ":\tAnswers were saved.")
            } else {
                console.log($id + ": \tError occurred: Answers not saved");
                console.log("Error: " + $obj.error);
            }
        })
}

function saveItems() {
    var $id = document.getElementById("ID_num").value;

    var items = [];
    for (var i = 0; i < 15; i++){
        items[i] = document.getElementById("item-" + i).value;
    }

    $.post("../php/serviceHandler.php", {action: "saveItems", items: items, id: $id})
        .done( function(data){
            var $obj = JSON.parse(data);
            if ($obj.result === true){
                console.log($id + ":\tItems were saved.")
            } else {
                console.log($id + ": \tError occurred: Item not saved");
                console.log("Error: " + $obj.error);
            }
        })

}

function savePrices(){
    var $id = document.getElementById("ID_num").value;

    var $prices = [];
    for (var i = 0; i < 15; i++){
        $prices[i] = document.getElementById("price-" + i).value;
    }

    $.post("../php/serviceHandler.php", {action: "savePrices", prices: $prices, id: $id})
        .done( function(data){
            var $obj = JSON.parse(data);
            if ($obj.result === true){
                console.log($id + ":\tPrices were saved.")
            } else {
                console.log($id + ": \tError occurred: Prices not saved");
                console.log("Error: " + $obj.error);
            }
        })
}



var continue_buttons = function (part) {
    if (part === 1) {
        window.open('pages/destig.html', 'Conserve', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,fullscreen=yes');
    }
    else if (part === 2) {
        document.getElementById("ID").style.display = "none";
        document.getElementById("instructions").style.display = "initial";
        saveLocation("instructions");
    }
    else if (part === 3) {
        document.getElementById("User_ID").style.display = "initial";
        document.getElementById("instructions").style.display = "none";
        document.getElementById("definition").style.display = "initial";
        var Defs = [
            "<strong>Recycled black water:</strong> Treated wastewater from toilets and urinals.",
            "<strong>Recycled gray water:</strong> Treated wastewater from washing, laundering, bathing, " +
            "and showering.",
            "<strong>Recycled produced water:</strong> Treated wastewater from oil and gas drilling operations.",
            "<strong>Conventional water:</strong> Traditional sources of irrigation water, such as surface water " +
            "(rivers, lakes, ponds, and reservoirs) and well water."];
        Defs.sort(function () {
            return 0.5 - Math.random()
        });

        for (var i = 0; i < Defs.length; i++) {
            document.getElementById("waterDef-" + i.toString()).innerHTML = Defs[i].toString();
        }

        saveLocation('definitions');
    }
    else if (part === 4) {
        var info_array = ["According to the United States Environmental Protection " +
        "Agency (EPA), In addition to providing a dependable, locally-controlled water supply water " +
        "recycling provides tremendous environmental benefits. By providing an additional source of water, " +
        "water recycling can help us find ways to decrease the diversion of water from sensitive ecosystems." +
        "Other benefits include decreasing wastewater discharges and reducing and preventing pollution\". " +
        "Recycled water can also be used to create or enhance wetlands and [riverside] habitats.",
            "According to cropscience.org ... \"There have been a number " +
            "of risk factors identified for using recycled waters for purposes such as agricultural irrigation. " +
            "Some risk factors are short term and vary in severity depending on the potential for human, animal " +
            "or environmental contact (eg, microbial pathogens), while others have longer term impacts which " +
            "increase with continued use of recycled water (eg, salt effects on soil)."];

        var $treatment = $("#treatment").val();

        switch($treatment){
            case "A":
                document.getElementById("definition").style.display = "none";
                document.getElementById("experiment").style.display = "initial";
                saveLocation("experiment");
                experiment();
                break;
            case "B":
                document.getElementById("info").innerHTML = info_array[0].toString();
                document.getElementById("definition").style.display = "none";
                document.getElementById("information").style.display = "initial";
                saveLocation("information");
                break;
            case "C":
                document.getElementById("info").innerHTML = info_array[1].toString();
                document.getElementById("definition").style.display = "none";
                document.getElementById("information").style.display = "initial";
                saveLocation("information");
                break;
            case "D":
                info_array.sort(function () {
                    return 0.5 - Math.random()
                });

                document.getElementById("info").innerHTML = info_array[0].toString() + " <br><br> " +
                    info_array[1].toString();
                document.getElementById("definition").style.display = "none";
                document.getElementById("information").style.display = "initial";
                saveLocation("information");
                break;
        }
    }
    else if (part === 5) {
        if (document.getElementById("treatment").value !== "A") {
            document.getElementById("information").style.display = "none";
            experiment();
        }
        else {
            document.getElementById("definition").style.display = "none";
        }
        document.getElementById("experiment").style.display = "initial";
        saveLocation("experiment");

    }
    else if (part === 6) {
        document.getElementById("experiment").style.display = "none";
        document.getElementById("survey").style.display = "initial";
        saveLocation("survey");
        $('html,body').scrollTop;
    }
    else if (part === 7) {
        document.getElementById("survey").style.display = "none";
        document.getElementById("dice-roll").style.display = "initial";
        saveLocation("dice-roll");
    }
    else if (part === 8) {
        document.getElementById("dice-roll").style.display = "none";
        document.getElementById("results").style.display = "initial";
        saveLocation("results");
    }
    else {
        document.getElementById("results").style.display = "none";
        document.getElementById("admin_field").style.display = "initial";
    }
};

function experiment() {
    var Defs = [
        "<strong>Recycled black water:</strong> Treated wastewater from toilets and urinals.",
        "<strong>Recycled gray water:</strong> Treated wastewater from washing, laundering, bathing, " +
        "and showering.",
        "<strong>Recycled produced water:</strong> Treated wastewater from oil and gas drilling operations.",
        "<strong>Conventional water:</strong> Traditional sources of irrigation water, such as surface water " +
        "(rivers, lakes, ponds, and reservoirs) and well water."];
    Defs.sort(function () {
        return 0.5 - Math.random()
    });

    for (i = 0; i < Defs.length; i++) {
        document.getElementById("waterDef-" + i.toString() + "-repeat").innerHTML = Defs[i].toString();
    }
    var grape_control = ["1 lb. of grapes"];
    var grapes = ["1 lb. of grapes that were irrigated with <strong>conventional water</strong>",
        "1 lb. of grapes that were irrigated with <strong>recycled black water</strong>",
        "1 lb. of grapes that were irrigated with <strong>recycled gray water</strong>",
        "1 lb. of grapes that were irrigated with <strong>recycled produced water</strong>"];
    grapes.sort(function () {
        return 0.5 - Math.random()
    });
    var grapes_sub = [];
    grapes_sub.push(grape_control);
    for (i = 0; i < grapes.length; i++) {
        grapes_sub.push(grapes[i]);
    }

    var carrot_control = ["1 lb. of carrots"];
    var carrots = ["1 lb. of carrots that were irrigated with <strong>conventional water</strong>",
        "1 lb. of carrots that were irrigated with <strong>recycled black water</strong>",
        "1 lb. of carrots that were irrigated with <strong>recycled gray water</strong>",
        "1 lb. of carrots that were irrigated with <strong>recycled produced water</strong>"];
    carrots.sort(function () {
        return 0.5 - Math.random()
    });
    var carrots_sub = [];
    carrots_sub.push(carrot_control);
    for (i = 0; i < carrots.length; i++) {
        carrots_sub.push(carrots[i]);
    }

    var almond_control = ["6 oz. of almonds"];
    var almonds = ["6 oz. of almonds that were irrigated with <strong>conventional water</strong>",
        "6 oz. of almonds that were irrigated with <strong>recycled black water</strong>",
        "6 oz. of almonds that were irrigated with <strong>recycled gray water</strong>",
        "6 oz. of almonds that were irrigated with <strong>recycled produced water</strong>"];
    almonds.sort(function () {
        return 0.5 - Math.random()
    });
    var almonds_sub = [];
    almonds_sub.push(almond_control);
    for (i = 0; i < almonds.length; i++) {
        almonds_sub.push(almonds[i]);
    }

    var experimentQs_temp = [];
    experimentQs_temp.push(grapes_sub);
    experimentQs_temp.push(carrots_sub);
    experimentQs_temp.push(almonds_sub);
    experimentQs_temp.sort(function () {
        return 0.5 - Math.random()
    });

    var experimentQs = [];
    for (var i = 0; i < experimentQs_temp.length; i++) {
        var question = experimentQs_temp[i];
        for (var j = 0; j < question.length; j++) {
            experimentQs.push(question[j]);
        }
    }

    for (i = 0; i < experimentQs.length; i++) {
        document.getElementById("price-" + i.toString()).value = (Math.random() * (5)).toFixed(2).toString();
    }


    for (i = 0; i < experimentQs.length; i++) {
        if (experimentQs[i].toString().indexOf("grapes") !== -1) {
            document.getElementById("treatment-" + i.toString()).src = "../images/grape.jpg";
        }
        else if (experimentQs[i].toString().indexOf("carrots") !== -1) {
            document.getElementById("treatment-" + i.toString()).src = "../images/carrots.jpg";
        }
        else if (experimentQs[i].toString().indexOf("almonds") !== -1) {
            document.getElementById("treatment-" + i.toString()).src = "../images/almonds.jpg";
        }

        document.getElementById("treatment-" + i.toString() + "-question").innerHTML =
            "Do you want to buy " + experimentQs[i] + " for $" +
            document.getElementById("price-" + i.toString()).value.toString();
        document.getElementById("item-" + i.toString()).value = experimentQs[i].toString();
    }
}

function displayNextImage() {
    x = (x === images.length - 1) ? 0 : x + 1;
    document.getElementById("dice-number").innerHTML = (x + 1).toString();
}

function startTimer() {
    setInterval(displayNextImage, 50);
    document.getElementById("dice_roller").style.display = "none";
    document.getElementById("dice_stopper").style.display = "initial";
}

function stopDice() {
    var final_die = parseInt(document.getElementById("dice-number").innerHTML) + 1;
    if (final_die === 1) {
        updateFinalInfo("0", final_die);
    }
    else if (final_die === 2) {
        updateFinalInfo("1", final_die);
    }
    else if (final_die === 3) {
        updateFinalInfo("2", final_die);

    }
    else if (final_die === 4) {
        updateFinalInfo("3", final_die);

    }
    else if (final_die === 5) {
        updateFinalInfo("4", final_die);

    }
    else if (final_die === 6) {
        updateFinalInfo("5", final_die);

    }
    else if (final_die === 7) {
        updateFinalInfo("6", final_die);

    }
    else if (final_die === 8) {
        updateFinalInfo("7", final_die);

    }
    else if (final_die === 9) {
        updateFinalInfo("8", final_die);

    }
    else if (final_die === 10) {
        updateFinalInfo("9", final_die);

    }
    else if (final_die === 11) {
        updateFinalInfo("10", final_die);

    }
    else if (final_die === 12) {
        updateFinalInfo("11", final_die);

    }
    else if (final_die === 13) {
        updateFinalInfo("12", final_die);

    }
    else if (final_die === 14) {
        updateFinalInfo("13", final_die);

    }
    else if (final_die === 15) {
        updateFinalInfo("14", final_die);

    }

    document.getElementById("dice-number").style.display = "none";
    document.getElementById("dice_stopper").style.display = "none";
    document.getElementById("dice-roll-button").style.display = "initial";
    //noinspection JSValidateTypes
    document.getElementById("final-dice-number").innerHTML = final_die;
    document.getElementById("final-dice-number").style.display = "initial";
}

function updateFinalInfo(number, final_die) {
    document.getElementById("option-selected").value = final_die.toString();
    document.getElementById("optionNum").innerHTML = final_die.toString();
    var endPrice = document.getElementById("price-" + number.toString()).value.toString();
    document.getElementById("optionInfo").innerHTML = document.getElementById("item-" +
        number.toString()).value;
    if (document.getElementById("treatment_" + number.toString() + "_decision").value === "Yes") {
        document.getElementById("final-selection").innerHTML = document.getElementById("item-" +
            number.toString()).value;
        document.getElementById("final-price").innerHTML = "$" +
            document.getElementById("price-" + number.toString()).value;
        //alert(10 - parseFloat(endPrice));
        document.getElementById("takeHome").innerHTML = "and $" + (10 - parseFloat(endPrice)).toString();
    }
    else {
        document.getElementById("final-selection").innerHTML = "$10";
        document.getElementById("agree").style.display = "none";
    }
    document.getElementById("final-selection-data").value = document.getElementById("item-" +
        number.toString()).value;
    document.getElementById("final-price-data").value = document.getElementById("price-" + number.toString()).value;
    document.getElementById("yesno").innerHTML =
        document.getElementById("treatment_" + number.toString() + "_decision").value;
    document.getElementById("yesno-data").value =
        document.getElementById("treatment_" + number.toString() + "_decision").value;
}

function submitExperiment() {
    if (document.getElementById("treatment_0_decision").value !== ''
        && document.getElementById("treatment_1_decision").value !== ''
        && document.getElementById("treatment_2_decision").value !== ''
        && document.getElementById("treatment_3_decision").value !== ''
        && document.getElementById("treatment_4_decision").value !== ''
        && document.getElementById("treatment_5_decision").value !== ''
        && document.getElementById("treatment_6_decision").value !== ''
        && document.getElementById("treatment_7_decision").value !== ''
        && document.getElementById("treatment_8_decision").value !== ''
        && document.getElementById("treatment_9_decision").value !== ''
        && document.getElementById("treatment_10_decision").value !== ''
        && document.getElementById("treatment_11_decision").value !== ''
        && document.getElementById("treatment_12_decision").value !== ''
        && document.getElementById("treatment_13_decision").value !== ''
        && document.getElementById("treatment_14_decision").value !== ''
    ) {
        document.getElementById("continueExp").style.display = "initial";
        saveAnswers();
        saveItems();
        savePrices();
    }

}

function checkPassword() {
    document.getElementById("password_button").style.display = "none";
    document.getElementById("password").style.display = "initial";
}

function passCode() {
    if (document.getElementById("password").value.toString() === "025") {
        document.getElementById("admin").style.display = "initial";
    }
    else {
        document.getElementById("admin").style.display = "none";
    }
}

values_to_html_tags = [
    "gender",
    "live",
    "zip",
    "profession",
    "political",
    "race",
    "income",
    "education",
    "GrapeConsume",
    "AlmondsConsume",
    "CarrotConsume",
    "primShop",
    "freshCons",
    "freshACons",
    "HomeGrown",
    "WaterPref",
    "waterSource",
    "heardPro",
    "heardB",
    "heardG",
    "reuseWater"

];

output_update_tags = [
    "#foodPrice",
    "#foodTimeValue",
    "#foodOrganicValue",
    "#foodNonGMOValue",
    "#foodWaterValue",
    "#foodLocalValue",
    "#waterCommunityValue",
    "#waterStateValue",
    "#waterUSValue",
    "#waterWorldValue",
    "#PresentValue",
    "#tenYearsValue",
    "#thirtyYearsValue",
    "#fiftyYearsValue",
    "#climateCommunityValue",
    "#climateStateValue",
    "#climateUSValue",
    "#climateWorldValue",
    "#climatePresentValue",
    "#climateTenYearsValue",
    "#climateThirtyYearsValue",
    "#climateFiftyYearsValue",
    "#YNDiffValue",
    "#YNDiffAValue",
    "#YNDiffBValue",
    "#FedValue",
    "#StateGovValue",
    "#LocalGovValue",
    "#FarmValue",
    "#NpValue",
    "#PlantValue",
    "#PlantAValue"
];

function outputUpdate(vol, i) {
    i = i - 1;
    document.querySelector(output_update_tags[i]).value = vol;
}
