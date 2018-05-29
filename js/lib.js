function stopCheckbox(e){
    event.stopPropagation();
}

function clientDetails(path){
    console.log("Ruta: " + path);
    window.location.href = path;
}