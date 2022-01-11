<?php
include('header.php');

$errors = array();

//add department
if (isset($_POST['submit'])) {
    //Get the course data
    $name = htmlentities($_POST['name']);
    $indexnumber = htmlentities($_POST['indexnumber']);
    $password = htmlentities($_POST['password']);
    $contact = htmlentities($_POST['contact']);
    $usertype = "Security";


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

    if (empty($contact)) {
        $errors['contact'] = "Contact Is Required";
    }

    //check if the Index number is used or not
    $indexQuery = "SELECT * FROM security WHERE indexnumber=:indexnumber LIMIT 1";
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

        $addSecurityQuery = "INSERT INTO security(indexnumber, name, contact, password)
                VALUES(:indexnumber, :name, :contact, :password);
                INSERT INTO authentication(indexnumber, password, usertype)
                    VALUES(:indexnumber, :password, :usertype)";

        $addSecurityStmt = $conn->prepare($addSecurityQuery);

        //Bind the field to PDO parameters
        $addSecurityStmt->bindParam('s', $indexnumber, PDO::PARAM_STR);
        $addSecurityStmt->bindParam('s', $name, PDO::PARAM_STR);
        $addSecurityStmt->bindParam('s', $contact, PDO::PARAM_STR);
        $addSecurityStmt->bindParam('s', $password, PDO::PARAM_STR);
        $addSecurityStmt->bindParam('s', $usertype, PDO::PARAM_STR);

        //execute pdo query
        $addSecurityStmt->execute(
            [
                'indexnumber' => $indexnumber,
                'name' => $name,
                'contact' => $contact,
                'password' => $password,
                'usertype' => $usertype
            ]
        );

        //check if security addition was successful
        $lastInsertId = $conn->lastInsertId();

        if ($lastInsertId) {
           
            echo "<script>window.alert('Security Successfully Added');
            window.location.href='security.php';        
            </script>";
            $_SESSION['message'] = "Security Registed Successfully";
            $_SESSION['alert-class'] = "alert alert-success";
        } else {
            $_SESSION['message'] = "Sorry!! Security Registration Failed";
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
                        <span>Create New Security Personnel</span>
                    </h1>
                </div>
            </div>
        </div>

        <!--Start Form-->
        <div class="container-fluid mt-n10">
            <div class="card mb-4">
                <div class="card-header">Create Security Personnel</div>
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
                            <div class="col-6 form-group">
                                <label for="user-name">Security Name </label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>

                            <div class="col-6 form-group">
                                <label for="user-name">Index Number </label>
                                <input type="text" name="indexnumber" id="indexnumber" class="form-control">
                            </div>

                        </div>

                        <div class="row col-12">
                            <div class="col-6 form-group">
                                <label for="user-name">Password:</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                            <div class="col-6 form-group">
                                <label for="user-name">Contact:</label>
                                <input type="tel" name="contact" id="contact" class="form-control">
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
                <div class="card-header">All Security Personnel</div>
                <div class="card-body">
                    <div class="datatable table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Index Number</th>
                                    <th>Name </th>
                                    <th>Contact </th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql = "SELECT * FROM security";
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
                                            <td><?php echo htmlentities($results->contact) ?></td>
                                            <td>
                                                <a class="btn btn-blue btn-icon" href="edit-security.php?id=<?php echo htmlentities($results->id); ?>"><i data-feather="edit"></i></a>
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