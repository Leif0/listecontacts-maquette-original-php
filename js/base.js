var creerXHR = function(){
    var xhr = null;

    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch(e) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } else {
            xhr = new XMLHttpRequest();
        }
    }else{
        return null;
    }
    return xhr;
};

var xhr = creerXHR();

var addClass = function(el, className){
    if (el.classList)
        el.classList.add(className);
    else
        el.className += ' ' + className;
}

var removeClass = function(el, className){
    if(el.classList){
        el.classList.remove(className);
    }
}

window.onload = function(){

    /***************************
        FORMULAIRE INSCRIPTION
     **************************/

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
    if(formulaireInscription){
        formulaireInscription.onsubmit = validerInscription;
    }

    /********************************************
        FORMULAIRE AJOUT/MODIFICATION DE CONTACT
     ********************************************/

    // Récupèrer le formulaire

    var formulaireAjoutModificationContact = document.querySelector('.formulaire.ajout-modification-contact');

    // Lorsque le formulaire est envoyé
    function validerAjoutModificationContact(event){
        var nom = document.getElementById("nom").value;
        var prenom = document.getElementById("prenom").value;
        var telephone = document.getElementById("telephone").value;
        var email = document.getElementById("email").value;
        var valide = true;

        var regexEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var regexTelephone = /[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}/;

        if(nom == '' || prenom == '' || telephone == '' || email == '') {
            alert ("Veuillez renseigner tous les champs");
            valide = false;
        }

        if (nom.length < 2) {
            alert ("Le nom doit comporter au moins 2 caractères");
            valide = false;
        }

        if (prenom.length < 2) {
            alert ("Le prenom doit comporter au moins 2 caractères");
            valide = false;
        }

        if (email.length < 6) {
            alert ("L'email doit comporter au moins 6 caractères");
            valide = false;
        }

        if(!regexEmail.test(email)){
            alert ("Email invalide");
            valide = false;
        }

        if(!regexTelephone.test(telephone)){
            alert ("Téléphone invalide");
            valide = false;
        }

        if(valide == false){
            event.preventDefault();
        }

    };

    // Attache l'évenement submit à la fonction
    if(formulaireAjoutModificationContact){
        formulaireAjoutModificationContact.onsubmit = validerAjoutModificationContact;
    }

    // Clic sur le bouton + pour afficher le reste de la description

    var plusInfos = document.querySelectorAll('.description .plus');

    for(var i=0; i<plusInfos.length; i++) {
        plusInfos[i].addEventListener('click', clickPlus, false);
    }

    function clickPlus(element){
        var parent = this.parentNode;
        addClass(parent, 'clickedPlus');

    }

    // Hover sur un bouton appeler ou contacter

    var hoverElement = function(caller, type){
        var parent = caller.parentNode.parentNode.parentNode.parentNode;
        var element = parent.querySelector('ul .'+type);
        addClass(element, 'hover');
    }

    var removeHover = function(caller, type, className){
        var parent = caller.parentNode.parentNode.parentNode.parentNode;
        var element = parent.querySelector('ul .'+type);
        removeClass(element, className);
    }

    var bouttonAppeler = document.querySelectorAll('.action.appeler');

    for(var i=0; i<bouttonAppeler.length; i++) {
        bouttonAppeler[i].addEventListener('mouseover', function() {
                hoverElement(this, 'telephone');
        }, false);

        bouttonAppeler[i].addEventListener('mouseleave', function() {
            removeHover(this, 'telephone', 'hover');
        }, false);
    }

    var bouttonContact = document.querySelectorAll('.action.contacter');

    for(var i=0; i<bouttonContact.length; i++) {
        bouttonContact[i].addEventListener('mouseover', function() {
            hoverElement(this, 'email');
        }, false);

        bouttonContact[i].addEventListener('mouseleave', function() {
            removeHover(this, 'email', 'hover');
        }, false);
    }
};