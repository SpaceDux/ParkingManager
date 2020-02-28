INSERT INTO parking_records_archive (SELECT * FROM parking_records WHERE Arrival < '2019-11-01 00:00:00');

DELETE FROM parking_records WHERE Arrival < '2019-11-01 00:00:00';

