CREATE DATABASE IF NOT EXISTS db_sistemagestionPIE;
USE db_sistemagestionPIE;

CREATE TABLE users(
id                  int(255) auto_increment NOT NULL,
name                varchar(50) NOT NULL,
surname             varchar(100),
email               varchar(255) NOT NULL,
password            varchar(255) NOT NULL,
image               varchar(255),
profesion           varchar(255),
role_user           varchar(50) NOT NULL,
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
remember_token      varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE estudiantes(
id                  int(255) auto_increment NOT NULL,
rut                 varchar(255) NOT NULL,
nombre              varchar(255),
apellido            varchar(255),
fecha_nacimiento    date,
direccion           varchar(255),
curso               varchar(255),
personas_vive       varchar(255),
imagen_perfil       varchar(255),
imagen_genograma    varchar(255),
estado              int(255),          
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_estudiantes PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE diagnosticos(
id                  int(255) auto_increment NOT NULL,
fecha_autorizacion  date,
fecha_evaluacion    date,
fecha_reevaluacion  date,
nee_postulada       varchar(255),
tipo_nee            varchar(255),
derivacion          varchar(255),
observacion         varchar(255),
user_id             int(255),
estudiante_id       int(255),
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_diagnosticos PRIMARY KEY(id),
CONSTRAINT fk_diagnostico_user FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_diagnostico_estudiante FOREIGN KEY(estudiante_id) REFERENCES estudiantes(id)
)ENGINE=InnoDb;

CREATE TABLE entrevistas(
id                  int(255) auto_increment NOT NULL,
fecha               date,
observacion         varchar(255),
user_id             int(255) NOT NULL,
estudiante_id       int(255) NOT NULL,
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_entrevistas PRIMARY KEY(id),
CONSTRAINT fk_entrevista_user FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_entrevista_estudiante FOREIGN KEY(estudiante_id) REFERENCES estudiantes(id)
)ENGINE=InnoDb;



CREATE TABLE apoderados(
id                  int(255) auto_increment NOT NULL,
nombre              int(255),
apellido            int(255),
telefono            varchar(255),
email               varchar(255),
parentesco          varchar(255),
actividad           varchar(255),
direccion           varchar(255),
nivel_educacional   varchar(255),
tipo                varchar(255),
estado              int(255),         
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_apoderados PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE estudiantes_apoderados(
id                  int(255) auto_increment NOT NULL,
estudiante_id       int(255) NOT NULL,
apoderado_id        int(255) NOT NULL,
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_estudiantes_apoderados PRIMARY KEY(id),
CONSTRAINT fk_estudianteapoderado_estudiante FOREIGN KEY(estudiante_id) REFERENCES estudiantes(id),
CONSTRAINT fk_estudianteapoderado_apoderado  FOREIGN KEY(apoderado_id)  REFERENCES apoderados(id)
)ENGINE=InnoDb;



CREATE TABLE fichas_salud(
id                  int(255) auto_increment NOT NULL,
nombre_sistema      varchar(255),
medicamentos        varchar(255),  
observacion         varchar(255),    
estudiante_id       int(255),   
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_fichas_salud PRIMARY KEY(id),
CONSTRAINT fk_fichasalud_estudiante FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id)
)ENGINE=InnoDb;

CREATE TABLE documentos(
id                  int(255) auto_increment NOT NULL,
certificado_nac     int(50),         
autorizacion_padres int(50),
derivacion          int(50),        
anamnesis           int(50),
pruebas             int(50),        
protocolos          int(50),
formualrio_ingreso  int(50),         
valoracion_salud    int(50),
fonoaudiologico     int(50),         
psicopedagogico     int(50),
psicologico         int(50),         
neurologico         int(50),
estudiante_id       int(255),
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_documentos PRIMARY KEY(id),
CONSTRAINT fk_documento_estudiante FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id)

)ENGINE=InnoDb;

CREATE TABLE historiales_academicos(
id                  int(255) auto_increment NOT NULL,
ingreso_cpc         date,         
ingreso_pie         date,
colegio_anterior    varchar(255),
curso_repetido      varchar(255),
activid_extraprogra varchar(255),
estudiante_id       int(255),
created_at          datetime DEFAULT NULL,
updated_at          datetime DEFAULT NULL,
CONSTRAINT pk_historiales_academicos PRIMARY KEY(id),
CONSTRAINT fk_historialacademico_estudiante FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id)
)ENGINE=InnoDb;

