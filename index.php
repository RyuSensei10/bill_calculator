<?php


// Function: calculate power (Wh) from voltage and current
function calculatePower($voltage, $current) {
    return $voltage * $current; // Power (Wh) = Voltage (V) * Current (A)
}

// Function: calculate energy (kWh) for a given hour
function calculateEnergy($powerWh, $hour) {
    // Energy (kWh) = Power (Wh) * Hour / 1000
    return ($powerWh * $hour) / 1000;
}

// Function: calculate total charge (RM) based on rate (sen/kWh)
function calculateTotal($energyKwh, $rate) {
    // Total (RM) = Energy (kWh) * (rate / 100)
    return $energyKwh * ($rate / 100);
}

// Default values
$voltage = '';
$current = '';
$rate    = '';
$results = [];
$powerWh = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voltage = isset($_POST['voltage']) ? floatval($_POST['voltage']) : 0;
    $current = isset($_POST['current']) ? floatval($_POST['current']) : 0;
    $rate    = isset($_POST['rate']) ? floatval($_POST['rate']) : 0;

    $powerWh = calculatePower($voltage, $current);

    for ($hour = 1; $hour <= 24; $hour++) {
        $energy = calculateEnergy($powerWh, $hour);
        $total  = calculateTotal($energy, $rate);
        $results[] = [
            'hour'   => $hour,
            'energy' => $energy,
            'total'  => $total,
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kira Elektrik - Electricity Bill Calculator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/css/bootstrap.min.css">
    <style>
        body { background-color: #f4f6f9; padding-top: 40px; padding-bottom: 40px; }
        .calc-card { max-width: 900px; margin: 0 auto; }
        .summary-box { background: #e9f5ff; border-radius: 8px; padding: 15px; margin-top: 15px; }
    </style>
</head>
<body>
<div class="container calc-card">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Kira Elektrik (Electricity Calculator)</h3>

            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="voltage">Voltage (V)</label>
                        <input type="number" step="any" class="form-control" id="voltage" name="voltage"
                               value="<?php echo htmlspecialchars($voltage); ?>" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="current">Current (A)</label>
                        <input type="number" step="any" class="form-control" id="current" name="current"
                               value="<?php echo htmlspecialchars($current); ?>" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="rate">Current Rate (sen/kWh)</label>
                        <input type="number" step="any" class="form-control" id="rate" name="rate"
                               value="<?php echo htmlspecialchars($rate); ?>" required>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-5">Calculate</button>
                </div>
            </form>

            <?php if (!empty($results)): ?>
                <div class="summary-box">
                    <strong>POWER :</strong> <?php echo round($powerWh / 1000, 5); ?> kW
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    <strong>RATE :</strong> <?php echo round($rate / 100, 3); ?> RM
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Hour</th>
                                <th>Energy (kWh)</th>
                                <th>TOTAL (RM)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $row): ?>
                                <tr>
                                    <td><?php echo $row['hour']; ?></td>
                                    <td><?php echo $row['hour']; ?></td>
                                    <td><?php echo round($row['energy'], 5); ?></td>
                                    <td><?php echo round($row['total'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>