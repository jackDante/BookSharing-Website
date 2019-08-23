window.onload = function() {
	websocketallchat();
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

function websocketallchat(){
    xmlreq = getXMLHttpRequestObject();

    url = encodeURI("./script/async_socket_all_chat.php");
    xmlreq.onreadystatechange = check_socket_all_chat;
    xmlreq.open("GET", url, true);
    xmlreq.send();
}

function check_socket_all_chat() {
    if (xmlreq.readyState == 4) {
        if (xmlreq.status == 200) {
            if (xmlreq.responseText != null)
            {
                if (xmlreq.responseText != "0")
                {
                    var updates = xmlreq.responseText.split(',');
					for(var i = 0; i < updates.length; i++)
					{
						var fields = updates[i].split(" ");
                        for(var j = 0; j < fields.length; j+=2)
                        {
                        	if(fields[j+1] != null) {
                                var statName = "status" + fields[j];
                                document.getElementById(statName).innerHTML = '';
                                document.getElementById(statName).insertAdjacentHTML('beforeend', '<span class="label label-warning">Unread ('+fields[j+1]+')</span>');
                            }
                            else{
                                document.getElementById("all_messages").innerHTML = '';
                                document.getElementById("all_messages").insertAdjacentHTML('beforeend', "<a href='chat.php'><i class='icon-envelope icon-white'></i> Messagges <i class='fa fa-exclamation' style='color: red;'></i> ("+fields[j]+")</a>");
							}
                        }
					}
                    setTimeout(function() { websocketallchat(); }, 5000);
                }
                else{
                    setTimeout(function() { websocketallchat(); }, 5000);
                }
            }
            else alert("Ajax error: no data received");
        }
        else
            alert("Ajax error: " + xmlreq.statusText);
    }
}
