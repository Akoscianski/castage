CREATE TABLE user (
	IdUser INT PRIMARY KEY AUTO_INCREMENT,
	Nom varchar(20) NOT NULL,
	Prenom Varchar(20) NOT NULL,
	Mdp char(32) NOT NULL,	/*CHAMP à remplir en MD5 : MD5('mot de passe')*/
	TUser char(5)
	);
