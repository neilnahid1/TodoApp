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
                updateTableRowValues(JSON.parse(data));
            }
        });

    });
})
function FetchUpdateModalValues(data) {
    //data is an array that contains JSON
    //can be accessed as data[0].propertyName
    document.getElementById("uTaskName").value = data[0].Name;
    document.getElementById("uTaskDescription").value = data[0].Description;
    document.getElementById("uTaskCodeID").value = data[0].TaskCodeID;
    document.getElementById("uTaskIsComplete").checked = data[0].IsComplete == 0 ? false : true;
}
function updateTableRowValues(data) {
    var rowID = "row" + data[0].TaskCodeID; //gets the updated row
    var element = document.getElementById(rowID)
    //taskcodeID, first col
    element.childNodes[0].textContent = data[0].TaskCodeID;
    //Name, second col
    element.childNodes[1].textContent = data[0].Name;
    //checkbox isComplete, third col
    element.childNodes[2].childNodes[0].checked = data[0].IsComplete == 0 ? false : true;
}