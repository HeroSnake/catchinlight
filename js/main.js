window.addEventListener('load', function() {
    //Display video thumbnail
    $videos = $('div .modal fade');

    $('.fade').each(function(){
        $(this).on('hidden.bs.modal', function (e) {
            // do something...
            $(this, 'iframe').attr("src", $(this, 'iframe').attr('src'));
        });
    });

    $('img').each(function() {
        $(this).attr("src", $(this).attr("original"));
    });

    // this will disable dragging of all images
    $("img").mousedown(function(e) {
        e.preventDefault()
    });

    // this will disable right-click on all images
    $("img").on("contextmenu", function(e) {
        return false;
    });

    //Slide content on click
    // $(".flip").click(function(){
    //     $(this).find(".panel").slideToggle("slow");
    // });
    registerSW();
});

window.addEventListener("cookieAlertAccept", function() {
    alert("cookies accepted")
})

function toggleLike(){
    
}

async function registerSW(){
    if('serviceWorker' in navigator){
        try{
            await navigator.serviceWorker.register('./sw.js');
        } catch (e){
            console.log('SW registration failed');
        }
    }
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

$(document).ready(function(){
	$(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    // scroll body to 0px on click
    $('#back-to-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 400);
        return false;
    });
});
