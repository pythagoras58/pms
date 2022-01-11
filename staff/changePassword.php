<?php
include('header.php');


//update student info
if (isset($_POST['submit'])) {
    //get all the data from the field
    $oldpassword = htmlentities($_POST['oldpassword']);
    $newpassword = htmlentities($_POST['newpassword']);
    $confirmnewpassword = htmlentities($_POST['confirmnewpassword']);

    //validate all the fields
    if(empty($oldpassword)){
        $errors['oldpassword'] = "Old Password Is Required";
    }

    if(empty($newpassword)){
        $errors['newpassword'] = "New Password Is Required";
    }

    if(empty($confirmnewpassword)){
        $errors['confirmnewpassword'] = "Confirm New Password Is Required";
    }

    if(($newpassword) != ($confirmnewpassword)){
        $errors['misPassword'] = "New Password and Confirm Password Are Different";
    }

    if (count($errors) === 0) {
         // hash the new password
         $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);

         // update password query
         $SQL = "
             UPDATE student SET password=:newpassword WHERE indexnumber=:indexnumber;
             UPDATE authentication SET password=:newpassword WHERE indexnumber=:indexnumber;
         ";
 
         $stmt = $conn->prepare($SQL);
         $stmt->bindParam('s', $newpassword, PDO::PARAM_STR);
         $stmt->bindParam('s', $indexnumber, PDO::PARAM_STR);
 
         $isExecuted = $stmt->execute([
             'indexnumber' => $indexnumber,
             'newpassword' => $newpassword
         ]);
 
         if ($isExecuted) {
             $_SESSION['message'] = $indexnumber . ", Your Password Has Been Updated";
             $_SESSION['alert-class'] = "alert alert-success";
         } else {
             $_SESSION['message'] = $indexnumber . ", Your Password Failed To Be Updated";
             $_SESSION['alert-class'] = "alert alert-success";
         } 
    }
}

?>

<div id="layoutSidenav_content">
    <main>
        <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
            <div class="container-fluid">
                <div class="page-header-content">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="edit-3"></i></div>
                        <span>Manage Profile</span>
                    </h1>
                </div>
            </div>
        </div>

        <!--Start Form-->
        <div class="container-fluid mt-n10">
            <div class="card mb-4">
                <div class="card-header">Change Password</div>
                <div class="card-body">
                    <form method="POST">


                        <div class="row">
                            <div class="col-md-6 offset-md-3">
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

                                <div class="col-12 form-group">
                                    <label for="user-name" class="text-primary">Old Password </label>
                                    <input type="password" name="oldpassword" class="form-control" placeholder="Old Password">
                                </div>

                                <div class="col-12 form-group">
                                    <label for="user-name" class="text-primary">New Password </label>
                                    <input type="password" name="newpassword" class="form-control" placeholder="New Password">
                                </div>

                                <div class="col-12 form-group">
                                    <label for="user-name" class="text-primary">Confirm New Password </label>
                                    <input type="password" name="confirmnewpassword" class="form-control" placeholder="Confirm New Password">
                                </div>

                                <div class="col-12 form-group">
                                    <div class="col-12">
                                        <button class="btn btn-warning mr-2 my-1 form-control" type="submit" name="submit">Change Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>

                </div>
            </div>
        </div>
        <!--End Form-->

    </main>

</div>

<!--Script JS-->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>

</body>