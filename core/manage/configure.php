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

  //ANPR Server Connection Details (MSSQL-Holyhead)
  $_CONFIG['anpr_holyhead']['ip'] = ''; //ANPR Server: IP Address
  $_CONFIG['anpr_holyhead']['user'] = ''; //ANPR Server: User
  $_CONFIG['anpr_holyhead']['pass'] = ''; //ANPR Server: Password
  $_CONFIG['anpr_holyhead']['port'] = ''; //ANPR Server: Port
  $_CONFIG['anpr_holyhead']['database'] = ''; //ANPR Server: Database name

  $_CONFIG['anpr_holyhead']['imgdir'] = ''; //ANPR Server: Image Directory
  //ANPR Server Connection Details (MSSQL-Cannock)
  $_CONFIG['anpr_cannock']['ip'] = ''; //ANPR Server: IP Address
  $_CONFIG['anpr_cannock']['user'] = ''; //ANPR Server: User
  $_CONFIG['anpr_cannock']['pass'] = ''; //ANPR Server: Password
  $_CONFIG['anpr_cannock']['port'] = ''; //ANPR Server: Port
  $_CONFIG['anpr_cannock']['database'] = ''; //ANPR Server: Database name

  $_CONFIG['anpr_cannock']['imgdir'] = ''; //ANPR Server: Image Directory

  /*
    ParkingManager Configuration + Settings
  */
  $_CONFIG['pm']['url'] = 'http://localhost/ParkingManager'; //PM: Url (DOES NOT END WITH '/')
  $_CONFIG['pm']['timezone'] = 'Europe/London'; //PM: Set Timezone
  $_CONFIG['pm']['ticket_printer'] = 'PD_TICKET_PRINT'; //Name of the local printer via shared-network

?>
