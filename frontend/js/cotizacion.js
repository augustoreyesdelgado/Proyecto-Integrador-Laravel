document.addEventListener('DOMContentLoaded', () => {

    // Obtener auto_id desde la URL
    const params = new URLSearchParams(window.location.search);
    const autoId = params.get('auto_id');

    if (!autoId) {
        alert('No se recibió el ID del auto.');
        return;
    }

    const autoInfo = document.getElementById('auto-info');
    const formCotizacion = document.getElementById('form-cotizacion');
    const resultado = document.getElementById('resultado');

    let precioAuto = 0;

    // Cargar información del auto
    fetch(`http://localhost:8000/api/autos/${autoId}`)
        .then(res => res.json())
        .then(data => {
            const auto = data.Auto;

            precioAuto = parseFloat(auto.precio);

            autoInfo.innerHTML = `
                <img src="assets/${auto.id}.jpg"
                    class="auto-img"
                    onerror="this.src='assets/default.jpg'">

                <h4 class="fw-bold">${auto.marca} ${auto.modelo}</h4>
                <p><strong>Año:</strong> ${auto.anio}</p>
                <p><strong>Color:</strong> ${auto.color}</p>
                <p><strong>Precio:</strong> $${precioAuto.toLocaleString()}</p>
            `;
        })
        .catch(() => {
            autoInfo.innerHTML = '<p>Error al cargar la información del auto.</p>';
        });


    // Enviar cotización
    formCotizacion.addEventListener('submit', (e) => {
        e.preventDefault();

        const porcentaje = parseFloat(formCotizacion.pago_inicial_pct.value);
        const meses = parseInt(formCotizacion.meses.value);
        const edad = parseInt(formCotizacion.edad.value);

        if (!precioAuto || isNaN(porcentaje)) {
            alert('Información incompleta para cotizar.');
            return;
        }

        const pagoInicial = precioAuto * porcentaje;

        const payload = {
            auto_id: autoId,
            precio: precioAuto,
            pago_inicial: pagoInicial,
            meses: meses,
            edad: edad
        };

        fetch('http://localhost:8000/api/autos/cotizacion', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            resultado.classList.remove('d-none');
            resultado.innerHTML = `
                <p>Pago inicial (${porcentaje * 100}%): 
                    <strong>$${pagoInicial.toLocaleString()}</strong>
                </p>
                <p>Pago mensual estimado:</p>
                <span class="fs-4">$${data.pago_mensual}</span>
            `;
        });
    });

});
