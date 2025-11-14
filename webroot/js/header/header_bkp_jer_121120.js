$(document).ready(function(){

    // === Declare and initialize global variables ===

    var responsiveDesktopScreen = 1288;
    var elementComputedStyle = window.getComputedStyle(document.documentElement);

    // === End of section to Declare and initialize global variables ===


    // === Display sub-nav-wrapper for user on Header ===

    $(document).on('click', 'header .inner-header-wrapper .header-avatar-wrapper .outer-avatar-wrap', function(){

        $(this).parents('.inner-header-avatar-wrapper').find('.sub-nav-wrapper').toggleClass('display');
        $(this).parents('.inner-header-avatar-wrapper').find('.sub-nav-wrapper').toggleClass('animate__flipInY');

    });

    $(document).on('click', function(e){

        let userSubNavWrapper = $('header .inner-header-wrapper .header-avatar-wrapper .inner-header-avatar-wrapper .sub-nav-wrapper');

        if( $(e.target).closest( $('header .inner-header-wrapper .header-avatar-wrapper .outer-avatar-wrap') ).length === 0 && $(e.target).closest( userSubNavWrapper ).length === 0  ) {

            userSubNavWrapper.removeClass('display');
            userSubNavWrapper.removeClass('animate__flipInY');
        }

    });

    // === End of section to Display sub-nav-wrapper for user on Header ===


    // === Display Responsive Menu ===

    var mainMenuUrls = [];
    var mainMenuTexts = [];
    var countMainMenus = 0;

    $(document).on('click', 'header .inner-header-wrapper .burger-menu-wrap', function(){

        $(this).toggleClass('active');

        if( window.matchMedia('(min-width: 768px)').matches && window.matchMedia('(max-width: ' + responsiveDesktopScreen + 'px)').matches ) {

            $(this).parents('header').find('.inner-header-wrapper .nav-wrapper').toggleClass('display');
            $(this).parents('header').find('.inner-header-wrapper .header-avatar-wrapper').toggleClass('display');
            $(this).parents('header').find('.inner-header-wrapper .header-settings-wrapper').toggleClass('display');

        } else if( window.matchMedia('(max-width: 767px)').matches ) {

            $(this).parents('header').find('.inner-header-wrapper .main-header-right-section').toggleClass('display');

            $('header .inner-header-wrapper .nav-wrapper').removeClass('customized-scrollbar');

            $('header .inner-header-wrapper .header-search-wrapper .sub-nav-wrapper').prepend('<svg class="close-zone-icon" viewBox="0 0 511.058 511.058"><path d="M511.058 60.811L450.247 0 255.529 194.718 60.811 0 0 60.811l194.718 194.718L0 450.247l60.811 60.811L255.529 316.34l194.718 194.718 60.811-60.811L316.34 255.529z"/></svg>');

            //$('header .inner-header-wrapper .header-search-wrapper .sub-nav-wrapper').prepend('<svg class="close-zone-icon" viewBox="0 0 348.333 348.334"><path d="M336.559 68.611L231.016 174.165l105.543 105.549c15.699 15.705 15.699 41.145 0 56.85-7.844 7.844-18.128 11.769-28.407 11.769-10.296 0-20.581-3.919-28.419-11.769L174.167 231.003 68.609 336.563c-7.843 7.844-18.128 11.769-28.416 11.769-10.285 0-20.563-3.919-28.413-11.769-15.699-15.698-15.699-41.139 0-56.85l105.54-105.549L11.774 68.611c-15.699-15.699-15.699-41.145 0-56.844 15.696-15.687 41.127-15.687 56.829 0l105.563 105.554L279.721 11.767c15.705-15.687 41.139-15.687 56.832 0 15.705 15.699 15.705 41.145.006 56.844z"/></svg>');

        }

        if( !$(this).hasClass('active') ) {

            $(this).parents('header').find('.inner-header-wrapper .nav-wrapper .nav-block').removeClass('open');
            $(this).parents('header').find('.inner-header-wrapper .nav-wrapper .nav-block .sub-nav-wrapper').css( 'max-height', '0' );

        }

        // --***-- Add hyperlinked main nav wrapper as sub-menu --***--

        if( !mainMenuUrls.length ) {

            $('header .inner-header-wrapper .nav-wrapper .nav-block').each(function(){

                mainMenuUrls.push( $(this).find('a.main-nav-wrapper').attr('href') );
                mainMenuTexts.push( $(this).find('a.main-nav-wrapper .text').text() );

                $(this).find('a.main-nav-wrapper').parents('.nav-block').find('.sub-nav-wrapper').prepend('<a href="' + mainMenuUrls[countMainMenus] + '" class="sub-nav-block responsive-sub-item">' + mainMenuTexts[countMainMenus] + '</a>');

                countMainMenus++;

            });

        }

        $('header .inner-header-wrapper .nav-wrapper .nav-block').each(function(){

            // Unset url for hyperlinked main nav wrapper
            $(this).find('a.main-nav-wrapper').attr('href', '#');

            // Add down arrow icon to main nav wrapper when necessary
            if( !$(this).find('.sub-nav-wrapper a.responsive-sub-item').parents('.nav-block').find('.main-nav-wrapper svg.down-arrow-icon').length && $(this).find('.sub-nav-wrapper a.responsive-sub-item').parents('.nav-block').find('.main-nav-wrapper').is('a') ) {

                // Call function to add main menu arrow icon
                addMainMenuArrow( $(this) );
            }

        });

        // --***-- End of section to Add hyperlinked main nav wrapper as sub-menu --***--


    });

    // === End of section to Display Responsive Menu ===



    // === Reset header on initial desktop screen on window resize ===

    $(window).resize(function(){

        // ---***--- Reset responsive menu for desktop when resizing window on desktop initial screen ---***---

        if( window.matchMedia('(min-width: ' + ( responsiveDesktopScreen + 1 ) + 'px)').matches && mainMenuUrls.length ) {

            // Call function to reset responsive menu for desktop
            resetMenuForRespDesktop( elementComputedStyle.getPropertyValue('--navWrapperSubMaxHeight') );

            // --***-- Reset urls for main menus --***--

            $('header .inner-header-wrapper .nav-wrapper .nav-block').each(function(){

                $(this).find('a.main-nav-wrapper').attr( 'href', $(this).find('.sub-nav-wrapper a.responsive-sub-item').attr('href') );

                // Remove down arrow icon from main menu when necessary
                if( $(this).find('.sub-nav-wrapper .sub-nav-block').length == 1 && $(this).find('.sub-nav-wrapper .sub-nav-block').hasClass('responsive-sub-item') ) {

                    $(this).find('.main-nav-wrapper svg.down-arrow-icon').remove();
                }

            });

        }


        // ---***--- Reset responsive menu for mobile when resizing window on screen larger than mobile screen ---***---

        if( window.matchMedia('(min-width: 768px)').matches && mainMenuUrls.length ) {

            $('header .inner-header-wrapper .main-header-right-section').removeClass('display');
            $('header .inner-header-wrapper .nav-wrapper').addClass('customized-scrollbar');
            $('header .inner-header-wrapper .header-search-wrapper .sub-nav-wrapper svg.close-zone-icon').remove();
        }



        // ---***--- Reset responsive menu for desktop when resizing window on mobile screen ---***---

        if( window.matchMedia('(max-width: 767px)').matches && mainMenuUrls.length ) {

            if( !$('header .inner-header-wrapper .main-header-right-section').hasClass('display') ) {

                $('header .inner-header-wrapper .burger-menu-wrap').removeClass('active');
            }

            // Call function to reset responsive menu for desktop
            resetMenuForRespDesktop('0');

        }

        // ---***--- End of section to Reset responsive menu for desktop when resizing window on mobile screen ---***---


    });


    // === End of section to Reset header on initial desktop screen on window resize ===


    // === Function to reset responsive menu for desktop ===

    function resetMenuForRespDesktop(maxHeight) {

        $('header .inner-header-wrapper .burger-menu-wrap').removeClass('active');
        $('header .inner-header-wrapper .nav-wrapper').removeClass('display');
        $('header .inner-header-wrapper .nav-wrapper .nav-block').removeClass('open');
        $('header .inner-header-wrapper .nav-wrapper .nav-block .sub-nav-wrapper').css( 'max-height', maxHeight );
        $('header .inner-header-wrapper .header-avatar-wrapper').removeClass('display');
        $('header .inner-header-wrapper .header-settings-wrapper').removeClass('display');
    }

    // === End of Function to reset responsive menu for desktop ===



    // === Display Responsive Sub-Menu ===

    $(document).on('click', 'header .inner-header-wrapper .nav-wrapper .nav-block', function(){

        if( window.matchMedia('(max-width: ' + responsiveDesktopScreen + 'px)').matches ) {

            $(this).toggleClass('open');

            var subNavWrapper = $(this).find('.sub-nav-wrapper');

            if( $(this).hasClass('open') ) {

                subNavWrapper.css( 'max-height', subNavWrapper[0].scrollHeight + 'px' );

            } else {

                subNavWrapper.css( 'max-height', '0' );
            }

            $('header .inner-header-wrapper .nav-wrapper .nav-block').not(this).each(function(){

                $(this).removeClass('open');
                $(this).find('.sub-nav-wrapper').css( 'max-height', '0' );

            });

        }

    });

    // === End of section to Display Responsive Sub-Menu ===


    // === Reset desktop responsive menu when clicking outside of it ===

    $(document).on('click', function(e){

        if( window.matchMedia('(min-width: 768px)').matches && window.matchMedia('(max-width: ' + responsiveDesktopScreen + 'px)').matches ) {

            if( $(e.target).closest( $('header .inner-header-wrapper .burger-menu-wrap') ).length === 0 && $(e.target).closest( $('header .inner-header-wrapper .nav-wrapper') ).length === 0 && $(e.target).closest( $('header .inner-header-wrapper .header-settings-wrapper') ).length === 0 && $(e.target).closest( $('header .inner-header-wrapper .header-avatar-wrapper') ).length === 0 ) {

                // Call function to reset responsive menu for desktop
                resetMenuForRespDesktop('0');
            }

        }

    });

    // === End of section to Reset desktop responsive menu when clicking outside of it ===


    // === Function to add Main menu arrow icon ===

    function addMainMenuArrow( currentNavBlock ) {

        currentNavBlock.find('.main-nav-wrapper').append('<svg class="down-arrow-icon" viewBox="0 0 491.996 491.996"><path d="M484.132 124.986l-16.116-16.228c-5.072-5.068-11.82-7.86-19.032-7.86-7.208 0-13.964 2.792-19.036 7.86l-183.84 183.848L62.056 108.554c-5.064-5.068-11.82-7.856-19.028-7.856s-13.968 2.788-19.036 7.856l-16.12 16.128c-10.496 10.488-10.496 27.572 0 38.06l219.136 219.924c5.064 5.064 11.812 8.632 19.084 8.632h.084c7.212 0 13.96-3.572 19.024-8.632l218.932-219.328c5.072-5.064 7.856-12.016 7.864-19.224 0-7.212-2.792-14.068-7.864-19.128z"/></svg>');
    }

    // === End of Function to add Main menu arrow icon ===


    // === Add down arrow icon to menu having sub-menus on Header ===

    $('header .inner-header-wrapper .nav-wrapper .nav-block').each(function(){

        // Add sub nav wrapper to menu nav block when necessary
        if( !$(this).find('.sub-nav-wrapper').length ) {

            $(this).append('<div class="sub-nav-wrapper customized-scrollbar"></div>');
        }

        // Add down arrow icon to main menu when necessary
        if( $(this).find('.sub-nav-wrapper .sub-nav-block').length > 0 && !$(this).find('.sub-nav-wrapper .sub-nav-block').hasClass('responsive-sub-item') ) {

            // Call function to add main menu arrow icon
            addMainMenuArrow( $(this) );
        }

    });

    // === End of section to Add down arrow icon to menu having sub-menus on Header ===



    // === Scroll back to top of sub-menu when mouse cursor leaves it on Header ===

    $('header .inner-header-wrapper .nav-wrapper .nav-block .sub-nav-wrapper').on('mouseleave', function(){

        $(this).scrollTop(0);

    });

    // === End of section to Scroll back to top of sub-menu when mouse cursor leaves it on Header ===



    // === Customized styles for Firefox on Header ===

    if( navigator.userAgent.indexOf("Firefox") > -1 ) {

        $('.customized-scrollbar').css({

            'overflow-y': 'auto'

        });

        //$('header .inner-header-wrapper .nav-wrapper .nav-block .sub-nav-wrapper').css('max-height', '330px');

        $('.customized-scrollbar').removeClass('customized-scrollbar');

    }

    // === End of Customized styles for Firefox on Header ===


    // === Display or hide search sub nav wrapper ===

    // Get search sub nav wrapper
    var searchSubNav = $('header .inner-header-wrapper .header-search-wrapper .sub-nav-wrapper');


    //$(document).on('click keyup', 'header .inner-header-wrapper .header-search-wrapper .header-search-wrap input.header-input-search', function(){

    $(document).on('click keypress', 'header .inner-header-wrapper .header-search-wrapper .header-search-wrap input.header-input-search', function(){

        // Check if header input search is empty and uncheck all checkboxes for search zone
        if( !searchSubNav.parents('.header-search-wrapper').find('input.header-input-search').val() && !searchSubNav.hasClass('display') ) {

            searchSubNav.find('.search-zone-wrapper .zone-block').removeClass('checked');
            searchSubNav.find('.search-zone-wrapper .zone-block input[type="checkbox"]').prop('checked', false);

        }

        // Display search sub nav wrapper
        $(this).parents('.header-search-wrapper').find('.sub-nav-wrapper').addClass('display').addClass('animate__bounceInDown');

    });

    $(document).on('mousemove', function(e){

        if( $(e.target).closest( $('header') ).length === 0 && $(e.target).closest( $('header .inner-header-wrapper .header-search-wrapper .sub-nav-wrapper.display') ).length === 0 ) {

            // Call function to remove search sub nav wrapper
            removeSearchSubNav();
        }

    });

    $(document).on('mouseover', 'header .inner-header-wrapper .nav-wrapper .nav-block, header .inner-header-wrapper .header-avatar-wrapper .outer-avatar-wrap, header .inner-header-wrapper .header-settings-wrapper .inner-header-settings-wrap, header .inner-header-wrapper .burger-menu-wrap',function(){

        // Call function to remove search sub nav wrapper
        removeSearchSubNav();

    });

    $(document).on('click', 'header .inner-header-wrapper .header-search-wrapper .sub-nav-wrapper svg.close-zone-icon',function(){

        // Call function to remove search sub nav wrapper
        removeSearchSubNav();

    });

    $(document).on('keyup', function(e){

        if( e.key === 'Escape' ) {

            // Call function to remove search sub nav wrapper
            removeSearchSubNav();
        }

    });

    $(document).on('click', 'header .inner-header-wrapper .header-search-wrapper .sub-nav-wrapper #btn-header-search', function(){

        // Check if at least one checkbox is checked

        if( searchSubNav.find('.search-zone-wrapper .zone-block .checkbox-wrap input[type="checkbox"]:checked').length > 0 ) {

            // Call function to remove search sub nav wrapper
            removeSearchSubNav();

            // Clear search input text
            searchSubNav.parents('.header-search-wrapper').find('input.header-input-search').val('');
            searchSubNav.parents('.header-search-wrapper').find('input.header-input-search').focus();

        }

    });


    // -- Function to remove search sub nav wrapper --

    function removeSearchSubNav() {

        searchSubNav.removeClass('display').removeClass('animate__bounceInDown');

        // Check if header input search is empty and uncheck all checkboxes for search zone
        /* if( !searchSubNav.parents('.header-search-wrapper').find('input.header-input-search').val() ) {

            searchSubNav.find('.search-zone-wrapper .zone-block').removeClass('checked');
            searchSubNav.find('.search-zone-wrapper .zone-block input[type="checkbox"]').prop('checked', false);

        } */

    }

    // -- End of Function to remove search sub nav wrapper --


    // === End of section to Display or hide search sub nav wrapper ===



    // === Check checkbox for search zone on Header ===

    $(document).on('click', 'header .inner-header-wrapper .header-search-wrapper .sub-nav-wrapper .search-zone-wrapper .zone-block', function(){

        $(this).toggleClass('checked');

        if( $(this).hasClass('checked') ) {

            $(this).find('input[type="checkbox"]').prop('checked', true);

        } else {

            $(this).find('input[type="checkbox"]').prop('checked', false);
        }

    });

    // === End of section to Check checkbox for search zone on Header ===




});
