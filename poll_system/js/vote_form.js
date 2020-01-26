function get(name){
    if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
       return decodeURIComponent(name[1]);
 }

 
window.onload = function() {
    const xhr = new XMLHttpRequest();
    const url='src/vote_form.php';
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("pollId=" + get('pollId'));

    xhr.onload = (e) => {
        var x, txt = "";
        if(xhr.status == 200) {
            polls = JSON.parse(xhr.responseText);
            txt += "<form action='src/submit_vote.php' method='POST'>";
            txt += "<h3>" +  polls['poll'].question + "</h3>";
            txt += "<ul>";      
            for (x in polls['options']) {
            txt += "<li><input type='radio' name='poll_option' value='" + polls['options'][x].id + "'>" + polls['options'][x].content + "</li>";
            }
            txt += "</ul>";
            txt += "<input type='hidden' name='poll' value='" + polls['poll'].id +"'>";
            txt += "<button id='btn_vote' type='submit'>Vote</button>";
            txt += "<a href='results.php?pollID=" + polls['poll'].id + "'>Results ➡ </a>";
            txt += "</form>"; 
            document.getElementById("vote_form").innerHTML = txt;
        }
    }
};