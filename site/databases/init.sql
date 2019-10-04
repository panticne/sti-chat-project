CREATE TABLE 'user'
(
    'id'        INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    'firstname' TEXT                              NOT NULL,
    'lastname'  TEXT                              NOT NULL,
    'username'  TEXT                              NOT NULL unique,
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

INSERT INTO "user" ("id", "firstname", "lastname", "username", "password", "admin", "active")
VALUES (NULL, 'Jean', 'Dupond', 'jdupond', '1234', 'TRUE', 'TRUE');

INSERT INTO "user" ("id", "firstname", "lastname", "username", "password", "active")
VALUES (NULL, 'Jeanne', 'Dutroux', 'jdutroux', 'jeanne', 'TRUE');

INSERT INTO "message" ("id", "date", "sender", "receiver", "subject", "content")
VALUES (NULL, '01-01-2000', '2', '1', 'Salut', 'Comment ça va ?')