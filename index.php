<?php
	session_start();
	//$currentpage="View Employees"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Spotify</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
	<style type="text/css">
        .wrapper{
            width: 70%;
            margin:0 auto;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
		 $('.selectpicker').selectpicker();
    </script>
</head>
<body>
 
    <?php
        // Include config file
        require_once "config.php";
//		include "header.php";
	?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
		    <div class="page-header clearfix">
		     <h2> Sample Project CS 340 </h2> 
                       <p> Project should include CRUD operations. In this website you can:
				<ol> 
                <td>
        
				</ol>
		       <h2 class="pull-left">Playlists</h2>
               <tr>
                      <td><a href="updateDependent.php" class="btn btn-warning">Update a Song</a></td>
                      <td><a href="deletesong.php" class="btn btn-danger">Delete a Song</a></td>
                      <td><a href="createSong.php" class="btn btn-success">Add a Song</a></td>
                     <td><a href="viewPlaylist.php?Ssn=" class="btn btn-info">List All Songs</a></td>
                      <td><a href="createEmployee.php" class="btn btn-success pull-right">Add New Playlists</a></td>
                      <td><a href= "createASong.php" class="btn btn-danger">Create a new song</a></td>
                      <td><a href="Check Record.php?Ssn=" class= "btn btn-warning">Check Record</a></td>
                       <td> "<a href="CheckCategory.php?Ssn=" class="btn btn-danger">Check Category </a></td>
                       <td><a href="checkArtist.php?Ssn=" class="btn btn-success">Check Artist</a></td>

                </tr>
                       
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select all employee query execution
					// *****
					// Insert your function for Salary Level
					/*
						$sql = "SELECT Ssn,Fname,Lname,Salary, Address, Bdate, PayLevel(Ssn) as Level, Super_ssn, Dno
							FROM EMPLOYEE";
					*/
                    $sql = "SELECT Playlist_id,Playlist_name,User_id
							FROM Playlist";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th width=10%>Playlist_id</th>";
                                        echo "<th width =8%>Playlist_name</th>";
                                        echo "<th width=10%>User_id</th>";
                                        echo "<th width=10%>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['Playlist_id'] . "</td>";
                                        echo "<td>" . $row['Playlist_name'] . "</td>";
                                        echo "<td>" . $row['User_id'] . "</td>";
                                        echo "<td>";
                                        echo "<a href='viewPlaylist.php?Ssn=". $row['Playlist_id']."' title='View songs' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
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
					echo "<br> <h2> Playlist Stats </h2> <br>";
					
                    // Select Department Stats
					// You will need to Create a DEPT_STATS table
					
                    $sql2 = "SELECT Playlist.Playlist_id AS 'pid', Playlist_name, SUM(Duration) AS total_duration 
                            FROM Song, added , Playlist 
                            WHERE added.song_id = Song.Song_id AND added.playlist_id = Playlist.Playlist_id 
                            GROUP BY Playlist.Playlist_id";
                    if($result2 = mysqli_query($link, $sql2)){
                        if(mysqli_num_rows($result2) > 0){
                            echo "<div class='col-md-4'>";
							echo "<table width=30% class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th width=20%>Playlist_id</th>";
                                        echo "<th width = 40%>Playlist name</th>";
                                        echo "<th width = 40%>Duration </th>";
	
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result2)){
                                    echo "<tr>";
                                        echo "<td>" . $row['pid'] . "</td>";
                                        echo "<td>" . $row['Playlist_name'] . "</td>";
                                        echo "<td>" . $row['total_duration'] . "</td>";
               
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result2);
                        } else{
                            echo "<p class='lead'><em>No records were found for Dept Stats.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql2. <br>" . mysqli_error($link);
                    }
					
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>

</body>
</html>
