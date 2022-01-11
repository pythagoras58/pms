<?php
include('header.php');
$errors = array();
// Get the details of the admin
$getAdmin = "Select * from admin WHERE indexnumber=:indexnumber LIMIT 1";
$stmt = $conn->prepare($getAdmin);
$stmt->bindParam("s", $id, PDO::PARAM_STR);
$stmt->execute(['indexnumber' => $indexnumber]);

//Get the result in an array
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$userCount = $stmt->rowCount();

if ($userCount > 0) {
    $getname = $row['name'];
}

//update admin info
if (isset($_POST['submit'])) {
    //get all the data from the field
    $name = htmlentities($_POST['name']);

    //validate all the fields
    if (empty($name)) {
        $errors['name'] = "Name Is Required";
    }

    if (count($errors) === 0) {
        //Lets edit the details
        $SQL = "UPDATE admin SET name=:name WHERE indexnumber=:indexnumber";
        $stmt = $conn->prepare($SQL);
        $stmt->bindParam('s', $name, PDO::PARAM_STR);
        $stmt->bindParam('s', $indexnumber, PDO::PARAM_STR);

        $isExecuted = $stmt->execute([
            'name' => $name,
            'indexnumber' => $indexnumber
        ]);

        if ($isExecuted) {
            $_SESSION['message'] = $indexnumber . ", Your Profile Has Been Updated";
            $_SESSION['alert-class'] = "alert alert-success";
        } else {
            $_SESSION['message'] = $indexnumber . ", Your Profile Failed To Be Updated";
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
                <div class="card-header">Your Details</div>
                <div class="card-body">
                    <form method="POST">

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

                        <div class="row col-md-6 offset-md-3">

                            <label for="user-name">Name </label>
                            <input type="text" name="name" id="name" class="form-control" value="<?php echo $getname ?>">

                            <br>

                        </div>

                        <br>
                        <div class="row col-md-6 offset-md-3">
                            <div class="col-6">
                                <button class="btn btn-primary mr-2 my-1 form-control" type="submit" name="submit">Edit Profile</button>
                            </div>

                            <div class="col-6">
                                <a class="btn btn-success mr-2 my-1 form-control" href="changePassword.php">Change Password</a>
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