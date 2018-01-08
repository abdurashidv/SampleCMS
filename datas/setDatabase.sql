--CREATE TABLES
CREATE TABLE users(
   id SERIAL PRIMARY KEY,
   firstname VARCHAR NOT NULL,
   lastname VARCHAR NOT NULL,
   displayname VARCHAR NOT NULL,
   login VARCHAR NOT NULL,
   password VARCHAR NOT NULL
);

CREATE TABLE catalogs(
   id SERIAL PRIMARY KEY,
   name VARCHAR NOT NULL,
   recipe VARCHAR NOT NULL,
   userid int NOT NULL
);