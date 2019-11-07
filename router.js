var OAuth = require('./42.js');
var stream = require('./streaming.js');
var http = require('http');
const express = require('express');
const fs = require('fs');
const path = require('path');
var torrentStream = require('torrent-stream');
var bodyParser = require('body-parser');
var opensubtitles = require("subtitler");

module.exports = function(router, app) {
    
    router.use(function (req, res, next) {
        res.header("Access-Control-Allow-Origin", "*");
        res.header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,PROPFIND');
        res.header("Access-Control-Allow-Headers", "X-Requested-With, Content-Type");
        next();
    });

    var hash = "";
    var imdbid = "";
    
    router.get('/', function(req, res) {
        hash = req.query.hash;
        imdbid = req.query.imdbid;
        res.sendFile(path.join(__dirname + '/vid_player.html'))
    })

    app.use(express.static(path.join(__dirname, 'public')))

    router.get('/login42/:Ocode', function (req, res) {
        var Ocode = req.params.Ocode;
        var data = {
            Ocode: Ocode,
            Otoken: "",
            res: res
        }
        OAuth.login42(data)
        .then(OAuth.retrieve42)
        .then(OAuth.OExistsOrCreate);
     });
    
    router.get('/video', function(req, res)
    {
        // var token = "";
        // var lang = "-lang eng";
        // var text = "iron man"
        // opensubtitles.api.login()
        // .then(function(token)
        // {
        //     token = token;
        // });
        // opensubtitles.api.searchForTitle(token, lang, text)
        // .then(function (results)
        // {
        //     console.log(results);
        // });

        // var magnet = 'magnet:?xt=urn:btih:' + hash;
        //       var engine = torrentStream(magnet, {path: '/movies'});
      
        //       engine.on('ready', function() {
        //           console.log('Ready to stream...');
        //           engine.files.forEach(function(file)
        //           {
        //               if (file.name.substr(file.name.length - 3) == 'mkv' || file.name.substr(file.name.length - 3) == 'mp4') {
        //                   console.log('Now streaming: ', file.name);
        //                   var stream = file.createReadStream().pipe(res);
        //               }
        //           });
        //       });
      
        //       engine.on('download', function(data) {
        //           console.log('Downloaded: ', data);
        //       });
      
        //       engine.on('idle', function() {
        //           console.log('Torrent ended');
        //       });

        var data2 = {
            hash: hash,
            imdbid: imdbid,
            res: res,
            req: req
        }
        stream.stream(data2);
      })
};