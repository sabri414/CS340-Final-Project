const mongoose = require("mongoose");
mongoose.connect("mongodb+srv://abounozs:test1@cluster0.5xtcuo6.mongodb.net/music_db?retryWrites=true&w=majority");
module.exports = mongoose;