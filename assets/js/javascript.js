function startFinishSeason() {
    let start = document.getElementById('start').value;
    start = Number(start);
    let finish = start + 1;
    
    document.getElementById('finish').value = finish;
}

function useThis(sourceId, targetId) {

    let value = document.getElementById(sourceId).innerHTML;
    
    addValue(value, targetId);

    /*document.getElementById('general_button').addEventListener('click', function(){
        nameAssociation = document.getElementById('general_name_div').innerHTML;
        
        addValue(nameAssociation, 'name');*/

       
}


function addValue(value, elementId) {
    const elem = document.getElementById(elementId);
    elem.setAttribute("value", value);
} 