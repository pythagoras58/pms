<?php
include('header.php');

//add department
if (isset($_POST['submit'])) {
    //Get the course data
    $name = htmlentities($_POST['name']);
    $faculty = htmlentities($_POST['faculty']);
    $status = "Active";

    
    $insertDepartmentSQL = "INSERT INTO department(name,faculty,status)
        VALUES(:name, :faculty, :status)";

    $stmt = $conn->prepare($insertDepartmentSQL);
    $stmt->bindParam('s', $name, PDO::PARAM_STR);
    $stmt->bindParam('s', $faculty, PDO::PARAM_STR);
    $stmt->bindParam('s', $status, PDO::PARAM_STR);

    $stmt->execute([
        'name' => $name,
        'faculty' => $faculty,
        'status' => $status,
    ]);

    $lastInsertId = $conn->lastInsertId();
    if ($lastInsertId) {
        echo "<script>window.alert('Department Successfully Added');
                            window.location.href='department.php';        
            </script>";
    } else {
        echo "<script>window.alert('Department Registration Failed');</script>";
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
                        <span>Create New Department</span>
                    </h1>
                </div>
            </div>
        </div>

        <!--Start Form-->
        <div class="container-fluid mt-n10">
            <div class="card mb-4">
                <div class="card-header">Create New Department</div>
                <div class="card-body">
                    <form method="POST">

                        <div class="form-group">
                            <label for="user-name">Department Name:</label>
                            <input class="form-control" id="name" name="name" type="text" placeholder="Department Name..." />
                        </div>

                        <div class="form-group">
                            <label for="user-name">Select Faculty:</label>
                            <select name="faculty" id="faculty" class="form-control">
                                <option value="default" selected="true" disabled="disabled">Select Faculty</option>
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

                        <button class="btn btn-primary mr-2 my-1" type="submit" name="submit">Create now!</button>
                    </form>
                </div>
            </div>
        </div>
        <!--End Form-->

        <!--Table-->
        <div class="container-fluid ">

            <div class="card mb-4">
                <div class="card-header">All Department</div>
                <div class="card-body">
                    <div class="datatable table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name </th>
                                    <th>Faculty </th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql = "SELECT * FROM department";
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
                                            <td><?php echo htmlentities($results->faculty) ?></td>
                                            <td>
                                                <a class="btn btn-blue btn-icon" href="edit-department.php?id=<?php echo htmlentities($results->id); ?>"><i data-feather="edit"></i></a>
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

