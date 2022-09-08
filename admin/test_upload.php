<?php
include('import_pdf.php');
?>

<!DOCTYPE html>
<html>
<body>



<form action="import_pdf.php" method="post" enctype="multipart/form-data">

    Select an image to upload:
    <input type ="file" name="myFile" id="fileToUpload">
    <input type ="submit"  value="Upload" name="submit">
</form>

</body>
</html>