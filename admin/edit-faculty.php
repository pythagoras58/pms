<?php
include('header.php');
$errors = array();
// get the id of the user to be updated
$facultyyid = $_GET['id'];
// Get the details of the faculty
$getFaculty = "Select * from faculty WHERE id=:facultyyid LIMIT 1";
$stmt = $conn->prepare($getFaculty);
$stmt->bindParam("s", $facultyyid, PDO::PARAM_STR);
$stmt->execute(['facultyyid' => $facultyyid]);

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
        $SQL = "UPDATE faculty SET name=:name WHERE id=:facultyyid";
        $stmt = $conn->prepare($SQL);
        $stmt->bindParam('s', $name, PDO::PARAM_STR);
        $stmt->bindParam('s', $facultyyid, PDO::PARAM_STR);

        $isExecuted = $stmt->execute([
            'name' => $name,
            'facultyyid' => $facultyyid
        ]);

        if ($isExecuted) {
            $_SESSION['message'] = $indexnumber . ", Faculty Details Has Been Updated";
            $_SESSION['alert-class'] = "alert alert-success";
        } else {
            $_SESSION['message'] = $indexnumber . ", Faculty Failed To Be Updated";
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
                        <span>Edit Faculty</span>
                    </h1>
                </div>
            </div>
        </div>

        <!--Start Form-->
        <div class="container-fluid mt-n10">
            <div class="card mb-4">
                <div class="card-header">Current Faculty Details</div>
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
                            <div class="col-12">
                                <button class="btn btn-primary mr-2 my-1 form-control" type="submit" name="submit">Edit Profile</button>
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