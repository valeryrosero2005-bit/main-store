-- CREATE USERS TABLE 
CREATE TABLE users (
    id            BIGSERIAL     PRIMARY KEY,
    firstname     VARCHAR(100)  NOT NULL,
    lastname      VARCHAR(100)  NOT NULL,
    ident_number  VARCHAR(20)   NOT NULL UNIQUE,
    mobile_phone  VARCHAR(20),
    email         VARCHAR(150)  NOT NULL UNIQUE,
    password      VARCHAR(255)  NOT NULL,
    url_photo     TEXT,
    birth_date    DATE,
    status        BOOLEAN       NOT NULL DEFAULT TRUE,
    created_at    TIMESTAMPTZ   NOT NULL DEFAULT NOW(),
    updated_at    TIMESTAMPTZ   NOT NULL DEFAULT NOW(),
    deleted_at    TIMESTAMPTZ
);
-- SELECT ALL USERS FROM USERS TABLE 
SELECT * FROM users;
-- INSERT A NEW USER INTO USERS TABLE 
INSERT INTO users (firstname, lastname, ident_number, email, password) VALUES (‘Joan’, ’Ayala’, ‘56890988’, ‘joan@mail.com’, ‘123456’) ;
--update field url_foto
update users SET url_photo = 'photos/photo_default.png';
update users set  url_photo = 'photos/photo_default.png' WHERE ID =12;