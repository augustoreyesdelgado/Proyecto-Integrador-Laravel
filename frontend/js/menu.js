// Consulta a la API para obtener los autos y mostrarlos en la página

fetch('http://localhost:8000/api/autos')
    .then(response => response.json())
    .then(data => {
        const contenedor = document.getElementById('contenedor-autos');
        contenedor.innerHTML = '';

        if (!data.Autos || data.Autos.length === 0) {
            contenedor.innerHTML = '<p>No hay autos disponibles.</p>';
            return;
        }

        data.Autos.forEach(auto => {
            const card = document.createElement('div');
            card.classList.add('auto-card');

            card.innerHTML = `
                <div class="row g-3 align-items-center">
                    
                    <!-- Columna imagen -->
                    <div class="col-md-4">
                        <img 
                            src="assets/${auto.id}.jpg" 
                            alt="Auto ${auto.modelo}"
                            class="auto-img"
                        >
                    </div>

                    <!-- Columna datos -->
                    <div class="col-md-8 auto-info">
                        <h5 class="auto-title fw-bold">${auto.marca} ${auto.modelo}</h5>

                        <p><strong>Color:</strong> ${auto.color}</p>
                        <p><strong>Año:</strong> ${auto.anio}</p>
                        <p><strong>Cilindrada:</strong> ${auto.cilindrada ?? 'N/A'}</p>
                        <p><strong>Precio:</strong> $${auto.precio}</p>

                        <a 
                            href="realizar_cotizacion.html?auto_id=${auto.id}" 
                            class="btn btn-dark btn-sm"
                        >
                            Realizar cotización
                        </a>
                    </div>

                </div>
            `;

            contenedor.appendChild(card);
        });
    })
    .catch(error => {
        console.error(error);
        document.getElementById('contenedor-autos').innerHTML =
            '<p>Error al cargar los autos.</p>';
    });