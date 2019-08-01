function convertTasksToTable(userTasks) {
    if (table = document.getElementById("userTasksTable")) {
        table.outerHTML = "";
    }
    //UserTasks is array that contains JSON object
    //properties TaskCodeID, Name, Descriptionm, UserID, IsComplete
    var table = document.createElement("table");
    table.className = "table";
    table.id = "userTasksTable";
    var theads = ['TaskCodeID', 'Name', 'Description', 'UserID', 'IsComplete'];
    //append theads to the table
    theads.forEach(thead => {
        var th = document.createElement('th');
        th.textContent = thead;
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
            var data = JSON.parse(data);
            convertTasksToTable(data);
        }
    });
}
function createRowElement(data) {
    var row = document.createElement('tr');
    for (col in data) {
        var td = document.createElement('td');
        td.textContent = data[col];
        row.appendChild(td);
    }
    return row;
}