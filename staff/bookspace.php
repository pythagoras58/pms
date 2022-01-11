<?php
include('header.php');

//get the parking name from the url
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Get the name of the id in the url
$bookNameSQL = "Select * from parking_lot WHERE id=:id LIMIT 1";
$stmt = $conn->prepare($bookNameSQL);
$stmt->bindParam("s", $id, PDO::PARAM_STR);
$stmt->execute(['id' => $id]);

//Get the result in an array
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$userCount = $stmt->rowCount();

if ($userCount > 0) {
    $parking_lot = $row['name'];
}

//Get the contact of the user
$getContactSQL = "SELECT * from staff Where indexnumber=:indexnumber";
$getContactSTMT = $conn->prepare($getContactSQL);
$getContactSTMT->bindParam('s', $indexnumber, PDO::PARAM_STR);
$getContactSTMT->execute([
    'indexnumber' => $indexnumber,
]);
$getRow = $getContactSTMT->fetch(PDO::FETCH_ASSOC);
$findContactCount = $getContactSTMT->rowCount();

if ($findContactCount > 0) {
    $contact = $getRow['contact'];
}

//############################################
//codes to book space
if (isset($_POST['submit'])) {

    // get the carnumber
    $carnumber = htmlspecialchars($_POST['carnumber']);
    $parking_time = htmlspecialchars($_POST['parking_time']);
    $status = 'booked';

    //validation
    if (empty($carnumber)) {
        $errors['carnumber'] = "Car Number Is Required";
    }

    if(empty($parking_time)){
        $errors['parking_time'] = "Parking Time Is Required";
    }

    // validate student indexnumber
    $indexQuery = "SELECT * FROM booking WHERE indexnumber=:indexnumber LIMIT 1";
    $stmt = $conn->prepare($indexQuery);
    $stmt->bindParam('s', $indexnumber, PDO::PARAM_STR);
    $stmt->execute(['indexnumber' => $indexnumber]);

    $searchresult = $stmt->fetchAll(PDO::FETCH_OBJ);
    $searchuserCount = $stmt->rowCount();
    //$stmt->close();

    if ($searchuserCount > 0) {
        $errors['indexFound'] = "You cannot book more than 1 space";
    }

    if (count($errors) === 0) {
        $bookSQL = "INSERT INTO booking(indexnumber, carnumber,parking_lot,contact, parking_time,status)
                    VALUES(:indexnumber, :carnumber, :parking_lot, :contact,:parking_time,:status);
                    INSERT INTO transactionLog(indexnumber, carnumber) VALUES(:indexnumber, :carnumber);
                    UPDATE parking_lot SET status=:status WHERE id=:id";
        $bookSQLStmt = $conn->prepare($bookSQL);
        $bookSQLStmt->bindParam('s', $indexnumber, PDO::PARAM_STR);
        $bookSQLStmt->bindParam('s', $carnumber, PDO::PARAM_STR);
        $bookSQLStmt->bindParam('s', $parking_lot, PDO::PARAM_STR);
        $bookSQLStmt->bindParam('s', $contact, PDO::PARAM_STR);
        $bookSQLStmt->bindParam('s', $parking_time, PDO::PARAM_STR);
        $bookSQLStmt->bindParam('s', $status, PDO::PARAM_STR);
        $bookSQLStmt->bindParam(':id', $id, PDO::PARAM_INT);

        //execute query
        $is_executed = $bookSQLStmt->execute([
            'indexnumber' => $indexnumber,
            'carnumber' => $carnumber,
            'parking_lot' => $parking_lot,
            'contact' => $contact,
            'parking_time' => $parking_time,
            'status' => $status,
            'id' => $id
        ]);

        if ($is_executed) {
            $_SESSION['message'] =  $parking_lot . ' Booked Successfully' . $indexnumber;
            $_SESSION['alert-class'] = "alert alert-success";
        } else {
            $_SESSION['message'] =  "Booking Failed";
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
                        <span>Book Space</span>
                    </h1>
                </div>
            </div>
        </div>

        <!--Start Form-->
        <div class="container-fluid mt-n10">
            <div class="card mb-4">
                <div class="card-header">Your Details</div>
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
                            <input type="text" name="carnumber" id="carnumber" placeholder="Enter Car Number" class="form-control">
                            <br>

                            <label for="index">Parking Time</label>
                            <input type="time" name="parking_time" id="parking_time" placeholder="Enter Parking Time" class="form-control">
                            <br>

                        </div>

                        <br>
                        <div class="row col-md-6 offset-md-3">
                            <div class="col-6">
                                <button class="btn btn-primary mr-2 my-1 form-control" type="submit" name="submit">Book Space</button>
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