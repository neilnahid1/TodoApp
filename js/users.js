function generateUsersTable(users) {
    //Users is an array of JSON objects
    let table = document.getElementById('usersTable');
    table.innerHTML = "";
    table.style.tableLayout = "fixed";
    createUserTableHeaders(users[0], table);
    createUserTableRows(users, table);
}
function createUserRowElement(user) {
    //create a table row element from the given data
    let row = document.createElement('tr');
    for (col in user) {
        let td = document.createElement('td');
        td.textContent = user[col];
        row.appendChild(td);
    }
    row.insertAdjacentHTML('beforeend', createRowFuncButtons(user.userid));
    return row;
}
function createUserTableRows(users, table) {
    users.forEach(user => {
        table.appendChild(createUserRowElement(user));
    });
}
function fetchUsersTable() {
    $.ajax({
        url: "../php/get_users.php",
        type: 'POST',
        success: (data) => {
            var data = JSON.parse(data);
            generateUsersTable(data);
        }
    })
}
function createUserTableHeaders(userSample, table) {
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
function createRowFuncButtons(UserID) {
    let dom = ` <td>
                <button onclick='getAllUserTasks(this.value)' value='${UserID}' data-toggle='modal' id='viewUser' data-target='#viewTaskModal' class='btn btn-dark'>View Tasks</button>
                <button value='${UserID}' data-toggle='modal' id='updateUser' data-target='#updateTaskModal' class='btn btn-dark'>Edit</button>
                <button value='${UserID}' data-toggle='modal' id='deleteUser' data-target='#deleteTaskModal' class='btn btn-dark'>Delete</button>
                </td>`;
    return dom;
}
