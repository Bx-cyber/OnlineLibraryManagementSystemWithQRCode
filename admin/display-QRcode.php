<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 

   
    // get the id of the QR code to display
    $id = $_GET['id'];
     
    // query the database to retrieve the image data
    $query = "SELECT image FROM tblbooks WHERE id = :id";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // encode the image data as a base64 string
    $image_base64 = base64_encode($row['image']);
    
   
}
?>
<style>


.qr-code-wrapper{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* adjust as needed */
    page-break-before: always;
    page-break-after: always;
}
.qr-code {
  position: relative;
  max-width: 80%;
  max-height: 80%;
  margin: 0 auto;
  
}
.qr-code img {
  display: block;
  max-width: 100%;
  max-height: 100%;
}
.qr-code button {
  position: absolute;
  bottom: -30px; /* adjust as needed */
  right: 43px; /* adjust as needed */
  padding: 7px;
  font-size: 10px;
  background-color: lightblue;
  color: black;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
</style>
<div class ="qr-code-wrapper">
  <div class = "qr-code">
    <img id="qr-code" src="data:image/png;base64,<?php echo $image_base64; ?>" alt="QR Code">
    <button id="print-button">Print</button>
  </div>
</div>


<!-- JavaScript code for printing the QR code image when the print button is clicked -->
<script>
  // get a reference to the print button and the QR code image
  const printButton = document.getElementById('print-button');
  const qrCodeImage = document.getElementById('qr-code');

  // add a click event listener to the print button
  printButton.addEventListener('click', () => {
    // create a new window with the QR code image
    const printWindow = window.open();
    printWindow.document.write(`<img src="${qrCodeImage.src}">`);
    printWindow.document.close();

    // trigger the print dialog
    printWindow.print();
    printWindow.close();
  });
</script>
