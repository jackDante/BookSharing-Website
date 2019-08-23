var xmlreq;


function show(target) {
    document.getElementById(target).style.visibility = 'visible';
    document.getElementById(target).style.overflow = 'auto';
    document.getElementById(target).style.height = 'auto';
    if(target == "signUpForm")
    {
        document.getElementById(target).style.marginTop = '-80px';
    }
};


function hide(target) {
    document.getElementById(target).style.visibility = 'hidden';
    document.getElementById(target).style.overflow = 'hidden';
    document.getElementById(target).style.height = '0';
};


function checkBeforeSubmit(){
    //fai cose

    document.signup.submit();
}



function getXMLHttpRequestObject() {
	var request = null;
	if (window.XMLHttpRequest) {
	    request = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // Older IE.
	    request = new ActiveXObject("MSXML2.XMLHTTP.3.0");
	}
	return request;
}



function ajaxcheckPassword(){
	var user = document.getElementById("usernameLog").value;
    var password = document.getElementById("pswLog").value;

    if(user.length == 0 || password.length == 0) {
        document.getElementById("errorLoginBox").innerHTML = "Username or Password Missing!";
        return;
    }
    
    var encrypt_psw = SHA1(password);
	document.getElementById("pswEncryptLog").value = encrypt_psw;

	xmlreq = getXMLHttpRequestObject();

	url = encodeURI("./script/async_login.php" + "?username=" + user + "&password=" + encrypt_psw);
	xmlreq.onreadystatechange = checklogin;
	xmlreq.open("GET", url, true);
	xmlreq.send();
}



function checklogin() {
	if (xmlreq.readyState == 4) {
		if (xmlreq.status == 200) {
			if (xmlreq.responseText != null)
			{
				if (xmlreq.responseText == "ok")
				{
					document.getElementById("pswLog").value = "";
					document.login.submit();
				}
				else
				    document.getElementById("errorLoginBox").innerHTML = "Wrong Username or Password!";
			}
			else alert("Ajax error: no data received");
		}
		else
		alert("Ajax error: " + xmlreq.statusText);
	}
}



function removeError(){
    document.getElementById("errorLoginBox").innerHTML = "<br>";
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



function checkSignUp(){
    var user = document.getElementById("userSign").value;
    var email = document.getElementById("emailSign").value;
    var password = document.getElementById("pswSign").value;
    var passwordconfirm = document.getElementById("pswConfirmSign").value;
    var date = document.getElementById("dateSign").value;
    var name = document.getElementById("nameSign").value;
    var surname = document.getElementById("surnameSign").value;
    var gender = document.getElementById("gender").value;
    var city = document.getElementById("citySign").value;
    var checkbox = document.getElementById("checkboxSign").checked;

    var checks = 0;

    if(user.length == 0 || !checkuser(user)) {
        document.getElementById("userSign").style.borderColor = "red";
        checks = 1;
    }
    if(email.length == 0  || !checkemail(email)) {
        document.getElementById("emailSign").style.borderColor = "red";
        checks = 1;
    }
    if(password.length == 0 ) {
        document.getElementById("pswSign").style.borderColor = "red";
        checks = 1;
    }
    if(passwordconfirm.length == 0 ) {
        document.getElementById("pswConfirmSign").style.borderColor = "red";
        checks = 1;
    }
    else {
        if (passwordconfirm != password) {
            document.getElementById("pswConfirmSign").style.borderColor = "red";
            document.getElementById("errorSignupBox").innerHTML = "The Confirm Password is different!";
            return;
        }
    }
    if(name.length == 0 || !checkname(name)) {
        document.getElementById("nameSign").style.borderColor = "red";
        checks = 1;
    }
    if(surname.length == 0 || !checkname(surname)) {
        document.getElementById("surnameSign").style.borderColor = "red";
        checks = 1;
    }

    if(date == "" || !checkdate(date)) {
        document.getElementById("dateSign").style.borderColor = "red";
        checks = 1;
    }
    if(gender == "not-selected") {
        document.getElementById("gender").style.borderColor = "red";
        checks = 1;
    }
    if(city == "not-selected") {
        document.getElementById("citySign").style.borderColor = "red";
        checks = 1;
    }
    if(checkbox == false)
    {
        document.getElementById("errorSignupBox").innerHTML = "You Must Agree with the Terms & Conditions!";
        return;
    }

    if(checks >= 1){
        document.getElementById("errorSignupBox").innerHTML = "Some Data are Missing or Wrong!";
        return;
    }
        
    var encrypt_psw = SHA1(password);
	document.getElementById("pswEncryptSign").value = encrypt_psw;

    xmlreq = getXMLHttpRequestObject();

    url = encodeURI("./script/async_checkemail.php" + "?email=" + email+"&username=" + user);
    xmlreq.onreadystatechange = checkEmail;
    xmlreq.open("GET", url, true);
    xmlreq.send();
}



function checkEmail() {
    if (xmlreq.readyState == 4) {
        if (xmlreq.status == 200) {
            if (xmlreq.responseText != null)
            {
                if (xmlreq.responseText == "ok"){
					document.getElementById("pswSign").value = "";
					document.getElementById("pswConfirmSign").value = "";
					document.signupform.submit();
				}
                else if(xmlreq.responseText == "email")
                    document.getElementById("errorSignupBox").innerHTML = "Email Already Taken!";
                else if(xmlreq.responseText == "username")
                    document.getElementById("errorSignupBox").innerHTML = "Username Already Taken!";
            }
            else alert("Ajax error: no data received");
        }
        else
            alert("Ajax error: " + xmlreq.statusText);
    }
}



//SERVE??? -----------------------------------------------------------------------------
function asyncSelCity() {
 /*   if (xmlreq.readyState == 4) {
        if (xmlreq.status == 200) {
            if (xmlreq.responseText != null)
            {
                document.getElementById("citySign").innerHTML = xmlreq.responseText;
            }
            else alert("Ajax error: no data received");
        }
        else
            alert("Ajax error: " + xmlreq.statusText);
    }*/
}



function removeErrorSignup(){
    document.getElementById("errorSignupBox").innerHTML = "<br>";
    document.getElementById("userSign").style.borderColor = "white";
    document.getElementById("emailSign").style.borderColor = "white";
    document.getElementById("pswSign").style.borderColor = "white";
    document.getElementById("pswConfirmSign").style.borderColor = "white";
    document.getElementById("nameSign").style.borderColor = "white";
    document.getElementById("surnameSign").style.borderColor = "white";
    document.getElementById("dateSign").style.borderColor = "white";
    document.getElementById("gender").style.borderColor = "white";
    document.getElementById("citySign").style.borderColor = "white";
}



function checkSettings(){
    document.settings.submit();
}



document.addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        if(document.getElementById("logIn").style.visibility == "" || document.getElementById("logIn").style.visibility == "visible")
            ajaxcheckPassword();
        else if(document.getElementById("signUpForm").style.visibility == "visible")
            checkSignUp();

    }
});





function SHA1(msg) {

  function rotate_left(n,s) {
    var t4 = ( n<<s ) | (n>>>(32-s));
    return t4;
  };




  function lsb_hex(val) {
    var str="";
    var i;
    var vh;
    var vl;
    for( i=0; i<=6; i+=2 ) {
      vh = (val>>>(i*4+4))&0x0f;
      vl = (val>>>(i*4))&0x0f;
      str += vh.toString(16) + vl.toString(16);
    }
    return str;
  };




  function cvt_hex(val) {
    var str="";
    var i;
    var v;
    for( i=7; i>=0; i-- ) {
      v = (val>>>(i*4))&0x0f;
      str += v.toString(16);
    }
    return str;
  };




  function Utf8Encode(string) {
    string = string.replace(/\r\n/g,"\n");
    var utftext = "";
    for (var n = 0; n < string.length; n++) {
      var c = string.charCodeAt(n);
      if (c < 128) {
        utftext += String.fromCharCode(c);
      }
      else if((c > 127) && (c < 2048)) {
        utftext += String.fromCharCode((c >> 6) | 192);
        utftext += String.fromCharCode((c & 63) | 128);
      }
      else {
        utftext += String.fromCharCode((c >> 12) | 224);
        utftext += String.fromCharCode(((c >> 6) & 63) | 128);
        utftext += String.fromCharCode((c & 63) | 128);
      }
    }
    return utftext;
  };




  var blockstart;
  var i, j;
  var W = new Array(80);
  var H0 = 0x67452301;
  var H1 = 0xEFCDAB89;
  var H2 = 0x98BADCFE;
  var H3 = 0x10325476;
  var H4 = 0xC3D2E1F0;
  var A, B, C, D, E;
  var temp;
  msg = Utf8Encode(msg);
  var msg_len = msg.length;
  var word_array = new Array();

  for( i=0; i<msg_len-3; i+=4 ) {
    j = msg.charCodeAt(i)<<24 | msg.charCodeAt(i+1)<<16 |
    msg.charCodeAt(i+2)<<8 | msg.charCodeAt(i+3);
    word_array.push( j );
  }

  switch( msg_len % 4 ) {
    case 0:
      i = 0x080000000;
    break;
    case 1:
      i = msg.charCodeAt(msg_len-1)<<24 | 0x0800000;
    break;
    case 2:
      i = msg.charCodeAt(msg_len-2)<<24 | msg.charCodeAt(msg_len-1)<<16 | 0x08000;
    break;
    case 3:
      i = msg.charCodeAt(msg_len-3)<<24 | msg.charCodeAt(msg_len-2)<<16 | msg.charCodeAt(msg_len-1)<<8  | 0x80;
    break;
  }

  word_array.push( i );
  while( (word_array.length % 16) != 14 ) word_array.push( 0 );
  word_array.push( msg_len>>>29 );
  word_array.push( (msg_len<<3)&0x0ffffffff );
  for ( blockstart=0; blockstart<word_array.length; blockstart+=16 ) {
    for( i=0; i<16; i++ ) W[i] = word_array[blockstart+i];
    for( i=16; i<=79; i++ ) W[i] = rotate_left(W[i-3] ^ W[i-8] ^ W[i-14] ^ W[i-16], 1);
    A = H0;
    B = H1;
    C = H2;
    D = H3;
    E = H4;
    for( i= 0; i<=19; i++ ) {
      temp = (rotate_left(A,5) + ((B&C) | (~B&D)) + E + W[i] + 0x5A827999) & 0x0ffffffff;
      E = D;
      D = C;
      C = rotate_left(B,30);
      B = A;
      A = temp;
    }
    for( i=20; i<=39; i++ ) {
      temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff;
      E = D;
      D = C;
      C = rotate_left(B,30);
      B = A;
      A = temp;
    }
    for( i=40; i<=59; i++ ) {
      temp = (rotate_left(A,5) + ((B&C) | (B&D) | (C&D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff;
      E = D;
      D = C;
      C = rotate_left(B,30);
      B = A;
      A = temp;
    }
    for( i=60; i<=79; i++ ) {
      temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff;
      E = D;
      D = C;
      C = rotate_left(B,30);
      B = A;
      A = temp;
    }
    H0 = (H0 + A) & 0x0ffffffff;
    H1 = (H1 + B) & 0x0ffffffff;
    H2 = (H2 + C) & 0x0ffffffff;
    H3 = (H3 + D) & 0x0ffffffff;
    H4 = (H4 + E) & 0x0ffffffff;
  }
  
  var temp = cvt_hex(H0) + cvt_hex(H1) + cvt_hex(H2) + cvt_hex(H3) + cvt_hex(H4);

  return temp.toLowerCase();
}

