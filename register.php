<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Todo App - Register</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                  </div>
                  <form id="registerForm" method="post" action="javascript:register()" class="user">
                    <input type="hidden" name="Type" value="addUser">
                    <div class="form-group row">
                      <div class="col-sm-6 mb-3 mb-sm-0">
                        <input required type="text" class="form-control form-control-user" name="FirstName" placeholder="First Name">
                      </div>
                      <div class="col-sm-6">
                        <input required type="text" class="form-control form-control-user" name="LastName" placeholder="Last Name">
                      </div>
                    </div>
                    <div class="form-group">
                      <input required type="text" class="form-control form-control-user" name="Address" placeholder="Address">
                    </div>
                    <div class="form-group">
                      <input type="email" required class="form-control form-control-user" name="EmailAddress" placeholder="Email Address">
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-12 mb-3 mb-sm-0">
                        <input requiredtype="text" class="form-control form-control-user" name="Username" placeholder="Username">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-6 mb-3 mb-sm-0">
                        <input required type="password" class="form-control form-control-user" name="Password" placeholder="Password">
                      </div>
                      <div class="col-sm-6">
                        <input required type="password" class="form-control form-control-user" name="RepeatPassword" placeholder="Repeat Password">
                      </div>
                    </div>
                    <p class="text-danger" id="responseMessage"></p>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Register</button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="login.php">Already have an account? Login!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script>
    function register() {
      let form = document.getElementById("registerForm");
      if (form.checkValidity()) {
        let formData = $('#registerForm').serializeArray();
        $.post("../php/users/process.php", formData, (data) => {
          let errorP = document.getElementById("responseMessage");
          if (data == "1062 Duplicate entry ") {
            errorP.innerHTML = "Username/Email already exists!";
            return;
          }
          errorP.innerHTML = data;
        });
      }

    }
  </script>
</body>

</html>