console.log('Beginning database execution');

const cassandra = require('cassandra-driver');

const client = new cassandra.Client({
	contactPoints: ['127.0.0.1:9042'],
	keyspace: 'glink',
});

const query = 'SELECT name FROM data WHERE id = ?';

console.log(query);

client.execute(query, [5]).then(result => console.log('User name is %s',result.rows[0].name));
