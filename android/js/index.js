function onInit(){
    var isAuth = localStorage.getItem("isAuth");
    if(typeof isAuth == "undefined"){
        window.location.href = "./signup.html"
        return true;
    }
    if(isAuth == "true"){
        var username = localStorage.getItem("username");
        var passwd = localStorage.getItem("password");
    	var data = "grant_type=password&email=" + username + "&password=" + passwd;
        var http = new XMLHttpRequest(); 
        http.open("POST",apiServiceBase+'login',true);
        http.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        http.onreadystatechange=function(){
            if(http.readyState == 4){
                if(http.status==200){
                    var response = JSON.parse(http.responseText);
                    if(response.status) {
                        response = response.data;
                        localStorage.setItem('fname',response.firstname);
                        localStorage.setItem('lname',response.lastname);
                        localStorage.setItem("username",response.username);
                        localStorage.setItem("password",passwd);
                        localStorage.setItem("socketId",response.socketId);
                        localStorage.setItem("isAuth", true);
                    }
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
    else {
        window.location.href = "./login.html"
    }
}