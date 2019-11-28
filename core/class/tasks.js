function tasks_LoadNotifications()
{
  var pane = document.getElementById("Notifications");
  if (pane.style.display === "none") {
     pane.style.display = "block";
     pane.style.transition = "0.2s ease-in-out";
     $('#NotificationsList').html('<img src="img/loading.gif" style="height: 80px; width:80px;margin:150px auto; display:block;"></img>');
     user_getInfo(session.getItem("User_ID"), function(response) {
     var connection = mysql.createConnection({
         host: config.MySQL.Host,
         user: config.MySQL.User,
         password: config.MySQL.Pass,
         database: config.MySQL.Database
     });
     var site = JSON.parse(response).Site;
     connection.query("SELECT * FROM notifications WHERE notification_site = ? ORDER BY notification_created DESC LIMIT 20", [site], function(error, result, fields) {
       if(error) throw error;
       if(result.length > 0)
       {
         var lists = [];
         result.forEach(function(row) {
           var date = $.format.date(row.notification_created, "dd/HH:mm")
           if(row.notification_urgency == "0") {
           var data = '<div class="alert alert-success" role="alert">'+
           '<p>'+row.notification_text+'</p><hr>'+
           '<p class="mb-0" style="text-align: right;"><i class="fa fa-clock"></i> '+date+'</p>'+
           '</div>';
         } else {
           var data = '<div class="alert alert-warning" role="alert">'+
           '<p>'+row.notification_text+'</p><hr>'+
           '<p class="mb-0" style="text-align: right;"><i class="fa fa-clock"></i> '+date+'</p>'+
           '</div>';
         }
           lists.push(data);
         });
         $('#NotificationsList').html(lists);
       }
       });
     });
  } else {
    pane.style.display = "none";
    pane.style.transition = "0.2s ease-in-out";

  }
}
