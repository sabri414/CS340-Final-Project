<?php
session_start();
ob_start();

// Temporary session setup (Replace with real login logic)
$_SESSION["Ssn"] = "123456789"; // Example SSN
$_SESSION["Lname"] = "Doe";     // Example Last Name

if (!isset($_SESSION["Ssn"]) || !isset($_SESSION["Lname"])) {
    die("Session variables not set. Please login again.");
}

$Ssn = $_SESSION["Ssn"];
$Lname = htmlspecialchars($_SESSION["Lname"]);

require_once "config.php";

$SongId = $Duration = "";
$SongId_err = $Duration_err = $SQL_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $SongId = trim($_POST["SongId"]);
    if (empty($SongId)) {
        $SongId_err = "Please select a song.";
    }

    $Duration = trim($_POST["Duration"]);
    if (!is_numeric($Duration) || $Duration < 1 || $Duration > 900) {
        $Duration_err = "Please enter a valid duration (1-900 seconds).";
    }

    if (empty($SongId_err) && empty($Duration_err)) {
        $sql = "INSERT INTO WORKS_ON (Essn, SongId, Duration) VALUES (?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sii", $Ssn, $SongId, $Duration);

            if (mysqli_stmt_execute($stmt)) {
                echo "<div class='alert alert-success'>Song added to the playlist successfully!</div>";
            } else {
                $SQL_err = "Database error: " . mysqli_error($link);
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Music Playlist</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style>
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h3>Add a Song to Playlist</h3>
        <h4><?php echo htmlspecialchars($Lname); ?> (SSN: <?php echo htmlspecialchars($Ssn); ?>)</h4>
        <?php if (!empty($SQL_err)) echo "<div class='alert alert-danger'>$SQL_err</div>"; ?>

        <?php
        $sql = "SELECT Playlist.Playlist_id, Playlist_name FROM Song, added , Playlist"; // Replace with actual column names
        $result = mysqli_query($link, $sql);
        if (!$result) {
            die("<div class='alert alert-danger'>Error fetching songs: " . mysqli_error($link) . "</div>");
        }
        ?>

<form action="
<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group <?php echo (!empty($Playlist_id_err)) ? 'has-error' : ''; ?>">
                            <label>Song id</label>
                            <input type="text" name="Song_id" class="form-control" value="<?php echo $Playlist_id; ?>">
                            <span class="help-block"><?php echo $Playlist_id_err;?></span>
                        </div>
                 
						<div class="form-group <?php echo (!empty($Playlist_name_err)) ? 'has-error' : ''; ?>">
                            <label>Song Name</label>
                            <input type="text" name="Song_name" class="form-control" value="<?php echo $Playlist_name; ?>">
                            <span class="help-block"><?php echo $Playlist_name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Playlist_name_err)) ? 'has-error' : ''; ?>">
                            <label>Record Label</label>
                            <input type="text" name="Record_Label" class="form-control" value="<?php echo $Playlist_name; ?>">
                            <span class="help-block"><?php echo $Playlist_name_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($Lname_err)) ? 'has-error' : ''; ?>">
                            <label>Artist Name</label>
                            <input type="text" name="Artist" class="form-control" value="<?php echo $User_id; ?>">
                            <span class="help-block"><?php echo $User_id_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Lname_err)) ? 'has-error' : ''; ?>">
                            <label>Language</label>
                            <input type="text" name="Langauge" class="form-control" value="<?php echo $User_id; ?>">
                            <span class="help-block"><?php echo $User_id_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Lname_err)) ? 'has-error' : ''; ?>">
                            <label>Category</label>
                            <input type="text" name="Category" class="form-control" value="<?php echo $User_id; ?>">
                            <span class="help-block"><?php echo $User_id_err;?></span>
                        </div>
        
                        <div class="form-group <?php echo (!empty($Duration_err)) ? 'has-error' : ''; ?>">
                       <label>Duration (seconds)</label>
                      <input type="number" name="Duration" class="form-control" min="1" max="900" value="<?php echo $Duration; ?>">
                       <span class="help-block"><?php echo $Duration_err; ?></span>
                        </div>
                         <div class="form-group <?php echo (!empty($Lname_err)) ? 'has-error' : ''; ?>">
                            <label>Artist_id</label>
                            <input type="text" name="Artist_id" class="form-control" value="<?php echo $User_id; ?>">
                            <span class="help-block"><?php echo $User_id_err;?></span>
                        </div>
            <div class="form-group">
            <form action="addSongToPlaylist.php" method="POST">
             <input type="hidden" name="song_id" value="34"> <!-- Replace 123 with dynamic song ID -->
            <input type="hidden" name="playlist_id" value="59"> <!-- Replace 456 with dynamic playlist ID -->
          <input type="submit" class="btn btn-success" value="Add to Playlist">
            </form>
                <a href="viewPlaylist.php?Ssn=12345" class="btn btn-primary">View Songs</a>

            </div>
        </form>

        <?php
        mysqli_free_result($result);
        mysqli_close($link);
        ?>
    </div>
</body>
</html>
