<?php
// Retrieve the user ID from the session
session_start();
$userId = $_SESSION['userId'];

// Retrieve the print attributes from the AJAX request
$numOfCopies = $_POST['numOfCopies'];
$orientation = $_POST['orientation'];
$duplex = $_POST['duplex'];
$paperSize = $_POST['paperSize'];

// Create a unique request ID
$requestId = uniqid();

// Insert the print attributes into the REQUEST_PRINT table
$sql = "INSERT INTO print_request (ID, Creation_Date, Pages_Per_Sheet, Number_Of_Copies, Page_Size, `One/Doubled_Sided`, `Status`, File_ID)
        VALUES (:requestId, NOW(), '1', :numOfCopies, :paperSize, :duplex, '0', :fileId)";

// Prepare the SQL statement
$stmt = $pdo->prepare($sql);

// Bind the parameters
$stmt->bindParam(':requestId', $requestId);
$stmt->bindParam(':userId', $userId);
$stmt->bindParam(':fileId', $fileId);
$stmt->bindParam(':numOfCopies', $numOfCopies);
$stmt->bindParam(':orientation', $orientation);
$stmt->bindParam(':duplex', $duplex);
$stmt->bindParam(':paperSize', $paperSize);

// Execute the SQL statement
$stmt->execute();

// Return a response to the AJAX request
$response = array('success' => true, 'message' => 'Print request sent successfully');
echo json_encode($response);