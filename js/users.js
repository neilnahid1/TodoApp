function getUsers() {
    $.post("../php/users/process.php", { Type: "getUsers" },
        (res) => {
            let table = generateTable(JSON.parse(res));
            document.getElementById("userTable").innerHTML = "";
            document.getElementById("userTable").appendChild(table);
            applyDataTables();
        }
    );
}

function applyDataTables() {
    var tbl = $('#table').DataTable({ select: true, destroy: true });
    $('#btn_editUser').click(e => {
        let data = tbl.row({ selected: true }).data();
        populateUserModalFields(data);
    });
    $('#btn_confirmDeleteUser').click(e => {
        let data = tbl.row({ selected: true }).data();
        deleteUser(data[0]);
    });
    $('#btn_updateChanges').click(e => {
        updateUserProfile();
    });
}

function updateUserProfile() {
    let formData = $('#userProfile').serializeArray();
    formData.push({ name: "Type", value: "updateUser" });
    $.post("../php/users/process.php", formData).then(res => {
        document.getElementById('response').innerHTML = res;
        if (res == "SUCCESS: REDIRECT") {
            window.location.href = "login.php";
        }
        fetchUsersTable();
    });
}

/**
 * 
 * @param {Number} UserID 
 */
function deleteUser(UserID) {
    $.post("../php/users/process.php", { UserID: UserID, Type: "deleteUser" }).then((res) => {
        if (res == "Successfully deleted!")
            fetchUsersTable();
        else
            alert(res);
    });
}
/**q
 * 
 * @param {Array} data 
 */
function populateUserModalFields(data) {
    for (let i = 0; i < data.length; i++) {
        $(`#${i}`).val(data[i]);
    }
}