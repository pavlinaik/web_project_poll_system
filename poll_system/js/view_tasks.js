window.onload = function() {
    const xhr = new XMLHttpRequest();
    const url='src/view_tasks.php';
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
                        "<td>" + tasks[x].weight + "</td>";
            if(tasks[x].status == 1){
                txt += "<td>active</td>";
            }
            else {
                txt += "<td>closed</td>";
            }             
            txt +="</tr>";
            }
            txt += "</tbody>";
            txt += "</table>"; 
            document.getElementById("tasks").innerHTML = txt;
        }
    }
  };