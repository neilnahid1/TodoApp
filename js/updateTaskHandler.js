$('button').click((event) => {
    if (event.target.id === 'updateTask') {
        $.ajax({
            url: "../php/view_task.php",
            data: { TaskCodeID: event.target.value },
            type: 'POST',
            success: (data) => {
                var data = JSON.parse(data);
                updateModalValues(data);
            }
        });
    }

});
function updateModalValues(data) {
    //data is an array that contains JSON
    //can be accessed as data[0].propertyName
    document.getElementById("vTaskName").value = data[0].Name;
    document.getElementById("vTaskDescription").value = data[0].Description;
}