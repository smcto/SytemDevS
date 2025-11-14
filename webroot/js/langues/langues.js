$(document).ready(function () {
    $('.tinymce').tinymce({
            language: 'fr_FR',
            menubar: false,
            plugins: ['advlist autolink link imagetools spellchecker lists autoresize'],        
            toolbar: 'bold italic underline strikethrough |numlist bullist| link removeformat ',
            relative_urls : false,
            contextmenu: false,
            remove_script_host : false,
            convert_urls : false,
            branding: false,
            statusbar: false,
        });
});