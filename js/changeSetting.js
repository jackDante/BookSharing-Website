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

function removeErrorChange(){
    document.getElementById("errorSettingsBox").innerHTML = "<br>";
    document.getElementById("userChange").style.borderColor = "white";
    document.getElementById("emailChange").style.borderColor = "white";
    document.getElementById("dateChange").style.borderColor = "white";
    document.getElementById("surnameChange").style.borderColor = "white";
    document.getElementById("gender").style.borderColor = "white";
    document.getElementById("cityChange").style.borderColor = "white";

}


function checkuser(user){
    var regexp1=/^[a-zA-Z0-9]+$/;
    test = regexp1.test(user);
    return test;
}

function checkemail(email){
    var regexp1=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,3}))$/;
    test = regexp1.test(email);
    return test;

}

function checkdate(date){
    var regEx = /^\d{4}-\d{2}-\d{2}$/;
    var dtArray = date.match(regEx); // is format OK?

    if (dtArray == null)
        return false;

    //Checks for mm/dd/yyyy format.
    dtMonth = dtArray[1];
    dtDay= dtArray[3];
    dtYear = dtArray[5];

    if (dtMonth < 1 || dtMonth > 12)
        return false;
    else if (dtDay < 1 || dtDay> 31)
        return false;
    else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
        return false;
    else if (dtMonth == 2)
    {
        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
        if (dtDay> 29 || (dtDay ==29 && !isleap))
            return false;
    }

    var d1 = new Date(date);
    var d2 = new Date();
    if(d1.getTime() >= d2.getTime())
        return false;
    return true;
}

function checkname(name){
    var regexp1=/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/;
    test = regexp1.test(name);
    return test;
}

function checkSettings(){
    var user = document.getElementById("userChange").value;
    var email = document.getElementById("emailChange").value;
    var date = document.getElementById("dateChange").value;
    var name = document.getElementById("nameChange").value;
    var surname = document.getElementById("surnameChange").value;
    var gender = document.getElementById("gender").value;
    var city = document.getElementById("cityChange").value;

    var checks = 0;
    if(user.length == 0 || !checkuser(user)) {
        document.getElementById("userChange").style.borderColor = "red";
        checks = 1;
    }
    if(email.length == 0  || !checkemail(email)) {
        document.getElementById("emailChange").style.borderColor = "red";
        checks = 1;
    }
    if(name.length == 0 || !checkname(name)) {
        document.getElementById("nameChange").style.borderColor = "red";
        checks = 1;
    }
    if(surname.length == 0 || !checkname(surname)) {
        document.getElementById("surnameChange").style.borderColor = "red";
        checks = 1;
    }

    if(date == "" || !checkdate(date)) {
        document.getElementById("dateChange").style.borderColor = "red";
        checks = 1;
    }
    if(gender == "not-selected") {
        document.getElementById("gender").style.borderColor = "red";
        checks = 1;
    }
    if(city == "not-selected") {
        document.getElementById("cityChange").style.borderColor = "red";
        checks = 1;
    }
	
    if(checks >= 1){
        document.getElementById("errorSettingsBox").innerHTML = "Some Data are missing or wrong!";
        return;
    }
    
	
    xmlreq = getXMLHttpRequestObject();

    url = encodeURI("./script/async_checkemailModify.php" + "?email=" + email+"&username=" + user);
    xmlreq.onreadystatechange = asyncEmail;
    xmlreq.open("GET", url, true);
    xmlreq.send();
}

function asyncEmail() {
    if (xmlreq.readyState == 4) {
        if (xmlreq.status == 200) {
            if (xmlreq.responseText != null)
            {
                if (xmlreq.responseText == "ok"){
					document.settingsForm.submit();
				}
                else if(xmlreq.responseText == "email") {
                    document.getElementById("errorSettingsBox").innerHTML = "Email Already Taken!";
                    document.getElementById("emailChange").style.borderColor = "red";
                }
            }
            else alert("Ajax error: no data received");
        }
        else
            alert("Ajax error: " + xmlreq.statusText);
    }
}

/*
function selectCity(){
    var province = document.getElementById("province").value;

    if(province == "not-selected")
        return;

    xmlreq = getXMLHttpRequestObject();

    url = encodeURI("./script/async_select_city.php" + "?province=" + province);

    xmlreq.onreadystatechange = asyncSelCity;
    xmlreq.open("GET", url, true);
    xmlreq.send();
}

function asyncSelCity() {
    if (xmlreq.readyState == 4) {
        if (xmlreq.status == 200) {
            if (xmlreq.responseText != null)
            {
                document.getElementById("cityChange").innerHTML = xmlreq.responseText;
            }
            else alert("Ajax error: no data received");
        }
        else
            alert("Ajax error: " + xmlreq.statusText);
    }
}
*/

function removeErrorSignup(){
    document.getElementById("errorSettingsBox").innerHTML = "<br>";
    document.getElementById("emailChange").style.borderColor = "white";
    document.getElementById("nameChange").style.borderColor = "white";
    document.getElementById("surnameChange").style.borderColor = "white";
    document.getElementById("dateChange").style.borderColor = "white";
    document.getElementById("gender").style.borderColor = "white";
    document.getElementById("cityChange").style.borderColor = "white";
}

document.addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode === 13) {
            checkSettings();
    }
});
