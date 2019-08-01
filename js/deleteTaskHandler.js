$(document).ready(() => {
    $('button').click((event) => {
        if (event.target.id === 'deleteTask') {
            document.getElementById('btn_delete').value = event.target.value;
        }
    });
    $('#btn_delete').click((event) => {
        $.ajax({
            url: "../php/delete_task.php",
            data: { TaskCodeID: event.target.value },
            type: 'POST',
            success: (data) => {
                removeRow(event.target.value);
            }
        });
    });
});
function removeRow(rowID) {
    //deletes the element from the DOM;
    document.getElementById(`row${rowID}`).outerHTML = "";
}