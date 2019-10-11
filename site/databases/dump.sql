PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS 'user'
(
    'id'        INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    'firstname' TEXT                              NOT NULL,
    'lastname'  TEXT                              NOT NULL,
    'username'  TEXT                              NOT NULL unique,
    'password'  TEXT                              NOT NULL,
    'admin'     BOOLEAN                           NOT NULL DEFAULT FALSE,
    'active'    BOOLEAN                           NOT NULL DEFAULT FALSE
);
INSERT INTO user VALUES(1,'Jérôme','Bagnoud','jerome','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(2,'Mickael','Bonjour','mickael','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(3,'Stefan','Dejanovic','stefan','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(4,'Filipe','Fortunato','filipe','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(5,'Nikolaos','Garanis','niko','admin','TRUE','TRUE');
INSERT INTO user VALUES(6,'Baptiste','Hardrick','baptiste','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(7,'Olivier','Koffi','olivier','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(8,'Pierre','Kohler','pierre','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(9,'Samuel','Mettler','samuel','password','TRUE','TRUE');
INSERT INTO user VALUES(10,'Nathanaël','Mizutani','nathanaël','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(11,'Caroline','Monthoux','caroline','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(12,'Edin','Mujkanovic','edin','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(13,'Daniel','Oliveira Paiva','daniel','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(14,'Nemanja','Pantic','nemanja','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(15,'Florian','Polier','florian','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(16,'Julien','Quartier','julien','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(17,'Nathan','Séville','nathan','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(18,'David','Simeonovic','david','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(19,'Victor','Truan','victor','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(20,'Jonathan','Zaehringer','jonathan','mypwd','FALSE','TRUE');
INSERT INTO user VALUES(21,'Jeremy','Zerbib','jeremy','mypwd','FALSE','TRUE');
CREATE TABLE IF NOT EXISTS 'message'
(
    'id'       INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    'date'     DATETIME                          NOT NULL,
    'sender'   INTEGER                           NOT NULL,
    'receiver' INTEGER                           NOT NULL,
    'subject'  TEXT,
    'content'  TEXT,
    'seen'     BOOLEAN                           NOT NULL DEFAULT FALSE,
    FOREIGN KEY (sender) REFERENCES user (id),
    FOREIGN KEY (receiver) REFERENCES user (id)
);
DELETE FROM sqlite_sequence;
INSERT INTO sqlite_sequence VALUES('user',21);
COMMIT;
