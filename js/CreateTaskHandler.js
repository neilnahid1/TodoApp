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
        `<tr>
        <td>${data[0].TaskCodeID}</td>
        <td>${data[0].Name}</td>
        <td>${data[0].IsComplete}</td>
        <td>
            <button data-toggle='modal' value='${data[0].TaskCodeID}' id='viewTask'  data-target='#viewTaskModal' class='btn btn-dark'>View</button>
            <button data-toggle='modal' value='${data[0].TaskCodeID}' id='updateTask' data-target='#viewTask' class='btn btn-dark'>Edit</button>
            <button data-toggle='modal' value='${data[0].TaskCodeID}' data-target='#viewTask' class='btn btn-dark'>Delete</button>
        </td>
    </tr>`;
    $('#btn_NewRow').before(dom);
}