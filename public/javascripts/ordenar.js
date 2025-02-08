let ordenarActivo = { field: null, asc: true }; 

document.addEventListener("DOMContentLoaded", function () {
    let spanOrdenar = document.getElementById("ordenar_por");

    ordenarActivo = {
        field: spanOrdenar.dataset.field || null,
        asc: spanOrdenar.dataset.direccion === 'ASC'
    };

    actualizarFlechas(ordenarActivo.field, ordenarActivo.asc);
});

const btnsOrdenar = document.querySelectorAll('.sort-option');

btnsOrdenar.forEach((btn) => {
    btn.addEventListener('click', function () {
        let field = this.dataset.field; // Obtener el campo del botón

        // Verifica si el mismo campo ya está ordenado
        if (ordenarActivo.field === field) {
            ordenarActivo.asc = !ordenarActivo.asc; // Alternar entre ASC y DESC
        } else {
            ordenarActivo.field = field;
            ordenarActivo.asc = true; // Siempre inicia como ASC si es un nuevo campo
        }

        const urlParams = new URLSearchParams(window.location.search);
        const paginaActual = urlParams.get('pagina') || 1; // Si no hay página, usa 1
        const limit= urlParams.get('limit') || 10;

        const direccion = ordenarActivo.asc ? 'ASC' : 'DESC';
        const url = `${BASE_URL_ORDENAR}${field}&direccion=${direccion}&pagina=${paginaActual}&limit=${limit}`;
        
        // Actualiza las flechas de ordenación
        actualizarFlechas(ordenarActivo.field, ordenarActivo.asc);

        window.location.href = url;
    });
});

function actualizarFlechas(campo, asc) {
    document.querySelectorAll('.sort-option').forEach(btn => {
        const arrow = btn.nextElementSibling;

        // Remueve la clase 'active' de todos los botones
        btn.classList.remove('active');

        if (arrow) { // Verifica que haya una flecha
            if (btn.dataset.field === campo) {
                btn.classList.add('active'); // Agrega la clase al botón activo
                arrow.style.transform = asc ? "rotate(-45deg)" : "rotate(135deg)";
            }
        }
    });
}
