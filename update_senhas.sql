USE clientes;

UPDATE utilizadores
SET senha = SHA2(senha, 256)
WHERE CHAR_LENGTH(senha) <> 64;
