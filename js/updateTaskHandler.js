$(document).ready(() => {
    $('button').click((event) => {
        if (event.target.id === 'updateTask') {
            $.ajax({
                url: "../php/view_task.php",
                data: { TaskCodeID: event.target.value },
                type: 'POST',
                success: (data) => {
                    var data = JSON.parse(data);
                    FetchUpdateModalValues(data);
                }
            });
        }
    });
    $('#btn_update').click((event) => {
        event.preventDefault();
        var data = $('#update_task').serializeArray();
        $.ajax({
            url: "../php/update_task.php",
            data: data,
            type: 'POST',
            success: (data) => {
                var data = JSON.parse(data);
                updateTableRowValues(data);
            }
        });

    });
})
function FetchUpdateModalValues(data) {
    //data is an array that contains JSON
    //can be accessed as data[0].propertyName
    document.getElementById("uTaskName").value = data[0].Name;
    document.getElementById("uTaskDescription").value = data[0].Description;
}
function updateTableRowValues(data) {
    var element = getElementById(`#row${data[0].UserCodeID}`);
    alert(element);
}