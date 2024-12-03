const db = require("../db");

const Song = db.model("Song", {
     
   title:       { type: String, required: true },
   artist:      String,
   popularity:  { type: Number, min: 1, max: 10 },
   releaseDate: { type: Date, default: Date.now },
   genre:       [ String ]
})

/*db.once("open", () => {
    console.log("Successfully connected to MongoDB using Mongoose!");
  });
*/
module.exports = Song;