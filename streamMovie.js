const express = require('express')
const fs = require('fs')
const path = require('path')
const app = express()
var torrentStream = require('torrent-stream')
var bodyParser = require('body-parser')
var router = express.Router();
// var hash = "";

// console.log("pre");

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// app.get('/', function(req, res) {
//     hash = req.query.hash;
//     res.sendFile(path.join(__dirname + '/vid_player.html'))
//   })

//hash = "96ED427EDA0D589677DB10939F7649CE99BF1EF0";

// console.log("start: " + hash);
// app.use(express.static(path.join(__dirname, 'public')))

// app.get('/video', function(req, res) {
  
//   var magnet = 'magnet:?xt=urn:btih:' + hash;
//         var engine = torrentStream(magnet,{path: '/films'});

//         engine.on('ready', function() {
//             console.log('torrent dl ready:');
//             engine.files.forEach(function(file) {
//                 if (file.name.substr(file.name.length - 3) == 'mkv' || file.name.substr(file.name.length - 3) == 'mp4') {
//                     console.log('   Now streaming :', file.name);
//                     var stream = file.createReadStream().pipe(res);
//                     //data.path = file.path;
//                     //fullfil(data);
//                 }
//             });
//         });

//         engine.on('download', function(data) {
//             console.log('       piece downloaded :', data);
//         });

//         engine.on('idle', function() {
//             console.log('torrent end');
//         });
// })

require('./router.js')(router, app);
app.use('/', router);

app.listen(3000, function () {
  console.log('Listening on port 3000!')
})