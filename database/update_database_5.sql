USE crud_carro;

-- ALTER TABLE usuario DROP COLUMN tipo;
ALTER TABLE usuario ADD tipo CHAR(3) DEFAULT 'F' NOT NULL AFTER id_pessoa;
UPDATE usuario SET tipo = 'ADM' WHERE id = 1;
INSERT INTO pessoa VALUES (4, 'Funcionario 1', 'func@ifpr.edu.br', '1970-01-01');
INSERT INTO usuario VALUES (2, 4, 'F', 'MTIzNDU='); -- senha codificada em base64: 12345
