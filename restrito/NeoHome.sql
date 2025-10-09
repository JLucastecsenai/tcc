CREATE DATABASE NeoHome;
USE NeoHome;

CREATE TABLE mensagem (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(128) NOT NULL,
email VARCHAR(128) NOT NULL,
telefone VARCHAR(11) NOT NULL,
msg VARCHAR(10000) NOT NULL,
data_msg TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cliente (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(128) NOT NULL,
email VARCHAR(128) NOT NULL,
telefone VARCHAR(16) NOT NULL,
cpf VARCHAR(11) NOT NULL,
cep VARCHAR(8) NOT NULL,
numero_casa INT(5),
complemento VARCHAR(30)
);
CREATE TABLE funcionarios (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(128) NOT NULL,
email VARCHAR(128) NOT NULL,
telefone VARCHAR(11) NOT NULL,
cpf VARCHAR(11) NOT NULL,
cargo INT NOT NULL,
FOREIGN KEY (cargo) REFERENCES cargos(id)
);

CREATE TABLE cargos (
id INT AUTO_INCREMENT PRIMARY KEY,
funcao VARCHAR(128),
salario DECIMAL(10, 2)
);
CREATE TABLE demandas (
id INT AUTO_INCREMENT PRIMARY KEY,
cliente INT NOT NULL,
demanda VARCHAR(500) NOT NULL,
data_demanda DATE NOT NULL 
);
CREATE TABLE funcionario_demanda(
id INT AUTO_INCREMENT PRIMARY KEY,
id_funcionarios INT NOT NULL,
id_demanda INT NOT NULL,
FOREIGN KEY (id_funcionarios) REFERENCES funcionarios(id),
FOREIGN KEY (id_demanda) REFERENCES demandas(id)
);

CREATE TABLE admin_login (
id INT AUTO_INCREMENT PRIMARY KEY,
login VARCHAR(128),
senha_admin VARCHAR(128),
funcionario_admin INT
);


INSERT INTO admin_login(login, senha_admin, funcionario_admin) 
VALUES ('admin@123', sha2('admin123',256), 1);
INSERT INTO funcionarios(nome, email, telefone, cpf, cargo) VALUES
('Samuel','samuel@gmail.com','111111111','111111111', 2 ),
('Daniel','daniel@gmail.com','222222222','222222222', 1 ),
('Renata','renata@gmail.com','333333333','333333333', 3);

INSERT INTO cargos (funcao, salario) VALUES
('Tecnico', 4300.00),
('Gerente', 5000.00),
('Atendente', 2150.00),
('RH', 3390.00),
('Gerente de RH', 4500.00);

SELECT * FROM admin_login;
SELECT * FROM mensagem;
SELECT * FROM cargos; 
SELECT * FROM funcionarios;
SELECT 
funcionarios.id,
funcionarios.nome,
funcionarios.email,
funcionarios.telefone,
funcionarios.cpf,
cargos.funcao AS cargo,
cargos.salario
FROM funcionarios
INNER JOIN cargos ON funcionarios.cargo = cargos.id;