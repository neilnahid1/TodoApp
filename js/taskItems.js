var TaskItemID = 0; // global variable
function createTaskItemElement(TaskItemID) {
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
function appendToTaskModal() {
    document.getElementById('form_addTask').insertAdjacentHTML('beforeend', createTaskItemElement(TaskItemID++));
}
