CREATE TABLE entreprise(
	IdEntreprise INT PRIMARY KEY AUTO_INCREMENT,
	Nom char(20)
	);

CREATE TABLE offres_stages(
	IdOffre INT PRIMARY KEY AUTO_INCREMENT,
	IdUser INT NOT NULL,	
	Intitule varchar(50) NOT NULL,
	IdEntreprise INT NOT NULL,
	Description TEXT NOT NULL,
	FOREIGN KEY (IdUser) REFERENCES user(IdUser),
	FOREIGN KEY (IdEntreprise) REFERENCES entreprise(IdEntreprise)
	);
