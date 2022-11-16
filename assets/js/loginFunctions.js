//change form visible to user
let changeFormValue = true;
function changeForm() {
    let btnChangeForm = document.getElementById('btnChangeForm');
    let frmLogin = document.getElementById('frmLogin');
    let frmRegister = document.getElementById('frmRegister');
    if (changeFormValue) {
        btnChangeForm.innerHTML = "Log in";
        changeFormValue = false;
        frmLogin.classList.add("hidden");
        frmRegister.classList.remove("hidden");
    } else {
        btnChangeForm.innerHTML = "Registreer";
        changeFormValue = true;
        frmRegister.classList.add("hidden");
        frmLogin.classList.remove("hidden");
    }
}

// submit / validate login form
function frmLogin_Submit(form) {
    // Check if email and password are correct
    let formData = new FormData();
    formData.append('login', 'true');
    formData.append('email', form['email'].value);
    formData.append('password', form['password'].value);
    fetch('./backend/functions/userDB.php', {method: "POST", body: formData})
        .then(response => response.text()).then(data => {
        let parsedResponse = JSON.parse(data);
        if (parsedResponse[0] && parsedResponse[1]) {
            window.open('./', '_self').focus();
        } else {
            alert('email en of wachtwoord zijn incorrect');
        }
        return false;
    });
    return false;
}

// submit / validate register form
function frmRegister_Submit(form) {
    // Validate email
    const validateEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (form['email'].value === '') {
        alert('Vul een E-mail in.');
        return false;
    } else if (!validateEmail.test(form['email'].value.toLowerCase())) {
        alert('Vul een geldig E-mail adres in.');
        return false;
    }

    // Validate userName
    // no username given
    if (form['username'].value === '') {
        alert('Vul een Gebruikersnaam in.');
        return false;
    }
    // username too long
    if (form['username'].value.length > 20) {
        alert('Vul een kortere Gebruikersnaam in.');
        return false;
    }

    // Validate password
    // Validate lowercase letters
    const lowerCaseLetters = /[a-z]/g;
    if(!form['password'].value.match(lowerCaseLetters)) {
        alert('Het wachtwoord moet minimaal een kleine letter bevatten.');
        return false;
    }
    // Validate capital letters
    const upperCaseLetters = /[A-Z]/g;
    if(!form['password'].value.match(upperCaseLetters)) {
        alert('Het wachtwoord moet minimaal een hoofdletter bevatten.');
        return false;
    }
    // Validate numbers
    const numbers = /[0-9]/g;
    if(!form['password'].value.match(numbers)) {
        alert('Het wachtwoord moet minimaal een nummer bevatten');
        return false;
    }
    // Validate length
    if(form['password'].value.length < 8) {
        alert('Het wachtwoord moet minimaal acht characters bevatten. ' + form['password'].value.length + '/8');
        return false;
    }


    // Check if email or userName exists and hash password
    let formData = new FormData();
    formData.append('register', 'true');
    formData.append('email', form['email'].value);
    formData.append('username', form['username'].value);
    formData.append('password', form['password'].value);
    fetch('./backend/functions/userDB.php', {method: "POST", body: formData})
        .then(response => response.text()).then(data => {
        let parsedResponse = JSON.parse(data);
        if (!parsedResponse[0]) {
            alert('Gebruikersnaam bestaat al.');
            return false;
        } else if (parsedResponse[1]) {
            alert('E-mail is al geregistreerd.');
            return false;
        } else {
            window.open('./', '_self').focus();
        }
    });
    return false;
}