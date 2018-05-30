function stopCheckbox(e){
    event.stopPropagation();
}

function clientDetails(path){
    window.location.href = path;
}

function init(){
    var avatar = document.getElementById('avatar');

    avatar.addEventListener("change", function(event) {
        if (event.attrName == "src") {
            var newAvatar = this.files[0];

    var url = window.URL.createObjectURL(newAvatar);

    avatar.src = url;
        }
    });
}