const path = require('path');
const express = require('express');
const app = express();
const staticPath = path.join(__dirname, "/public");
const fs = require('fs');
const cookieParser = require('cookie-parser');
const sessions = require('express-session');
const bcrypt = require('bcrypt');
const saltRounds = 10;
var bodyParser = require('body-parser')
const cassandra = require('cassandra-driver');
const {compare} = require("bcrypt");
const client = new cassandra.Client({
	contactPoints: ['127.0.0.1:9042'],
	localDataCenter: 'datacenter1',
	keyspace: 'glink'
});
app.set('view engine', 'ejs');
let id = 1;	/* Ideally should initialize id to be nextFromDB or write to file and read */
let idAccount = 1;
const port = 63342;	// Port that the server listens on */
const RADIUS_OF_EARTH_IN_MILES = 3958.7614580848;

app.use( bodyParser.json() );
app.use(bodyParser.urlencoded({
	extended: true
}));

app.use(sessions({
	secret: "iamasecretkey123",
	saveUninitialized: true,
	resave: false,
}))
app.use(cookieParser());
var session;
app.use(express.static(staticPath));

const GLINK_SIZE = 6;
function getRandomGLink() {
	let glink = "";
	glink = newString(GLINK_SIZE);
	validateLink(glink);
	return glink;
}
function validateLink(glink) {
	let qry = "SELECT id FROM data WHERE glink = ? allow filtering";
	client.execute(qry, [glink], {}, (err, result) => {
		if(err) {
			console.log(err.message);
			glink = null;
		}
		if (result.rows.length === 0) {
			console.log("Done");
		} else {
			console.log(glink);
			glink = getRandomGLink();
		}
	});
	return glink;
}
function newString(n) {
	let str = "";
	let symbols = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	for (let i = 0; i < n; i ++) {
		str += symbols.charAt(Math.floor(Math.random() * 52));
	}
	return str;
}

function nextIdData() {
	let next = id;
	id = id + 1;
	return next;
}
function nextIdAccount() {
	let next = idAccount;
	idAccount = idAccount + 1;
	return next;
}
function filter(path) {
	if (path.match(new RegExp("^/[a-zA-Z]+/*$"))) {
		if (path.charAt(0) === '/') {
			path = path.substring(1);
		}
		return path;
	} else {
		console.log("failed check. path is " + path);
		return null;
	}

}
function checkFileExistsSync(fp){
	let exists = true;
	console.log(staticPath + fp);
	fp = staticPath + fp;
	try{
		fs.accessSync(fp, fs.constants.F_OK);
	}catch(e){
		exists = false;
	}
	return exists;
}

function calculateDistance(lat1, lat2, long1, long2) {
	console.log(lat1 + " " + lat2 + " " + long1 + " " + long2);
	lat1 = lat1 * (Math.PI / 180);
	lat2 = lat2 * (Math.PI / 180);
	long1 = long1 * (Math.PI / 180);
	long2 = long2 * (Math.PI / 180);

	/* 2 asin(((lat2 - lat1)/2) ^ 2)*/
	return (2 * Math.asin(Math.sqrt(Math.pow(Math.sin((lat2 - lat1)/2), 2) + Math.pow(Math.sin((long2 - long1)/2), 2) * Math.cos(lat1) * Math.cos(lat2))) * RADIUS_OF_EARTH_IN_MILES);
}
// app.get('/', (request, response) => {
//  	response.render("index_1.html");
//  })
app.get('/node_modules/', (request, response) => {
	response.redirect("./error.html");
})
app.get('/public/', (request, response) => {
	response.redirect("./error.html");
})



const query = "INSERT INTO data (id, url, glink, time, isGeo, radius, latitude, longitude) VALUES (?, ?, ?, toTimestamp(now()), ?, ?, ?, ?)";

app.get('/', function(req, res) {
	console.log("Moving to a diff site");
	var tagline;
	var signup;
	var loc;
	if (req.session.userId) {
		tagline = "logout";
		signup = "hidden";
		loc = "__logout";
	} else {
		tagline = "log in";
		loc = "login.html";
	}
	res.render('pages/index', {
		tagline: tagline,
		signup: signup,
		loc: loc
	});
})
app.post('/__add', function(req, res) {
	session = req.session;
	console.log("add " + req.session);
	let input_url = req.body.url;
	let input_glink = req.body.glink;
	let input_checkbox = req.body.restricted;
	let input_radius = req.body.radiusSelect;
	let input_latitude = req.body.latitude;
	let input_longitude = req.body.longitude;
	let geoBool = false;
	let geoString = "off";
	//console.log("Received query " + input_url + " and " + input_glink);
	if (input_checkbox) {
		geoString = "on";
		geoBool = true;
	} else {
		input_radius = null;
		input_latitude = null;
		input_longitude = null;
	}

	if (input_glink === "") {
		input_glink = getRandomGLink();
		let currID = nextIdData();
		console.log(currID, input_url, input_glink, geoBool, input_radius, input_latitude, input_longitude)
		client.execute(query, [currID, input_url, input_glink, geoBool, input_radius, input_latitude, input_longitude], {prepare: true}, function(err,result) {
			if (err) {
				res.send("<html><body><p style=\"font-family:Rubik; color:red;\">" + err.message + "</p></body></html>");
			} else {
				res.send("<html><head><link rel=\"stylesheet\" href=\"./css/response.css\"></head>" +
					"<body><p class=\"para\">" +
					"New entry has been added with geolocation turned " + geoString + " and url = " + req.body.url + " and glink = " +
					"</p>" +
					"<input type=\"text\" value=\"localhost:63342/" + input_glink + "\" readOnly=\"true\" id=\"myInput\" class=\"textbox\">" +
					"<div class=\"tooltip\">" +
					"<button onClick=\"myFunction()\" onMouseOut=\"outFunc()\">" +
					"<span class=\"tooltiptext\" id=\"myTooltip\">Copy to clipboard</span>" +
					"Copy text" +
					"</button>" +
					"</div>" +
					"<script src=\"./src/response.js\"></script>" +
					"</body></html>");
			}
		});
	} else {
		let selectQuery = "SELECT id FROM data where glink = ? allow filtering";
		console.log(input_glink);
		client.execute(selectQuery, [input_glink],{} ,function(err, result) {
			if (result.rows.length === 0) {
				let currID = nextIdData();
				console.log("values are: " + currID, input_url, input_glink, geoBool, input_radius, input_latitude, input_longitude);
				client.execute(query, [currID, input_url, input_glink, geoBool, input_radius, input_latitude, input_longitude], {prepare: true}, function(err,result) {
					if (err) {
						res.send("<html><body><p style=\"font-family:Rubik; font-size:large; color:red;\">" + err.message + "</p></body></html>");
					} else {
						res.send("<html><head><link rel=\"stylesheet\" href=\"./css/response.css\"></head>" +
							"<body><p class=\"para\">" +
							"New entry has been added with geolocation turned " + geoString + " and url = " + req.body.url + " and glink = " +
							"</p>" +
							"<input type=\"text\" value=\"localhost:63342/" + req.body.glink + "\" readOnly=\"true\" id=\"myInput\" class=\"textbox\">" +
							"<div class=\"tooltip\">" +
								"<button onClick=\"myFunction()\" onMouseOut=\"outFunc()\">" +
									"<span class=\"tooltiptext\" id=\"myTooltip\">Copy to clipboard</span>" +
									"Copy text" +
								"</button>" +
							"</div>" +
							"<script src=\"./src/response.js\"></script>" +
							"</body></html>");
					}
				});
			} else {
				res.send("<html><body><p style=\"font-family:Rubik; font-size: 20px; color:red;\">This glink has already been registered. Please try a different glink</p></body></html>");
			}
		});
	}

})
app.get('/__logout', function(req, res, cb) {
	console.log("Entered logout");
	console.log(req.session);
	console.log(session);
	req.session.destroy();
	var tagline;
	var signup;
	var loc;
	console.log(req.session);
	if ( req.session && req.session.userId) {
		console.log("session valid");
		tagline = "logout";
		signup = "hidden";
		loc = "__logout";
	} else {
		console.log("session invalid");
		tagline = "log in";
		loc = "login.html";
	}
	// res.render('pages/index', {
	// 	tagline: tagline,
	// 	signup: signup,
	// 	loc: loc
	// });
	res.redirect("/");
	console.log("done");
	res.end();
})
app.post('/__check', function(req, res) {
	let user_latitude = req.body.latitude;
	let user_longitude = req.body.longitude;
	let req_path = req.body.glink;
	let selQry = "select url, latitude, longitude, radius from data where glink = ? allow filtering";
	client.execute(selQry, [req_path], {}, function(err, result) {
		if (result.rows.length === 0) {
			res.redirect("/error.html");
		} else {
			let page = result.rows[0]["url"];
			let latitude = result.rows[0]["latitude"];
			let longitude = result.rows[0]["longitude"];
			let radius = result.rows[0]["radius"];
			console.log(user_latitude + user_longitude);
			let distance = calculateDistance(user_latitude, latitude, user_longitude, longitude);
			console.log(distance  + " " + radius);
			if (distance < radius) {
				console.log("inside radius");
				res.writeHead(301, {Location: page});
				res.end();
			} else {
				res.redirect("./error.html ");
				console.log("Outside radius");
				res.end();
			}
		}
	})
})
app.get('/__signup', function(req, res) {
	console.log("Entered signup");
	let email = req.body.email;
	let password = req.body.password;
	let confirm_password = req.body.verify;
	console.log(confirm_password);
	console.log(email);
	console.log(password);
	if (password === confirm_password) {
		bcrypt.hash(password, saltRounds).then(hash => {
		console.log(hash);

		let add_qry = "insert into account (id, email, password) values (?, ?, ?)";
		let id = nextIdAccount();

		console.log(id, email, hash);
		client.execute(add_qry, [id, email, hash], {prepare: true}, function(err, result) {
			if (err) {
				console.log(err.message);
				res.end();
			} else {
				console.log("signed up");
				res.end();
			}
		})
	})
	} else {
		console.log("Passwords don't match");
		res.end();
	}
})
app.post('/__login', function(req, res) {
	console.log("entered login");
	let email = req.body.email;
	let password = req.body.password;
	/**   Validate to make sure user-password exists */
	let emailRX = new RegExp("^[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+(\\.[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z]+)+$");
	let domainRX = new RegExp("[A-Za-z0-9!@#$%^&*]");
	let minRXCharUp = new RegExp("[A-Z]");
	let minRXCharLow = new RegExp("[a-z]");
	let minRXNum = new RegExp("[0-9]");
	let symRX = new RegExp("[!@#$%^&*]");
	let selQry = "select password from account where email = ? allow filtering";
	if (emailRX.test(email) && domainRX.test(password) && minRXNum.test(password) && minRXCharUp.test(password) && minRXCharLow.test(password) && symRX.test(password) && password.length >= 10) {
		client.execute(selQry, [email], {}, function(error, result) {
			if (error) {
				console.log(error.message);
				res.end();
			} else {
				if (result.rows.length === 0) {
					console.log("Wrong email");
					res.redirect("/login.html?error=auth");
					res.end();
				} else {
					let hash = result.rows[0]["password"];
					console.log(password, hash);
					bcrypt.compare(password, hash)
						.then(match => {
							if (match) {
								console.log("Logged in");
								req.session.userId = email;
								session = req.session;
								console.log(req.session);
								res.redirect("/");
								/*res.redirect("/index_1.html");*/
								res.end();
							} else {
								console.log("Wrong password");
								res.redirect("/login.html?error=auth");
								res.end();
							}
						})
						.catch(err => {
							console.log(err.message);
							res.end();
						})
				}
			}
		})
	}
});

app.get('/__login', function(req, res) {
	console.log("entered login");
	let email = req.body.email;
	let password = req.body.password;
	/**   Validate to make sure user-password exists */
	let emailRX = new RegExp("^[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+(\\.[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z]+)+$");
	let domainRX = new RegExp("[A-Za-z0-9!@#$%^&*]");
	let minRXCharUp = new RegExp("[A-Z]");
	let minRXCharLow = new RegExp("[a-z]");
	let minRXNum = new RegExp("[0-9]");
	let symRX = new RegExp("[!@#$%^&*]");
	let selQry = "select password from account where email = ? allow filtering";
	if (emailRX.test(email) && domainRX.test(password) && minRXNum.test(password) && minRXCharUp.test(password) && minRXCharLow.test(password) && symRX.test(password) && password.length >= 10) {
		client.execute(selQry, [email], {}, function(error, result) {
			if (error) {
				console.log(error.message);
				res.end();
			} else {
				if (result.rows.length === 0) {
					console.log("Wrong email");
					res.redirect("/login.html?error=auth");
					res.end();
				} else {
					let hash = result.rows[0]["password"];
					console.log(password, hash);
					bcrypt.compare(password, hash)
						.then(match => {
							if (match) {
								console.log("Logged in");
								req.session.userId = email;
								session = req.session;
								console.log(req.session);

								res.redirect("/");
								/*res.redirect("/index_1.html");*/
								res.end();
							} else {
								console.log("Wrong password");
								res.redirect("/login.html?error=auth");
								res.end();
							}
						})
						.catch(err => {
							console.log(err.message);
							res.end();
						})
				}
			}
		})
	}
});



/* Redirect requests to corresponding entry in database */
app.get('/*', (request, response) => {
	console.log("Entered");
	let original_request = request.path;
	console.log(original_request);
	if (original_request.charAt(original_request.length - 1) === '/' && original_request.length > 1) {
		original_request = original_request.substring(0, original_request.length - 1);
	}
	let req_path = filter(original_request);
	console.log(checkFileExistsSync(original_request));
	if (!req_path) {
		if (checkFileExistsSync(original_request)) {
			console.log(original_request + " unable");
			response.redirect(original_request);
		} else {
			response.redirect("/error.html");
			response.end();
		}
	} else {
		let geoQry = "select isGeo from data where glink = ? allow filtering";
		client.execute(geoQry, [req_path], {}, function (err, result) {
			if (result.rows.length === 0) {
				response.redirect("/error.html");
			} else {
				let isGeo = result.rows[0]["isgeo"];
				if (isGeo) {
					response.send("<html><head></head><body><p style='color:red;'>Redirecting you to the website! Please wait ...</p><form id=\"form\" action=\"/__check\" method=\"post\"><input type=\"hidden\" name=\"latitude\" id=\"latitude\"><input type=\"hidden\" name=\"longitude\" id=\"longitude\"><input type=\"hidden\" name=\"glink\" id=\"glink\" value=\"" + req_path + "\"></form><script src=\"./src/redirect.js\"></script></body></html>");
					response.end();
				} else {
					let selQry = "select url from data where glink = ? allow filtering";
					client.execute(selQry, [req_path], {}, function (err, result) {
						if (result.rows.length === 0) {
							response.redirect("/error.html");
						} else {
							let page = result.rows[0]["url"];
							console.log(page);
							response.writeHead(301, {Location: page});
							response.end();
						}

					})
				}

			}
		})
	}
})
app.listen(port, function(){
	console.log("server listening on port 63342");
})
/** Validate url and glink on client side as well */
/** Validate to make sure request is a file before sending it */
/** Make sure zip it stays behind using z-index*/
/** Position all elements*/
/** Work on home page */