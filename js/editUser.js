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
function fetchUsersTable(){
    $.ajax({
        url: "../php/get_users.php",
        data: formData,
        type: 'POST',
        success: (data) => {
            var data = JSON.parse(data);
            generateUsersTable();
        }
    })
}