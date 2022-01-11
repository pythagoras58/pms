<?php 
    include('header.php');

    //add faculty
    if(isset($_POST['submit'])){
        //Get the course data
        $name = htmlentities($_POST['name']);
        $status = 'Active';

        $insertFacultySQL = "INSERT INTO faculty(name,status)
        VALUES(:name, :status)";

        $stmt = $conn->prepare($insertFacultySQL);
        $stmt->bindParam('s', $name, PDO::PARAM_STR);
        $stmt->bindParam('s', $status, PDO::PARAM_STR);

        $stmt->execute([
            'name' => $name,
            'status' => $status
        ]);

        $lastInsertId = $conn->lastInsertId();
        if($lastInsertId){
            echo "<script>window.alert('Faculty Successfully Added');
                            window.location.href='faculty.php';        
            </script>";
        }else{
            echo "<script>window.alert('Faculty Addition Failed');</script>";
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
                        <span>Create New Faculty</span>
                    </h1>
                </div>
            </div>
        </div>

        <!--Start Form-->
        <div class="container-fluid mt-n10">
            <div class="card mb-4">
                <div class="card-header">Create New Faculty</div>
                <div class="card-body">
                    <form method="POST">

                        <div class="form-group">
                            <label for="user-name">Faculty Name:</label>
                            <input class="form-control" id="name" name="name" type="text" placeholder="Faculty Name..." />
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
                <div class="card-header">All Faculty</div>
                <div class="card-body">
                    <div class="datatable table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name </th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql = "SELECT * FROM faculty";
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
                                            <td>
                                                <a class="btn btn-blue btn-icon" href="edit-faculty.php?id=<?php echo htmlentities($results->id); ?>"><i data-feather="edit"></i></a>
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

</html>