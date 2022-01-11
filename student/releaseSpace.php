<?php
include('header.php');

//get the parking name from the url
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Get the details of the id in the url
$bookNameSQL = "Select * from booking WHERE id=:id LIMIT 1";
$stmt = $conn->prepare($bookNameSQL);
$stmt->bindParam("s", $id, PDO::PARAM_STR);
$stmt->execute(['id' => $id]);

//Get the result in an array
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$userCount = $stmt->rowCount();

if ($userCount > 0) {
    $parking_lot = $row['parking_lot'];
    $carnumber = $row['carnumber'];
    $contact = $row['contact'];
}

$_SESSION['message'] =  "Are you sure of releasing parking space??";
$_SESSION['alert-class'] = "alert alert-warning";

//############################################
//codes to release space
if (isset($_POST['submit'])) {

    if (count($errors) === 0) {
        $bookSQL = "DELETE FROM booking WHERE id=:id;
                    UPDATE parking_lot SET status='Active' WHERE name=:parking_lot";
        $bookSQLStmt = $conn->prepare($bookSQL);
        $bookSQLStmt->bindParam('s', $parking_lot, PDO::PARAM_STR);
        $bookSQLStmt->bindParam(':id', $id, PDO::PARAM_INT);

        //execute query
        $is_executed = $bookSQLStmt->execute([
            'parking_lot' => $parking_lot,
            'id' => $id
        ]);

        if ($is_executed) {
            $_SESSION['message'] =  $parking_lot . ' Released Successfully' . $indexnumber;
            $_SESSION['alert-class'] = "alert alert-success";
        } else {
            $_SESSION['message'] =  "Booking Release Failed";
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
                        <span>Manage Booking</span>
                    </h1>
                </div>
            </div>
        </div>

        <!--Start Form-->
        <div class="container-fluid mt-n10">
            <div class="card mb-4">
                <div class="card-header">Your Booked Space</div>
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

                            <label for="user-name">Parking Name </label>
                            <input type="text" name="name" id="name" class="form-control" disabled value="<?php echo $parking_lot ?>">

                            <br>

                            <label for="index">Car Number</label>
                            <input type="text" name="carnumber" disabled value="<?php echo $carnumber ?>" class="form-control">
                            <br>

                            <label for="index">Contact</label>
                            <input type="text" name="contact" disabled value="<?php echo $contact ?>" class="form-control">
                            <br>

                        </div>

                        <br>
                        <div class="row col-md-6 offset-md-3">
                            <div class="col-6">
                                <button class="btn btn-primary mr-2 my-1 form-control" type="submit" name="submit">Release Space</button>
                            </div>

                            <div class="col-6">
                                <a class="btn btn-warning mr-2 my-1 form-control" href="booking.php"><i data-feather="back"> </i> Return</a>
                            </div>
                        </div>


                    </form>

                </div>
            </div>
        </div>
        <!--End Form-->

    </main>