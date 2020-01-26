window.onload = function() {
    const xhr = new XMLHttpRequest();
    const url='src/active_tasks.php';
    xhr.open("GET", url, true);
    xhr.send();

    xhr.onload = (e) => {
        var x, txt = "";
        if(xhr.status == 200) {
            tasks = JSON.parse(xhr.responseText);
            txt += "<table><thead><tr><th>Number</th><th>Content</th><th>Deadline</th><th>Maxpoints</th><th>Weight</th><th>Status</th></thead></tr>";
            txt += "<col style='width:10%'><col style='width:40%'><col style='width:20%'><col style='width:10%'><col style='width:10%'><col style='width:10%'><tbody>";
            for (x in tasks) {
            txt += "<tr>" +"<td>" + tasks[x].taskId + "</td>" +
                        "<td>" + tasks[x].content + "</td>" +
                        "<td>" + tasks[x].deadline + "</td>" +
                        "<td>" + tasks[x].maxpoints + "</td>" +
                        "<td>" + tasks[x].weight + "</td>" +
                        "<td>active</td>" +
                        // "<td><form action='src/vote_form.php'><button name='poll_number' type='submit' value=" + polls[x].id +">Vote</button></form></td>" +
                        // "<td><a href='vote_form.html?pollId=" + tasks[x].id +"'><button name='poll_number' type='button'>Vote</button></a></td>" +
                    "</tr>";
            }
            txt += "</tbody>";
            txt += "</table>"; 
            document.getElementById("active_tasks").innerHTML = txt;
        }
    }
  };