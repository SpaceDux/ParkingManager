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
  $_CONFIG['mysql']['ip'] = '127.0.0.1'; //MySQL Server: IP Address
  $_CONFIG['mysql']['port'] = '3306'; //MySQL Server: IP Address
  $_CONFIG['mysql']['user'] = 'root'; //MySQL Server: User
  $_CONFIG['mysql']['pass'] = ''; //MySQL Server: Password
  $_CONFIG['mysql']['database'] = 'parking_manager_db'; //MySQL Server: Database name

  //ANPR Server Connection Details (MSSQL-DEV)
  $_CONFIG['anpr_dev']['ip'] = '127.0.0.1'; //ANPR Server: IP Address
  $_CONFIG['anpr_dev']['user'] = 'root'; //ANPR Server: User
  $_CONFIG['anpr_dev']['pass'] = ''; //ANPR Server: Password
  $_CONFIG['anpr_dev']['port'] = ''; //ANPR Server: Port
  $_CONFIG['anpr_dev']['database'] = 'ANPR_DB'; //ANPR Server: Database name

  $_CONFIG['anpr_dev']['imgdir'] = ''; //ANPR Server: Image Directory

  //ANPR Server Connection Details (MSSQL-Holyhead)
  $_CONFIG['anpr_holyhead']['ip'] = '127.0.0.1'; //ANPR Server: IP Address
  $_CONFIG['anpr_holyhead']['user'] = 'root'; //ANPR Server: User
  $_CONFIG['anpr_holyhead']['pass'] = ''; //ANPR Server: Password
  $_CONFIG['anpr_holyhead']['port'] = ''; //ANPR Server: Port
  $_CONFIG['anpr_holyhead']['database'] = 'ANPR_DB'; //ANPR Server: Database name

  $_CONFIG['anpr_holyhead']['imgdir'] = 'http://127.0.0.1/'; //ANPR Server: Image Directory

  //ANPR Server Connection Details (MSSQL-Cannock)
  $_CONFIG['anpr_cannock']['ip'] = '127.0.0.1'; //ANPR Server: IP Address
  $_CONFIG['anpr_cannock']['user'] = 'root'; //ANPR Server: User
  $_CONFIG['anpr_cannock']['pass'] = ''; //ANPR Server: Password
  $_CONFIG['anpr_cannock']['port'] = ''; //ANPR Server: Port
  $_CONFIG['anpr_cannock']['database'] = 'ANPR_DB'; //ANPR Server: Database name

  $_CONFIG['anpr_cannock']['imgdir'] = 'http://127.0.0.1/'; //ANPR Server: Image Directory

  //Gate Functions
  //Holyhead
  $_CONFIG['gate_holyhead']['in'] = ""; //Entry Barrier IP
  $_CONFIG['gate_holyhead']['out'] = ""; //Exit Barrier IP
  //Cannock
  $_CONFIG['gate_cannock']['out'] = ""; //Exit Barrier IP

  /*
    ParkingManager Configuration + Settings
  */
  $_CONFIG['pm']['url'] = 'http://localhost/'; //PM: Url (DOES NOT END WITH '/')
  $_CONFIG['pm']['timezone'] = 'Europe/London'; //PM: Set Timezone
  $_CONFIG['pm']['ticket_printer_holyhead'] = ''; //Name of the local printer via shared-network
  $_CONFIG['pm']['ticket_printer_cannock'] = ''; //Name of the local printer via shared-network

  //ETP API Settings
  $_CONFIG['etp_api']['base_uri'] = "https://api.etpcp.com/trx/";
  //Holyhead
  $_CONFIG['etp_api']['user'] = "";
  $_CONFIG['etp_api']['pass'] = "";

  $_CONFIG['etp_api']['location_user-holyhead'] = "";
  $_CONFIG['etp_api']['location_pass-holyhead'] = "";
  //Cannock
  $_CONFIG['etp_api']['location_user-cannock'] = "";
  $_CONFIG['etp_api']['location_pass-cannock'] = "";
?>
