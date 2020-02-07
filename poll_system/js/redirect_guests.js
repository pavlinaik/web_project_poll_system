function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
}

var user = this.getCookie("username");
if (user == ""){
    var currentLocation = window.location;
    var separate = currentLocation.toString().split('/').filter(item => item);;
    console.log(separate);
    separate[0] = "http:/"
    separate[4] = "login.html";
    var currentdomain = separate.join('/');
    console.log(currentdomain);
    window.location.href = currentdomain;
}