CREATE TABLE commentaires_offres(
	IdComm INT PRIMARY KEY AUTO_INCREMENT,
	IdOffre INT NOT NULL,
	IdUser INT NOT NULL,
	CDate DATE NOT NULL,
	Com varchar(256),
	FOREIGN KEY (IdOffre) REFERENCES offres_stages(IdOffre),
	FOREIGN KEY (IdUser) REFERENCES user(IdUser)
	);
	
