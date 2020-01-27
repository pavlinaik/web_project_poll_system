window.onload = function() {
    const xhr = new XMLHttpRequest();
    const url='src/task_results.php';
    xhr.open("GET", url, true);
    xhr.send();

    xhr.onload = (e) => {
        var x, y, txt = "";
        if(xhr.status == 200) {
            console.log(xhr.responseText);
            response = JSON.parse(xhr.responseText);
            txt += "<table><thead><tr><th>Number</th><th>Content</th><th>Deadline</th><th>Maxpoints</th><th>Weight</th><th>Status</th><th>Points</th></thead></tr>";
            txt += "<col style='width:10%'><col style='width:40%'><col style='width:20%'><col style='width:10%'><col style='width:10%'><col style='width:10%'><tbody>";
            for (x in response['tasks']) {
            txt += "<tr>" +"<td>" + response['tasks'][x].taskId + "</td>" +
                        "<td>" + response['tasks'][x].content + "</td>" +
                        "<td>" + response['tasks'][x].deadline + "</td>" +
                        "<td>" + response['tasks'][x].maxpoints + "</td>" +
                        "<td>" + response['tasks'][x].weight + "</td>";
            if(response['tasks'][x].status == 1){
                txt += "<td>active</td>";
            }
            else {
                txt += "<td>closed</td>";
            }
            var hasResult = 0;
            for(y in response['results']){
                if(response['results'][y].taskId == response['tasks'][x].taskId){
                    hasResult = 1;
                    txt +=  "<td>" + response['results'][y].result + "</td>";
                }
            }
            if (!hasResult){
                txt +=  "<td>-</td>";
            }             
            txt +="</tr>";
            }
            txt += "</tbody>";
            txt += "</table>"; 
            document.getElementById("tasks").innerHTML = txt;
        }
    }
  };