function getCurrentUserTask() {
    $.post("../php/tasks/process.php", { Type: "getCurrentUserTasks" }).then((res) => {
        let table = generateTable(JSON.parse(res));
        document.getElementById("taskTable").innerHTML = "";
        document.getElementById("taskTable").appendChild(table);
        applyTaskDataTables();
    });
}
function applyTaskDataTables() {
    if (!tbl) { //runs if it's first time to initialize tbl
        var tbl = $('#table').DataTable({ select: true, destroy: true });
        $('#btn_editTask').click(e => {
            clearTaskItemElements();
            let data = tbl.row({ selected: true }).data();
            getTaskItems(data[0]); //first index of table is TaskCOdeID thus 0;
            populateEditTaskModalField(data);
        });
        $('#btn_confirmDeleteTask').click(e => {
            let data = tbl.row({ selected: true }).data();
            deleteTask(data[0]);// the first index is the taskCodeID

        });
        $('#btn_confirmUpdateTask').click(e => {
            updateTask();
        });
        $('#btn_addTask').click(e => {
            clearTaskItemElements();
        })
    }
    else
        $('#table').DataTable({ select: true, destroy: true });
}
function updateTask() {
    let formData = $('#form_editsask').serializeArray();
    formData.push({ name: "Type", value: "updateTask" });
    $.post("../php/tasks/process.php", formData).then((res) => {
        alert(res);
    });
}
function addTask() {
    let formData = $('#form_addTask').serializeArray();
    formData.push({ name: "Type", value: "addTask" });
    $.post("../php/tasks/process.php", formData).then(res => {
        getCurrentUserTask();
    });
}
function deleteTask(TaskCodeID) {
    $.post("../php/tasks/process.php", { Type: "deleteTask", TaskCodeID: TaskCodeID }).then((res) => {
        if (res == "Successfully deleted Task.")
            getCurrentUserTask();
        else
            alert(res);
    });
}
function populateEditTaskModalField(data) {
    alert(data);
    document.getElementById('eTaskCodeID').value = data[0];
    document.getElementById('eName').value = data[1];
    document.getElementById('eDescription').value = data[2];
    document.getElementById('eDateCreated').value = data[3];
    document.getElementById('eDateUpdated').value = data[4];
    document.getElementById('eUserID').value = data[5];
    document.getElementById('eIsComplete').value = data[6];
}



//functions below taskitem related
var TaskItemID = 0;
function createTaskItemElement(TaskItemID) {
    let taskItem =
        `<div class="input-group mb-3">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <input name="TaskItems[${TaskItemID}][IsDone]" type="checkbox" aria-label="Checkbox for following text input">
                <input name="TaskItems[${TaskItemID}][Name]" placeholder="Task name" type="text" class="form-control" aria-label="Text input with checkbox">
                <button value="${TaskItemID}" type="button" onclick="removeTaskItemElement(this.value)" class="btn btn-primary rounded-circle"><i
                            class="fa fa-times"></i></button>
            </div>
        </div>
    </div>`;
    return taskItem;
}
function appendToAddTaskModal() {
    document.getElementById('addTaskItemsContainer').insertAdjacentHTML('beforeend', createTaskItemElement(TaskItemID++));
}


//FUNCTION FOR EDIT MODAL
function createEditTaskItemElement(taskItemObject) {
    if (!TaskItemID)
        var TaskItemID = 0;
    let taskItem =
        `<div id="taskItem${taskItemObject.TaskItemID}" class="input-group mb-3">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <input name="TaskItems[${taskItemObject.TaskItemID}][TaskCodeID]" type="hidden" value="${taskItemObject.TaskCodeID}">
                <input name="TaskItems[${taskItemObject.TaskItemID}][TaskItemID]" type="hidden" value="${taskItemObject.TaskItemID}">
                <input ${taskItemObject.IsDone ? "checked" : ""} name="TaskItems[${taskItemObject.TaskItemID}][IsDone]" type="checkbox" aria-label="Checkbox for following text input">               
                <input value="${taskItemObject.Name}" placeholder="Task name" name="TaskItems[${taskItemObject.TaskItemID}][Name]" type="text" class="form-control" aria-label="Text input with checkbox">
                <button value="${taskItemObject.TaskItemID}" type="button" onclick="removeTaskItemElement(this.value)" class="btn btn-primary rounded-circle"><i
                            class="fa fa-times"></i></button>
            </div>
        </div>
    </div>`;
    return taskItem;
}

//clear the task items whenever the user adds/edits a task item, happens before the modal pop ups
function clearTaskItemElements() {
    document.getElementById('addTaskItemsContainer').innerHTML = "";
    document.getElementById('editTaskItemContainer').innerHTML = "";
}
function removeTaskItemElement(TaskItemID) {
    document.getElementById(`taskItem${TaskItemID}`).remove();
}
function appendToEditTaskModal() {
    document.getElementById('editTaskItemContainer').insertAdjacentHTML('beforeend', createTaskItemElement(TaskItemID++));
}
/**
 * 
 * @param {Array} data 
 */
function generateTaskItemElements(taskItems) {
    taskItems.forEach(taskItem => {
        let item = createEditTaskItemElement(taskItem);
        document.getElementById('editTaskItemContainer').insertAdjacentHTML('beforeend', item);
    });
}

function getTaskItems(TaskCodeID) {
    $.post("../php/tasks/process.php", { TaskCodeID: TaskCodeID, Type: "getTaskItems" }, (res) => {
        alert(res);
        generateTaskItemElements(JSON.parse(res));
    });
}