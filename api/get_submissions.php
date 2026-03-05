<?php

require_once '../vendor/autoload.php';
require_once '../config/Database.php';
require_once '../helper/AuthMiddleware.php';

AuthMiddleware::check();

$db = new Database();
$conn = $db->connect();

$stmt = $conn->query("
SELECT 
tbl_forms.id,
tbl_forms.title,
COUNT(DISTINCT tbl_submissions.roll_number) AS total_submissions
FROM tbl_forms
LEFT JOIN tbl_submissions 
ON tbl_forms.id = tbl_submissions.form_id
GROUP BY tbl_forms.id
ORDER BY tbl_forms.id DESC
");

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
"status"=>true,
"forms"=>$data
]);