<?php
require_once "../config.php";

session_start();

if (isset($_POST["addTest"])) {
    addTest();
} elseif (isset($_POST["getTests"])) {
    getTests();
} elseif (isset($_POST["getQuestions"])) {
    getQuestions();
} elseif (isset($_POST["deleteTest"])) {
    deleteTest();
} else {
    header("location: home");
}

// add new test to db
function addTest() {
    global $conn;

    $userID = $_SESSION["loggedIn"];
    $title = $_POST["title"];
    $title = htmlspecialchars($title);
    $title = $conn->real_escape_string($title);
    // add test to test table
    $conn->query("INSERT INTO `e-learning_test` (`ID`, `title`, `userID`)
                            VALUES (NULL, '$title', $userID)");

    // get test id
    $testID = $conn->insert_id;

    // add questions to question table
    $questions = json_decode($_POST["question"]);
    for ($i = 0; $i < count($questions); $i++) {
        $sentence = $questions[$i]->{"sentence"};
        $sentence = htmlspecialchars($sentence);
        $sentence = $conn->real_escape_string($sentence);
        $answer = $questions[$i]->{"answer"};
        $answer = htmlspecialchars($answer);
        $answer = $conn->real_escape_string($answer);
        $conn->query("INSERT INTO `e-learning_question` (`ID`, `sentence`, `answer`, `testID`)
                            VALUES (NULL, '$sentence', '$answer', $testID)");
    }
}

// get all tests from user & preset tests
function getTests() {
    global $conn;

    // get preset tests
    // 18 is the id of the user preset
    $testArray = array();
    $result = $conn->query("SELECT `title`, `id` FROM `e-learning_test` WHERE `userID` = 18");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            array_push($row, "preset");
            array_push($testArray, $row);
        }
    }

    if (isset($_SESSION["loggedIn"])) {
        // get user made tests
        $userID = $_SESSION["loggedIn"];
        $result = $conn->query("SELECT `title`, `id` FROM `e-learning_test` WHERE `userID` = $userID");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array()) {
                array_push($testArray, $row);
            }
        }

        // get test result_history
        for ($i = 0; $i < count($testArray); $i++) {
            $testArray[$i]["grade"] = array();
            $testID = $testArray[$i]["id"];
            $result = $conn->query("SELECT `grade` FROM `e-learning_result_history` 
                        WHERE `testID` = $testID AND `userID` = $userID ORDER BY `id` DESC LIMIT 5");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_array()) {
                    array_push($testArray[$i]["grade"], $row["grade"]);
                }
            }
        }
    }

    echo json_encode($testArray);
}

// get test questions using testID
function getQuestions() {
    global $conn;
    // get questions from test
    $questionArray = array();
    $testID = $_POST["testID"];
    $result = $conn->query("SELECT `sentence`, `answer` FROM `e-learning_question` WHERE `testID` = $testID");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            array_push($questionArray, $row);
        }
    }

    echo json_encode($questionArray);
}

// delete test
function deleteTest() {
    global $conn;

    $testID = $_POST["testID"];

    // delete questions where testID
    $conn->query("DELETE FROM `e-learning_question` WHERE `testID` = $testID");

    // delete result_history where testID
    $conn->query("DELETE FROM `e-learning_result_history` WHERE `testID` = $testID");

    // delete test
    $conn->query("DELETE FROM `e-learning_test` WHERE `id` = $testID");
}