<?php
include('header.php');


$errors = array();

//add student
if (isset($_POST['submit'])) {

    // get all the data from the controls
    //Get the course data
    $name = htmlentities($_POST['name']);
    $location = htmlentities($_POST['location']);
    $type = htmlentities($_POST['type']);
    $status = "Active";

    // check if all data are inputted (Validation)
    if (empty($name)) {
        $errors['name'] = "Name Is Required";
    }

    if (empty($location)) {
        $errors['location'] = "Location Is Required";
    }

    if (empty($type)) {
        $errors['type'] = "Parking Type is Required";
    }

    if ($type === "default") {
        $errors['defaultType'] = "Select Type";
    }

    // validate to make sure the index number is not in the system
    $nameQuery = "SELECT * FROM parking_lot WHERE name=:name LIMIT 1";
    $stmt = $conn->prepare($nameQuery);
    $stmt->bindParam('s', $name, PDO::PARAM_STR);
    $stmt->execute(['name' => $name]);

    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    $userCount = $stmt->rowCount();

    // close the statement 
    //$stmt->close();

    if ($userCount > 0) {
        $errors['nameFound'] = "Hey!! " . $indexnumber . " Parking Name is already in the system";
    }


    // insert the data to register parking space in the database
    if (count($errors) === 0) {

        $addParkingSpaceQuery = "INSERT INTO parking_lot(name,location,type,status)
                                 VALUES(:name, :location, :type, :status)";
        $addParkingSpaceSTMT = $conn->prepare($addParkingSpaceQuery);

        //Bind the variables to the stmt
        $addParkingSpaceSTMT->bindParam('s', $name, PDO::PARAM_STR);
        $addParkingSpaceSTMT->bindParam('s', $location, PDO::PARAM_STR);
        $addParkingSpaceSTMT->bindParam('s', $type, PDO::PARAM_STR);
        $addParkingSpaceSTMT->bindParam('s', $status, PDO::PARAM_STR);

        // execute stmt
        $addParkingSpaceSTMT->execute([
            'name' => $name,
            'location' => $location,
            'type' => $type,
            'status' => $status
        ]);

        //check if addition was successful
        $lastInsertId = $conn->lastInsertId();

        if($lastInsertId){
            $_SESSION['message'] = "Parking Space Added";
            $_SESSION['alert-class'] = "alert alert-success alert-dismissible fade show";
        }else{
            $_SESSION['message'] = "Parking Space Addition Failed";
            $_SESSION['alert-class'] = "alert alert-danger alert-dismissible fade show";
        }
        //error
        
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
                        <span>Manage Parking Slots</span>
                    </h1>
                </div>
            </div>
        </div>

        <!--Start Form-->
        <div class="container-fluid mt-n10">
            <div class="card mb-4">
                <div class="card-header">Create Parking Slot</div>
                <div class="card-body">

                    <div class="text-center">
                        <?php
                        if (count($errors) > 0) :
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php foreach ($errors as $error) : ?>
                                    <li><?php echo $error; ?></li><br>
                                <?php endforeach; ?>

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['message'])) : ?>
                            <div class="alert <?php echo $_SESSION['alert-class']; ?>" role="alert">
                                <strong>
                                    <?php
                                    echo $_SESSION['message'];
                                    unset($_SESSION['message']);
                                    unset($_SESSION['alert-class']);
                                    ?>
                                </strong>

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                            </div>
                        <?php endif; ?>
                    </div>
                    <form method="POST">
                        <div class="row col-12">
                            <div class="col-4 form-group">
                                <label for="user-name">Parking Mark / Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>

                            <div class="col-4 form-group">
                                <label for="user-name">Location</label>
                                <input type="text" name="location" id="location" class="form-control">
                            </div>

                            <div class="col-4 form-group">
                                <label for="user-name">Parking Type </label>
                                <select class="form-control" name="type" id="type">
                                    <option value="default">Select Parking Type</option>
                                    <option value="student">Student</option>
                                    <option value="lecturer">Lecturer</option>
                                </select>
                            </div>

                        </div>

                        <div class="row col-12">
                            <div class="col-md-4 offset-md-4">
                                <button class="btn btn-primary mr-2 my-1 form-control" type="submit" name="submit">Create now!</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--End Form-->

        <!--Table-->
        <div class="container-fluid ">

            <div class="card mb-4">
                <div class="card-header">All Parking Slot</div>
                <div class="card-body">
                    <div class="datatable table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Parking ID</th>
                                    <th>Name </th>
                                    <th>Location </th>
                                    <th>Type </th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql = "SELECT * FROM parking_lot";
                                $query = $conn->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $rowCount = $query->rowCount();

                                if ($rowCount > 0) {
                                    foreach ($results as $results) {
                                ?>
                                        <tr>
                                            <td><?php echo htmlentities($results->id) ?></td>
                                            <td><?php echo htmlentities($results->name) ?></td>
                                            <td><?php echo htmlentities($results->location) ?></td>
                                            <td><?php echo htmlentities($results->type) ?></td>
                                            <td>
                                                <div class="badge badge-success">
                                                    <?php echo htmlentities($results->status) ?>
                                                </div>
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