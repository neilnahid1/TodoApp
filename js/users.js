async function getUsers() {
    document.getElementById("userTable").childNodes.forEach(node=>node.remove());
    let table = await $.post("../php/users/process.php", { Type: "getUsers" }).then(res => { return generateTable(JSON.parse(res)) });
    document.getElementById("userTable").appendChild(table);
    $(document).ready(() => {
        var tbl = $('#table').DataTable({ select: true });
        $('#btn_editUser').click(e => {
            let data = tbl.row({ selected: true }).data();
            populateUserModalFields(data);
        });
        $('#btn_deleteUser').click(e => {
            let data = tbl.row({ selected: true }).data();
            deleteUser(data[0]);
        });
    });
}

function updateUserProfile() {
    let formData = $('#userProfile').serializeArray();
    $.post("../php/users/process.php", formData, (res) => {
        document.getElementById('response').innerHTML = res;
        if (res == "Successfully updated, redirecting now...") {
            window.location.href = "login.php";
        }
    });
}

/**
 * 
 * @param {Number} UserID 
 */
function deleteUser(UserID) {
    $.post("../php/users/process.php", { UserID: UserID, Type: "deleteUser" }).then((res) => {
        alert(res);
        if (res == "Successfully deleted!")
            getUsers();
        else
            alert(res);

    });
}
/**
 * 
 * @param {Array} data 
 */
function populateUserModalFields(data) {
    for (let i = 0; i < data.length; i++) {
        $(`#${i}`).val(data[i]);
    }
}