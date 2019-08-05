function generateTasksTable(tasks) {
    let table = document.getElementById('mainTable');
    document.getElementById('table_name').innerHTML = "Tasks Table";
    table.innerHTML = "";
    table.style.tableLayout = "fixed";
    if (tasks) {
        createTaskTableHeaders(tasks[0], table);
        createTaskTableRows(tasks, table);
        table.appendChild(addNewTaskButton());
    }
    else {
        //if if tasks is empty, set up thead only.
        let fields = ["TaskCodeID", "Name", "Description", "IsComplete", "Functionalities"];
        let thead = document.createElement("thead");
        thead.className = "thead-dark";
        fields.forEach(val => {
            let th = document.createElement("th");
            th.textContent = val;
            thead.appendChild(th);
        });
        table.appendChild(thead);
        table.appendChild(addNewTaskButton());
    }

}
function createTaskRowElement(task) {
    //create a table row element from the given data
    let row = document.createElement('tr');
    for (col in task) {
        let td = document.createElement('td');
        if (col == "IsComplete") {
            let isCompleteCheckbox = document.createElement("input");
            isCompleteCheckbox.type = "checkbox";
            isCompleteCheckbox.onclick = () => { return false };
            isCompleteCheckbox.checked = task[col] == 1 ? true : false;
            td.appendChild(isCompleteCheckbox);
        }
        else
            td.textContent = task[col];
        row.appendChild(td);
    }
    row.insertAdjacentHTML('beforeend', createTasksRowFuncButtons(task.TaskCodeID));
    return row;
}
function createTaskTableRows(tasks, table) {
    tasks.forEach(task => {
        table.appendChild(createTaskRowElement(task));
    });
}
function fetchTasksTable() {
    $.ajax({
        url: "../php/get_tasks.php",
        type: 'POST',
        success: (data) => {
            if (data != "") {

                generateTasksTable(JSON.parse(data));
            }
            else {
                generateTasksTable("");
            }
        }
    })
}
function createTaskTableHeaders(userSample, table) {
    //create table headers from one Users sample
    var thead = document.createElement("thead");
    thead.className = "thead-dark";
    Object.keys(userSample).forEach(key => {
        let th = document.createElement('th');
        th.textContent = key;
        thead.appendChild(th);
    });
    //add another thead for the functionalities button
    var thfunc = document.createElement('th');
    thfunc.textContent = "Functionalities";
    thead.appendChild(thfunc);
    table.appendChild(thead);

}
function createTasksRowFuncButtons(TaskCodeID) {
    let dom = ` <td>
                    <button onclick='fetchTaskData(this.value)' value='${TaskCodeID}' data-toggle='modal' id='viewTask' data-target='#viewTaskModal' class='btn btn-dark'>View</button>
                    <button onclick='fetchTaskData(this.value)' value='${TaskCodeID}' data-toggle='modal' id='updateTask' data-target='#updateTaskModal' class='btn btn-dark'>Edit</button>
                    <button onclick='assignModalDeleteTaskButtonValue(this.value)'value='${TaskCodeID}' data-toggle='modal' id='deleteTask' data-target='#deleteTaskModal' class='btn btn-dark'>Delete</button>
                </td>`;
    return dom;
}
function fetchTaskData(TaskCodeID) {
    $.ajax({
        url: "../php/view_task.php",
        data: { TaskCodeID: TaskCodeID },
        type: 'POST',
        success: (data) => {
            var data = JSON.parse(data);
            updateViewTaskModalFields(data);
        }
    });

}
function updateViewTaskModalFields(data) {
    document.getElementById("vTaskName").value = data[0].Name;
    document.getElementById("vTaskDescription").value = data[0].Description;
    document.getElementById("vTaskIsComplete").checked = data[0].IsComplete == 0 ? false : true;
    document.getElementById("uTaskName").value = data[0].Name;
    document.getElementById("uTaskDescription").value = data[0].Description;
    document.getElementById("uTaskCodeID").value = data[0].TaskCodeID;
    document.getElementById("uTaskIsComplete").checked = data[0].IsComplete == 0 ? false : true;
}
function updateTask(event) {
    alert(event);   
    var formData = $('#updateTaskForm').serializeArray();
    $.ajax({
        url: "../php/update_task.php",
        data: formData,
        type: "POST",
        success: data => {
            fetchTasksTable();
        }
    });
}
function deleteTask(TaskCodeID) {
    $.ajax({
        url: "../php/delete_task.php",
        data: { TaskCodeID: TaskCodeID },
        type: "POST",
        success: data => {
            fetchTasksTable();
        }
    })
}
function assignModalDeleteTaskButtonValue(TaskCodeID) {
    document.getElementById("btn_deleteTask").value = TaskCodeID;
}
function addNewTaskButton() {
    let tr = document.createElement('tr');
    tr.appendChild(document.createElement('td'));
    tr.appendChild(document.createElement('td'));
    tr.appendChild(document.createElement('td'));
    tr.appendChild(document.createElement('td'));
    tr.insertAdjacentHTML("beforeend", `<button data-toggle="modal" data-target="#createNewModal" class="btn btn-dark">New Task</button>`);
    return tr;
}
function addTask() {
    var data = $('#addTask').serializeArray(); //serialize data from modal
    $.ajax({
        url: "../php/add_task.php",
        data: data,
        type: 'POST',
        success: (data) => {
            var data = JSON.parse(data);
            fetchTasksTable();
        }
    });
}