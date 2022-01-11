<?php
    session_start();
    include('assets/connection/connection.php');

    $errors = array();

    // check if the submit button is clicked
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>SIGN UP || CPS</title>
    <link href="admin/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="admin/assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="admin/js/all.min.js"></script>
    <script src="admin/js/feather.min.js"></script>
    <style>
        #bg-body {
            background-image: url('assets/image/bg-image.jpg') !important;
        }

        .textColor {
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
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header justify-content-center">
                                    <h3 class="font-weight-light my-4">Create Student Account</h3>
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
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1 textColor" for="inputName">Name</label>
                                                    <input class="form-control py-4" id="inputName" type="text" name="name" placeholder="Enter Student Name" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1 textColor" for="inputLastName">Index Number</label>
                                                    <input class="form-control py-4" id="indexnumber" type="text" name="indexnumber" placeholder="Enter Student ID" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1 textColor" for="inputFaculty">Faculty</label>
                                                    <select name="faculty" id="faculty" class="form-control" required>
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
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1 textColor" for="inputDepartment">Department</label>
                                                    <select name="department" id="department" class="form-control" require>
                                                        <option value="default">Select Department</option>
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
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1 textColor" for="inputContact">Contact</label>
                                                    <input class="form-control py-4" id="contact" type="tel" name="contact" placeholder="Enter Contact" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1 textColor" for="inputPassword">Password</label>
                                                    <input class="form-control py-4" name="password" type="password" placeholder="Password" />
                                                </div>
                                            </div>
                                        </div>

                                       
                                        <button class="btn btn-primary mr-2 my-1 form-control" type="submit" name="submit">Create now!</button>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small"><a href="index.php">Have an account? Go to signin</a></div>
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