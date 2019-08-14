function createTaskItemElement(TaskItemID) {
    if(!TaskItemID)
    var TaskItemID = 0;
    taskItem =
        `<div class="input-group mb-3">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <input name="TaskItems[${TaskItemID}][TaskCodeID]" type="hidden" value="${TaskItemID}">
                <input name="TaskItems[${TaskItemID}][Name]" type="text" class="form-control" aria-label="Text input with checkbox">
                <input name="TaskItems[${TaskItemID}][IsDone]" type="checkbox" aria-label="Checkbox for following text input">
            </div>
        </div>
    </div>`;
    return taskItem;
}
function appendToAddTaskModal() {
    document.getElementById('form_addTask').insertAdjacentHTML('beforeend', createTaskItemElement(TaskItemID++));
}

function createEditTaskItemElement(TaskItemID,TaskCodeID) {
    if(!TaskItemID)
    var TaskItemID = 0;
    taskItem =
        `<div id="taskItem${TaskItemID}" class="input-group mb-3">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <input name="TaskItems[${TaskItemID}][TaskCodeID]" type="hidden" value="${TaskCodeID}">
                <input name="TaskItems[${TaskItemID}][Name]" type="text" class="form-control" aria-label="Text input with checkbox">
                <input name="TaskItems[${TaskItemID}][IsDone]" type="checkbox" aria-label="Checkbox for following text input">
                <button value="${TaskItemID}" type="button" onclick="removeTaskItemElement(this.value)" class="btn btn-primary rounded-circle"><i
                            class="fa fa-plus"></i></button>
            </div>
        </div>
    </div>`;
    return taskItem;
}
function removeTaskItemElement(TaskItemID){
    document.getElementById(`taskItem${TaskItemID}`).remove();
}
function appendToEditTaskModal() {
    document.getElementById('form_editTask').insertAdjacentHTML('beforeend', createTaskItemElement(TaskItemID++));
}
/**
 * 
 * @param {Array} data 
 */
function generateTaskItemElements(taskItems){
    taskItems.forEach(taskItem=>{
        let item = createEditTaskItemElement(taskItem.TaskItemID,taskItem.TaskCodeID);
        document.getElementById('form_editTask').insertAdjacentElement('beforeend', item);
    });
}

function getTaskItems(TaskCodeID){
    $.post("../php/tasks/process.php",{TaskCodeID: TaskCodeID},(res)=>{
        generateTaskItemElements(JSON.parse(res));
    });
}