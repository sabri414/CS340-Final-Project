<?php
// Include config file
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get song_id and playlist_id from the form
    $song_id = $_POST["song_id"];
    $playlist_id = $_POST["playlist_id"];

    // Check if the song ID and playlist ID are valid
    if (!empty($song_id) && !empty($playlist_id)) {
        // Prepare the SQL statement to insert the song into the playlist
        $sql = "INSERT INTO added (song_id, playlist_id) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ii", $param_song_id, $param_playlist_id);

            // Set parameters
            $param_song_id = $song_id;
            $param_playlist_id = $playlist_id;

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to the playlist view page with a success message
                header("location: viewPlaylist.php?playlist_id=$playlist_id");
                exit();
            } else {
                echo "Error: Could not execute the query. " . mysqli_error($link);
            }

            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: Could not prepare the query. " . mysqli_error($link);
        }
    } else {
        echo "Error: Song ID and Playlist ID are required.";
    }

    // Close the database connection
    mysqli_close($link);
} else {
    echo "Invalid request.";
}
?>
