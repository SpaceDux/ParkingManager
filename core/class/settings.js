function getSite(id, callback)
{
  var connection = mysql.createConnection({
      host: config.MySQL.Host,
      user: config.MySQL.User,
      password: config.MySQL.Pass,
      database: config.MySQL.Database
  });
  connection.query("SELECT * FROM sites WHERE Uniqueref = ? LIMIT 1", [id], function(error, result, fields) {
    if(error) throw error;
    if(result.length > 0) {
      callback(JSON.stringify(result[0]));
    }
  });
  connection.end();
}
