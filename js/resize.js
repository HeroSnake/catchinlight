window.addEventListener('load', function() {
    let arrayDiv = Array.from(document.getElementById('gallery').children);
    let array_bis = [];

    arrayDiv.forEach(function(el, index){
        array_bis[index] = { element: el , height_img: el.children[2].firstElementChild.clientHeight };
    })

    array_bis.forEach(function(el) {
        el['element'].style.height = el['height_img'] + "px";
    })
});