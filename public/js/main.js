$(window).load(function() {
    //initialise Stellar.js
    // $(window).stellar();

    goToScroll(window.topSlide, 'slide');

    // Drop down menu
    // $('li.main-menu').bind('mouseover',function () {
    //     $(this).find('ul.dropdown-menu').show();
    // }).bind('mouseleave',function () {
    //     $(this).find('ul.dropdown-menu').hide();
    // });

    $('li.main-menu > a[data-scroll]').click(function (e) {
        e.preventDefault();
        goToScroll($(this).attr('data-scroll'), 'slide');
    });

    // Drop down menu
    window.onresize = function() {
        windowResize();
    };
    windowResize();

    // On-top button controls
    // window.lastPosition = $(window).scrollTop();
    $(window).scroll(function() {
        var win = $(this);
        $('.slide').each(function () {
            if ($(this).offset().top <= win.scrollTop() && parseInt($(this).attr('data-menu'))) {
                $('.main-menu > a.active').removeClass('active');
                var scrollData = $(this).attr('data-slide');
                $('a[data-scroll=' + scrollData + ']').addClass('active');
            }
        });

        var button = $('#on_top_button');
        if (win.scrollTop() > win.outerHeight()) button.fadeIn();
        else button.fadeOut();
    });

    $('#on_top_button').click(function() {
        goToScroll(window.topSlide, 'slide');
        // $(window).scrollTop(0);
    });

    $('.button.bottom').click(function(e) {
        e.preventDefault();
        goToScroll($(this).attr('data-slide'), 'slide');
    });
});


function goToScroll(scrollData, scrollClass) {
    $('html,body').animate({
        scrollTop: $('.'+scrollClass+'[data-slide=' + scrollData + ']').offset().top
    }, 1000, 'easeInOutQuint');
}

function addLoaderScreen() {
    $('body').css('overflow','visible').append(
        $('<div></div>').attr('id','loader-screen').append(
            $('<img>').attr('src','../images/loader.gif')
        )
    );
}

function removeLoaderScreen() {
    $('body').css('overflow','auto');
    $('#loader-screen').remove();
}

function windowResize() {
    if ($(window).width() > 768) {
        var body = $('body'),
            navbarCont = $('.navbar-default'),
            navbar = $('.nav.navbar-nav'),
            phoneBlock = $('.phone_block'),
            logo = $('.logo'),
            phoneBlockOffset = parseInt(phoneBlock.css('left')),
            logoOffset = parseInt(logo.css('right'));

        if (body.width() < (phoneBlockOffset + phoneBlock.width() + navbar.width() + logo.width() + logoOffset)) {
            navbarCont.css('height',180);

            phoneBlock.css({
                'top':'35%'
            });

            navbar.css({
                'transform':'translate(-50%,0)',
                'top':110
            });

            logo.css({
                'top':'35%'
            });

        } else {
            navbarCont.css('height',120);

            phoneBlock.css({
                'top':'50%'
            });

            navbar.css({
                'transform':'translate(-50%,-50%)',
                'top':'50%'
            });

            logo.css({
                'top':'50%'
            });
        }

        var imageBlock = $('.slide > .image-block'),
            divSlides = $('.slide > div'),
            counter = 0;

        divSlides.each(function () {
            var height = body.height() - navbarCont.height(),
                self = $(this);

            if (counter >= divSlides.length - 2) {
                var parentSlide = self.parents('.slide');
                self.css('height',height - 48);
                parentSlide.css('height',height - 48);

            } else {
                self.css('height',height);
            }

            self.css('margin-top',navbarCont.height());
            counter++;
        });

        imageBlock.each(function () {
            var img = $(this).find('img');
            if (img.width() >= $(this).width()) {
                img.css({
                    'width':'100%',
                    'height':'auto'
                });
            } else {
                img.css({
                    'width':'auto',
                    'height':'100%'
                });
            }
        });
    }
}