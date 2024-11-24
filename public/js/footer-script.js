// Back to top button
let mybutton = $("#btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
$(window).on("scroll", function() {
    scrollFunction();
});

function scrollFunction() {
    if ($(window).scrollTop() > 20) {
        mybutton.show();
    } else {
        mybutton.hide();
    }
}

// When the user clicks on the button, scroll to the top of the document
mybutton.on("click", function() {
    $("html, body").animate({ scrollTop: 0 }, "fast");
});

// Collapsible sections
$(".collapsible").each(function() {
    $(this).on("click", function() {
        $(this).toggleClass("active");
        var content = $(this).next();
        content.toggle(); // Toggles between display block and none
    });
});

//Opening and Closing Navbar on mobile
function openSidemenu() {
    document.body.classList.toggle('sb-sidenav-toggled');
    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
}