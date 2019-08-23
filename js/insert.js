var xmlreq;

function getXMLHttpRequestObject() {
    var request = null;
    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else if (window.ActiveXObject) { // Older IE.
        request = new ActiveXObject("MSXML2.XMLHTTP.3.0");
    }
    return request;
}


var currentCatNumber = 1;

function selectCategory(id){
    var facName = "fac"+id;
    currentCatNumber = id;
    var faculty = document.getElementById(facName).value;

    if(faculty == "")
        return;

    xmlreq = getXMLHttpRequestObject();

    url = encodeURI("./script/async_select_category.php" + "?faculty=" + faculty);

    xmlreq.onreadystatechange = asyncSelCategory;
    xmlreq.open("GET", url, true);
    xmlreq.send();
}

function asyncSelCategory() {
    if (xmlreq.readyState == 4) {
        if (xmlreq.status == 200) {
            if (xmlreq.responseText != null)
            {
                var catName = "cat"+currentCatNumber;
                document.getElementById(catName).innerHTML = xmlreq.responseText;
            }
            else alert("Ajax error: no data received");
        }
        else
            alert("Ajax error: " + xmlreq.statusText);
    }
}

function addNewCategory(){
    currentCatNumber = currentCatNumber + 1;
    document.getElementById("number_of_categories").value = currentCatNumber;

    xmlreq = getXMLHttpRequestObject();

    url = encodeURI("./script/async_add_category.php" + "?count=" + currentCatNumber);

    xmlreq.onreadystatechange = asyncAddCategory;
    xmlreq.open("GET", url, true);
    xmlreq.send();
}

function removeCategory(num){
    var facName = "fac"+num;
    var catName = "cat"+num;
    var butName = "removeButton"+num;

    document.getElementById(facName).selectedIndex = 0;
    document.getElementById(facName).remove();
    document.getElementById(catName).selectedIndex = 0;
    document.getElementById(catName).remove();
    document.getElementById(butName).remove();
}

function asyncAddCategory() {
    if (xmlreq.readyState == 4) {
        if (xmlreq.status == 200) {
            if (xmlreq.responseText != null)
            {
                document.getElementById("categories").insertAdjacentHTML('beforeend', xmlreq.responseText);
            }
            else alert("Ajax error: no data received");
        }
        else
            alert("Ajax error: " + xmlreq.statusText);
    }
}

