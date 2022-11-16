function setQuestionAmount(amount) {
    let question = document.getElementsByClassName('question');
    for (let i = 0; i < 40; i++) {
        if (i < amount) {
            question[i].style.display = 'block';
        } else {
            question[i].style.display = 'none';
        }
    }
}

window.onload = function () {
    // set up questions
    let questions = document.getElementsByClassName('questions')[0];
    questions.innerHTML = '';
    for (let i = 0; i < 40; i++) {
        questions.innerHTML +=
            '<div class="question">' +
                '<textarea rows="2" class="sentence" name="question" required maxlength="300" placeholder="vraag..."></textarea>' +
                '<textarea rows="2" class="answer" type="text" name="answer" required maxlength="200" placeholder="antwoord..."></textarea>' +
            '</div>';
    }

    setQuestionAmount(10);
}

function saveTest() {
    let titleHtml = document.getElementById('title');
    // validate Title
    if (titleHtml.value === '') {
        alert('Vul AUB een titel in.');
        return false;
    }
    if (titleHtml.value.length > 40) {
        alert('Vul een kortere titel in.');
        return false;
    }

    // validate questions
    let sentenceHtml = document.getElementsByClassName('sentence');
    let answerHtml = document.getElementsByClassName('answer');
    let questionArray = [];
    for (let i = 0; i < sentenceHtml.length; i++) {
        if (sentenceHtml[i].value !== '' &&
            sentenceHtml[i].value.length < 300 &&
            answerHtml[i].value.length < 200) {
            questionArray.push(
                {
                    'sentence': sentenceHtml[i].value,
                    'answer': answerHtml[i].value
                }
            );
        }
    }
    if (questionArray.length < 1) {
        alert('vul meer vragen in.');
        return false;
    }

    // add test to db
    let formData = new FormData();
    formData.append('addTest', 'true');
    formData.append('question', JSON.stringify(questionArray));
    formData.append('title', titleHtml.value);
    fetch('./backend/functions/questionDB.php', {method: "POST", body: formData})
        .then(response => response.text()).then(data => {
        window.open('./', '_self').focus();
    });
}

function populateCopyTest(testID) {
    let formData = new FormData();
    formData.append('getQuestions', 'true');
    formData.append('testID', testID);
    fetch('./backend/functions/questionDB.php', {method: 'POST', body: formData})
        .then(response => response.text()).then(data => {
        let parsedResponse = JSON.parse(data);
        document.getElementById('questionAmount').value = parsedResponse.length;
        let answerHtml = document.getElementsByClassName('answer');
        let sentenceHtml = document.getElementsByClassName('sentence');
        setQuestionAmount(parsedResponse.length);
        for (let i = 0; i < parsedResponse.length; i++) {
            answerHtml[i].value = parsedResponse[i]['answer'];
            sentenceHtml[i].value = parsedResponse[i]['sentence'];
        }
    });
}