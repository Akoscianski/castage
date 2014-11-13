CREATE USER castage@localhost;
SET password FOR castage@localhost = password('castage');
CREATE DATABASE castage;
USE castage;
GRANT SELECT , INSERT , UPDATE , DELETE , CREATE , DROP , REFERENCES , INDEX , ALTER , CREATE TEMPORARY TABLES , CREATE VIEW , EVENT, TRIGGER, SHOW VIEW , CREATE ROUTINE, ALTER ROUTINE, EXECUTE ON `castage` . * TO 'castage'@'localhost';
