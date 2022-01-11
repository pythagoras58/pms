<?php
    session_start();
    include('assets/connection/connection.php');

    $errors = array();

    //check if the submit button is clicked
    if(isset($_POST['submit'])){
        // get all data input
        $indexnumber = htmlentities($_POST['indexnumber']);
        $password = htmlentities($_POST['password']);

        if(empty($indexnumber)){
            $errors['indexnumber'] = "Index Number is required";
        }

        if(empty($password)){
            $errors['password'] = "Password is required";
        }

        if(count($errors) ===0){

            $LoginQuery = "SELECT * FROM authentication WHERE indexnumber=:indexnumber LIMIT 1";
            $stmt = $conn->prepare($LoginQuery);
            $stmt->bindParam("s", $indexnumber, PDO::PARAM_STR);
            $stmt->execute(['indexnumber' => $indexnumber]);

            //Get the result in an array
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $userCount = $stmt->rowCount();

            // check if a user was found
            if($userCount>0){

                // Let's unhash the password
                if(password_verify($password, $row['password'])){
                    $userRole = $row['usertype'];
                    //List add the user types
                    $userAsAdmin = "Admin";
                    $userAsStudent = "Student";
                    $userAsStaff = "Staff";
                    $userAsSecurity = "Security";

                    //Get session variables
                    $_SESSION['role'] = $userRole;
                    $_SESSION['indexnumber'] = $row['indexnumber'];

                    // Redirect to Different pages based on the user type

                    // to admin page
                    if($userRole === $userAsAdmin){
                        header("location: admin/index.php");
                    }

                    //to security page
                    if($userRole === $userAsSecurity){
                        header("location: security/index.php");
                    }

                    //to student page
                    if($userRole === $userAsStudent){
                        header("location: student/index.php");
                    }

                    //to lecturer page
                    if($userRole === $userAsStaff){
                        header("location: staff/index.php");
                    }

                    $_SESSION['message'] =  $indexnumber ." Found As " . $userRole;
                    $_SESSION['alert-class'] = "alert alert-success";
                }else{
                    $_SESSION['message'] = " Wrong Password!!";
                    $_SESSION['alert-class'] = "alert alert-danger";
                }
                
            }else{
                $_SESSION['message'] =  $indexnumber ." Not Found - Proceed to Sign Up";
                $_SESSION['alert-class'] = "alert alert-danger";
            }

           
        }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>SIGN IN || Admin Panel</title>
    <link href="admin/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="admin/assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="admin/js/all.min.js"></script>
    <script src="admin/js/feather.min.js"></script>
    <style>
        #bg-body{
            background-image: url('assets/image/bg-image.jpg') !important;
        }
        .textColor{
            color: #0000ff !important;
        }
    </style>
</head>

<body class="bg-primary" id="bg-body">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header justify-content-center">
                                    <h3 class="font-weight-light my-4">SIGN IN</h3>
                                </div>
                                <div class="card-body">

                                    <div class="text-center">
                                        <?php
                                        if (count($errors) > 0) :
                                        ?>
                                            <div class="alert alert-danger">
                                                <?php foreach ($errors as $error) : ?>
                                                    <li><?php echo $error; ?></li><br>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (isset($_SESSION['message'])) : ?>
                                            <div class="alert <?php echo $_SESSION['alert-class']; ?>">
                                                <strong> <?php echo $_SESSION['message'];
                                                            unset($_SESSION['message']);
                                                            unset($_SESSION['alert-class']);
                                                            ?></strong>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <form method="POST">
                                        <div class="form-group">
                                            <label class="small mb-1 textColor" for="inputIndexNumber">Index Number</label>
                                            <input class="form-control py-4" id="indexnumber" name="indexnumber" type="text" placeholder="Enter Index Number" />
                                        </div>

                                        <div class="form-group">
                                            <label class="small mb-1 textColor" for="inputPassword">Password</label>
                                            <input class="form-control py-4" id="inputPassword" name="password" type="password" placeholder="Enter password" />
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox"><input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" /><label class="custom-control-label" for="rememberPasswordCheck">Remember password</label></div>
                                        </div>

                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary mr-2 my-1 form-control" type="submit" name="submit">Log In</button>
                                        </div>

                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small"><a href="signup.php">Need an account? Sign up!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!--Script JS-->
    <script src="admin/js/jquery-3.4.1.min.js"></script>
    <script src="admin/js/bootstrap.bundle.min.js"></script>
    <script src="admin/js/scripts.js"></script>
</body>

</html>