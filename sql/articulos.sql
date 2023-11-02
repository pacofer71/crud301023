create table articulos(
    id int auto_increment primary key,
    nombre varchar(80) unique not null,
    descripcion varchar(200) not null,
    precio numeric(6,2) not null,
    stock int unsigned not null default 0,
    imagen varchar(100)
);