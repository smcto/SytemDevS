$(document).ready(function() {
    $('.dropify').dropify();
    
    $('.textarea_editor').summernote({
        height: '100%', //set editable area's height
        lang: 'fr-FR',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            // ['view', ['fullscreen', 'codeview', 'help']],
        ],
        onPaste: function (e) {
            var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
            e.preventDefault();
            setTimeout(function(){
                document.execCommand( 'insertText', false, bufferText );
            }, 10);
        }
    });
});