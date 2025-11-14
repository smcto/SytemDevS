$(document).ready(function() {
    $('.dropify').dropify({
        messages: {
            'default': 'Glissez-déposez un fichier ou cliquez ici',
            'replace': 'Glisser-déposer ou cliquez pour remplacer',
            'remove':  'Supprimer',
            'error':   'Une erreur est survenue. Veuillez réessayer plus tard.'
        }
    });

    tinymce.init({
        selector: '.textarea_editor',
        language: 'fr_FR',
        menubar: false,
        plugins: 'preview  emoticons searchreplace autolink directionality visualblocks visualchars fullscreen  link   template  table charmap hr pagebreak nonbreaking anchor  insertdatetime advlist lists  wordcount  imagetools textpattern noneditable help charmap quickbars code',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist  | forecolor backcolor casechange   removeformat  | fullscreen |  pageembed link table | code',
        relative_urls : false,
        remove_script_host : false,
        convert_urls : false,
        branding: false,
    });
});
