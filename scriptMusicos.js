document.addEventListener('DOMContentLoaded', function() {
    const editFormContainer = document.getElementById('editFormContainer');
    const editForm = document.getElementById('editForm');
    const editId = document.getElementById('editId');
    const editNombre = document.getElementById('editNombre');
    const editInstrumento = document.getElementById('editInstrumento');

    document.querySelectorAll('.editBtn').forEach(button => {
        button.addEventListener('click', function() {
            editId.value = this.dataset.id;
            editNombre.value = this.dataset.nombre;
            editInstrumento.value = this.dataset.instrumento;
            editFormContainer.style.display = 'block';
        });
    });

    editForm.addEventListener('submit', function(e) {
        if (!confirm('¿Está seguro de que desea actualizar este músico?')) {
            e.preventDefault();
        }
    });

    document.querySelectorAll('.deleteForm').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('¿Está seguro de que desea eliminar este músico?')) {
                e.preventDefault();
            }
        });
    });
});
