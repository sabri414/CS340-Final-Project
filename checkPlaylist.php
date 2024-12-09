<!-- 
 Names:
Isabella Mann
Dennis Aguilar
Sabri Abounozha 
Hunter McCoy
Date: 12/8/2024 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check Playlist Songs</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Search Playlist</h2>
                    </div>
                    <p>Please fill this form to search for songs by category.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($Playlist_err)) ? 'has-error' : ''; ?>">
                            <label>Playlist id</label>
                            <input type="text" name="Playlist" class="form-control" value="<?php echo $Playlist; ?>">
                            <span class="help-block"><?php echo $Playlist_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Return</a>
                    </form>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Define variables and initialize with empty values
                    $Playlist = "";
                    $Playlist_err = "";
                    
                    // Processing form data when form is submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Validate Record Label
                        $Playlist = trim($_POST["Playlist"]);
                        if (empty($Playlist)) {
                            $Playlist = "Please enter a Playlist id.";
                        } elseif(!ctype_digit($Playlist_id)){
                            $Playlist_id_err = "Please enter a positive integer value for Playlist id.";
                        } 
                        
                        // Check input errors before querying the database
                        if (empty($Playlist_err)) {
                            // Prepare a call to the stored procedure
                            $sql = "SELECT Song.Song_Title AS 'Song', Song.Artist AS 'Artist', Song.Duration AS 'Duration (seconds)'
                            FROM Song, added , Playlist 
                            WHERE Playlist.Playlist_id = ? AND added.song_id = Song.Song_id AND added.playlist_id = Playlist.Playlist_id
                            GROUP BY Song.Song_id";
                            
                            if ($stmt = mysqli_prepare($link, $sql)) {
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "s", $param_pid);
                                
                                // Set parameters
                                $param_pid = $Playlist;
                                
                                // Attempt to execute the prepared statement
                                if (mysqli_stmt_execute($stmt)) {
                                    // Store result
                                    mysqli_stmt_store_result($stmt);
                                    
                                    // Bind result variables
                                    mysqli_stmt_bind_result($stmt, $song_title, $artist, $duration);
                                    
                                    // Check if any rows are returned
                                    if (mysqli_stmt_num_rows($stmt) > 0) {
                                        echo "<table class='table table-bordered table-striped'>";
                                            echo "<thead>";
                                                echo "<tr>";
                                                    echo "<th width=10%>Song</th>";
                                                    echo "<th width=10%>Artist</th>";
                                                    echo "<th width=10%>Duration (seconds)</th>";
                                                echo "</tr>";
                                            echo "</thead>";
                                            echo "<tbody>";
                                            while (mysqli_stmt_fetch($stmt)) {
                                                echo "<tr>";
                                                    echo "<td>" . htmlspecialchars($song_title) . "</td>";
                                                    echo "<td>" . htmlspecialchars($artist) . "</td>";
                                                    echo "<td>" . htmlspecialchars($duration) . "</td>";
                                                echo "</tr>";
                                            }
                                            echo "</tbody>";
                                        echo "</table>";
                                    } else {
                                        echo "<p class='lead'><em>No songs were found.</em></p>";
                                    }
                                } else {
                                    echo "<center><h4>Error while searching for playlist songs</h4></center>";
                                }
                            }
                            
                            // Close statement
                            mysqli_stmt_close($stmt);
                        }

                        // Close connection
                        mysqli_close($link);
                    }
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>