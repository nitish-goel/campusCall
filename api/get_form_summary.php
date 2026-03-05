<?php

require_once '../vendor/autoload.php';
require_once '../config/Database.php';
require_once '../helper/AuthMiddleware.php';

AuthMiddleware::check();

$form_id = $_GET['id'];

$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("
SELECT 
tbl_fields.label,
tbl_submissions.answer,
COUNT(*) as total
FROM tbl_submissions
JOIN tbl_fields ON tbl_fields.id = tbl_submissions.field_id
WHERE tbl_submissions.form_id = ?
GROUP BY tbl_fields.label, tbl_submissions.answer
ORDER BY tbl_fields.label
");

$stmt->execute([$form_id]);

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
"status"=>true,
"data"=>$data
]);