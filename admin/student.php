<?php
include('header.php');

$errors = array();

//add student
if(isset($_POST['submit'])){

    // get all the data from the controls
    //Get the course data
    $name = htmlentities($_POST['name']);
    $indexnumber = htmlentities($_POST['indexnumber']);
    $password = htmlentities($_POST['password']);
    $faculty = htmlentities($_POST['faculty']);
    $contact = htmlentities($_POST['contact']);
    $department = htmlentities($_POST['department']);
    $usertype = "Student";

    // check if all data are inputted (Validation)
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

   

    // validate to make sure the index number is not in the system
    $indexQuery = "SELECT * FROM student WHERE indexnumber=:indexnumber LIMIT 1";
    $stmt = $conn->prepare($indexQuery);
    $stmt->bindParam('s', $indexnumber, PDO::PARAM_STR);
    $stmt->execute(['indexnumber' => $indexnumber]);

    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    $userCount = $stmt->rowCount();
    //$stmt->close();

    if ($userCount > 0) {
        $errors['indexFound'] = "Hey!! " . $name . " Your Index Number is used already";
    }

    // insert the data to register student in the database
    if (count($errors) === 0) {

        //encrypt password
        $password = password_hash($password, PASSWORD_DEFAULT);

        $addSecurityQuery = "INSERT INTO student(indexnumber, name,faculty, department, contact, password)
                VALUES(:indexnumber, :name, :faculty, :department, :contact, :password);
                INSERT INTO authentication(indexnumber, password, usertype)
                    VALUES(:indexnumber, :password, :usertype)";

        $addSecurityStmt = $conn->prepare($addSecurityQuery);

        //Bind the field to PDO parameters
        $addSecurityStmt->bindParam('s', $indexnumber, PDO::PARAM_STR);
        $addSecurityStmt->bindParam('s', $name, PDO::PARAM_STR);
        $addSecurityStmt->bindParam('s', $contact, PDO::PARAM_STR);
        $addSecurityStmt->bindParam('s', $faculty, PDO::PARAM_STR);
        $addSecurityStmt->bindParam('s', $department, PDO::PARAM_STR);
        $addSecurityStmt->bindParam('s', $password, PDO::PARAM_STR);
        $addSecurityStmt->bindParam('s', $usertype, PDO::PARAM_STR);

        //execute pdo query
        $addSecurityStmt->execute(
            [
                'indexnumber' => $indexnumber,
                'name' => $name,
                'faculty' => $faculty,
                'department' => $department,
                'contact' => $contact,
                'password' => $password,
                'usertype' => $usertype
            ]
        );

        //check if staff addition was successful
        $lastInsertId = $conn->lastInsertId();

        if ($lastInsertId) {

            $_SESSION['message'] =  $name . ", you are  registed Successfully. kindly proceed to login";
            $_SESSION['alert-class'] = "alert alert-success";
        } else {
            $_SESSION['message'] = "Sorry!! " . $name . ", your Registration Failed";
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
                        <span>Manage Student</span>
                    </h1>
                </div>
            </div>
        </div>

        <!--Start Form-->
        <div class="container-fluid mt-n10">
            <div class="card mb-4">
                <div class="card-header">Create Student</div>
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
                                <label for="user-name">Staff Name </label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>

                            <div class="col-4 form-group">
                                <label for="user-name">Index Number </label>
                                <input type="text" name="indexnumber" id="indexnumber" class="form-control">
                            </div>

                            <div class="col-4 form-group">
                                <label for="user-name">Password </label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                        </div>

                        <div class="row col-12">

                            <div class="col-4 form-group">
                                <label for="user-name">Contact </label>
                                <input type="tel" name="contact" id="contact" class="form-control">
                            </div>

                            <div class="col-4 form-group">
                                <label for="user-name">Select Faculty:</label>
                                <select name="faculty" id="faculty" class="form-control">
                                    <option value="default">Select Faculty</option>
                                    <?php
                                    $sql = "SELECT * FROM faculty WHERE status='Active'";
                                    $query = $conn->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $levels) {
                                    ?>
                                            <option value="<?php echo htmlentities($levels->name); ?>">
                                                <?php echo htmlentities($levels->name); ?>
                                            </option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>

                            <div class="col-4 form-group">
                                <label for="user-name">Select Department:</label>
                                <select name="department" id="department" class="form-control">
                                    <option value="default" selected="true" disabled>Select Department</option>
                                    <?php
                                    $sql = "SELECT * FROM department WHERE status='Active'";
                                    $query = $conn->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $levels) {
                                    ?>
                                            <option value="<?php echo htmlentities($levels->name); ?>">
                                                <?php echo htmlentities($levels->name); ?>
                                            </option>
                                    <?php }
                                    } ?>
                                </select>
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
                <div class="card-header">All Student</div>
                <div class="card-body">
                    <div class="datatable table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Index Number</th>
                                    <th>Name </th>
                                    <th>Contact </th>
                                    <th>Department </th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql = "SELECT * FROM student";
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
                                            <td><?php echo htmlentities($results->department) ?></td>
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