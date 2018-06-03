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

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}