<?php
	session_start();
	//$currentpage="View Employees"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company DB</title>
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
                 <tr><button  ><a href="viewDependent.php">Search Playlist</a></button></tr>
        <tr><button ><a href="updateDependent.php">Update a song</a></button></tr>
        <tr><button  ><a href="deletesong.php">Delete a song</a></button></tr>
        <tr><button  ><a href="createSong.php"> Add a song</a></button></tr>
        <tr><button  ><a href="viewProjects.php"> List all songs</a></button></tr>
        <a href="createEmployee.php" class="btn btn-success pull-right">Add New Playlists</a>
         </td>
                       
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
                                            echo "<a href='updateEmployee.php?Ssn=". $row['Artist_id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='deleteEmployee.php?Ssn=". $row['Artist_id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
											echo "<a href='viewDependents.php?Ssn=". $row['Artist_id']."' title='View Dependents' data-toggle='tooltip'><span class='glyphicon glyphicon-user'></span></a>";
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
