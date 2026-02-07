<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RentPro</title>

    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome/css/all.css">
    <link rel="stylesheet" href="assets/css/index.css">

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="logic/login.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-2 login"></div>
                <div class="col-md-4 login-panel">
                    <i class="fas fa-user-circle"></i>
                    <h1 class="text-center">Login</h1>

                    <form name="login" id="login" enctype="multipart/form-data">
                        <input type="text" class="form-control mb-3" id="username" name="username" placeholder="Username" autocomplete="off">
                        <input type="password" class="form-control mb-4" id="pwd" name="pwd" placeholder="Password">
                        <input type="button" class="btn btn-sm btn-info d-block m-auto login-btn" value="Log In" onclick="userLogin()">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>