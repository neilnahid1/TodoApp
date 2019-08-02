function generateUsersTable(users) {
    //Users is an array of JSON objects
    document.getElementById('table_name').innerHTML = "Users Table";
    let table = document.getElementById('mainTable');
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
        if (col == "roleid") {
            td.textContent = user[col] == 1 ? "Admin" : "User";
        }
        else
            td.textContent = user[col];
        row.appendChild(td);
    }
    row.insertAdjacentHTML('beforeend', createUserRowFuncButtons(user.userid));
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
function createUserRowFuncButtons(UserID) {
    let dom = ` <td>
                <button onclick='getAllUserTasks(this.value)' value='${UserID}' data-toggle='modal' id='viewUser' data-target='#viewUserTasksModal' class='btn btn-dark'>View Tasks</button>
                <button onclick='fetchUserData(this.value)' value='${UserID}' data-toggle='modal' id='updateUser' data-target='#editUserModal' class='btn btn-dark'>Edit</button>
                <button onclick='assignModalDeleteUserButtonValue(this.value)' value='${UserID}' data-toggle='modal' id='deleteUser' data-target='#deleteUserModal' class='btn btn-dark'>Delete</button>
                </td>`;
    return dom;
}
function fetchUserData(UserID) {
    $.ajax({
        url: "../php/get_user.php",
        data: { UserID: UserID },
        type: "POST",
        success: (data) => {
            data = JSON.parse(data);
            updateUserModalFields(data);
        }
    });
}
function updateUserModalFields(data) {
    document.getElementById('UserID').value = data.UserID;
    document.getElementById('Username').value = data.Username;
    document.getElementById('RoleID').value = data.RoleID;
}
function updateUser() {
    var formData = $('#updateUserForm').serializeArray();
    $.ajax({
        url: "../php/update_user.php",
        data: formData,
        type: "POST",
        success: data => {
            alert(data);
            fetchUsersTable();
        }
    });
}
function deleteUser(UserID) {
    $.ajax({
        url: "../php/delete_user.php",
        data: { UserID: UserID },
        type: "POST",
        success: data => {
            alert(data);
            fetchUsersTable();
        }
    })
}
function assignModalDeleteUserButtonValue(UserID) {
    document.getElementById("btn_deleteUser").value = UserID;
}