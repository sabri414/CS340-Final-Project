addEventListener("DOMContentLoaded", function() {
const createButton = document.getElementById('createButton');
const readButton = document.getElementById('readButton');
const deleteButton = document.getElementById('deleteButton');


createButton.addEventListener('click', (e) => {
  e.preventDefault();
  // Implement create functionality
  const song = {
    title: document.querySelector("#title").value,
    artist: document.querySelector("#artist").value,
    releaseDate: document.querySelector("#released").value,
    popularity: document.querySelector("#popularity").value,
    genre: document.querySelector("#genre").value ? 
       document.querySelector("#genre").value.split(",") : []
 };
  console.log("createbuttoneventlistner")
  fetch('/api/songs', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(song),
  })
    .then(response => response.json())
    .then(data => {
      console.log('Created song:', data);
      // Handle the response as needed
    })
    .catch(error => {
      console.error('Failed to create song:', error);
      // Handle the error as needed
    });
});


console.log(readButton);
readButton.addEventListener('click', (e) => {
    // Implement read functionality
    console.log("readButton");
    fetch('/songs')
      .then(response => response.json())
      .then(data => {
        console.log('Retrieved songs:', data);
        // Handle the response as needed
      })
      .catch(error => {
        console.error('Failed to retrieve songs:', error);
        // Handle the error as needed
      });
  });



  deleteButton.addEventListener('click', () => {
    // Implement create functionality
    const songData = {
      title: 'New Song',
      artist: 'New Artist',
      genre: 'New Genre',
      duration: 180,
    };
  
    fetch('/songs', {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(songData),
    })
      .then(response => response.json())
      .then(data => {
        console.log('Created song:', data);
        // Handle the response as needed
      })
      .catch(error => {
        console.error('Failed to create song:', error);
        // Handle the error as needed
      });
  });

 
    document.querySelector("#addBtn").addEventListener("click", addSong);
 });


 
 async function addSong(e) {
  e.preventDefault();
  console.log("adding a song");
  // Create a song object from the form fields
    
 
    // POST a JSON-encoded song to Music API
    const response = await fetch("/api/songs", {
       method: "POST",
       headers: { "Content-Type": "application/json" },
       body: JSON.stringify(song)
    });
 
    if (response.ok) {
       const results = await response.json();
       alert("Added song with ID " + results._id);
 
       // Reset the form after adding the song
       document.querySelector("form").reset();
    }
    else {
       document.querySelector("#error").innerHTML = "Cannot add song.";
    }     
 }