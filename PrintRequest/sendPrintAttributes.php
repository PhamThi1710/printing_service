<?php

// Retrieve the print attributes from the AJAX request
$numOfCopies = $_POST['numOfCopies'];
$orientation = $_POST['orientation'];
$duplex = $_POST['duplex'];
$paperSize = $_POST['paperSize'];

// Create a unique request ID
$requestId = uniqid();

// Insert the print attributes into the REQUEST_PRINT table
$sql = "INSERT INTO REQUEST_PRINT (REQUEST_ID, USER_ID, FILE_ID, NUMS_OF_COPY, ORIENTATION, DUPLEX, PAPER_SIZE, CREATED_DATE)
        VALUES (:requestId, :userId, :fileId, :numOfCopies, :orientation, :duplex, :paperSize, NOW())";

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