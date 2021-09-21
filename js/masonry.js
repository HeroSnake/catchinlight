window.addEventListener('load', function () {
    var elem = document.querySelector('.grid');
    var msnry = new Masonry(elem, {
        // options
        itemSelector: '.grid-item',
        columnWidth: 200
    });
    // element argument can be a selector string
    //   for an individual element
    var msnry = new Masonry('.grid', {
        // options
    });
    // if(this.screen.width > 1000){
    //     var hiddenSlides = document.getElementsByClassName('animate__animated');
    //     for (var i = 0; i < hiddenSlides.length; i++) {
    //         hiddenSlides[i].classList.add("invisible");
    //     }
    //     var animates = document.getElementsByClassName('carousel-item');
    //     for (var i = 0; i < animates.length; i++) {
    //         animates[i].addEventListener('mouseenter', (e) => {
    //             var child = (((((e.target.children[0]).children[0]).children[0]).children[1]).children[0]).children[2];
    //             child.classList.add("animate__fadeInRight");
    //             child.classList.remove("animate__fadeOutRight");
    //             child.classList.remove("invisible");
    //         })
    //         animates[i].addEventListener('mouseleave', (e) => {
    //             var child = (((((e.target.children[0]).children[0]).children[0]).children[1]).children[0]).children[2];
    //             child.classList.remove("animate__fadeInRight");
    //             child.classList.add("animate__fadeOutRight");
    //         })
    //     }
    // }
})