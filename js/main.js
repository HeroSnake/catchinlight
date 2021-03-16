window.addEventListener('load', function() {
    registerSW();
    setTimeout(removeLoader); //wait for page load PLUS two seconds.
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

    registerSW();
    var likes = document.getElementsByClassName('change-icon');
    for (var i = 0; i < likes.length; i++) {
        likes[i].addEventListener("click", function toggleLike(element){
            var element = element.target.parentNode;
            var gallery_id = element.name;
            var image_id = element.id;
            var liked;
            //AJAX
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "controllers/like.php", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = this.responseText;
                }
            };
            if(element.children[0].style.display != "none"){    //+1 LIKE
                element.children[0].style.display = "none";
                element.children[1].style.display = "inherit";
                liked = true;
                element.nextElementSibling.innerHTML = parseInt(element.nextElementSibling.innerHTML) + 1;
            }else{                                              //-1 LIKE
                element.children[0].style.display = "inherit";
                element.children[1].style.display = "none";
                liked = false;
                element.nextElementSibling.innerHTML = parseInt(element.nextElementSibling.innerHTML) - 1;
            }
            var data = {like:liked,gallery_id:gallery_id,image_id:image_id};
            xhttp.send(JSON.stringify(data));
        });
    }

    //MASONRY
    var elem = document.querySelector('.grid');
    var msnry = new Masonry( elem, {
    // options
    itemSelector: '.grid-item',
    columnWidth: 200
    });

    // element argument can be a selector string
    //   for an individual element
    var msnry = new Masonry( '.grid', {
    // options
    });
});

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
function removeLoader(){
    $( "#loadingDiv" ).fadeOut(500, function() {
        // fadeOut complete. Remove the loading div
        $( "#loadingDiv" ).remove(); //makes page more lightweight 
        $( "#pageAwait" ).css('visibility', 'visible');
    });  
}
