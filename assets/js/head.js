// Responsive navbar active animation
function activateNavbar() {
    var tabsNewAnim = $('#navbarSupportedContent');
    var activeItem = tabsNewAnim.find('.active');
    var activeWidthHeight = activeItem.innerHeight();
    var activeWidthWidth = activeItem.innerWidth();
    var itemPosTop = activeItem.position().top;
    var itemPosLeft = activeItem.position().left;

    $(".hori-selector").css({
        "top": itemPosTop + "px",
        "left": itemPosLeft + "px",
        "height": activeWidthHeight + "px",
        "width": activeWidthWidth + "px"
    });

    $("#navbarSupportedContent").on("click", "li", function () {
        $('#navbarSupportedContent ul li').removeClass("active");
        $(this).addClass('active');
        var activeHeight = $(this).innerHeight();
        var activeWidth = $(this).innerWidth();
        var itemPosTop = $(this).position().top;
        var itemPosLeft = $(this).position().left;
        $(".hori-selector").css({
            "top": itemPosTop + "px",
            "left": itemPosLeft + "px",
            "height": activeHeight + "px",
            "width": activeWidth + "px"
        });
    });
}

// Initialize on document ready
$(document).ready(function () {
    setTimeout(activateNavbar, 0);
});

// Reinitialize on window resize
$(window).on('resize', function () {
    setTimeout(activateNavbar, 500);
});

// Navbar-toggler animation
$(".navbar-toggler").click(function () {
    $(".navbar-collapse").slideToggle(300);
    setTimeout(activateNavbar, 300);
});
