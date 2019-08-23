window.onload = function() {
    websocket();
};

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

function websocket(){
    xmlreq = getXMLHttpRequestObject();

    url = encodeURI("./script/async_socket.php");
    xmlreq.onreadystatechange = check_socket;
    xmlreq.open("GET", url, true);
    xmlreq.send();
}

function check_socket() {
    if (xmlreq.readyState == 4) {
        if (xmlreq.status == 200) {
            if (xmlreq.responseText != null)
            {
                if (xmlreq.responseText != "0")
                {
                    document.getElementById("all_messages").innerHTML = '';
                    document.getElementById("all_messages").insertAdjacentHTML('beforeend', xmlreq.responseText);
                    setTimeout(function() { websocket(); }, 5000);
                }
                else{
                    setTimeout(function() { websocket(); }, 5000);
                }
            }
            else alert("Ajax error: no data received");
        }
        else
            alert("Ajax error: " + xmlreq.statusText);
    }
}
