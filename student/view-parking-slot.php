<?php
include('header.php');



?>


<div id="layoutSidenav_content">
    <main>
        <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
            <div class="container-fluid">
                <div class="page-header-content">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="edit-3"></i></div>
                        <span>View Parking Slots</span>
                    </h1>
                </div>
            </div>
        </div>


        <!--Table-->
        <div class="container-fluid ">

            <div class="card mb-4">
                <div class="card-header">
                    <span>All Parking Slot</span>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary modalButton" data-toggle="modal" data-target="#bookedModal">
                        Booked Space
                    </button>
                </div>
                <div class="card-body">
                    <div class="datatable table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $sql = "SELECT * FROM parking_lot WHERE status='Active' AND type='student'";
                                $query = $conn->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $rowCount = $query->rowCount();

                                if ($rowCount <= 0) {
                                    echo '<div class="alert alert-primary" role="alert">
                                            No Parking Space For Students Yet!
                                        </div>';
                                }

                                if ($rowCount > 0) {
                                    foreach ($results as $results) {
                                ?>
                                        <tr>
                                            <td><?php echo htmlentities($results->name) ?></td>
                                            <td><?php echo htmlentities($results->location) ?></td>
                                            <td><?php echo htmlentities($results->type) ?></td>
                                            <td>
                                                <div class="badge badge-success">
                                                    <?php echo htmlentities($results->status) ?>
                                                </div>
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

    <!-- Modal -->
    <div class="modal fade" id="bookedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="exampleModalLongTitle">ALl Booked Parking Space</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="datatable table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Index Number </th>
                                    <th>Car Number </th>
                                    <th>Parking Name </th>
                                    <th>Contact</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql = "SELECT * FROM booking WHERE status='booked'";
                                $query = $conn->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $rowCount = $query->rowCount();

                                if ($rowCount <= 0) {
                                    echo '<div class="alert alert-primary" role="alert">
                                            No Space Booked Yet!
                                        </div>';
                                }

                                if ($rowCount > 0) {
                                    foreach ($results as $results) {
                                ?>
                                        <tr>
                                            <td><?php echo htmlentities($results->indexnumber) ?></td>
                                            <td><?php echo htmlentities($results->carnumber) ?></td>
                                            <td><?php echo htmlentities($results->parking_lot) ?></td>
                                            <td><?php echo htmlentities($results->contact) ?></td>
                                            <td><?php echo htmlentities($results->parking_time) ?></td>
                                            <td>
                                                <div class="badge badge-warning">
                                                    <?php echo htmlentities($results->status) ?>
                                                </div>
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

<!--Script JS-->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>

</body>