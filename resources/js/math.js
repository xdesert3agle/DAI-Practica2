function calcLinePrice(changedElement){
    let changedRowNumber = parseInt(changedElement.getAttribute('data-row'));
    let selReplacementList = document.getElementById('selectReplacementList' + changedRowNumber);
    let selectedReplacementPrice = parseInt(selReplacementList.options[selReplacementList.selectedIndex].getAttribute('data-price'));
    let selectedReplacementPercent = parseInt(selReplacementList.options[selReplacementList.selectedIndex].getAttribute('data-percent'));
    let units = parseInt(document.getElementById('units' + changedRowNumber).value);
    let amount = document.getElementById('rep' + changedRowNumber + '_amount');

    let changedRowPriceContainer = document.getElementById('row' + changedRowNumber + '_price');
    changedRowPriceContainer.value = units * selectedReplacementPrice;

    let gain = changedRowPriceContainer.value * (selectedReplacementPercent / 100);

    amount.innerHTML = !isNaN(changedRowPriceContainer.value) ? parseInt(changedRowPriceContainer.value) + gain + " €" : "0 €";
}

function changePrice(replacementList){
    let pattern = /\d+/g;

    let selectedReplacementPrice = replacementList.options[replacementList.selectedIndex].getAttribute('data-price');
    document.getElementById('rep' + replacementList.id.match(pattern) + '_price').innerText = selectedReplacementPrice + " €";

    let selectedReplacementPercent = replacementList.options[replacementList.selectedIndex].getAttribute('data-percent');
    document.getElementById('rep' + replacementList.id.match(pattern) + '_percent').innerText = selectedReplacementPercent + " %";
}

function doTheMath(){
    let numberOfLines = document.getElementById('billLines').rows.length;
    let base = document.getElementById('base');
    let iva = document.getElementById('iva');
    let total = document.getElementById('total');
    let pattern = '[+-]?([0-9]*[.])?[0-9]+';
    let workPrice = document.getElementById('workPrice').value;
    let calc = 0;

    for (var i = 1; i <= numberOfLines; i++){
        let amount = document.getElementById('rep' + i + "_amount").innerText.match(pattern);
        calc += !isNaN(parseFloat(amount)) ? parseFloat(amount) : 0;

        console.log(calc);
    }

    calc += parseFloat(workPrice);

    base.value = !isNaN(calc) ? calc : 0;
    iva.value = (base.value * 0.21).toFixed(2);
    total.value = parseFloat(base.value) + parseFloat(iva.value);
}

function calcWorkPrice(){
    let hours = document.getElementById('hours').value;
    let cph = document.getElementById('cph').value;
    cph.replace(",", ".");
    let workPrice = document.getElementById('workPrice');

    if (hours !== "" && cph !== ""){
        workPrice.value = hours * cph;
    } else {
        workPrice.value = 0;
    }


    doTheMath();
}