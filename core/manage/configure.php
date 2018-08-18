<?php
  /*
    =================================================
    =        ParkingManager 3                       =
    =        By Ryan Williams                       =
    =        ryan@roadkingcafe.uk                   =
    =                                               =
    =        Designed, Developed & owned            =
    =        by ryan@roadkingcafe.uk                =
    =                                               =
    =        License:                               =
    =        TBD                                    =
    =================================================
  */

  /*
    DATABASE CONNECTIONS
  */

  //MySQL Connection Details
  $_CONFIG['mysql']['ip'] = '127.0.0.1'; //MySQL Server: IP Address
  $_CONFIG['mysql']['user'] = 'root'; //MySQL Server: User
  $_CONFIG['mysql']['pass'] = ''; //MySQL Server: Password
  $_CONFIG['mysql']['database'] = 'new_rkpm'; //MySQL Server: Database name

  //ANPR Server Connection Details (MSSQL)
  $_CONFIG['anpr']['ip'] = ''; //ANPR Server: IP Address
  $_CONFIG['anpr']['user'] = ''; //ANPR Server: User
  $_CONFIG['anpr']['pass'] = ''; //ANPR Server: Password
  $_CONFIG['anpr']['port'] = ''; //ANPR Server: Port
  $_CONFIG['anpr']['database'] = ''; //ANPR Server: Database name

  $_CONFIG['anpr']['imgdir'] = ''; //ANPR Server: Image Directory

  /*
    ParkingManager Configuration + Settings
  */
  $_CONFIG['pm']['url'] = 'http://localhost/PM2'; //PM: Url (DOES NOT END WITH '/')
  $_CONFIG['pm']['timezone'] = 'Europe/London'; //PM: Set Timezone


?>
