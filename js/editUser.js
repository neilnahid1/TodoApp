function updateUser() {
    let formData = $('#userForm').serialize();
    $.ajax({
        url: "../php/add_task.php",
        data: formData,
        type: 'POST',
        success: (data) => {
            var data = JSON.parse(data);

        }
    });
}