USE crud_carro;

ALTER TABLE pessoa ADD data_nascimento DATE DEFAULT NULL AFTER email;
UPDATE pessoa SET data_nascimento = '1970-01-01';