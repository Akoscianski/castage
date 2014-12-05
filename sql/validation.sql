CREATE TABLE demande_validation(
	IdOffre INT PRIMARY KEY NOT NULL,
	DDate DATE NOT NULL,
	FOREIGN KEY (IdOffre) REFERENCES offres_stages(IdOffre)
	);

CREATE TABLE validation(
	IdOffre INT PRIMARY KEY NOT NULL,
	VDate DATE NOT NULL,
	IdValidant INT NOT NULL,
	FOREIGN KEY (IdOffre) REFERENCES demande_validation(IdOffre),
	FOREIGN KEY (IdValidant) REFERENCES user(IdUser)
	);
	
