USE crud_carro;

DROP TABLE IF EXISTS usuario;

CREATE TABLE IF NOT EXISTS usuario (
  id                        bigint not null auto_increment,
  nome                      varchar(45) not null,
  email                     varchar(255) not null,
  senha   					varchar(45) not null,

  constraint pk_usuario primary key (id),
  constraint u_email unique (email)

) DEFAULT CHARSET=UTF8;

-- senha codificada em base64: admin
INSERT INTO usuario VALUES (1, 'admin', 'admin@ifpr.edu.br', 'YWRtaW4=');

