function convertTasksToTable(userTasks) {
    if (table = document.getElementById("userTasksTable")) {
        table.outerHTML = "";
    }
    //UserTasks is array of JSON objects
    //properties TaskCodeID, Name, Descriptionm, UserID, IsComplete
    var table = document.createElement("table");
    table.className = "table";
    table.id = "userTasksTable";
    //crate theads from one userTask sample
    Object.keys(userTasks[0]).forEach(key=>{
        let th = document.createElement('th');
        th.textContent = key;
        table.appendChild(th);
    });
    //append user tasks data as rows
    userTasks.forEach(userTask => {
        table.appendChild(createRowElement(userTask));
    })
    document.getElementById('userTasksModalBody').appendChild(table);
}

function getAllUserTasks(UserID) {
    $.ajax({
        url: "../php/get_userTasks.php",
        data: { UserID: UserID },
        type: 'POST',
        success: (data) => {
            data = JSON.parse(data); //convert it into json objects
            convertTasksToTable(data);
        }
    });
    updateModalDeleteAllTasksValue(UserID);
}
function createRowElement(data) {
    //create a table row element from the given data
    let row = document.createElement('tr');
    for (col in data) {
        let td = document.createElement('td');
        if (col == "IsComplete") {
            let isCompleteCheckBox = document.createElement("input");
            isCompleteCheckBox.type = "checkbox";
            isCompleteCheckBox.checked = data[col] == 1 ? true : false;
            td.appendChild(isCompleteCheckBox);
        }
        else
            td.textContent = data[col];
        row.appendChild(td);
    }
    return row;
}
function updateModalDeleteAllTasksValue(UserID){
    document.getElementById('btn_deleteAllTasks').value = UserID;
}