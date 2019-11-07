const fs = require('fs');
const http = require('http');
const path = require('path');
var torrentStream = require('torrent-stream');
const OS = require('opensubtitles-api');
var srt2vtt = require('srt-to-vtt');

const openSub = new OS({
    useragent:'TemporaryUserAgent'
});

module.exports.stream = function(data) {

    return  new Promise(function(fullfil, reject) {

        var fs = require('fs');
        if (fs.existsSync("movies/"+data.hash+".mp4") || fs.existsSync("movies/"+data.hash+".mkv")) {
            var path = "movies/"+data.hash+".mp4"
            if (fs.existsSync("movies/"+data.hash+".mkv"))
            {
                var path = "movies/"+data.hash+".mkv"
            }
            const stat = fs.statSync(path)
            const fileSize = stat.size
            const range = data.req.headers.range

            if (range) {
                const parts = range.replace(/bytes=/, "").split("-")
                const start = parseInt(parts[0], 10)
                const end = parts[1]
                ? parseInt(parts[1], 10)
                : fileSize-1

                const chunksize = (end-start)+1
                const file = fs.createReadStream(path, {start, end})
                const head = {
                'Content-Range': `bytes ${start}-${end}/${fileSize}`,
                'Accept-Ranges': 'bytes',
                'Content-Length': chunksize,
                'Content-Type': 'video/mp4',
                }

                data.res.writeHead(206, head)
                file.pipe(data.res)
            } else {
                const head = {
                'Content-Length': fileSize,
                'Content-Type': 'video/mp4',
                }
                res.writeHead(200, head)
                fs.createReadStream(path).pipe(res)
            }
        }
        else
        {
            var magnet = 'magnet:?xt=urn:btih:' + data.hash;
            var engine = torrentStream(magnet, {path: '/movies'});

            engine.on('ready', function() {
                console.log('Ready to stream...');
                engine.files.forEach(function(file)
                {
                    if (file.name.substr(file.name.length - 3) == 'mkv' || file.name.substr(file.name.length - 3) == 'mp4') {
                        console.log('Now streaming: ', file.name);
                        data.name = file.name;
                        var lang = ["fre", "eng"];

                        openSub.search({filename: file.name, imdbid: data.imdbid}).then(subtitle => {
                            console.log(subtitle.en.url);
                            var file = fs.createWriteStream("subtitles/sub.srt");
                            var req = http.get(subtitle.en.url, function (res){
                                //res.pipe(file);
                                //console.log(res);
                                res.on("data", function (data2){
                                    file.write(data2);
                                }).on("end", function (){
                                    console.log("Done loading subtitle");
                                })
                                //fs.createReadStream().pipe("http://localhost:3000/sub");
                            });
                            fullfil(data);
                        })
                        var stream = file.createReadStream();
                        stream.pipe(data.res);
                        filename = data.hash + ".mp4";
                        if (file.name.substr(file.name.length - 3) == 'mkv')
                        {
                            filename = data.hash + ".mkv";
                        }
                        var writeStream = fs.createWriteStream("./movies/" + filename);
                        stream.pipe(writeStream);

                        fs.createReadStream('subtitles/sub.srt')
                            .pipe(srt2vtt())
                            .pipe(fs.createWriteStream('subtitles/sub.vtt'));

                    }
                });
            });

            engine.on('download', function(info) {
                console.log('Downloaded: ', info);
            });

            engine.on('idle', function() {
                console.log('Torrent ended');
            });
        }
    });
};