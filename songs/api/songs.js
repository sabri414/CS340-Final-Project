const Song = require("../models/song");
const router = require ("express").Router();

//Get list of all songs on the database 
router.get("/", function(req, res) {
    let query = {};
     
    // Check if genre was supplied in query string
    if (req.query.genre) {
       query = { genre: req.query.genre };
    }
 
    Song.find().then((songs)=> res.json(songs))
         .catch((err)=> res.status(400).send(err));
   
 });

router.post("/", function(req,res){
   console.log("add new song") 
   Song.create(req.body)
        .then((result)=>res.json(result))
        .catch((err)=>res.status(400).send(err));
})
router.put("/:id", function(req, res){
    Song.updateOne({ _id: req.params.id }, req.body).then( function(err, result) {
        if (err) {
           res.status(400).send(err);
        } 
        else if (result.matchedCount === 0) {
           res.sendStatus(404);
        } 
        else {
           res.sendStatus(204);
        }
     });
     
})

router.delete("/:id", function(req, res) {
    Song.deleteOne({ _id: req.params.id }) .then( function(err, result) {
       if (err) {
          res.status(400).send(err);
       } 
       else if (result.matchedCount === 0) {
          res.sendStatus(404);
       } 
       else {
          res.sendStatus(204);
       }
    });
});

router.get("/:id", function(req, res) {
    // Use the ID in the URL path to find the song
    Song.findById(req.params.id) 
    .then (function(err, song) {
       if (err) {
          res.status(400).send(err);
       } 
       else {
          res.json(song);
       }
    });
 });

module.exports = router; 