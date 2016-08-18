function onSignUp() {
    var firstname = document.forms["signupForm"]["sign-fname"].value.trim();
    var lastname = document.forms["signupForm"]["sign-lname"].value.trim();
    var username = document.forms["signupForm"]["sign-uname"].value.trim();
	var passwd = document.forms["signupForm"]["sign-pswd"].value.trim();
    var mobilenum = document.forms["signupForm"]["sign-num"].value.trim();
    if (firstname == null || firstname == ""){
        alert("First name cannot be blank");
        return false;
    }
    if(username == null || username == "" ){
        alert("Username cannot be blank");
        return false;
    }
    if(passwd == null || passwd == "") {
        alert("Password cannot be blank");
        return false;
    }
    if(passwd.length < 8){
        alert("Password must contain at least 8 characters");
        return false;
    }
	if(passwd.length > 20){
        alert("Password length cannot exceed 20 characters");
        return false;
	}
	var data = 'firstname='+firstname+'&lastname='+lastname+'&email='+username+'&password='+passwd+'&mobileNumber=+91'+mobilenum;
	var http = new XMLHttpRequest();
	http.open("POST",apiServiceBase+'signup',true);
	http.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	http.onreadystatechange=function(){
		if(http.readyState == 4){
            if(http.status==200){
            	var response = JSON.parse(http.responseText);
                if(response.status) {
                    localStorage.setItem("username",username);
                    localStorage.setItem("passwd",passwd);
                    localStorage.setItem("mobilenum",data.MobileNumber);
                    window.location.href = "./verifyCode.html"
                }
            }
            else if(http.status == 400){
            	var response = JSON.parse(http.responseText);
            }
            else{
            	alert('Please check your network connection');
            }
		}
	}
	http.send(data);
}

function togglePasswordVisiblity(){
    var unHideCheckbox = document.getElementById('unhide-pswd');
    var passwordField = document.getElementById('sign-pswd');
    if(unHideCheckbox.checked){
        passwordField.setAttribute('type','text');
    }
    else{
        passwordField.setAttribute('type','password');
    }
}
function onInit(){
    var isAuth = localStorage.getItem("isAuth");
    if(isAuth == "true"){
        window.location.href = "./home.html"
    }
}
