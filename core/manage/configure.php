<?php
  /*
    =================================================
    =        ParkingManager 3                       =
    =        By Ryan Williams                       =
    =        ryan@roadkingcafe.uk                   =
    =                                               =
    =        Designed, Developed & owned            =
    =        by ryan@roadkingcafe.uk                =
    =================================================
  */

  /*
    DATABASE CONNECTIONS
  */

  //MySQL Connection Details (Main Server)
  $_CONFIG['mysql']['ip'] = 'localhost'; //MySQL Server: IP Address
  $_CONFIG['mysql']['port'] = '3306'; //MySQL Server: IP Address
  $_CONFIG['mysql']['user'] = 'root'; //MySQL Server: User
  $_CONFIG['mysql']['pass'] = ''; //MySQL Server: Password
  $_CONFIG['mysql']['database'] = 'new_rkpm'; //MySQL Server: Database name

  /*
    ParkingManager Configuration + Settings
  */
  $_CONFIG['pm']['url'] = 'http://localhost/ParkingManager'; //PM: Url (DOES NOT END WITH '/')
  $_CONFIG['pm']['timezone'] = 'Europe/London'; //PM: Set Timezone
  $_CONFIG['pm']['ticket_printer_holyhead'] = 'pdholyhead'; //Name of the local printer via shared-network
  $_CONFIG['pm']['ticket_printer_cannock'] = 'CITIZEN-PD-Holy'; //Name of the local printer via shared-network

  //ETP API Settings
  $_CONFIG['etp_api']['base_uri'] = "https://api.etpcp.com/trx/";
  //Holyhead
  $_CONFIG['etp_api']['user'] = "sm394_34lll2345Ae";
  $_CONFIG['etp_api']['pass'] = "P2002laeif[3234JklmNo1A@344_12Qq";

  $_CONFIG['etp_api']['location_user-holyhead'] = "holyhead";
  $_CONFIG['etp_api']['location_pass-holyhead'] = "2hst36sg";
  //Cannock
  $_CONFIG['etp_api']['location_user-cannock'] = "hollies";
  $_CONFIG['etp_api']['location_pass-cannock'] = "hollies";
?>
