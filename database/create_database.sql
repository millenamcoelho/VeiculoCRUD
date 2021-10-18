DROP DATABASE IF EXISTS crud_carro;

CREATE DATABASE crud_carro CHARSET=UTF8;

USE crud_carro;

-- tabela carro
CREATE TABLE carro (
  id                        bigint NOT NULL AUTO_INCREMENT,
  nome                      varchar(45) NOT NULL,
  marca                     varchar(45) NOT NULL,
  ano                       integer(4) NOT NULL,
  cor   					varchar(45),
  placa              		varchar(8) NOT NULL,
  caminho_imagem 			varchar(255) DEFAULT NULL,

  constraint pk_carro primary key (id),
  constraint u_placa unique (placa)

) DEFAULT CHARSET=UTF8;

INSERT INTO carro VALUES (1, 'Palio', 'Fiat', 2008, 'Prata', 'MUN5736', NULL);