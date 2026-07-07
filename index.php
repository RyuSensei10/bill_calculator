<!DOCTYPE html>
<html lang="en">
<head>
    <title>Electricity Bill Calculator</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .custom-box {
            border: 1px solid #007bff;
            border-radius: 8px;
            padding: 10px;
        }

        .text-dark-blue {
        color: #003366; 
    }
    </style>
</head>
<body>

<?php
// Initialize form variable defaults
$voltage = '';
$current = '';
$rate    = '';
$error   = '';
$show_results = false;

// Handle form submit directly inside the POST request lifecycle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calculate'])) {

    $voltage = trim($_POST['voltage']);
    $current = trim($_POST['current']);
    $rate    = trim($_POST['rate']);

    // Validate: must not be empty and must be numeric
    if ($voltage === '' || $current === '' || $rate === '' ||
        !is_numeric($voltage) || !is_numeric($current) || !is_numeric($rate)) {
        
        $error = 'Please fill in all fields with valid numbers.';
    } else {
        // Validation passes; set flag to show results immediately without a redirect
        $show_results = true;
    }
}
?>

<div class="container mt-5 pt-3">

    <div class="text-center text-dark-blue mb-4">
         <h1>Calculate</h1>
    </div>

    <form method="POST" action="index.php">

        <div class="form-group">
            <label><b>Voltage</b></label>
            <input type="text" name="voltage" class="form-control" placeholder="Voltage (V)"
                   value="<?php echo htmlspecialchars($voltage); ?>">
        </div>

        <div class="form-group">
            <label><b>Current</b></label>
            <input type="text" name="current" class="form-control" placeholder="Ampere (A)"
                   value="<?php echo htmlspecialchars($current); ?>">
        </div>

        <div class="form-group">
            <label><b>CURRENT RATE</b></label>
            <input type="text" name="rate" class="form-control" placeholder="sen/kWh"
                   value="<?php echo htmlspecialchars($rate); ?>">
        </div>

        <div class="text-center mt-4">
            <button type="submit" name="calculate" class="btn btn-primary px-4">calculate</button>
        </div>

    </form>

    <br>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php
    if ($show_results) {
        // Calculate power (Watts)
        $power = $voltage * $current; 
    ?>

    <div class="text-center custom-box mb-5">
        <p class="mb-2 text-dark-blue"><b>POWER :</b> <?php echo round($power / 1000, 5); ?> kw</p>
        <p class="mb-0 text-dark-blue"><b>RATE :</b> <?php echo round($rate / 100, 3); ?> RM</p>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Hour</th>
                <th>Energy (kWh)</th>
                <th>TOTAL (RM)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Generate a row mapping metrics hour-by-hour for a 24-hour bracket
            for ($hour = 1; $hour <= 24; $hour++) {
                $energy = ($power * $hour) / 1000; 
                $total  = $energy * ($rate / 100); 
            ?>
            <tr>
                <td><?php echo $hour; ?></td>
                <td><?php echo $hour; ?></td>
                <td><?php echo round($energy, 5); ?></td>
                <td><?php echo number_format($total, 2); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php } ?>

</div>

</body>
</html>