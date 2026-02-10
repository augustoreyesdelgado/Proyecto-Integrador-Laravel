document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('form-auto');
    const mensaje = document.getElementById('mensaje');

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const payload = {
            marca: form.marca.value,
            modelo: form.modelo.value,
            anio: form.anio.value,
            color: form.color.value,
            cilindrada: form.cilindrada.value,
            precio: form.precio.value
        };

        fetch(`http://localhost:8000/api/autos/${new URLSearchParams(window.location.search).get('id')}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            mensaje.classList.remove('d-none', 'alert-danger');
            mensaje.classList.add('alert-success');
            mensaje.textContent = 'Auto registrado correctamente';

            form.reset();
        })
        .catch(() => {
            mensaje.classList.remove('d-none', 'alert-success');
            mensaje.classList.add('alert-danger');
            mensaje.textContent = 'Error al registrar el auto';
        });
    });

});
