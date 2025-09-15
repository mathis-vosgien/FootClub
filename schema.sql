-- Schéma MySQL FootClub
CREATE TABLE joueur (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100),
  prenom VARCHAR(100),
  date_naissance DATE,
  photo VARCHAR(255)
);

CREATE TABLE equipe (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100)
);

CREATE TABLE role_joueur_equipe (
  joueur_id INT,
  equipe_id INT,
  role VARCHAR(50),
  PRIMARY KEY (joueur_id, equipe_id),
  FOREIGN KEY (joueur_id) REFERENCES joueur(id),
  FOREIGN KEY (equipe_id) REFERENCES equipe(id)
);

CREATE TABLE club_adverse (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100),
  ville VARCHAR(100),
  pays VARCHAR(100)
);

CREATE TABLE match_foot (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_match DATETIME,
  ville VARCHAR(100),
  score_equipe INT,
  score_adverse INT,
  equipe_id INT,
  adversaire_id INT,
  FOREIGN KEY (equipe_id) REFERENCES equipe(id),
  FOREIGN KEY (adversaire_id) REFERENCES club_adverse(id)
);

CREATE TABLE staff (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100),
  prenom VARCHAR(100),
  photo VARCHAR(255),
  role_club VARCHAR(100)
);
