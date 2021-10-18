USE crud_carro;

DROP TABLE IF EXISTS cliente;

CREATE TABLE cliente (
  id                        bigint not null auto_increment,
  nome                      varchar(45) not null,
  email                     varchar(255) not null,
  telefone					bigint(14) not null,

  CONSTRAINT pk_cliente PRIMARY KEY (id)

) DEFAULT CHARSET=UTF8;

INSERT INTO cliente VALUES (1, 'Cliente 1', 'cliente1@ifpr.edu.br', 01545999999999);

-- adicionar coluna id_cliente que ira servir como chave estrangeira
ALTER TABLE carro ADD id_cliente bigint NOT NULL AFTER id;

-- carros ja existentes terao como cliente o de id 1
UPDATE carro SET id_cliente = 1;

-- adicionar chave estrangeira id_cliente a carro 
-- chave estrangeira tem de ser criada apos setar o cliente no carro, pois a apos criar a chave nao eh permitido
ALTER TABLE carro ADD CONSTRAINT fk_cliente 
FOREIGN KEY (id_cliente) REFERENCES cliente (id)
ON DELETE CASCADE ON UPDATE CASCADE;