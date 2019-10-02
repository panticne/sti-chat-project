CREATE TABLE 'user'
(
    'id'        INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    'firstname' TEXT                              NOT NULL,
    'lastname'  TEXT                              NOT NULL,
    'password'  TEXT                              NOT NULL,
    'admin'     BOOLEAN                           NOT NULL DEFAULT FALSE,
    'active'    BOOLEAN                           NOT NULL DEFAULT FALSE
);

CREATE TABLE 'message'
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

INSERT INTO "user" ("id", "firstname", "lastname", "password", "admin", "active")
VALUES (NULL, 'Jean', 'Dupond', '1234', 'TRUE', 'TRUE');

INSERT INTO "user" ("id", "firstname", "lastname", "password", "active")
VALUES (NULL, 'Jeanne', 'Dutroux', 'jeanne', 'TRUE');
