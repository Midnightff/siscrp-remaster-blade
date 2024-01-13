<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Arte Dental</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" integrity="...">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="..."
        crossorigin="anonymous"></script>

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- Estilos css David --}}
    <link rel="stylesheet" href="{{ asset('assets/css/estilos.css') }}">

    <link rel="shortcut icon" href="{{ asset('faviconArt.png') }}">


    <title>Login</title>
</head>

<body>
    <div id="logreg">
        <main class="py-4">
            <div class="modal fade" id="terms" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog  modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-4 fw-bold" id="staticBackdropLabel">Terminos y Condiciones de Uso
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Laboriosam possimus eius
                                consectetur
                                consequuntur ratione animi, veritatis amet eveniet magnam ea doloribus! Eveniet
                                quisquam, vel,
                                molestias
                                deserunt iusto quaerat in quod quis alias maxime voluptas doloremque quos. Ratione, cum
                                asperiores
                                optio
                                ipsa maiores, quod magni nemo nesciunt iste eius et commodi molestias mollitia nam sequi
                                quas enim
                                quos.
                                Neque maxime sequi nisi explicabo labore magnam autem sapiente in hic unde quia veniam
                                debitis eaque
                                dignissimos magni, perferendis tenetur. Laboriosam dolorem repellat nemo magnam tempore
                                doloribus
                                reprehenderit unde quo corporis, adipisci alias ratione praesentium, ut natus quasi
                                dolores minus
                                quas
                                incidunt. Atque animi dolores cumque nisi numquam saepe in aliquid enim aspernatur
                                molestiae!
                                Laborum
                                dolor fuga maiores iste odit facere tempora, corporis a. Nesciunt enim sequi
                                voluptatibus maxime
                                beatae
                                suscipit debitis aspernatur eaque! Quisquam repudiandae reiciendis quo aspernatur hic
                                placeat
                                facilis
                                magni optio dolor id nam expedita, deleniti asperiores consequatur fugiat amet
                                consequuntur
                                doloribus ea
                                dolores impedit vel fugit? Molestias facere excepturi hic debitis ullam.</p>
                            <br>
                            <br>
                            <label for="agreed" class="fw-bold">De Acuerdo</label>
                            <input type="checkbox" name="" id="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary">Entendido</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="political" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog  modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-4 fw-bold" id="staticBackdropLabel">Politica de Privacidad</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Laboriosam possimus eius
                                consectetur
                                consequuntur ratione animi, veritatis amet eveniet magnam ea doloribus! Eveniet
                                quisquam, vel,
                                molestias
                                deserunt iusto quaerat in quod quis alias maxime voluptas doloremque quos. Ratione, cum
                                asperiores
                                optio
                                ipsa maiores, quod magni nemo nesciunt iste eius et commodi molestias mollitia nam sequi
                                quas enim
                                quos.
                                Neque maxime sequi nisi explicabo labore magnam autem sapiente in hic unde quia veniam
                                debitis eaque
                                dignissimos magni, perferendis tenetur. Laboriosam dolorem repellat nemo magnam tempore
                                doloribus
                                reprehenderit unde quo corporis, adipisci alias ratione praesentium, ut natus quasi
                                dolores minus
                                quas
                                incidunt. Atque animi dolores cumque nisi numquam saepe in aliquid enim aspernatur
                                molestiae!
                                Laborum
                                dolor fuga maiores iste odit facere tempora, corporis a. Nesciunt enim sequi
                                voluptatibus maxime
                                beatae
                                suscipit debitis aspernatur eaque! Quisquam repudiandae reiciendis quo aspernatur hic
                                placeat
                                facilis
                                magni optio dolor id nam expedita, deleniti asperiores consequatur fugiat amet
                                consequuntur
                                doloribus ea
                                dolores impedit vel fugit? Molestias facere excepturi hic debitis ullam.</p>
                            <br>
                            <br>
                            <label for="agreed" class="fw-bold">De Acuerdo</label>
                            <input type="checkbox" name="" id="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary">Entendido</button>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
        </main>
    </div>

</body>

<footer class="bg-light w-100 mx-auto p-2 mt-4 pb-1" id="">
    <section class="row">
        <div class="col-md-4 text-center">
            Arte Dental
        </div>
        <div class="col-md-4 text-center">
            <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#terms">
                Términos y Condiciones
            </button>

            <span>
                <img src="images/arteDentalLogo.jpg" class="" id="logteeth">
            </span>
            <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#political">
                Politica de Privacidad
            </button>
        </div>
        <div class="col-md-4 text-center">
            <a href="https://www.facebook.com/Caballerodontologo"
                class="social-icon-link bi-facebook text-secondary"></a>
            &nbsp;
            <a href="https://www.instagram.com/artedentalsv/" class="social-icon-link bi-instagram text-secondary"></a>
            &nbsp;
            <a href="https://api.whatsapp.com/send?phone=50379858515&text=Quiero%20agendar%20una%20cita%20por%20favor%20%0A"
                class="social-icon-link bi-whatsapp text-secondary"></a>

        </div>
    </section>
</footer>

</html>
