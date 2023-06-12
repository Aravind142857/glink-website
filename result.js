const path = require('path');
//const http = require('http');
const express = require('express');
const app = express();
const staticPath = path.join(__dirname, "/public");
var bodyParser = require('body-parser')
const cassandra = require('cassandra-driver');
const client = new cassandra.Client({
	contactPoints: ['127.0.0.1:9042'],
	localDataCenter: 'datacenter1',
	keyspace: 'glink'
});
//var server = http.createServer(app);
let id = 1;	/* Ideally should initialize id to be nextFromDB or write to file and read */
const port = 63342;	// Port that the server listens on */

app.use( bodyParser.json() );
app.use(bodyParser.urlencoded({
	extended: true
}));
app.use(express.static(staticPath));

const GLINK_SIZE = 6;
function getRandomGLink() {
	let glink = "";
	glink = newString(GLINK_SIZE);
	//console.log(glink);
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

function nextId() {
	let next = id;
	id = id + 1;
	return next;
}
function filter(path) {
	if (path.match(new RegExp("^/[a-zA-Z]+/*$"))) {
		if (path.charAt(0) === '/') {
			path = path.substring(1);
		}
		if (path.charAt(path.length - 1) === '/' && path.length > 1) {
			path = path.substring(0, path.length - 1);
		}
		return path;
	} else {
		console.log("failed check");
		return null;
	}

}
app.get('/', (request, response) => {
 	response.render("index.html");
 })
app.get('/node_modules/', (request, response) => {
	response.sendFile(path.join(staticPath, "/error.html"));
})
app.get('/public/', (request, response) => {
	response.sendFile(path.join(staticPath, "/error.html"));
})



const query = "INSERT INTO data (id, url, glink) VALUES (?, ?, ?)";

app.post('/add', function(req, res) {
	let input_url = req.body.url;
	let input_glink = req.body.glink;
	console.log("Received query " + input_url + " and " + input_glink);
	let currID = nextId();
	if (input_glink === "") {
		input_glink = getRandomGLink();
		client.execute(query, [currID, input_url, input_glink], {prepare: true}, function(err,result) {
			if (err) {
				res.send("<html><body><p style=\"font-family:Futura; font-size:large; color:red;\">" + err.message + "</p></body></html>");
			} else {
				res.send("<html><body><p style=\"font-family:Futura; font-size:large; color:green;\">New entry has been added with url = " + req.body.url + " and glink = " + input_glink + "</p></body></html>");
			}
		});
	} else {
		let selectQuery = "SELECT id FROM data where glink = ? allow filtering";
		client.execute(selectQuery, [input_glink],{} ,function(err, result) {
			if (result.rows.length === 0) {
				client.execute(query, [currID, input_url, input_glink], {prepare: true}, function(err,result) {
					if (err) {
						res.send("<html><body><p style=\"font-family:Futura; font-size:large; color:red;\">{err.message}</p></body></html>");
					} else {
						res.send("<html><head><link rel=\"stylesheet\" href=\"./css/response.css\"></head>" +
							"<body><p class=\"para\">" +
							"New entry has been added with url = " + req.body.url + " and glink = " /*+ req.body.glink*/ + "" +
							"</p>" +
							"<input type=\"text\" value=\"" + req.body.glink + "\" readOnly=\"true\" id=\"myInput\" class=\"textbox\">" +
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
				res.send("<html><body><p style=\"font-family:futura; font-size:large; color:red;\">This glink has already been registered. Please try a different glink</p></body></html>");
			}
		});
	}

})

/* Redirect requests to corresponding entry in database */
app.get('/*', (request, response) => {
	let req_path = request.path;
	req_path = filter(req_path);
	console.log("Path is " +req_path);
	if (req_path == null) {
		response.sendFile(path.join(staticPath, "/error.html"));
		return;
	}

	let selQry = "select url from data where glink = ? allow filtering";
	client.execute(selQry, [req_path], {}, function(err, result) {
		if (result.rows.length === 0) {
			console.log("Failed");
			response.sendFile(path.join(staticPath, "/error.html"));
		} else {
			let page = result.rows[0]["url"];
			console.log(page);
			response.writeHead(301, {Location: page});
			response.end();
		}

	})
})
app.listen(port, function(){
	console.log("server listening on port 63342");
})
/** Validate url and glink on client side as well */
/** Put the glink in a span or label and make it copyable */