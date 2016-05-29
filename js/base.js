// Vérification de l'inscription

window.onload = function(){

    // Récupèrer le formulaire

    var formulaireInscription = document.querySelector('.formulaire.inscription');

    // Lorsque le formulaire est envoyé
    function validerInscription(event){
        var login = document.getElementById("login").value;
        var password = document.getElementById("password").value;
        var email = document.getElementById("email").value;
        var valide = true;

        var regexEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        if(login == '' || password == '' || email == '') {
            alert ("Veuillez renseigner tous les champs");
            valide = false;
        }

        if (login.length < 2) {
            alert ("Votre login doit comporter au moins 2 caractères");
            valide = false;
        }

        if (password.length < 6) {
            alert ("Votre mot de passe doit comporter au moins 6 caractères");
            valide = false;
        }

        if (email.length < 6) {
            alert ("Votre email doit comporter au moins 6 caractères");
            valide = false;
        }

        if(!regexEmail.test(email)){
            alert ("Email invalide");
            valide = false;
        }

        if(valide == false){
            event.preventDefault();
        }

    };

    // Attache l'évenement submit à la fonction
    formulaireInscription.onsubmit = validerInscription;

};