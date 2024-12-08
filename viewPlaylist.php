<?php
	session_start();
    // Include config file
    require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Playlists</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
	   <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
        
    </script>
    

</head>
<body>
<table id= "songtable"></table>


    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">View Playlist</h2>
						<a href="addProject.php" class="btn btn-success pull-right">Add Song</a>
                    </div>
<?php


// Check existence of id parameter before processing further
if(isset($_GET["Ssn"]) && !empty(trim($_GET["Ssn"]))){
	$_SESSION["Ssn"] = $_GET["Ssn"];
}
if(isset($_GET["Lname"]) && !empty(trim($_GET["Lname"]))){
	$_SESSION["Lname"] = $_GET["Lname"];
}

if(isset($_SESSION["Ssn"]) ){
	
    // Prepare a select statement
    $sql = "SELECT Song_id, Song_title ,Record_Label
    FROM Song";
if($result = mysqli_query($link, $sql)){
if(mysqli_num_rows($result) > 0){
    echo "<table class='table table-bordered table-striped'>";
        echo "<thead>";
            echo "<tr>";
                echo "<th width=10%>Song_id</th>";
                echo "<th width =8%>Song_Title</th>";
                echo "<th width=10%>Record_Label</th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['Song_id'] . "</td>";
                echo "<td>" . $row['Song_title'] . "</td>";
                echo "<td>" . $row['Record_Label'] . "</td>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";                            
    echo "</table>";
    // Free result set
    mysqli_free_result($result);
} else{
    echo "<p class='lead'><em>No records were found.</em></p>";
}
} else{
echo "ERROR: Could not able to execute $sql. <br>" . mysqli_error($link);
}
    mysqli_stmt_close($stmt);
    $sql = "SELECT song_id, song_title FROM Song";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<form action='addSongToPlaylist.php' method='POST'>";
        echo "<input type='hidden' name='song_id' value='" . $row['song_id'] . "'>";
        echo "<input type='hidden' name='playlist_id' value='1'>"; // Replace '1' with dynamic playlist ID
        echo "<p>" . $row['song_title'] . "</p>";
        echo "<input type='submit' class='btn btn-success' value='Add to Playlist'>";
        echo "</form>";
    }
} else {
    echo "No songs available.";
}
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>					                 					
	<p><a href="index.php" class="btn btn-primary">Back</a></p>
    </div>
   </div>        
  </div>
</div>
</body>
</html>


