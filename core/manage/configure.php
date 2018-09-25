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

  //MySQL Connection Details (Main Server)
  $_CONFIG['mysql']['ip'] = '127.0.0.1'; //MySQL Server: IP Address
  $_CONFIG['mysql']['port'] = '3306'; //MySQL Server: IP Address
  $_CONFIG['mysql']['user'] = 'root'; //MySQL Server: User
  $_CONFIG['mysql']['pass'] = ''; //MySQL Server: Password
  $_CONFIG['mysql']['database'] = 'new_rkpm'; //MySQL Server: Database name

  //ANPR Server Connection Details (MSSQL-DEV)
  $_CONFIG['anpr_dev']['ip'] = '127.0.0.1'; //ANPR Server: IP Address
  $_CONFIG['anpr_dev']['user'] = 'sa'; //ANPR Server: User
  $_CONFIG['anpr_dev']['pass'] = '1212'; //ANPR Server: Password
  $_CONFIG['anpr_dev']['port'] = ''; //ANPR Server: Port
  $_CONFIG['anpr_dev']['database'] = 'ANPR'; //ANPR Server: Database name

  $_CONFIG['anpr_dev']['imgdir'] = ''; //ANPR Server: Image Directory

  //ANPR Server Connection Details (MSSQL-Holyhead) arble2501
  $_CONFIG['anpr_holyhead']['ip'] = '192.168.3.201'; //ANPR Server: IP Address
  $_CONFIG['anpr_holyhead']['user'] = 'pm'; //ANPR Server: User
  $_CONFIG['anpr_holyhead']['pass'] = '1212'; //ANPR Server: Password
  $_CONFIG['anpr_holyhead']['port'] = ''; //ANPR Server: Port
  $_CONFIG['anpr_holyhead']['database'] = 'ANPR'; //ANPR Server: Database name

  $_CONFIG['anpr_holyhead']['imgdir'] = 'http://192.168.3.201/'; //ANPR Server: Image Directory

  //ANPR Server Connection Details (MSSQL-Cannock)
  $_CONFIG['anpr_cannock']['ip'] = ''; //ANPR Server: IP Address
  $_CONFIG['anpr_cannock']['user'] = ''; //ANPR Server: User
  $_CONFIG['anpr_cannock']['pass'] = ''; //ANPR Server: Password
  $_CONFIG['anpr_cannock']['port'] = ''; //ANPR Server: Port
  $_CONFIG['anpr_cannock']['database'] = ''; //ANPR Server: Database name

  $_CONFIG['anpr_cannock']['imgdir'] = ''; //ANPR Server: Image Directory

  //Gate Functions
  $_CONFIG['gate_holyhead']['in'] = "http://192.168.3.37/setParam.cgi?DOPulseStart_05=1?"; //Entery Barrier IP
  $_CONFIG['gate_holyhead']['out'] = "http://192.168.3.37/setParam.cgi?DOPulseStart_04=1?"; //Exit Barrier IP

  $_CONFIG['gate_cannock']['out'] = ""; //Exit Barrier IP


  /*
    ParkingManager Configuration + Settings
  */
  $_CONFIG['pm']['url'] = 'http://localhost/ParkingManager'; //PM: Url (DOES NOT END WITH '/')
  $_CONFIG['pm']['timezone'] = 'Europe/London'; //PM: Set Timezone
  $_CONFIG['pm']['ticket_printer_holyhead'] = 'CITIZEN-PD-Holy'; //Name of the local printer via shared-network
  $_CONFIG['pm']['ticket_printer_cannock'] = 'CITIZEN-PD-Holy'; //Name of the local printer via shared-network
?>
