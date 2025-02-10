atenção

deve atualizar o campo senha da tabela de utilizadores

update clientes.utilizadores set senha = SHA2(senha, 256)


para o requisito de privilegio minimo:
==========================================================================
CREATE USER 'transfer_user'@'localhost' IDENTIFIED BY 'senha_segura';
GRANT INSERT ON clientes.transferencias TO 'transfer_user'@'localhost';
FLUSH PRIVILEGES;
==========================================================================

Os utilizadores que estao na base de dados:

ccosta@gmail.com / elefante

msilva@yahoo.com / tigre
