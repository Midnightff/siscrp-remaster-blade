<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arte Dental</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/templatemo-medic-care.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></script>


</head>

<body id="top">
    <nav class="set navbar navbar-expand-lg bg-light fixed-top shadow-lg py-1">
        <div class="container">
            <a class="navbar-brand mx-auto d-lg-none" href="/">
                Arte Dental
                <strong class="d-block ">Especialistas dentales</strong>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <a class="navbar-brand p-1 text-black d-none d-lg-block" href="welcome">
                        Arte Dental
                        <strong class="d-block fs-8">Especialistas dentales</strong>
                    </a>

                    <li class="nav-item active">
                        <a class="nav-link" href="{{route('welcome')}}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('publicaciones.cliente') }}">Publicaciones</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tratamientos.cliente') }}">Tratamientos</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('citas.create') }}" onclick="return validarCita()">
                            Agendar cita
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#contacto">Contacto</a>
                    </li>
                </ul>
            </div>

        </div>

        @guest
            @if (Route::has('login'))
                <li class="nav-item list-unstyled">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right fs-3 text-secondary"></i>
                    </a>
                </li>
            @endif
            &nbsp;
            @if (Route::has('register'))
                <li class="nav-item list-unstyled">
                    <a class="nav-link text-secondary" href="{{ route('register') }}">
                        <i class="bi bi-person-plus-fill fs-3 text-secondary"></i>
                    </a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown list-unstyled">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <span><i class="bi bi-person-fill-check fs-2 text-success"></i></span>
                    {{-- {{ Auth::user()->name }} --}}
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('pacientes') }}">
                        {{ __('Pacientes') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </nav>
    <div class="container">
        @yield('content')
    </div>
    <footer class="site-footer section-padding" id="contacto">
        <div class="container">
            <div class="row">

                <div class="col-lg-5 me-auto col-12">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15482.448340532876!2d-88.9383438!3d14.0409934!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f6365863996a197%3A0x5fa4ad2d40c0c20a!2sArte%20Dental!5e0!3m2!1ses!2ssv!4v1699159530721!5m2!1ses!2ssv"
                        width="400" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <div class="col-lg-2 col-md-6 col-12 my-4 my-lg-0">
                    <h5 class="mb-lg-4 mb-3">Información</h5>

                    <p>
                        <a
                            href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=artedental@gmail.com">artedental@gmail.com</a>
                    <p>

                    <p>Calle Poniente, Barrio El Centro, atrás de Banco Cuscatlán, Chalatenango.</p>
                </div>

                <div class="col-lg-3 col-md-6 col-12 ms-auto">
                    <h5 class="mb-lg-4 mb-3">Redes sociales</h5>

                    <ul class="social-icon">
                        <li><a href="https://www.facebook.com/Caballerodontologo"
                                class="social-icon-link bi-facebook"></a></li>

                        <li><a href="https://www.instagram.com/artedentalsv/"
                                class="social-icon-link bi-instagram"></a></li>

                        <li><a href="https://api.whatsapp.com/send?phone=50379858515&text=Quiero%20agendar%20una%20cita%20por%20favor%20%0A"
                                class="social-icon-link bi-whatsapp"></a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-12 ms-auto mt-4 mt-lg-0">
                    <p class="copyright-text">Copyright © Arte Dental 2023
                </div>

            </div>
            </section>
    </footer>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/scrollspy.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</body>
<script>
    function validarCita() {

        // Verificar si el usuario está autenticado
        var estaAutenticado = {{ auth()->check() ? 'true' : 'false' }};

        if (!estaAutenticado) {
            // Si el usuario no está autenticado, redirigirlo a la página de inicio de sesión
            window.location.href = "{{ route('login') }}";
            return false; // Evitar que se siga el enlace
        }
        // Realiza una petición AJAX para verificar si el usuario tiene un paciente asociado
        $.ajax({
            url: "{{ route('verificar-paciente') }}",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (!response.tienePaciente) {
                    // Si no tiene un paciente asociado, mostrar la alerta y evitar la redirección
                    Swal.fire({
                        icon: 'error',
                        title: 'Faltan datos',
                        text: 'Por favor, completa todos los campos antes de agendar una cita.',
                    }).then(function() {
                        // Después de que el usuario haga clic en "OK", redirigir al formulario de creación de pacientes
                        window.location.href = "{{ route('crear-paciente') }}";
                    });
                } else {
                    // Redirigir al usuario a la vista de paciente si tiene un paciente asociado
                    window.location.href = "{{ route('citas.create') }}";
                }
            }
        });

        // Evitar que se ejecute el enlace inmediatamente
        return false;
    }


    document.addEventListener('DOMContentLoaded', function() {
        const toast = Swal.mixin({
            title: 'No puedes seleccionar fin de semana',
            text: 'Por favor, seleccione un día laboral',
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Entendido',
        });

        const dateInput = document.getElementById('date');
        dateInput.min = new Date().toISOString().split('T')[0];

        dateInput.addEventListener('input', function(e) {
            const day = new Date(this.value).getUTCDay();
            if ([0].includes(day)) {
                e.preventDefault();
                this.value = '';
                toast.fire();
            }
        });
    });
</script>

</html>
