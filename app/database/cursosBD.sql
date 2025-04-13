create database curso;
use curso;

create table categoria(
id_categoria int  auto_increment primary key not null,
categoria varchar(200) not null,
constraint categoria_uk unique(categoria)
);

create table cursos(
id_cursos int primary key auto_increment not null,
titulo varchar(400) not null,
duracion_horas varchar(50) not null,
nivel varchar(100) not null,
precio decimal(5,2),
fecha_inicio date,
id_categoria int,
constraint categoria_fk foreign key(id_categoria) references categoria(id_categoria)
);

-- TABLA CATEGORIA CRUD
delimiter //
create procedure insertar_categoria(
in _categoria varchar(800)
)
begin
insert into categoria(categoria) values(_categoria);
end //
delimiter ;

delimiter //
create procedure actualizar_categoria(
in _id_categoria int,
in _categoria varchar(800)
)
begin
update categoria
set categoria=_categoria
where id_categoria=_id_categoria;
end //
delimiter ;

delimiter //
create procedure eliminar_categoria(
in _id_categoria int
)
begin
delete from categoria where id_categoria=_id_categoria;
end //
delimiter ;

-- TABLA CURSOS

delimiter //
create procedure insertar_cursos(
in _titulo varchar(400),
in _duracion_horas varchar(50),
in _nivel varchar(100),
in _precio decimal(5,2),
in _fecha_inicio date,
in _id_categoria int
)
begin
insert into cursos(titulo,duracion_horas,nivel,precio,fecha_inicio,id_categoria) values
(_titulo,_duracion_horas,_nivel,_precio,_fecha_inicio,_id_categoria);
end //
delimiter ;

delimiter //
create procedure buscar_curso(
in _categoria varchar(200)
)
begin
select titulo,duracion_horas,nivel,precio,fecha_inicio,categoria from categoria inner join cursos
on categoria=_categoria;
end //
delimiter ;

delimiter //
create procedure actualizar_curso(
in _id_cursos int,
in _titulo varchar(400),
in _duracion_horas varchar(50),
in _nivel varchar(100),
in _precio decimal(5,2),
in _fecha_inicio date,
in _id_categoria int
)
begin
update cursos
set titulo=_titulo,
duracion_horas=_duracion_horas,
nivel=_nivel,
precio=_precio,
fecha_inicio=_fecha_inicio,
id_categoria=_id_categoria
where id_cursos=_id_cursos;
end //
delimiter ;

delimiter //
create procedure eliminar_curso(
in _id_cursos int
)
begin
delete from cursos where id_cursos=_id_cursos;
end //
delimiter ;
