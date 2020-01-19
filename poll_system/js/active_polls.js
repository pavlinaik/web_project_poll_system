window.onload = function() {
    const xhr = new XMLHttpRequest();
    const url='src/active_polls.php';
    xhr.open("GET", url, true);
    xhr.send();

    xhr.onload = (e) => {
        var x, txt = "";
        if(xhr.status == 200) {
            polls = JSON.parse(xhr.responseText);
            txt += "<table><tr><th>Number</th><th>Subject</th><th>Expires at</th><th>Status</th></tr>";
            
            for (x in polls) {
            txt += "<tr>" +"<td>" + polls[x].id + "</td>" +
                        "<td>" + polls[x].question + "</td>" +
                        "<td>" + polls[x].expiresAt + "</td>" +
                        "<td>active</td>" +
                        "<td><form action='src/vote_form.php'><button name='poll_number' type='submit' value=" + polls[x].id +">Vote</button></form></td>" +
                    "</tr>";
            }
            txt += "</table>"; 
            this.console.log(txt);
            document.getElementById("active_table").innerHTML = txt;
        }
    }
  };