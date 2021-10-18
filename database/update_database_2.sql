USE crud_carro;

-- TODO: colocar if para so criar caso nao exista
ALTER TABLE carro ADD caminho_imagem VARCHAR(255) DEFAULT NULL AFTER placa;