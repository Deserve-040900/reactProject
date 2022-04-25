const express = require("express");
const path = require("path");
require("./data/connect");
const hbs = require("hbs");

const app = express();
const port = process.env.PORT || 2000;

// setting the path
const staticpath = path.join(__dirname, "../public");
const viewspath = path.join(__dirname, "../templates/views");
const partialspath = path.join(__dirname, "../templates/partials");

// middleware
app.use('/css', express.static(path.join(__dirname, "../node_modules/bootstrap/dist/css")));
app.use('/js', express.static(path.join(__dirname, "../node_modules/bootstrap/dist/js")));
app.use('/jq', express.static(path.join(__dirname, "../node_modules/jquery/dist")));
app.use(express.static(staticpath));
app.set("view engine", "hbs");
app.set("views", viewspath);
hbs.registerPartials(partialspath);

// routing
// app.get(app, callback)
app.get("/", (req, res) => {
    res.render("index");
})

app.get("/", (req, res) => {
    res.render("session1");
})

// server create
app.listen(port, () => {
    console.log(`Server is running at PORT no ${port}`);
})