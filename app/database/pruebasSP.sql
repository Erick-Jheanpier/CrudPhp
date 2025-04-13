use curso;

-- llamada a los procedimientos almacenados

-- TABLA CATEGORIA
call insertar_categoria("matematicas");
call actualizar_categoria(1,"quimica");
call eliminar_categoria(1);
select * from categoria;

-- TABLA CURSOS
call insertar_cursos("fracciones","4H","basico",90,"2025-04-12",1);
call buscar_curso("matematicas");
call actualizar_curso(1,"ecuaciones lineales","2H 30m","basico",90,"2025-04-12",1);
call eliminar_curso(1);

select * from cursos;