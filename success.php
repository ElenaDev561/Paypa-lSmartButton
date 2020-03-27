<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<body>

<?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "Paypal";
            $transation=array();

            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "SELECT * FROM transation;";
            $query = mysqli_query($conn, $sql);
            if (mysqli_num_rows($query) > 0) {    

                    while ( $result = mysqli_fetch_array($query)) {
                       $transation = $result;
                    }
                    
                    
                
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            mysqli_close($conn);
    
//
?>
<div class="container" style="margin-top: 100px;">
<div class='panel panel-primary'>
    <div class='panel-heading'><h1 style='text-align: center;'>Thank You</<h1></div>
        <div class='panel-body'></div>
        <div class='col-sm-8'>&nbsp;&nbsp;First Name &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $transation[1]?></div><br><br>
        <div class='col-sm-8'>&nbsp;&nbsp;Last Name &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $transation[2]?></div><br><br>
                                    <br><div class='col-sm-8'>&nbsp;&nbsp;Email &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;: <?php echo $transation[3]?></div><br><br>
                                    <div class='col-sm-8'>&nbsp;&nbsp;amount &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;: <?php echo $transation[4]?></div><br><br>
                                    <div class='col-sm-8'>&nbsp;&nbsp;Curreny &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 
                                    <?php echo $transation[5]?></div><br><br>
                                    <div class='col-sm-8'>&nbsp;&nbsp;Transation ID :<?php echo $transation[6]?></div><br><br>
                                   <br>
                                    </div>
                                   
</body>
</html>