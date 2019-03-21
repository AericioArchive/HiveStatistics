const mysql = require('mysql2');
const mcpeping = require('mcpe-ping');

const db = mysql.createConnection(require('./connection.js'));

db.connect(function (err) {
    if (err) return console.error('error: ' + err.message);
    const createTable = `create table if not exists stats
                         (
                           id      INT AUTO_INCREMENT PRIMARY KEY,
                           time    datetime,
                           players int
                         )`;
    db.query(createTable, function (err, results, fields) {
        if (err) console.log(err.message);
    });
    console.log('connected!');
});

setInterval(function () {
    mcpeping('hivebedrock.network', 19132, function (err, res) {
            if (!err) {
                const sql = `INSERT INTO stats(players, time)
                             VALUES (?, ?)`;
                const data = [res["currentPlayers"], new Date()];
                db.query(sql, data, (error, results, fields) => {
                    if (error) return console.error(error.message);
                    console.log(new Date() + '> Rows affected:', results.affectedRows);
                });
            }
        }
    );
}, 60000);