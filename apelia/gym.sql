-- Create the tech_support database
DROP DATABASE IF EXISTS apeliadb;
CREATE DATABASE apeliadb;
USE apeliadb;

CREATE TABLE positions(
	posID varchar(2) NOT NULL,
	positionName varchar(20) NOT NULL,
	PRIMARY KEY (posID)
);
INSERT INTO positions VALUES 
('FW', 'Forward'),
('DF', 'Defender'),
('MF', 'Midfielder'),
('GK', 'Goalkeeper');

CREATE TABLE players (
    playerID int NOT NULL AUTO_INCREMENT,
    firstName varchar(50) NOT NULL,
    lastName varchar(50) NOT NULL,
    phone varchar(20) NOT NULL,
    email varchar(50) NOT NULL UNIQUE,
    password varchar(20) NOT NULL,
	posID varchar(2) NOT NULL,
	picPath varchar(200) NULL, 
    PRIMARY KEY (playerID), 
	FOREIGN KEY (posID) REFERENCES positions(posID)
);

INSERT INTO players VALUES 
(1000, 'Kelly', 'Jacobs', '505-784-0115', 'kelly@example.com', 'Test0101', 'GK', '../resources/images/profileimages/profilepic.png');

CREATE TABLE services(
	servID varchar(1) NOT NULL,
    serviceName varchar(50) NOT NULL,
	PRIMARY KEY (servID)
);

INSERT INTO services VALUES 
('T', 'Technical Development'),
('C', 'Cardio Workout'),
('R', 'Recovery & Rehab'),
('P', 'Physiotherapy');


CREATE TABLE staff(
    staffID int NOT NULL AUTO_INCREMENT,
	servID varchar(1) NOT NULL, 
    firstName varchar(50) NOT NULL,
    lastName varchar(50) NOT NULL,
    email varchar(50) NOT NULL UNIQUE,
    phone varchar(20) NOT NULL,
    password varchar(20) NOT NULL,
    PRIMARY KEY (staffID),
	FOREIGN KEY (servID) REFERENCES services(servID)
);

INSERT INTO staff VALUES 
(11, 'T', 'Rachel', 'Diaz', 'rachel@cnf.com', '800-555-0443', 'sesame'), 
(12, 'T', 'Samuel', 'Lee', 'samuel@cnf.com', '800-555-0444', 'sesame'),
(13, 'C', 'Amir', 'Wilson', 'awilson@cnf.com', '800-555-0449', 'sesame'), 
(14, 'C', 'Erik', 'Birkshire', 'erikb@cnf.com', '800-555-0449', 'sesame'), 
(15, 'R', 'Gunter', 'Wendt', 'gunter@cnf.com', '800-555-0400', 'sesame'), 
(16, 'R', 'Gina', 'Fiori', 'gfiori@cnf.com', '800-555-0459', 'sesame'),
(17, 'P','Gwen', 'Portonoy', 'gwen@cnf.com', '800-555-0459', 'sesame'),
(18, 'P','Ian', 'Gallagher', 'iang@cnf.com', '800-555-0459', 'sesame');

CREATE TABLE timeslots(
	slotID int NOT NULL AUTO_INCREMENT,
	startTime TIME NOT NULL,
	endTime TIME NOT NULL,
	PRIMARY KEY (slotID)
);

INSERT INTO timeslots VALUES
(1, '09:00:00', '11:00:00'),
(2, '11:00:00', '13:00:00'),
(3, '15:00:00', '17:00:00'),
(4, '17:00:00', '19:00:00'),
(5, '19:00:00', '21:00:00');

CREATE TABLE appointments(
    apptID int NOT NULL AUTO_INCREMENT,
    playerID int NOT NULL,
    staffID int NOT NULL,
    servID varchar(1) NOT NULL,
    slotID int NOT NULL,
	apptDate datetime NOT NULL,
    completed boolean NOT NULL,
    PRIMARY KEY (apptID), 
	FOREIGN KEY (playerID) REFERENCES players(playerID),
	FOREIGN KEY (staffID) REFERENCES staff(staffID),
	FOREIGN KEY (servID) REFERENCES services(servID),
	FOREIGN KEY (slotID) REFERENCES timeslots(slotID)
);




-- Create a userm named ts_user
GRANT SELECT, INSERT, UPDATE, DELETE
ON *
TO ts_user@localhost
IDENTIFIED BY 'pa55word';
