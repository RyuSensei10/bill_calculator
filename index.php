<!DOCTYPE html>
<html lang="en">
<head>
    <title>Electricity Bill Calculator</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

     <style>
        .custom-box {
            border: 1px solid #007bff;
            border-radius: 8px;
            padding: 10px;
        }
    </style>

    

</head>
<body>

<?php
session_start();

$error = '';

// handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calculate'])) {

    $voltage = trim($_POST['voltage']);
    $current = trim($_POST['current']);
    $rate    = trim($_POST['rate']);

    // validate: must not be empty and must be numeric
    if ($voltage === '' || $current === '' || $rate === '' ||
        !is_numeric($voltage) || !is_numeric($current) || !is_numeric($rate)) {

        // clear any previous result
        unset($_SESSION['voltage'], $_SESSION['current'], $_SESSION['rate']);
        $_SESSION['error'] = 'Please fill in all fields with valid numbers.';

        header("Location: index.php");
        exit();
    }

    // save data into session
    $_SESSION['voltage'] = $voltage;
    $_SESSION['current'] = $current;
    $_SESSION['rate']    = $rate;
    unset($_SESSION['error']);

    // redirect so refresh won't resubmit the form
    header("Location: index.php?calculated=1");
    exit();
}

if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

// if user opens the page fresh (no ?calculated=1), clear old result
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_GET['calculated'])) {
    unset($_SESSION['voltage'], $_SESSION['current'], $_SESSION['rate']);
}

?>

<div class="container mt-5">

    <form method="POST" action="index.php">

        <div class="container mt-3 text-center">
             <h1>Calculate</h1>
        </div>

        <div class="form-group">
            <label><b>Voltage</b></label>
            <input type="text" name="voltage" class="form-control" placeholder="Voltage (V)">
        </div>

        <div class="form-group">
            <label><b>Current</b></label>
            <input type="text" name="current" class="form-control" placeholder="Ampere (A)">
        </div>

        <div class="form-group">
            <label><b>CURRENT RATE</b></label>
            <input type="text" name="rate" class="form-control" placeholder="sen/kWh">
        </div>

        <div class="text-center">
            <button type="submit" name="calculate" class="btn btn-primary">calculate</button>
        </div>

    </form>

    <br>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>


    <?php
    if (isset($_GET['calculated']) && isset($_SESSION['voltage'])) {

        // get value from session
        $voltage = $_SESSION['voltage'];
        $current = $_SESSION['current'];
        $rate    = $_SESSION['rate'];

        // calculate power
        $power = $voltage * $current; // power in Wh
    ?>
<div class="text-center custom-box mb-5">
    <p><b>POWER :</b> <?php echo round($power / 1000, 5); ?>kw</p>
    <p><b>RATE :</b> <?php echo round($rate / 100, 3); ?>RM</p>
</div>

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Hour</th>
            <th>Energy (kWh)</th>
            <th>TOTAL (RM)</th>
        </tr>

        <?php
        // loop for 24 hours
        for ($hour = 1; $hour <= 24; $hour++) {

            $energy = ($power * $hour) / 1000; // energy in kWh
            $total = $energy * ($rate / 100); // total in RM
        ?>
        <tr>
            <td><?php echo $hour; ?></td>
            <td><?php echo $hour; ?></td>
            <td><?php echo round($energy, 5); ?></td>
            <td><?php echo round($total, 2); ?></td>
        </tr>
        <?php } ?>
    </table>

   

    <?php } ?>

</div>

</body>
</html>