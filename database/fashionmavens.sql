DROP DATABASE IF EXISTS fashionmavens;
CREATE DATABASE fashionmavens;
USE fashionmavens;

CREATE TABLE cadastro (
    user varchar(50) PRIMARY KEY,
    nome varchar(100) NOT NULL,
    nasc date NOT NULL,
    email varchar(100) UNIQUE NOT NULL,
    senha varchar(100) NOT NULL
);

CREATE TABLE userpage (
    user varchar(50),
    bio text,
    banner varchar(255),
    pfp varchar(255),
    FOREIGN KEY (user) REFERENCES cadastro(user)
);

CREATE TABLE posts (
    codpost int NOT NULL auto_increment PRIMARY KEY,
    user varchar(50),
    conteudo varchar(260) NOT NULL,
    data_postagem TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user) REFERENCES cadastro(user)
);