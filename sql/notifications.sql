CREATE TABLE notif(
	IdNotif INT PRIMARY KEY AUTO_INCREMENT,
	IdUser INT NOT NULL,
	NDate DATE NOT NULL,
	Vu BOOL default 0,
	notification varchar(256)
	);

CREATE TRIGGER trg_notif_date
AFTER INSERT ON notif FOR EACH ROW
DECLARE
	NewId notif.IdNotif%TYPE := new.IdNotif;
BEGIN
	UPDATE notification SET NDate = NOW() WHERE IdNotif=NewId;
END;
/
