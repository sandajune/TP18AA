CREATE DATABASE IF NOT EXISTS immobilier;
USE immobilier;

CREATE TABLE clients (
    id_client INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    date_naissance DATE,
    genre CHAR(1),
    email VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE proprietes (
    id_propriete INT AUTO_INCREMENT PRIMARY KEY,
    adresse VARCHAR(100),
    ville VARCHAR(50),
    prix DECIMAL(10, 2),
    type_maison VARCHAR(50),
    photo_principale VARCHAR(255),
    photo_galerie TEXT
);

CREATE TABLE transactions (
    id_transaction INT AUTO_INCREMENT PRIMARY KEY,
    id_client INT,
    id_propriete INT,
    date_transaction DATE,
    prix_final DECIMAL(10, 2),
    FOREIGN KEY (id_client) REFERENCES clients(id_client),
    FOREIGN KEY (id_propriete) REFERENCES proprietes(id_propriete)
);

CREATE TABLE agents (
    id_agent INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    region VARCHAR(50),
    adresse VARCHAR(100),
    telephone VARCHAR(20),
    email VARCHAR(100),
    photo_agent VARCHAR(255)
);

CREATE TABLE listings (
    id_listing INT AUTO_INCREMENT PRIMARY KEY,
    id_agent INT,
    id_propriete INT,
    date_debut DATE,
    date_fin DATE,
    FOREIGN KEY (id_agent) REFERENCES agents(id_agent),
    FOREIGN KEY (id_propriete) REFERENCES proprietes(id_propriete)
);

-- Table clients (sans mot de passe, avec email)
INSERT INTO clients (nom, prenom, date_naissance, genre, email) VALUES 
('Martin', 'Jean', '1980-05-15', 'M', 'jean.martin@example.com'),
('Dupont', 'Marie', '1990-06-24', 'F', 'marie.dupont@example.com'),
('Durand', 'Paul', '1975-02-12', 'M', 'paul.durand@example.com'),
('Morel', 'Sophie', '1988-11-19', 'F', 'sophie.morel@example.com'),
('Legrand', 'Luc', '1995-08-30', 'M', 'luc.legrand@example.com'),
('Bernard', 'Nathalie', '1982-01-22', 'F', 'nathalie.bernard@example.com'),
('Lemoine', 'Vincent', '1978-09-17', 'M', 'vincent.lemoine@example.com'),
('Fontaine', 'Chloe', '1992-12-05', 'F', 'chloe.fontaine@example.com'),
('Lefevre', 'Julie', '1991-04-08', 'F', 'julie.lefevre@example.com'),
('Roy', 'Laurent', '1986-07-13', 'M', 'laurent.roy@example.com'),
('Giraud', 'Emma', '1993-03-21', 'F', 'emma.giraud@example.com'),
('Perrin', 'Antoine', '1985-10-14', 'M', 'antoine.perrin@example.com'),
('Renaud', 'Caroline', '1994-09-29', 'F', 'caroline.renaud@example.com'),
('Marchand', 'Pierre', '1987-05-25', 'M', 'pierre.marchand@example.com'),
('Duval', 'Alice', '1989-11-03', 'F', 'alice.duval@example.com'),
('Vidal', 'Jacques', '1983-06-10', 'M', 'jacques.vidal@example.com'),
('Aubert', 'Lucie', '1990-02-28', 'F', 'lucie.aubert@example.com'),
('Girard', 'Henri', '1979-08-11', 'M', 'henri.girard@example.com'),
('Moulin', 'Celine', '1992-03-17', 'F', 'celine.moulin@example.com'),
('Dupuis', 'Louis', '1984-07-26', 'M', 'louis.dupuis@example.com');

-- Table proprietes
INSERT INTO proprietes (adresse, ville, prix, type_maison, photo_principale, photo_galerie) VALUES
('12 Rue de la Paix', 'Paris', 750000, 'Appartement', 'assets/images/propriete1_main.jpg', 'assets/images/propriete1_g1.jpg,assets/images/propriete1_g2.jpg'),
('15 Avenue de la Republique', 'Lyon', 300000, 'Maison', 'assets/images/propriete2_main.jpg', 'assets/images/propriete2_g1.jpg'),
('23 Boulevard Saint-Michel', 'Marseille', 450000, 'Appartement', 'assets/images/propriete3_main.jpg', 'assets/images/propriete3_g1.jpg'),
('7 Place Bellecour', 'Lyon', 550000, 'Maison', 'assets/images/propriete4_main.jpg', 'assets/images/propriete4_g1.jpg'),
('9 Rue de Rivoli', 'Paris', 950000, 'Appartement', 'assets/images/propriete5_main.jpg', 'assets/images/propriete5_g1.jpg'),
('18 Rue Victor Hugo', 'Lille', 250000, 'Maison', 'assets/images/propriete6_main.jpg', 'assets/images/propriete6_g1.jpg'),
('25 Rue Saint-Honore', 'Paris', 1100000, 'Appartement', 'assets/images/propriete7_main.jpg', 'assets/images/propriete7_g1.jpg'),
('3 Rue de la Republique', 'Lyon', 450000, 'Maison', 'assets/images/propriete8_main.jpg', 'assets/images/propriete8_g1.jpg'),
('14 Rue des Petits Champs', 'Paris', 800000, 'Appartement', 'assets/images/propriete9_main.jpg', 'assets/images/propriete9_g1.jpg'),
('5 Rue de la Bourse', 'Marseille', 500000, 'Maison', 'assets/images/propriete10_main.jpg', 'assets/images/propriete10_g1.jpg'),
('11 Rue Paradis', 'Marseille', 750000, 'Appartement', 'assets/images/propriete11_main.jpg', 'assets/images/propriete11_g1.jpg'),
('19 Rue Massena', 'Lille', 350000, 'Maison', 'assets/images/propriete12_main.jpg', 'assets/images/propriete12_g1.jpg'),
('22 Rue Faidherbe', 'Lille', 400000, 'Appartement', 'assets/images/propriete13_main.jpg', 'assets/images/propriete13_g1.jpg'),
('30 Rue Nationale', 'Bordeaux', 600000, 'Maison', 'assets/images/propriete14_main.jpg', 'assets/images/propriete14_g1.jpg'),
('2 Rue de l\'Intendance', 'Bordeaux', 650000, 'Appartement', 'assets/images/propriete15_main.jpg', 'assets/images/propriete15_g1.jpg'),
('16 Rue Sainte-Catherine', 'Bordeaux', 700000, 'Maison', 'assets/images/propriete16_main.jpg', 'assets/images/propriete16_g1.jpg'),
('28 Rue Gambetta', 'Nice', 480000, 'Appartement', 'assets/images/propriete17_main.jpg', 'assets/images/propriete17_g1.jpg'),
('6 Avenue Jean Medecin', 'Nice', 520000, 'Maison', 'assets/images/propriete18_main.jpg', 'assets/images/propriete18_g1.jpg'),
('10 Promenade des Anglais', 'Nice', 1000000, 'Appartement', 'assets/images/propriete19_main.jpg', 'assets/images/propriete19_g1.jpg'),
('12 Rue de la Paix', 'Paris', 1200000, 'Maison', 'assets/images/propriete20_main.jpg', 'assets/images/propriete20_g1.jpg');

-- Table transactions
INSERT INTO transactions (id_client, id_propriete, date_transaction, prix_final) VALUES
(1, 1, '2023-01-15', 740000),
(2, 2, '2023-02-20', 290000),
(3, 3, '2023-03-18', 440000),
(4, 4, '2023-04-25', 530000),
(5, 5, '2023-05-10', 930000),
(6, 6, '2023-06-15', 240000),
(7, 7, '2023-07-20', 1080000),
(8, 8, '2023-08-25', 430000),
(9, 9, '2023-09-30', 780000),
(10, 10, '2023-10-05', 490000),
(11, 11, '2023-11-10', 740000),
(12, 12, '2023-12-15', 340000),
(13, 13, '2024-01-20', 390000),
(14, 14, '2024-02-25', 580000),
(15, 15, '2024-03-30', 630000),
(16, 16, '2024-04-05', 680000),
(17, 17, '2024-05-10', 460000),
(18, 18, '2024-06-15', 500000),
(19, 19, '2024-07-20', 960000),
(20, 20, '2024-08-25', 1180000);

-- Table agents
INSERT INTO agents (nom, prenom, region, adresse, telephone, email, photo_agent) VALUES
('Leblanc', 'Sophie', 'Ile-de-France', '10 Rue de Paris, Paris', '(330) 1234 5671', 'sophie.leblanc@example.com', 'assets/images/agent1.jpg'),
('Rousseau', 'Pierre', 'Auvergne-Rhône-Alpes', '45 Rue de Lyon, Lyon', '(330) 1234 5672', 'pierre.rousseau@example.com', 'assets/images/agent2.jpg'),
('Moreau', 'Luc', 'Provence-Alpes-Côte d\'Azur', '12 Rue de Marseille, Marseille', '(330) 1234 5673', 'luc.moreau@example.com', 'assets/images/agent3.jpg'),
('Durand', 'Paul', 'Nouvelle-Aquitaine', '5 Rue de Bordeaux, Bordeaux', '(330) 1234 5674', 'paul.durand@example.com', 'assets/images/agent4.jpg'),
('Dumont', 'Jean', 'Hauts-de-France', '20 Rue de Lille, Lille', '(330) 1234 5675', 'jean.dumont@example.com', 'assets/images/agent5.jpg'),
('Fournier', 'Julie', 'Occitanie', '15 Rue de Toulouse, Toulouse', '(330) 1234 5676', 'julie.fournier@example.com', 'assets/images/agent6.jpg'),
('Gauthier', 'Marie', 'Grand Est', '8 Rue de Strasbourg, Strasbourg', '(330) 1234 5677', 'marie.gauthier@example.com', 'assets/images/agent7.jpg'),
('Lambert', 'Lucie', 'Bretagne', '3 Rue de Rennes, Rennes', '(330) 1234 5678', 'lucie.lambert@example.com', 'assets/images/agent8.jpg'),
('Henry', 'Alex', 'Normandie', '7 Rue de Rouen, Rouen', '(330) 1234 5679', 'alex.henry@example.com', 'assets/images/agent9.jpg'),
('Renaud', 'David', 'Pays de la Loire', '9 Rue de Nantes, Nantes', '(330) 1234 5680', 'david.renaud@example.com', 'assets/images/agent10.jpg'),
('Dufour', 'Emma', 'Centre-Val de Loire', '14 Rue de Tours, Tours', '(330) 1234 5681', 'emma.dufour@example.com', 'assets/images/agent11.jpg'),
('Perrin', 'Antoine', 'Bourgogne-Franche-Comté', '18 Rue de Dijon, Dijon', '(330) 1234 5682', 'antoine.perrin@example.com', 'assets/images/agent12.jpg'),
('Marchand', 'Elise', 'Corse', '6 Rue d\'Ajaccio, Ajaccio', '(330) 1234 5683', 'elise.marchand@example.com', 'assets/images/agent13.jpg'),
('Berger', 'Pauline', 'Provence-Alpes-Côte d\'Azur', '22 Rue de Nice, Nice', '(330) 1234 5684', 'pauline.berger@example.com', 'assets/images/agent14.jpg'),
('Leroy', 'Nicolas', 'Nouvelle-Aquitaine', '11 Rue de Bordeaux, Bordeaux', '(330) 1234 5685', 'nicolas.leroy@example.com', 'assets/images/agent15.jpg'),
('Morel', 'Sylvie', 'Ile-de-France', '25 Rue de Paris, Paris', '(330) 1234 5686', 'sylvie.morel@example.com', 'assets/images/agent16.jpg'),
('Girard', 'Hugo', 'Occitanie', '30 Rue de Montpellier, Montpellier', '(330) 1234 5687', 'hugo.girard@example.com', 'assets/images/agent17.jpg'),
('André', 'Cécile', 'Bretagne', '4 Rue de Brest, Brest', '(330) 1234 5688', 'cecile.andre@example.com', 'assets/images/agent18.jpg'),
('Lemoine', 'Claire', 'Grand Est', '16 Rue de Metz, Metz', '(330) 1234 5689', 'claire.lemoine@example.com', 'assets/images/agent19.jpg'),
('Garnier', 'Louis', 'Pays de la Loire', '19 Rue d\'Angers, Angers', '(330) 1234 5690', 'louis.garnier@example.com', 'assets/images/agent20.jpg');

-- Table listings
INSERT INTO listings (id_agent, id_propriete, date_debut, date_fin) VALUES
(1, 1, '2023-01-01', '2023-12-31'),
(2, 2, '2023-02-01', '2023-11-30'),
(3, 3, '2023-03-01', '2023-10-31'),
(4, 4, '2023-04-01', '2023-09-30'),
(5, 5, '2023-05-01', '2023-08-31'),
(6, 6, '2023-06-01', '2023-07-31'),
(7, 7, '2023-07-01', '2023-12-31'),
(8, 8, '2023-08-01', '2023-11-30'),
(9, 9, '2023-09-01', '2023-10-31'),
(10, 10, '2023-10-01', '2023-12-31'),
(11, 11, '2023-11-01', '2024-01-31'),
(12, 12, '2023-12-01', '2024-02-28'),
(13, 13, '2024-01-01', '2024-03-31'),
(14, 14, '2024-02-01', '2024-04-30'),
(15, 15, '2024-03-01', '2024-05-31'),
(16, 16, '2024-04-01', '2024-06-30'),
(17, 17, '2024-05-01', '2024-07-31'),
(18, 18, '2024-06-01', '2024-08-31'),
(19, 19, '2024-07-01', '2024-09-30'),
(20, 20, '2024-08-01', '2024-10-31');