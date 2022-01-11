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
                        <span>Booked Parking Slots</span>
                    </h1>
                </div>
            </div>
        </div>

        <!--Start Form-->
        <div class="container-fluid mt-n10">
            <div class="card mb-4">
                <div class="card-header">All Bookings</div>
                <div class="card-body">

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
                                    <th>Release Space</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql = "SELECT * FROM booking WHERE status='booked'";
                                $query = $conn->prepare($sql);
                                $query->execute(
                                   
                                );
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $rowCount = $query->rowCount();

                                if ($rowCount <= 0) {
                                    echo '<div class="alert alert-primary" role="alert">
                                            No Space booked yet! 
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
                                                <div class="badge badge-success">
                                                    <?php echo htmlentities($results->status) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="btn btn-info btn-icon" href="releaseSpace.php?id=<?php echo htmlentities($results->id);?>"><i data-feather="slack"></i></a>
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
        <!--End Form-->



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