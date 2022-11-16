window.onload = function () {
    getTests();
}

let saveGetTestsResponse = [];

// get and populate test
function getTests() {
    let formData = new FormData();
    formData.append('getTests', 'true');
    fetch('./backend/functions/questionDB.php', {method: 'POST', body: formData})
        .then(response => response.text()).then(data => {
        let parsedResponse = JSON.parse(data);
        saveGetTestsResponse = [...parsedResponse];
        let testsHtml = document.getElementsByClassName('tests')[0];
        for (let i = 0; i < parsedResponse.length; i++) {
            let innerHtml =
                    '<h2 onclick="openTest(' + i + ');">' +
                        parsedResponse[i]['title'] +
                    '</h2>';
            if (parsedResponse[i][2] !== 'preset') {
                innerHtml += '<p>| </p><p class="clickable" onclick="copyTest(' + i + ');" style="color: darkblue;">kopiëren</p><p class="clickable" onclick="deleteTest(' + i + ')" style="color: darkred ;">verwijderen</p>';
            }
            // populate result history limit 5
            if (parsedResponse[i]['grade'] !== null && parsedResponse[i]['grade'] !== undefined) {
                let resultHistory = '';
                if (parsedResponse[i]['grade'].length > 0) {
                    resultHistory = '<p> | Resultaten: </p>';
                    for (let z = 0; z < parsedResponse[i]['grade'].length; z++) {
                        resultHistory += '<p>' + parsedResponse[i]['grade'][z] + '%</p>';
                    }
                }
                innerHtml += resultHistory;
            }
            let div = '<div> :innerHtml: </div>';
            div = div.replace(':innerHtml:', innerHtml);
            testsHtml.innerHTML += div;
        }
    });
}

function openTest(index) {
    // opens test window & sends the testID with GET
    let testID = saveGetTestsResponse[index]['id'];
    window.open('./toets?test=' + testID, '_self').focus();
}

function copyTest(index) {
    // open new test window & send testID with GET
    let testID = saveGetTestsResponse[index]['id'];
    window.open('./nieuwe_toets?test=' + testID, '_self').focus();
}

function deleteTest(index) {
    if (confirm('weet je zeker dat je deze toets wil verwijderen?')) {
        let formData = new FormData();
        formData.append('deleteTest', 'true');
        formData.append('testID', saveGetTestsResponse[index]['id']);
        fetch('./backend/functions/questionDB.php', {method: "POST", body: formData})
            .then(response => response.text()).then(data => {
            window.open('./', '_self').focus();
        });
    }
}

function logOut() {
    if (confirm('weet je zeker dat je uit wil loggen?')) {
        let formData = new FormData();
        formData.append('logOut', 'true');
        fetch('./backend/functions/userDB.php', {method: "POST", body: formData})
            .then(response => response.text()).then(data => {
            window.open('./', '_self').focus();
        });
    }
}