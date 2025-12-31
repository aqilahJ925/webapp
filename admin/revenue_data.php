<?php
require('connection.php');
header('Content-Type: application/json');

$type = $_GET['type'] ?? 'daily';

$labels = [];
$values = [];

if ($type === 'daily') {
    // Daily: last 20 individual payments
    $sql = "SELECT paymentID, amount, payment_date
            FROM payment
            WHERE LOWER(payment_status)='paid'
            ORDER BY payment_date DESC
            LIMIT 20";
    $result = $con->query($sql);
    while ($row = $result->fetch_assoc()) {
        $labels[] = "Payment #" . $row['paymentID'] . " (" . date('d M', strtotime($row['payment_date'])) . ")";
        $values[] = (float)$row['amount'];
    }
    // Reverse for ascending order
    $labels = array_reverse($labels);
    $values = array_reverse($values);

} elseif ($type === 'weekly') {
    // Weekly: sum of payments per week (last 6 weeks), labels Mon-Sun
    $weeks = [];
    $weekLabels = [];
    $today = new DateTime('monday this week');
    for ($i = 5; $i >= 0; $i--) {
        $start = clone $today;
        $start->sub(new DateInterval('P' . ($i * 7) . 'D'));
        $end = clone $start;
        $end->modify('+6 days');
        $weeks[] = [
            'start' => $start->format('Y-m-d'),
            'end' => $end->format('Y-m-d')
        ];
        $weekLabels[] = $start->format('d M') . ' - ' . $end->format('d M');
    }

    foreach ($weeks as $w) {
        $sql = "SELECT SUM(amount) AS total
                FROM payment
                WHERE LOWER(payment_status)='paid'
                  AND payment_date BETWEEN '{$w['start']}' AND '{$w['end']}'";
        $result = $con->query($sql);
        $total = $result->fetch_assoc()['total'] ?? 0;
        $values[] = (float)$total;
    }
    $labels = $weekLabels;

} elseif ($type === 'monthly') {
    // Monthly: sum of payments per month (last 12 months)
    $months = [];
    $monthLabels = [];
    $today = new DateTime();
    for ($i = 11; $i >= 0; $i--) {
        $month = clone $today;
        $month->modify("-$i month");
        $start = $month->format('Y-m-01');
        $end = $month->format('Y-m-t');
        $months[] = ['start' => $start, 'end' => $end];
        $monthLabels[] = $month->format('F Y'); // e.g., January 2025
    }

    foreach ($months as $m) {
        $sql = "SELECT SUM(amount) AS total
                FROM payment
                WHERE LOWER(payment_status)='paid'
                  AND payment_date BETWEEN '{$m['start']}' AND '{$m['end']}'";
        $result = $con->query($sql);
        $total = $result->fetch_assoc()['total'] ?? 0;
        $values[] = (float)$total;
    }
    $labels = $monthLabels;
}

echo json_encode([
    'labels' => $labels,
    'values' => $values
]);
?>
