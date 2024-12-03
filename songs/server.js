//import mongoose from 'mongoose';
//import 'dotenv/config';

const express = require("express");
const app = express();
app.use(express.static("public"))
app.use(express.json());
app.use("/api/songs", require("./api/songs"));
app.listen(3000);
//app.get()

/*app.post('/songs', (req, res) => {
  const { title, artist, genre, duration } = req.body;
  const song = new Song({ title, artist, genre, duration });

  song.save((err, savedSong) => {
    if (err) {
      console.error('Failed to save the song:', err);
      return res.status(500).send('Failed to save the song.');
    }
    res.status(201).json(savedSong);
  });
});

*/


//const db = mongoose.connection;
//mongoose.connect("mongodb+srv://abounozs:Sabri12345@cluster0.1ztntd5.mongodb.net/music_db?retryWrites=true&w=majority");
  //  process.env.MONGODB_CONNECT_STRING,
  //  { useNewUrlParser: true }
//;
// Create a new song




