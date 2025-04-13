<?php include_once "../layout/header.php"; ?>
<h1 class="mb-4">Gestión de Categorías</h1>

<!-- Botón para abrir modal y crear nueva categoría -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#categoriaModal" onclick="openCategoriaModal()">Nueva Categoría</button>

<!-- Tabla de Categorías -->
<div class="table-responsive">
  <table class="table table-bordered" id="categoriaTable">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Categoría</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<!-- Modal para crear/editar categoría -->
<div class="modal fade" id="categoriaModal" tabindex="-1" aria-labelledby="categoriaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="categoriaForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="categoriaModalLabel">Nueva Categoría</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id_categoria" name="id_categoria" value="">
          <div class="mb-3">
            <label for="categoria" class="form-label">Nombre de la Categoría</label>
            <input type="text" class="form-control" id="categoria" name="categoria" required>
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
  // Cargar categorías vía AJAX
  function loadCategorias(){
    $.ajax({
      url: "../../../app/controllers/categoriaController.php",
      type: 'GET',
      dataType: 'json',
      success: function(data){
        let html = "";
        $.each(data, function(i, item){
          html += `<tr>
                      <td>${item.id_categoria}</td>
                      <td>${item.categoria}</td>
                      <td>
                        <button class="btn btn-warning btn-sm me-2" onclick="editCategoria(${item.id_categoria}, '${item.categoria}')">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteCategoria(${item.id_categoria})">Eliminar</button>
                      </td>
                   </tr>`;
        });
        $("#categoriaTable tbody").html(html);
      },
      error: function(xhr, status, error){
        console.error("Error:", xhr.responseText);
        alert("Error al cargar categorías.");
      }
    });
  }

  // Abre modal para nueva categoría
  function openCategoriaModal(){
    $("#id_categoria").val('');
    $("#categoria").val('');
    $("#categoriaModalLabel").text("Nueva Categoría");
  }

  // Abre modal para editar
  function editCategoria(id, nombre){
    $("#id_categoria").val(id);
    $("#categoria").val(nombre);
    $("#categoriaModalLabel").text("Editar Categoría");
    let modal = new bootstrap.Modal(document.getElementById('categoriaModal'));
    modal.show();
  }

  // Envío del formulario (crear/editar)
  $("#categoriaForm").submit(function(e){
    e.preventDefault();
    let id = $("#id_categoria").val();
    let categoria = $("#categoria").val();
    let data = { categoria: categoria };
    if(id) {
      data.id_categoria = id;
    }
    $.ajax({
      url: "../../../app/controllers/categoriaController.php",
      type: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(data),
      success: function(response){
        // Cerrar modal y recargar tabla
        let modal = bootstrap.Modal.getInstance(document.getElementById('categoriaModal'));
        modal.hide();
        loadCategorias();
      },
      error: function(xhr, status, error){
        console.error("Error:", xhr.responseText);
        alert("Error al guardar categoría.");
      }
    });
  });

  // Función para eliminar categoría
  function deleteCategoria(id){
    if(confirm("¿Está seguro de eliminar esta categoría?")){
      $.ajax({
        url: "../../../app/controllers/categoriaController.php?id=" + id,
        type: 'DELETE',
        success: function(response){
          loadCategorias();
        },
        error: function(xhr, status, error){
          console.error("Error:", xhr.responseText);
          alert("Error al eliminar categoría.");
        }
      });
    }
  }

  $(document).ready(function(){
    loadCategorias();
  });
</script>
<?php include_once "../layout/footer.php"; ?>

