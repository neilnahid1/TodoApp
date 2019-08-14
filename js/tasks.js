function getCurrentUserTask() {
    $.post("../php/tasks/process.php", { Type: "getCurrentUserTasks" }).then((res) => {
        alert(res);
        let table = generateTable(JSON.parse(res));
        document.getElementById("taskTable").innerHTML = "";
        document.getElementById("taskTable").appendChild(table);
        // applyDataTables();
        var tbl = $('#table').DataTable({ select: true, destroy: true });
    });
}
function applyDataTables() {
    if (!tbl) { //runs if it's first time to initialize tbl
        var tbl = $('#table').DataTable({ select: true, destroy: true });
        $('#btn_editTask').click(e => {
            let data = tbl.row({ selected: true }).data();
            populateUserModalFields(data);
        });
        $('#btn_confirmDeleteTask').click(e => {
            let data = tbl.row({ selected: true }).data();
            deleteUser(data[0]);
        });
        $('#btn_confirmUpdateTask').click(e => {
            updateUserProfile();
        });
    }
    else
        $('#table').DataTable({ select: true, destroy: true });
}
function updateTask() {
    $.post("../php/tasks/process.php", { Type: "updateUserTask" }).then((res) => {
        alert(res);
    });
}
function addTask() {
    let formData = $('#form_addTask').serializeArray();
    formData.push({ name: "Type", value: "addTask" });
    $.post("../php/tasks/process.php", formData).then(res => {
        alert(res);
    });
}
function populateUserModalFields(data) {
    for (let i = 0; i < data.length; i++) {
        $(`#${i}`).val(data[i]);
    }
}