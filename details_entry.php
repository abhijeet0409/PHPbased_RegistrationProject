<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entry Form</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="details.css">
</head>
<body>
    <a href="new.html" style="position: absolute; top: 10px; left: 10px;">Go Back</a>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

            <?php 
                    if(isset($_SESSION['status']))
                    {
                        unset($_SESSION['status']);
                        echo '<script>alert("Data submitted successfully"); window.location.reload();</script>';
                    }
                ?>

                <div class="card mt-5">
                    <div class="card-header">
                        <h4>Entry Details</h4>
                    </div>
                    <div class="card-body">

                        <form action="details_entry_control.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Purpose</label>
                                <input type="text" name="purpose" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Phone No.</label>
                                <input type="tel" name="phone" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Type</label> <br>
                                <input type="radio" name="t" value="Visitor" /> Visitor
                                <input type="radio" name="t" value="Trainee" /> Trainee
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Entry Date & Time</label>
                                <input type="datetime-local" name="event_dt" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Exit Date & Time</label>
                                <input type="datetime-local" name="eventt_dt" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="save_datetime" class="btn btn-primary">Save Event</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>