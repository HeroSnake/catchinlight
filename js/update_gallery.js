window.addEventListener('load', function () {
    var inputs = document.getElementsByClassName('toggleSubCat');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener('click', (e) => {
            var gallery_id = e.target.name;
            var checked = e.target.checked ? 1 : 0;
            //AJAX
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "../controllers/gallery_edit_ajax.php", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var response = this.responseText;
                    console.log(response);
                }
            };
            var data = { sub_cat: checked, gallery_id: gallery_id };
            xhttp.send(JSON.stringify(data));
        });
    }
    var visibles = document.getElementsByClassName('toggleVisibility');
    for (var i = 0; i < visibles.length; i++) {
        visibles[i].addEventListener('click', (e) => {
            var gallery_id = e.target.name;
            var checked = e.target.title;
            e.target.title = e.target.title == "1" ? "0" : "1";
            //AJAX
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "../controllers/gallery_edit_ajax.php", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var response = this.responseText;
                    if(checked == 0){
                        e.target.classList.remove("fa-eye");
                        e.target.classList.add("fa-eye-slash");
                    }else{
                        e.target.classList.remove("fa-eye-slash");
                        e.target.classList.add("fa-eye");
                    }
                }
            };
            var data = { visible: checked, gallery_id: gallery_id };
            xhttp.send(JSON.stringify(data));
        });
    }
})