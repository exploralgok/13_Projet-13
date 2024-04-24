jQuery(document).ready(function($) {
    $('#monFormulaire').submit(function(e) {
        console.log("form submit")
        e.preventDefault(); // Empêche la soumission du formulaire par défaut
        var formData = $(this).serialize(); // Sérialise les données du formulaire
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'montraitement',
                formData: formData
            },
            success: function(response) {
                $('#messageStatus').html(response); // Affiche la réponse
            },
            error: function(xhr, status, error) {
                console.log(error); // Affiche les erreurs dans la console
            }
        });
    });
});
