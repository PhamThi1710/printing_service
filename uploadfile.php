<?php

@include 'database.php';
$maxfilesize = 50000000; //50MB
$allowUpload = true;
if (isset($_POST['submit'])) {
    if (!isset($_FILES["fileupload"])) {
        echo "Dữ liệu không đúng cấu trúc";
        die;
    }
    if ($_FILES["fileupload"]['error'] != 0) {
        echo "Dữ liệu upload bị lỗi";
        die;
    }
    $allowTypes = array('.docx', '.xlsx', '.pptx', 'jpg', 'png', 'jpeg');
    if (isset($_FILES['fileupload'])) {
        $file_child = convert_upload_file_array($_FILES['fileupload']);

        foreach ($file_child as $key => $child) {
            // $target = "upload/{$child['name']}";        
            $targetDir = 'upload/'; //getcwd() . DIRECTORY_SEPARATOR;
            $fileName = basename($child['name']);
            $targetFilePath = $targetDir . $fileName;
            if (file_exists($targetFilePath)) {
                echo "Tên file đã tồn tại trên server, không được ghi đè";
                $allowUpload = false;
            }
            if ($child["size"] > $maxfilesize) {
                echo "Không được upload ảnh lớn hơn $maxfilesize (bytes).";
                $allowUpload = false;
            }
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            if (!empty($child['name'])) {

                if (in_array($fileType, $allowTypes)) {
                    // Upload file to server
                    if (move_uploaded_file($child['tmp_name'], $targetFilePath)) {
                        // Insert files name into database
                        $nameOffile = $fileName . '.' . $fileType;
                        $totalpage = count_pdf_pages($targetFilePath);
                        $insert = $conn->query("INSERT into file (userid,name,effectivedate,state,totalpage,filepath) VALUES ('1','$nameOffile',NOW,'Mới tải lên','" . $totalpage . "','" . $fileName . "')");
                        if ($insert) {
                            $statusMsg = "The file has been uploaded successfully.";
                            $allowUpload = true;
                        } else
                            $statusMsg = "File upload failed, please try again.";
                        $allowUpload = false;
                    }
                } else {
                    $statusMsg = "Sorry, there was an error uploading your file.";
                    $allowUpload = false;
                }
            } else {
                $statusMsg = 'Sorry, only valid type files are allowed to upload.';
                $allowUpload = false;
            }
        }
    }
}
function count_pdf_pages($pdfname)
{
    $pdftext = file_get_contents($pdfname);
    $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);

    return $num;
}
?>