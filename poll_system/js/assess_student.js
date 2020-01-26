window.onload = function() {
    const xhr = new XMLHttpRequest();
    const url='src/assess_student_form.php';
    xhr.open("GET", url, true);
    xhr.send();
    xhr.onload = (e) => {
        var x;
        if(xhr.status == 200) {
            data = JSON.parse(xhr.responseText);
            var task = document.getElementById("task");
            if(Array.isArray(data['tasks']) && data['tasks'].length){
                document.getElementById("lbl_result").innerHTML = "Assess points from maximum " + data['tasks'][0].maxpoints + " points";
            }
            task.addEventListener('change', function() {
                var lbl = document.getElementById("lbl_result");
                var taskId = this.value;
                var maxpoint;
                for(x in data['tasks']){
                    if(data['tasks'][x].taskId == taskId){
                        maxpoint = data['tasks'][x].maxpoints;
                    }
                }
                lbl.innerHTML = "Assess points from maximum " + maxpoint + " points";
              });
            for (x in data['tasks']) {
                var option = document.createElement("option");
                option.value = data['tasks'][x].taskId;
                option.text = data['tasks'][x].title;
                task.add(option);
            }
            var student = document.getElementById("student");
            for (x in data['students']) {
                var option = document.createElement("option");
                option.value = data['students'][x].id;
                option.text = data['students'][x].fn;
                student.add(option);
            }

        }
    }
};