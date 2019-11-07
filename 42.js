var Promise = require('promise');
var http = require('http');
var request = require('request');
const path = require('path')

module.exports.login42 = function(data) {
    return  new Promise(function(fullfil, reject) {

        request.post({
            url: 'https://api.intra.42.fr/oauth/token',
            json: true,
            body: {
                grant_type: 'authorization_code',
                client_id: '43c57bb453214ee3832296a532afdabf04557fe16d1211f6c652062694409c85',
                client_secret: '4622d7c251aa00bdf28153b528e6675b57ea88006b8f46526d1c834eb201d9d2',
                code: data.Ocode,
                redirect_uri: 'http://localhost:8100/hypertube/login.php'
            }
        }, function (error, response, body){
            if (error)
            {
                reject({'res': data.res, state:'validation', error: 'Your 42 token is invalid.'});
            }
            else {
                if (response.body.error)
                {
                    reject({'res': data.res, state:'validation', error: response.body.error_description});
                }
                data.Otoken = response.body.access_token;
                fullfil(data);
            }
        });
    });
};
module.exports.retrieve42 = function(data) {
    return  new Promise(function(fullfil, reject) {
        request.get({
            url: 'https://api.intra.42.fr/v2/me?access_token='+data.Otoken,
            json: true
        }, function (error, response, body){
            if (error)
            {
                reject({'res': data.res, state:'validation', error: '42 api does not work.'});
            }
            else {
                if (response.body.error)
                {
                    reject({'res': data.res, state:'validation', error: response.body.error_description});
                }
                data.Ouser = {
                    pseudo: "42-"+response.body.login,
                    email: response.body.email,
                    firstname: response.body.first_name,
                    lastname: response.body.last_name,
                    image: response.body.image_url,
                    lang: "en",
                    username: response.body.login,
                    id: response.body.id
                };
                fullfil(data);
            }
        });
    })
};

module.exports.OExistsOrCreate = function(data)
{
    var dir = path.join(__dirname + "/save42User.php?fname=" + data.Ouser.firstname + "&lname=" + data.Ouser.lastname + "&image_url=" + data.Ouser.image + "&lang=" + data.Ouser.lang + "&id=" + data.Ouser.id + "&name=" + data.Ouser.username);
    return data.res.redirect("http://localhost:8100" + dir.split("htdocs")[1]);
};
