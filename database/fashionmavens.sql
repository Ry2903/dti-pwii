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
    imagem varchar(255),
    data_postagem TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user) REFERENCES cadastro(user)
);

INSERT INTO cadastro (user, nome, nasc, email, senha) VALUES
("@snoopy" , "Snoopy" , 2005-03-05 , "snoopy@gmail.com" , "snoopy1234"),
("@ashleyyy" , "Ashley" , 2008-04-03 , "ashley@gmail.com" , "ashley1234"),
("@titrifude" , "Titrifude" , 2007-04-12 , "titrifude@gmail.com" , "titrifude1234"),
("@dinoslove" , "DinosLove" , 2004-06-13 , "dinoslove@gmail.com" , "dinoslove1234"),
("@martinabox" , "Martinabox" , 2007-10-19, "martinabox@gmail.com" , "marinabox1234"),
("@catwalk" , "CatWalk" , 2001-09-28 , "catwalk@gmail.com" , "catwalk1234"),
("@_riikan_" , "Rikan" , 2008-05-15 , "rikan@gmail.com" , "riikan1234"),
("@theking" , "TheKing" , 2008-03-28 , "theking@gmail.com" , "theking1234"),
("@grusensual" , "GruSensual" , 2003-10-09 , "grusensual@gmail.com" , "grusensual1234"),
("@_memim" , "MeMim" , 2007-03-18 , "memim@gmail.com" , "memim1234"),
("@flawiiis", "Flawis" , 2007-01-19 , "flawis@gmail.com" , "flawis1234"),
("@pinguuu_" , "Pingu" , 2002-12-21 , "pingu@gmail.com" , "pingu1234");

INSERT INTO userpage (user, bio, banner, pfp) VALUES
('@snoopy', ' ', '', 'uploads/@snoopy_pfp_icon1.jpg'),
('@ashleyyy', ' ', '', 'uploads/@ashleyyy_pfp_icon2.jpg'),
('@titrifude', ' ', '', 'uploads/@titrifude_pfp_icon3.jpg'),
('@dinoslove', ' ', '', 'uploads/@dinoslove_pfp_icon4.jpg'),
('@martinabox', ' ', '', 'uploads/@martinabox_pfp_icon5.jpg'),
('@catwalk', ' ', '', 'uploads/@catwalk_pfp_icon6.jpg'),
('@_riikan_', ' ', '', 'uploads/@_riikan__pfp_icon7.jpg'),
('@theking', ' ', '', 'uploads/@theking_pfp_icon8.jpg'),
('@grusensual', ' ', '', 'uploads/@grusensual_pfp_icon9.jpg'),
('@_memim', ' ', '', 'uploads/@_memim_pfp_icon10.jpg'),
('@flawiiis', 'she/her just living :)', 'uploads/@flawiiis_banner_header1.jpg', 'uploads/@flawiiis_pfp_icon11.jpg'),
('@pinguuu_', 'he/his :/ dressing to impress', 'uploads/@pinguuu__banner_icon12.jpg', 'uploads/@pinguuu__pfp_header2.jpg');

INSERT INTO posts (codpost, user, conteudo, imagem, data_postagem) VALUES
(1, '@snoopy', 'E eu que arrasei no look, pena que errei o tema #trevas', 'uploads/@snoopy_post_post1.jpeg', '2024-11-27 13:23:38'),
(2, 'ashleyyy', 'Uma foto diz mais que mil palavras.', 'uploads/ashleyyy_post_post2.jpeg', '2024-11-27 13:24:12'),
(3, 'titrifude', 'GENTE E A LORE DA LANA?? NÃƒO TO CONSEGUINDO PASSAR NENHUMA FASE AMO ðŸ˜ðŸ˜ðŸ˜ðŸ˜ðŸ˜ðŸ˜', NULL, '2024-11-27 13:25:28'),
(4, 'dinoslove', 'Eu e os de verdade quando o tema Ã© folclore', NULL, '2024-11-27 13:25:48'),
(5, 'dinoslove', 'Eu e os de verdade quando o tema Ã© folclore', 'uploads/dinoslove_post_post3.jpeg', '2024-11-27 13:26:04'),
(6, 'martinabox', 'Fizemos a Evelyn Hugo e a Celia St e perdemos, achei bem homofobico #atequandoopreconceito', 'uploads/martinabox_post_post4.jpeg', '2024-11-27 13:26:25'),
(7, 'catwalk', 'AlguÃ©m tem os cÃ³digos novos? ðŸ¤‘ðŸ¤‘ðŸ¤‘', NULL, '2024-11-27 13:26:50'),
(8, '_riikan_', 'GENTE???', 'uploads/_riikan__post_post5.jpeg', '2024-11-27 13:27:07'),
(9, 'theking', 'Nem lembro qual era o tema, sÃ³ sei que eu perdi\r\n', 'uploads/theking_post_post6.jpeg', '2024-11-27 13:27:32'),
(10, 'grusensual', 'Eu quando arraso (nÃ£o pegamos 1 lugar odeio todos)', 'uploads/grusensual_post_post7.jpeg', '2024-11-27 13:28:11'),
(11, '_memim', 'ODEIO ESSE POVO DESEMPREGADO QUE PROMETE VIP E DPS SAI NO SERVER, DESEJO SÃ“ REGRESSO PARA VCS!', NULL, '2024-11-27 13:28:34'),
(12, 'flawiiis', 'Simplesmente arrasei no look mas tive que sair antes da votaÃ§Ã£o #quemundoeessetaocruelqueagentevive', 'uploads/flawiiis_post_post8.jpeg', '2024-11-27 13:29:11'),
(13, 'flawiiis', 'Eu quando Sabrina Carpenter:\r\n', 'uploads/flawiiis_post_post9.jpeg', '2024-11-27 13:29:30'),
(14, 'flawiiis', 'Estou trocando pack do pÃ© por vip', NULL, '2024-11-27 13:29:42'),
(15, 'flawiiis', 'Achei soft\r\n', 'uploads/flawiiis_post_post10.jpeg', '2024-11-27 13:29:58'),
(16, 'flawiiis', 'Ainda tÃ´ em choque que perguntaram se o tema era chÃ¡ revelaÃ§Ã£o', 'uploads/flawiiis_post_post11.jpg', '2024-11-27 13:30:10'),
(17, 'pinguuu_ ', 'Eu quando tem parada gay:', 'uploads/pinguuu_ _post_post12.jpeg', '2024-11-27 13:30:28'),
(18, 'pinguuu_ ', 'Mas rapaz...', 'uploads/pinguuu_ _post_post13.jpeg', '2024-11-27 13:30:50'),
(19, 'pinguuu_ ', 'EU PASSEI, EU PASSEI OS NÃVEIS DA LANAAAAAAAAAAAA, NADA ME ABALAAAAAAAAAAAAAAAAA.', NULL, '2024-11-27 13:31:05'),
(20, 'pinguuu_ ', 'Nunca fiz tanta sobreposiÃ§Ã£o em um vestido, pelo menos o resultado ficou bom\r\n', 'uploads/pinguuu_ _post_post14.jpeg', '2024-11-27 13:31:16'),
(21, 'pinguuu_ ', 'Eu e as bests bem meninas do campo', 'uploads/pinguuu_ _post_post15.jpeg', '2024-11-27 13:31:28');