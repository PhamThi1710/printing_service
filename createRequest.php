<?php

@include 'database.php';
$maxfilesize = 50000000; //50MB
$allowUpload = true;
function convert_upload_file_array($upload_files)
{
    $converted = array();

    foreach ($upload_files as $attribute => $val_array) {
        foreach ($val_array as $index => $value) {
            $converted[$index][$attribute] = $value;
        }
    }
    return $converted;
}
if (isset($_POST['send'])) {

    $allowTypes = array('.docx', '.docm', '.dotx', '.dotm', '.xlsx', '.pptx', 'jpg', 'png', 'jpeg', 'pdf');
    if (isset($_FILES['fileupload'])) {
        $file_child = convert_upload_file_array($_FILES['fileupload']);

        foreach ($file_child as $key => $child) {
            $targetDir = 'upload/';
            $fileName = basename($child['name']);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            if (!empty($child['name'])) {

                if (
                    (
                        ($child["type"] == "application/pdf")
                        || ($child["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
                        || ($child["type"] == "image/gif")
                        || ($child["type"] == "image/jpeg")
                        || ($child["type"] == "image/jpg")
                        || ($child["type"] == "application/msword")
                        || ($child["type"] == "image/pjpeg")
                        || ($child["type"] == "image/x-png")
                        || ($child["type"] == "image/png")
                        && ($child["size"] < 50000000)
                        && in_array($fileType, $allowTypes)
                    )
                ) {
                    if ($child["error"] > 0) {
                        echo "Return Code: " . $child["error"] . "<br>";
                    } else {
                        if (file_exists("upload/" . $child["name"])) {
                            echo $child["name"] . " already exists. ";
                        } else {
                            // Upload file to server
                            if (move_uploaded_file($child['tmp_name'], $targetFilePath)) {
                                // Insert files name into database
                                $totalpage = 0;
                                if ($fileType == '.pdf')
                                    $totalpage = count_pdf_pages($targetFilePath);
                                if (($child["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")) {
                                    $word = new COM("Word.Application");
                                    $word->Documents->Open($targetFilePath);
                                    $wdStatisticPages = 2; // Value that corresponds to the Page count in the Statistics
                                    $num_pages = $word->ActiveDocument->ComputeStatistics($wdStatisticPages);
                                    $totalpage = getPages($targetFilePath);
                                    if ($totalpage != $num_pages) {
                                        if ($totalpage < $num_pages)
                                            $totalpage = $num_pages;
                                    }
                                    echo 'I\'m here';
                                }
                                $insert = $conn->query("INSERT into file (userid,name,effectivedate,state,totalpage,filepath) VALUES ('1','$fileName',NOW(),'Mới tải lên','" . $totalpage . "','" . $targetFilePath . "')");
                                if ($insert) {
                                    $statusMsg = "The file has been uploaded successfully.";
                                } else
                                    $statusMsg = "File upload failed, please try again.";
                            } else {
                                $statusMsg = "Sorry, there was an error uploading your file.";
                            }
                            # $statusMsg = 'Sorry, only valid type files are allowed to upload.';
                        }
                    }
                } else {
                    echo 'Invalid file';
                }
            }
        }
    }

}
function getPages($targetFilePath)
{
    $zip = new ZipArchive();
    $zip->open($targetFilePath);
    $xml = new \DOMDocument();
    $xml->loadXML($zip->getFromName("docProps/app.xml"));
    $res = $xml->getElementsByTagName('Pages')->item(0)->nodeValue;
    return $res;
}
function count_pdf_pages($pdfname)
{
    $pdftext = file_get_contents($pdfname);
    $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);

    return $num;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a request</title>
</head>

<body>
    <div>
        <label>Tạo yêu cầu in</label>
    </div>
    <div>
        <label>Upload File mới:</label>
        <?php
        if (isset($statusMsg)) {

            echo '<span style="padding-bottom: 2%; font-size: 25px" class="error-msg">' . $statusMsg . '</span>';

            ;
        }
        ;
        ?>
        <form method="post" action="" enctype="multipart/form-data">
            Chọn file để upload:
            <input type="file" name="fileupload[]" multiple>
            <input type="submit" value="Submit" name="send">
        </form>
    </div>

</body>

</html>