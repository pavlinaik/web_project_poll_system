window.onload = function() {
    const xhr = new XMLHttpRequest();
    const url='src/all_polls.php';
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
                        "<td>" + polls[x].expiresAt + "</td>";
            if(polls[x].status == 1){
                txt += "<td>active</td>";
            }
            else {
                txt += "<td>closed</td>";
            }            
            txt +=  "<td><a href='src/results.php?pollID=" + polls[x].id +"'><button name='btn_result_poll' type='button'>Result</button></a></td>" +
                    "<td><a href='src/delete_poll.php?pollID=" + polls[x].id +"'><button name='btn_delete_poll' type='button'>Delete</button></a></td>" +
                    "</tr>";
            }
            txt += "</table>"; 
            document.getElementById("all_poll_table").innerHTML = txt;
        }
    }
  };