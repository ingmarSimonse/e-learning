let questionArray = [];
let index = 0;
let correctQuestion = 0;
let questionAmount = 0;
let testFinished = false;
let saveTestID;
// get questions
function getQuestions(testID) {
    saveTestID = testID;
    let formData = new FormData();
    formData.append('getQuestions', 'true');
    formData.append('testID', testID);
    fetch('./backend/functions/questionDB.php', {method: 'POST', body: formData})
        .then(response => response.text()).then(data => {
        let parsedResponse = JSON.parse(data);
        questionArray = [...parsedResponse];
        populateQuestion();
    });
}

// populate current question
function populateQuestion() {
    let questionsHtml = document.getElementsByClassName('questions')[0];
    let question = questionArray[index]['sentence'];
    let correctAnswerHtml = document.getElementById('correctAnswer');
    correctAnswerHtml.innerHTML = '';
    let input = '<input id="answer" type="text" required name="answer" maxlength="200">';
    if (question.includes(":antwoord:")) {
        question = question.replace(':antwoord:', input);
    } else {
        if (questionArray[index]['answer'] !== '') {
            question += ' ' + input;
        }
    }
    if (question.includes(":nr:")) {
        question = question.replace(':nr:', '<br>');
    }
    questionsHtml.innerHTML =
        '<div class="question">' +
            question +
        '</div>';
}

function populateResult() {
    // populate result when test is finished
    let questionsHtml = document.getElementsByClassName('questions')[0];
    let score = Math.round(100 / questionAmount * correctQuestion);
    questionsHtml.innerHTML =
        '<div class="score">' +
            'Score: ' + score + '% (' + correctQuestion + '/' + questionAmount + ')' +
        '</div>';
    testFinished = true;
    // push result to result_history
    if (saveTestID != null) {
        let formData = new FormData();
        formData.append('pushResult', 'true');
        formData.append('testID', saveTestID);
        formData.append('grade', score.toString());
        fetch('./backend/functions/result_historyDB.php', {method: 'POST', body: formData})
            .then(response => response.text()).then(data => {
            let parsedResponse = JSON.parse(data);
        });
    }
}

// populate next question
function nextPage() {
    let answerHtml = document.getElementById('answer');
    let bodyHtml = document.getElementById('body');
    let correctAnswerHtml = document.getElementById('correctAnswer');
    // check if test is finished
    if (!testFinished) {
        // check if is a question
        if (questionArray[index]['answer'] !== '') {
            // check if question is correct
            if (answerHtml.value === questionArray[index]['answer']) {
                correctQuestion++;
                bodyHtml.style.backgroundColor = 'green';
            } else {
                bodyHtml.style.backgroundColor = 'red';
                // show correct answer
                correctAnswerHtml.innerHTML = questionArray[index]['answer'];
            }
            questionAmount++;

            setTimeout(function () {
                populateIf();
                bodyHtml.style.backgroundColor = 'white';
            }, 1000);
        } else {
            populateIf();
        }
    } else {
        populateIf();
    }
}

function populateIf() {
    index++;
    if (testFinished) {
        window.open('./', '_self').focus();
    } else if (index >= questionArray.length) {
        populateResult();
    } else {
        populateQuestion();
    }
}