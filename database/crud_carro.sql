DROP DATABASE IF EXISTS crud_carro;

CREATE DATABASE crud_carro CHARSET=UTF8;

USE crud_carro;

-- tabela pessoa
CREATE TABLE pessoa(
  id                        bigint NOT NULL AUTO_INCREMENT,
  nome                      varchar(45) NOT NULL,
  email                     varchar(255) NOT NULL,
  data_nascimento            DATE DEFAULT NULL,

  CONSTRAINT pk_pessoa PRIMARY KEY (id),
  CONSTRAINT u_email UNIQUE (email)

) DEFAULT CHARSET=UTF8;

INSERT INTO pessoa VALUES (1, 'admin', 'admin@ifpr.edu.br', '1970-01-01'), 
(2, 'Cliente 1', 'cliente1@ifpr.edu.br', '1970-01-01'), 
(3, 'Cliente 2', 'cliente2@ifpr.edu.br', '1970-01-01'),
(4, 'Funcionario 1', 'func@ifpr.edu.br', '1970-01-01');

-- tabela usuario
CREATE TABLE usuario (
  id                        bigint NOT NULL AUTO_INCREMENT,
  id_pessoa                 bigint NOT NULL,
  tipo                      CHAR(3) DEFAULT 'F' NOT NULL,
  senha   					        varchar(45) NOT NULL,

  CONSTRAINT pk_usuario PRIMARY KEY (id),
  CONSTRAINT fk_pessoa_usuario FOREIGN KEY (id_pessoa) REFERENCES pessoa (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT id_pessoa UNIQUE (id_pessoa)

) DEFAULT CHARSET=UTF8;

-- senha codificada em base64: para insert 1: admin | para insert 2: 12345
INSERT INTO usuario VALUES (1, 1, 'ADM', 'YWRtaW4='), (2, 4, 'F', 'MTIzNDU=');

-- tabela cliente
CREATE TABLE cliente (
  id                        bigint NOT NULL AUTO_INCREMENT,
  id_pessoa                 bigint NOT NULL,
  telefone					        bigint(14) NOT NULL,

  CONSTRAINT pk_cliente PRIMARY KEY (id),
  CONSTRAINT fk_pessoa_cliente FOREIGN KEY (id_pessoa) REFERENCES pessoa (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT id_pessoa UNIQUE (id_pessoa)

) DEFAULT CHARSET=UTF8;

INSERT INTO cliente VALUES (1, 2, 01545999999999), (2, 3, 01545777777777);

-- tabela carro
CREATE TABLE carro (
  id                        bigint NOT NULL AUTO_INCREMENT,
  id_cliente 				        bigint NOT NULL,
  nome                      varchar(45) NOT NULL,
  marca                     varchar(45) NOT NULL,
  ano                       integer(4) NOT NULL,
  cor   					          varchar(45),
  placa              		    varchar(8) NOT NULL,
  caminho_imagem 			      varchar(255) DEFAULT NULL,

  CONSTRAINT pk_carro PRIMARY KEY (id),
  CONSTRAINT u_placa UNIQUE (placa),

  -- adicionar chave estrangeira id_cliente a carro 
  CONSTRAINT fk_cliente FOREIGN KEY (id_cliente) REFERENCES cliente (id) ON DELETE CASCADE ON UPDATE CASCADE

) DEFAULT CHARSET=UTF8;

INSERT INTO carro VALUES (1, 1, 'Palio', 'Fiat', 2008, 'Prata', 'MUN5736', NULL);

