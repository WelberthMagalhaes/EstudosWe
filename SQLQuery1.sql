create database EstudosWE;
GO

use EstudosWE;

GO


CREATE TABLE usuario(
	CODUSER  CHAR(3)     NOT NULL PRIMARY KEY,
	NOME     CHAR(50)    NOT NULL,
	IDADE    INT         NOT NULL,
	ENDERECO VARCHAR(20) NOT NULL

);

--select * from usuario;

INSERT INTO usuario VALUES(1,'Ubiratan',38,'Rua dois');
INSERT INTO usuario VALUES(2,'Jeiciary',38,'Rua 45');

--DROP TABLE usuario;
