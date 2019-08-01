//event handler for create button from the modal.
$(document).ready(function () {
    $("#btnCreate").click(function (event) {
        event.preventDefault();
        var data = $('#addTask').serializeArray();
        $.ajax({
            url: "../php/add_task.php",
            data: data,
            type: 'POST',
            success: (data) => {
                var data = JSON.parse(data);
                updateTasksTableDOM(data);
            }
        });
    });
});
function updateTasksTableDOM(data) {
    dom =
        `<tr id='row${data[0].TaskCodeID}'>
        <td id='td_TaskCodeID'>${data[0].TaskCodeID}</td>
        <td id='td_name'>${data[0].Name}</td>
        <td class='text-center'>
        <input id='td_IsComplete' class='form-check-input' type='checkbox' id='defaultCheck1'${data[0].IsComplete == 1 ? "checked" : ""} onclick='return false;'>
        </td>
        <td>
            <button value='${data[0].TaskCodeID}' data-toggle='modal'  id='viewTask'  data-target='#viewTaskModal' class='btn btn-dark'>View</button>
            <button value='${data[0].TaskCodeID}' data-toggle='modal'  id='updateTask' data-target='#updateTaskModal' class='btn btn-dark'>Edit</button>
            <button value='${data[0].TaskCodeID}' data-toggle='modal'  id='deleteTask' data-target='#deleteTaskModal' class='btn btn-dark'>Delete</button>
        </td>
    </tr>`;
    $('#btn_NewRow').before(dom);
}