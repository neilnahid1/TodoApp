function generateUserTasksTable(tasks) {
    console.log("GENERAET USER TASKS TABLE");
    let table = document.getElementById('tbl_userTasks');
    var tableName = document.getElementById('table_name').innerHTML;
    tableName = document.getElementById('table_name').innerHTML != null ? "Tasks Table" : "";
    table.innerHTML = "";
    table.style.tableLayout = "fixed";
    if (tasks) {
        createUserTaskTableHeaders(tasks[0], table);
        createUserTaskTableRows(tasks, table);
        table.appendChild(addNewUserTaskButton());
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
        table.appendChild(addNewUserTaskButton());
    }

}
function createUserTaskRowElement(task) {
    console.log("CREATE USER TASK ROW ELEMENT");
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
    row.insertAdjacentHTML('beforeend', createUserTasksRowFuncButtons(task.TaskCodeID));
    return row;
}
function createUserTaskTableRows(tasks, table) {
    console.log("CREATE USER TASK TABLE ROWS");

    tasks.forEach(task => {
        table.appendChild(createUserTaskRowElement(task));
    });
}
function fetchUserTasksTable(UserID) {
    localStorage.setItem("UserID", UserID);
    console.log("FETCH USER TASKS TABLE");
    document.getElementById("btn_deleteAllTasks").value = UserID;
    document.getElementById("btn_Create").value = UserID;
    $.ajax({
        url: "../php/get_userTasks.php",
        data: { UserID: UserID },
        type: 'POST',
        success: (data) => {
            if (data != "") {
                generateUserTasksTable(JSON.parse(data));
            }
            else {
                generateUserTasksTable("");
            }
        }
    })
}
function createUserTaskTableHeaders(userSample, table) {
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
function createUserTasksRowFuncButtons(TaskCodeID) {
    console.log("CREATE TASKS ROW FUNC BUTTONS");
    let dom = ` <td>
                    <button onclick='fetchUserTaskData(this.value)' value='${TaskCodeID}' data-toggle='modal' id='viewUserTask' data-target='#viewUserTaskModal' class='btn btn-dark'>View</button>
                    <button onclick='fetchUserTaskData(this.value)' value='${TaskCodeID}' data-toggle='modal' id='updateUserTask' data-target='#updateUserTaskModal' class='btn btn-dark'>Edit</button>
                    <button onclick='assignUserModalDeleteTaskButtonValue(this.value)'value='${TaskCodeID}' data-toggle='modal' id='deleteUserTask' data-target='#deleteUserTaskModal' class='btn btn-dark'>Delete</button>
                </td>`;
    return dom;
}
function fetchUserTaskData(TaskCodeID) {
    console.log("FETCH USER TASK DATA");
    $.ajax({
        url: "../php/view_task.php",
        data: { TaskCodeID: TaskCodeID },
        type: 'POST',
        success: (data) => {
            var data = JSON.parse(data);
            updateUserViewTaskModalFields(data);
        }
    });
}
function updateUserViewTaskModalFields(data) {
    console.log("UPDATE MODAL VALUES");
    document.getElementById("vUserTaskName").value = data[0].Name;
    document.getElementById("vUserTaskDescription").value = data[0].Description;
    document.getElementById("vUserTaskIsComplete").checked = data[0].IsComplete == 0 ? false : true;
    document.getElementById("uUserTaskName").value = data[0].Name;
    document.getElementById("uUserTaskDescription").value = data[0].Description;
    document.getElementById("uUserTaskCodeID").value = data[0].TaskCodeID;
    document.getElementById("uUserTaskIsComplete").checked = data[0].IsComplete == 0 ? false : true;
}
function updateUserTask() {
    var formData = $('#updateUserTaskForm').serializeArray();
    $.ajax({
        url: "../php/update_task.php",
        data: formData,
        type: "POST",
        success: data => {
            fetchUserTasksTable(localStorage.getItem("UserID"));
        }
    });
}
function deleteUserTask(TaskCodeID) {
    $.ajax({
        url: "../php/delete_task.php",
        data: { TaskCodeID: TaskCodeID },
        type: "POST",
        success: data => {
            fetchUserTasksTable(localStorage.getItem("UserID"));
        }
    })
}
function assignUserModalDeleteTaskButtonValue(TaskCodeID) {
    document.getElementById("btn_UserdeleteTask").value = TaskCodeID;
}
function addNewUserTaskButton() {
    console.log("ADD NEW USER TASK BUTTON");
    let tr = document.createElement('tr');
    tr.appendChild(document.createElement('td'));
    tr.appendChild(document.createElement('td'));
    tr.appendChild(document.createElement('td'));
    tr.appendChild(document.createElement('td'));
    tr.insertAdjacentHTML("beforeend", `<button data-toggle="modal" data-target="#createNewUserModal" class="btn btn-dark">New Task</button>`);
    return tr;
}
function addUserTask(UserID) {
    var data = $('#addUserTask').serializeArray(); //serialize data from modal
    data.push({ name: "UserID", value: UserID });
    $.ajax({
        url: "../php/add_userTask.php",
        data: data,
        type: 'POST',
        success: (data) => {
            fetchUserTasksTable(UserID);
        }
    });
}
function deleteAllUserTasksFromUser(UserID) {
    $.ajax({
        url: "../php/delete_tasks.php",
        data: { UserID: UserID },
        type: "POST",
        success: (response) => {
            fetchUserTasksTable(UserID);
        }
    });
}   