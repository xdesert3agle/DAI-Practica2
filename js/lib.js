function stopCheckbox(e){
    event.stopPropagation();
}

function listElementDetails(path){
    window.location.href = path;
}

function showNewPhoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById("avatar").src = e.target.result;
        }
  
        reader.readAsDataURL(input.files[0]);
    }
}