@extends('layouts.index')
@section('content')
    <section class="my-5 p-3" id="welcome">
        <h1 class="text-uppercase text-center fw-bold">¡Sonrisas que iluminan vidas!</h1>
        <h2 class="text-uppercase text-center fw-light fst-italic">Eso es lo que hacemos</h2>
        <br>
        <div class="information row shadow-lg p-4">
            <div class="col mx-1 w-50 p-5 bg-light">
                <h5 class="p-2 text-dark">Médicos de Confianza</h5>
                <p class="text-dark px-3">
                    En Arte Dental, nos dedicamos a ofrecer servicios dentales de alta calidad,
                    con un enfoque en la atención personalizada y la comodidad del paciente.
                    Contamos con un equipo de profesionales altamente calificados, con años de experiencia en el sector.
                    Nuestro objetivo es proporcionar a nuestros pacientes una atención integral, que cubra todas sus
                    necesidades dentales.
                </p>
            </div>
            <div class="col mx-1 w-50 p-5 bg-light">
                <h5 class="p-2 text-dark">Amplia gama de servicios dentales</h5>
                <ul class="text-dark px-3">
                    <li><b>Odontología general:</b> limpiezas, empastes, extracciones, etc.</li>
                    <li><b>Implantología:</b> implantes dentales, prótesis, etc.</li>
                    <li><b>Periodoncia:</b> tratamiento de las encías, cirugía periodontal, etc.</li>
                    <li><b>Estética dental:</b> blanqueamiento dental, carillas, etc.</li>
                </ul>
                <br>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('citas.index') }}" class="btn btn-outline-secondary btn-block">Agendar Cita</a>
                </div>
            </div>
        </div>
        <div class="row m-3 text-center">
            <p class="col fst-italic">

            </p>
        </div>
    </section>

    <section class="hero" id="hero">
        <div class="container">
            <div class="row ">

                <div class="col-12">
                    <div id="myCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('assets/images/slider/img1.jpg/') }}"
                                    class="img-fluid d-block w-75 mx-auto" alt="">
                                <div class="carousel-caption d-none d-md-block bg-light rounded">
                                    <h5 class="text-secondary">¡Será un placer atenderle!</h5>
                                    <p class="text-secondary">Nos especializamos en hacerte sentir bien con tu sonrisa</p>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <img src="{{ asset('assets/images/slider/img2.jpg') }}"
                                    class="img-fluid d-block w-75 mx-auto" alt="">
                                <div class="carousel-caption d-none d-md-block bg-light rounded">
                                    <h5 class="text-secondary">Trabajo de Calidad</h5>
                                    <p class="text-secondary">¡La felicidad al alcance de una cita!</p>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <img src="{{ asset('assets/images/slider/img3.jpg') }}"
                                    class="img-fluid d-block w-75 mx-auto" alt="">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>...</h5>
                                    <p>...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section class="section-padding" id="about">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-md-6 col-12">
                    <h2 class="mb-lg-3 mb-3">Dr. Carlos Caballero</h2>

                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cum asperiores amet necessitatibus
                        dolorem laudantium quod unde temporibus, molestias odit, deserunt nihil ullam neque eaque
                        sint ipsam est rem numquam praesentium. Lorem ipsum, dolor sit amet consectetur adipisicing
                        elit. Amet molestias quod asperiores ut optio perspiciatis dolor voluptate dolorem dicta
                        architecto. Recusandae iste atque aut assumenda suscipit libero beatae quos ullam? Lorem
                        ipsum dolor sit amet, consectetur adipisicing elit. Dicta quasi praesentium dolorem
                        voluptates ipsam aspernatur in, maiores nemo iste ratione sit! Aliquam laborum repellendus
                        doloremque fugit sequi alias, commodi quaerat.</p>

                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Unde omnis est neque vero delectus,
                        dolor eum praesentium sapiente id amet debitis quod? Unde, quo rerum sint porro odio
                        dignissimos blanditiis.<a rel="nofollow" href="http://paypal.me/templatemo" target="_blank">support
                            us a little</a> via PayPal if this template is good and useful
                        for your work.</p>
                </div>

                <div class="col-lg-4 col-md-5 col-12 mx-auto">
                    <div class="featured-circle bg-white shadow-lg d-flex justify-content-center align-items-center">
                        <p class="featured-text"><span class="featured-number">+10</span> Años<br> de Experiencia
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="gallery">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-6 ps-0">
                    <img src="{{ asset('assets/images/slider/img1.jpg/') }}" class="img-fluid" alt="">
                </div>

                <div class="col-lg-6 col-6 pe-0">
                    <img src="{{ asset('assets/images/slider/img2.jpg/') }}" class="img-fluid" alt="">
                </div>

            </div>
        </div>
    </section>

    <section class="section-padding pb-0" id="testimonios">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <h2 class="text-center mb-lg-5 mb-4">Nuestro Compromiso</h2>

                    <div class="owl-carousel reviews-carousel">

                        <figure class="reviews-thumb d-flex flex-wrap align-items-center rounded">
                            <p class="text-primary d-block mt-2 mb-0 w-100"><strong>Higiene Bucal</strong></p>

                            <p class="reviews-text w-100">En Arte Dental estamos comprometidos con la salud y el
                                bienestar de nuestros pacientes. Por eso, nos esforzamos por ofrecer un servicio dental de
                                alta calidad, con un enfoque en la atención personalizada y la comodidad del paciente.</p>

                            <img src="{{ asset('images/secondImage.jpg') }}" class="img-fluid reviews-image" alt="">

                            <figcaption class="ms-4">
                                <strong>Dr. Carlos Caballero</strong>
                            </figcaption>
                        </figure>

                        <figure class="reviews-thumb d-flex flex-wrap align-items-center rounded">

                            <p class="text-primary d-block mt-2 mb-0 w-100"><strong>¡Un Mejor Servicio!</strong></p>

                            <p class="reviews-text w-100">Nos comprometemos a ofrecerte un servicio de excelencia, con
                                atención personalizada, ambiente cálido y presupuestos adaptados a tus necesidades.
                            </p>

                            <img src="{{ asset('images/arteDentalLogo.jpg') }}"class="img-fluid reviews-image"
                                alt="">

                            <figcaption class="ms-4">
                                <strong>Dr. Carlos Caballero</strong>
                            </figcaption>
                        </figure>

                        <figure class="reviews-thumb d-flex flex-wrap align-items-center rounded">
                            <p class="text-primary d-block mt-2 mb-0 w-100"><strong>Precios Accesibles</strong></p>

                            <p class="reviews-text w-100">En nuestra clínica dental, nos enorgullece ofrecer precios
                                accesibles sin comprometer la calidad de atención. Tu sonrisa y bienestar son nuestra
                                prioridad. ¡Confía en nosotros para cuidar de tu salud bucal!</p>

                            <img src="{{ asset('images/arteDental.jpg') }}" class="img-fluid reviews-image" alt="">

                            <figcaption class="ms-4">
                                <strong>Dr. Carlos Caballero</strong>
                            </figcaption>
                        </figure>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
