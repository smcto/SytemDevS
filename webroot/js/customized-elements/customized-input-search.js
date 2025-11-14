$(document).ready(function(){

    // === Add active class to customized-input-search ===

    $(document).on('click, focusin', '.customized-input-search input', function(e) {
    //$('.customized-input-search input').on('click, focusin', function(){

        $(this).parents('.customized-input-search').addClass('active');

    });

    // === End of section to Add active class to customized-input-search ===


    // === Remove active class from customized-input-search ===
    $(document).on('blur', '.customized-input-search input', function(e) {
    //$('.customized-input-search input').on('blur', function(){

        $(this).parents('.customized-input-search').removeClass('active');

    });

    // === End of section to Remove active class from customized-input-search ===

});
