document.addEventListener("DOMContentLoaded", (event) => {
    console.log("DOM fully loaded and parsed");

        // animation bouton NL

    var email = document.getElementById('email'),
    button = document.getElementById('button');

    function validateEmail(email) {
    var ex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return ex.test(email);
    };

    email.addEventListener('keydown', function() {
    var email = this.value;

    if(validateEmail(email)) {
    button.classList.add('is-active');
    }
    });

    button.addEventListener('click', function(e){
    e.preventDefault();
    this.classList.add('is-done','is-active');

    setTimeout(function(){ 
    button.innerHTML = "Votre abonnement est pris en compte 🤩"
    }, 500);
    });


  });


