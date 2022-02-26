function postRequest(strURL) 
{
	var xmlHttp;
          if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		 var xmlHttp = new XMLHttpRequest();
	    }else if (window.ActiveXObject) { // IE
		var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	      }
	    xmlHttp.open('POST', strURL, true);
	    xmlHttp.setRequestHeader
              ('Content-Type', 'application/x-www-form-urlencoded');
		xmlHttp.onreadystatechange = function() {
	if (xmlHttp.readyState == 4) {
	       updatepage(xmlHttp.responseText);
		//alert(xmlHttp.responseText);
	      }
	   }
	 xmlHttp.send(strURL);
}
function updatepage(str)
{
	document.getElementById("txtcaller_id").value = str ;
	var rnd = Math.random();
        var url="get_custumer.php?id="+rnd+"&caller_id="+str;
		//alert('dfds');
        kpostRequest(url);
}
function SayHello(){
	//alert('hiiiii');
	var user_id = document.getElementById("user_id").value;
	var rnd = Math.random();
	var url="includes/kget_caller.php?id="+rnd+"&c=Agents&user_id="+user_id;
	postRequest(url);
}

function kpostRequest(strURL)
{
        var xmlHttp;
          if (window.XMLHttpRequest) { // Mozilla, Safari, ...
                 var xmlHttp = new XMLHttpRequest();
            }else if (window.ActiveXObject) { // IE
                var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlHttp.open('POST', strURL, true);
            xmlHttp.setRequestHeader
              ('Content-Type', 'application/x-www-form-urlencoded');
                xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
               kupdatepage(xmlHttp.responseText);
                //alert(xmlHttp.responseText);
              }
           }
         xmlHttp.send(strURL);
}
function kupdatepage(str)
{
	//alert(str);
	var caller_id = str.substr(0,str.indexOf('|', 0));
	str = str.substr(str.indexOf('|',0)+1, str.length);
	//alert(caller_id);

	var first_name = str.substr(0,str.indexOf('|', 0));
	str = str.substr(str.indexOf('|',0)+1, str.length);
	document.getElementById("txtfirst_name").value = first_name ;

        var last_name = str.substr(0,str.indexOf('|', 0));
        str = str.substr(str.indexOf('|',0)+1, str.length);
	document.getElementById("txtlast_name").value = last_name;

        var gender = str.substr(0,str.indexOf('|', 0));
        str = str.substr(str.indexOf('|',0)+1, str.length);
	document.getElementById("txtgender").value = gender;

        var city = str.substr(0,str.indexOf('|', 0));
        str = str.substr(str.indexOf('|',0)+1, str.length);
	document.getElementById("txtcity").value = city;

        var email = str.substr(0,str.indexOf('|', 0));
        str = str.substr(str.indexOf('|',0)+1, str.length);
	document.getElementById("txtemail").value = email;

        var cell_no = str.substr(0,str.indexOf('|', 0));
        str = str.substr(str.indexOf('|',0)+1, str.length);
	document.getElementById("txtcell").value = cell_no;

        var company_name = str.substr(0,str.indexOf('|', 0));
        str = str.substr(str.indexOf('|',0)+1, str.length);
	document.getElementById("txcompany_name").value = company_name;

        var query = str.substr(0,str.indexOf('|', 0));
        str = str.substr(str.indexOf('|',0)+1, str.length);
	document.getElementById("txtquery").value = query;

        var desc = str.substr(0,str.indexOf('|', 0));
        //str = str.substr(str.indexOf('|',0)+1, str.length);
       document.getElementById("txtdesc").value = desc ;
}

