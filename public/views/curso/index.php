<?php include_once "../layout/header.php"; ?>
<h1 class="mb-4">Gestión de Cursos</h1>

<!-- Botón para abrir el modal y crear un nuevo curso -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#cursoModal" onclick="openCursoModal()">Nuevo Curso</button>

<!-- Tabla de cursos -->
<div class="table-responsive">
  <table class="table table-bordered" id="cursoTable">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Duración (horas)</th>
        <th>Nivel</th>
        <th>Precio</th>
        <th>Fecha de Inicio</th>
        <th>Categoría</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <!-- Se cargan los datos dinámicamente -->
    </tbody>
  </table>
</div>

<!-- Modal para crear o editar un curso -->
<div class="modal fade" id="cursoModal" tabindex="-1" aria-labelledby="cursoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="cursoForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cursoModalLabel">Nuevo Curso</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id_cursos" name="id_cursos" value="">
          <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
          </div>
          <div class="mb-3">
            <label for="duracion_horas" class="form-label">Duración (horas)</label>
            <input type="number" class="form-control" id="duracion_horas" name="duracion_horas" required>
          </div>
          <div class="mb-3">
            <label for="nivel" class="form-label">Nivel</label>
            <select class="form-select" id="nivel" name="nivel" required>
              <option value="">Seleccione un nivel</option>
              <option value="Básico">Básico</option>
              <option value="Intermedio">Intermedio</option>
              <option value="Avanzado">Avanzado</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
          </div>
          <div class="mb-3">
            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
          </div>
          <div class="mb-3">
            <label for="id_categoria" class="form-label">Categoría</label>
            <select class="form-select" id="id_categoria" name="id_categoria" required>
              <option value="">Seleccione una categoría</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  // Función para cargar los cursos desde el controlador
  function loadCursos(){
    $.ajax({
      url: "../../../app/controllers/CursosController.php",
      type: 'GET',
      dataType: 'json',
      success: function(data){
        console.log("Cursos recibidos:", data);
        let html = "";
        if(Array.isArray(data) && data.length > 0){
          $.each(data, function(i, item){
            html += `<tr>
                        <td>${item.id_cursos}</td>
                        <td>${item.titulo}</td>
                        <td>${item.duracion_horas}</td>
                        <td>${item.nivel}</td>
                        <td>${item.precio}</td>
                        <td>${item.fecha_inicio}</td>
                        <td>${item.categoria}</td>
                        <td>
                          <button class="btn btn-warning btn-sm me-2" onclick="editCurso(${item.id_cursos})">Editar</button>
                          <button class="btn btn-danger btn-sm" onclick="deleteCurso(${item.id_cursos})">Eliminar</button>
                        </td>
                     </tr>`;
          });
        } else {
          html = `<tr><td colspan="8" class="text-center">No hay cursos registrados</td></tr>`;
        }
        $("#cursoTable tbody").html(html);
      },
      error: function(xhr, status, error){
        console.error("Error al cargar cursos:", xhr.responseText);
        alert("Error al cargar cursos. Verifica la consola para más detalles.");
      }
    });
  }

  // Función para cargar el listado de categorías
  function loadCategoriasSelect(selectedId = ""){
    $.ajax({
      url: "../../../app/controllers/CategoriaController.php",
      type: 'GET',
      dataType: 'json',
      success: function(data){
        let options = '<option value="">Seleccione una categoría</option>';
        $.each(data, function(i, item){
          let selected = (selectedId == item.id_categoria) ? 'selected' : '';
          options += `<option value="${item.id_categoria}" ${selected}>${item.categoria}</option>`;
        });
        $("#id_categoria").html(options);
      },
      error: function(xhr, status, error){
        console.error("Error al cargar categorías para select:", xhr.responseText);
      }
    });
  }

  // Abre el modal para crear un nuevo curso
  function openCursoModal(){
    $("#id_cursos").val('');
    $("#titulo").val('');
    $("#duracion_horas").val('');
    $("#nivel").val('');
    $("#precio").val('');
    $("#fecha_inicio").val('');
    loadCategoriasSelect();
    $("#cursoModalLabel").text("Nuevo Curso");
  }

  // Función para editar un curso
  function editCurso(id){
    $.ajax({
      url: "../../../app/controllers/CursosController.php?id=" + id,
      type: 'GET',
      dataType: 'json',
      success: function(data){
        console.log("Curso para editar:", data);
        $("#id_cursos").val(data.id_cursos);
        $("#titulo").val(data.titulo);
        $("#duracion_horas").val(data.duracion_horas);
        $("#nivel").val(data.nivel); // Establecer nivel seleccionado
        $("#precio").val(data.precio);
        $("#fecha_inicio").val(data.fecha_inicio);
        loadCategoriasSelect(data.id_categoria);
        $("#cursoModalLabel").text("Editar Curso");
        let modal = new bootstrap.Modal(document.getElementById('cursoModal'));
        modal.show();
      },
      error: function(xhr, status, error){
        console.error("Error al cargar curso:", xhr.responseText);
        alert("Error al cargar los datos del curso. Verifica la consola.");
      }
    });
  }

  // Envío del formulario
  $("#cursoForm").submit(function(e){
    e.preventDefault();
    let formData = {
      id_cursos: $("#id_cursos").val(),
      titulo: $("#titulo").val(),
      duracion_horas: $("#duracion_horas").val(),
      nivel: $("#nivel").val(),
      precio: $("#precio").val(),
      fecha_inicio: $("#fecha_inicio").val(),
      id_categoria: $("#id_categoria").val()
    };
    console.log("Enviando datos del curso:", formData);
    $.ajax({
      url: "../../../app/controllers/CursosController.php",
      type: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(formData),
      success: function(response){
        console.log("Respuesta al guardar curso:", response);
        let modal = bootstrap.Modal.getInstance(document.getElementById('cursoModal'));
        modal.hide();
        loadCursos();
      },
      error: function(xhr, status, error){
        console.error("Error al guardar curso:", xhr.responseText);
        alert("Error al guardar el curso. Revisa la consola para detalles.");
      }
    });
  });

  // Eliminar curso
  function deleteCurso(id){
    if(confirm("¿Está seguro de eliminar este curso?")){
      $.ajax({
        url: "../../../app/controllers/cursoController.php?id=" + id,
        type: 'DELETE',
        success: function(response){
          console.log("Respuesta al eliminar curso:", response);
          loadCursos();
        },
        error: function(xhr, status, error){
          console.error("Error al eliminar curso:", xhr.responseText);
          alert("Error al eliminar el curso.");
        }
      });
    }
  }

  // Al cargar la página
  $(document).ready(function(){
    loadCursos();
  });
</script>
<?php include_once "../layout/footer.php"; ?>
