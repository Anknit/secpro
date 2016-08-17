function onLogin() {
    var username = document.forms["loginForm"]["username"].value.trim();
    if (username == null || username == ""){
        alert("Username cannot be blank");
        return false;
    }
	var passwd = document.forms["loginForm"]["passwd"].value.trim();
    if( passwd == null || passwd == ""){
        alert("Password cannot be blank");
        return false;
    }
	var data = "grant_type=password&email=" + username + "&password=" + passwd;
	var http = new XMLHttpRequest(); 
	http.open("POST",apiServiceBase+'login',true);
	http.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	http.onreadystatechange=function(){
		if(http.readyState == 4){
            if(http.status==200){
/*
            	var response = JSON.parse(http.responseText);
            	localStorage.setItem('access_token',response.access_token);
            	localStorage.setItem('name',response.name);
            	localStorage.setItem('token_type',response.token_type);
            	localStorage.setItem('refresh_token',response.refresh_token);
            	localStorage.setItem('token_expires',new Date(response['.expires']).getTime());
                localStorage.setItem("username",response.userName);
                localStorage.setItem("passwd",passwd);
                localStorage.setItem("isAuth", true);
                localStorage.setItem("isRemember", true);
*/
                window.location.href = "./home.html";
            }
            else if(http.status == 400){
            	var response = JSON.parse(http.responseText);
            	alert(response.error_description);
            }
            else{
            	alert('Please check your network connection');
            }
		}
	}
	http.send(data);
}
function onInit(){
    var isAuth = localStorage.getItem("isAuth");
    if(typeof isAuth == "undefined"){
        window.location.href = "./signup.html"
        return true;
    }
    if(isAuth == "true"){
        window.location.href = "./home.html"
    }
}