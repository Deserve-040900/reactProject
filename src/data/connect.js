const mongoose = require("mongoose");

// creating a database
// mongoose.connect("mongodb:// + config.host : config.port + /config..db")
mongoose.connect("mongodb://", {
    useCreateIndex: true,
    userNewUrlParser: true,
    useUnifiedTopology: true
}).then(() =>{
    console.log("Connection Successful")
}).catch((error) =>{
    console.log(error);
})