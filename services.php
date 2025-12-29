<?php
require __DIR__ . "admin/connection.php";

$sql = "
SELECT sp.packageID, sp.package_name, sp.item_limit,
       pd.duration_type, pd.price
FROM storagepackage sp
JOIN package_durations pd ON pd.packageID = sp.packageID
ORDER BY sp.packageID, pd.duration_id
";

$stmt = $pdo->query($sql);
$packages = $stmt->fetchAll();
?>




<?php foreach ($packages as $row): ?>
  <p>
    <b><?= htmlspecialchars($row['package_name']) ?></b>
    (limit <?= (int)$row['item_limit'] ?>)
    - <?= htmlspecialchars($row['duration_type']) ?> :
    RM <?= number_format((float)$row['price'], 2) ?>

    <a 
      href="booking.php?packageID=<?= (int)$row['packageID'] ?>">Book</a>

   </p>
<?php endforeach; ?>
