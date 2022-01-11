<?php
include('header.php');

$errors = array();

//add department
if (isset($_POST['submit'])) {
    //Get the course data
    $name = htmlentities($_POST['name']);
    $indexnumber = htmlentities($_POST['indexnumber']);
    $password = htmlentities($_POST['password']);
    $usertype = "Admin";

    //validation
    if (empty($name)) {
        $errors['name'] = "Name Is Required";
    }

    if (empty($indexnumber)) {
        $errors['indexnumber'] = "Index Number Is Required";
    }

    if (empty($password)) {
        $errors['password'] = "Password Is Required";
    }

    

    //check if the Index number is used or not
    $indexQuery = "SELECT * FROM admin WHERE indexnumber=:indexnumber LIMIT 1";
    $stmt = $conn->prepare($indexQuery);
    $stmt->bindParam('s', $indexnumber, PDO::PARAM_STR);
    $stmt->execute(['indexnumber' => $indexnumber]);

    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    $userCount = $stmt->rowCount();
    //$stmt->close();

    if ($userCount > 0) {
        $errors['indexFound'] = "Index Number is used already";
    }

    if (count($errors) === 0) {

        //encrypt password
        $password = password_hash($password, PASSWORD_DEFAULT);

        $addSecurityQuery = "INSERT INTO admin(indexnumber, name, password)
                VALUES(:indexnumber, :name, :password);
                INSERT INTO authentication(indexnumber, password, usertype)
                    VALUES(:indexnumber, :password, :usertype)";

        $addSecurityStmt = $conn->prepare($addSecurityQuery);

        //Bind the field to PDO parameters
        $addSecurityStmt->bindParam('s', $indexnumber, PDO::PARAM_STR);
        $addSecurityStmt->bindParam('s', $name, PDO::PARAM_STR);
        $addSecurityStmt->bindParam('s', $password, PDO::PARAM_STR);
        $addSecurityStmt->bindParam('s', $usertype, PDO::PARAM_STR);

        //execute pdo query
        $addSecurityStmt->execute(
            [
                'indexnumber' => $indexnumber,
                'name' => $name,
                'password' => $password,
                'usertype' => $usertype
            ]
        );

        //check if Administrator addition was successful
        $lastInsertId = $conn->lastInsertId();

        if ($lastInsertId) {
           
            echo "<script>window.alert('Administrator Successfully Added');
            window.location.href='admin.php';        
            </script>";
            $_SESSION['message'] = "Administrator Registed Successfully";
            $_SESSION['alert-class'] = "alert alert-success";
        } else {
            $_SESSION['message'] = "Sorry!! Administrator Registration Failed";
            $_SESSION['alert-class'] = "alert alert-danger";
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
                        <span>Manage Administrator</span>
                    </h1>
                </div>
            </div>
        </div>

        <!--Start Form-->
        <div class="container-fluid mt-n10">
            <div class="card mb-4">
                <div class="card-header">Create New Administrator</div>
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

                        <div class="row col-12">
                            <div class="col-4 form-group">
                                <label for="user-name">Administrator Name </label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>

                            <div class="col-4 form-group">
                                <label for="user-name">Index Number </label>
                                <input type="text" name="indexnumber" id="indexnumber" class="form-control">
                            </div>

                            <div class="col-4 form-group">
                                <label for="user-name">Password:</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                        </div>

                        <button class="btn btn-primary mr-2 my-1" type="submit" name="submit">Create now!</button>
                    </form>
                </div>
            </div>
        </div>
        <!--End Form-->

        <!--Table-->
        <div class="container-fluid ">

            <div class="card mb-4">
                <div class="card-header">All Administrators</div>
                <div class="card-body">
                    <div class="datatable table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Index Number</th>
                                    <th>Name </th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql = "SELECT * FROM admin";
                                $query = $conn->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $rowCount = $query->rowCount();

                                if ($rowCount > 0) {
                                    foreach ($results as $results) {
                                ?>
                                        <tr>
                                            <td><?php echo htmlentities($results->indexnumber) ?></td>
                                            <td><?php echo htmlentities($results->name) ?></td>
                                            <td>
                                                <a class="btn btn-blue btn-icon" href="deleteCourse.php?id=<?php echo htmlentities($results->id); ?>"><i data-feather="edit"></i></a>
                                            </td>
                                            <td>
                                                <a class="btn btn-red btn-icon" href="#?id=<?php echo htmlentities($results->id); ?>"><i data-feather="delete"></i></a>
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </main>



    <!--start footer-->
    <?php include('footer.php') ?>
    <!--end footer-->
</div>
</div>

<!--Script JS-->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>

</body>