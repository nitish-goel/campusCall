<?php
require_once '../vendor/autoload.php';
require_once '../config/Database.php';

$db = new Database();
$conn = $db->connect();

$stmt = $conn->query("SELECT * FROM tbl_forms WHERE is_active = 1 LIMIT 1");
$form = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$form){
    echo json_encode(["status"=>false,"message"=>"Form not found"]);
    exit;
}

$form_id = $form['id'];
$roll_number = $_POST['roll_number'];

// check submission
$stmt = $conn->prepare("
SELECT id FROM tbl_submissions
WHERE form_id = ? AND roll_number = ?
");
$stmt->execute([$form_id,$roll_number]);
if($stmt->rowCount() > 0){

    echo json_encode([
    "status"=>false,
    "message"=>"You already submitted this feedback"
    ]);
    
    exit;
    }

// Save answers
foreach($_POST as $key => $value){

    if(strpos($key, "field_") === 0){

        $field_id = str_replace("field_", "", $key);

        // If checkbox (array)
        if(is_array($value)){
            $value = implode(",", $value);
        }

        $stmt2 = $conn->prepare("
            INSERT INTO tbl_submissions 
            (form_id, field_id, answer,roll_number,submitted_at)
            VALUES (?, ?,?, ?,NOW())
        ");

        $stmt2->execute([$form_id, $field_id, $value,$roll_number]);
    }
}

echo json_encode([
    "status"=>true,
    "message"=>"Thank you! Feedback submitted successfully."
]);