<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/logo.png">
    <link rel="icon" type="image/png" href="/images/logo.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="mask-icon" href="/images/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/swiper-bundle.css">
    <script src="js/jquery.js"></script>
    <script src="js/jquery.easing.1.3.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <link href="/css/datatables.css" rel="stylesheet" />
    @laravelPWA
</head>
<body id="page-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent fixed-top">
        <div class="container-fluid">
          <img id="menulogo" class="img-fluid" src="images/logo_notext.png" width="40" height="40">
          <a class="navbar-brand page-scroll" href="#page-top">Sinergia F.T</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 m-auto lead">
              <li class="nav-item">
                <a class="nav-link active page-scroll" aria-current="page" href="#page-top">Inicio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link page-scroll" href="#next-match-section">Próxima fecha</a>
              </li>
              <li class="nav-item">
                <a class="nav-link page-scroll" href="#ranking-section">Ranking</a>
              </li>
              <li class="nav-item">
                <a class="nav-link page-scroll" href="#gallery-section">Galería</a>
              </li>
              <li class="nav-item">
                <a class="nav-link page-scroll" href="/api/home/matchHistory">Historial Partidos</a>
              </li>
            </ul>
            <form class="d-flex">
                <button id="loginBtn" type="button" data-bs-toggle="modal" data-bs-target="#loginModal" class="btn btn-outline-success">Iniciar Sesión</button>
                <div id="profile" class="dropdown" style="display: none;">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="profileDropDown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="profileDropDown">
                      <li><a class="dropdown-item" href="/api/home">Dashboard</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a id="logout" class="dropdown-item" href="#">Cerrar sesión</a></li>
                    </ul>
                  </div>
            </form>
          </div>
        </div>
    </nav>
    @yield('content')
    <footer class="">
        <div id="footerfondo" class="">
          <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    {{-- <img src="images/logo_transparent_inv.png" class="img-fluid " alt="Responsive image" style="max-height: 200px;"> --}}
                </div>
            </div>
            <div class="row pt-5">
              <div class="col-12 col-md offset-md-1">
                <h5 class="text-uppercase">Acerca de</h5>
                <p>Equipo de Futbol Uruguay.</p>
                <p>Grupo mixto abierto.</p>
              </div>
              <div class="col-6 col-md offset-md-2">
                <h5>SOCIAL</h5>
                <a href="https://facebook.com" target="_blank"><img src="/images/fbicon.png" alt="Responsive image" width="25" height="25"></a>
                <a href="https://www.instagram.com/sinergia.f.t/" target="_blank"><img src="/images/igicon.png" alt="Responsive image" width="25" height="25"></a>
                <a href="https://twitter.com" target="_blank"><img src="/images/twicono.png" alt="Responsive image" width="25" height="25"></a>
              </div>
              <div class="col-5 offset-1 col-sm-4 offset-sm-2 col-md offset-md-1">
                <h5>MENÚ</h5>
                <a href="#page-top" class="page-scroll"><p>Inicio</p></a>
                <a href="#gallery-section" class="page-scroll"><p>Galería</p></a>
                <a href="#ranking-section" class="page-scroll"><p>Ranking</p></a>
              </div>
            </div>
          </div>
          <hr class="border-light">
          <div class="container">
            <div id="copyright" class="row">
              <div class="col-12 text-center">
                <p>© 2021 Sinergia F.T. Todos los derechos reservados. Diseñado por <a class="font-weight-bold" href="mailto:mateo.galagorri@gmail.com">Mateo Galagorri</a></p>
              </div>
            </div>
          </div>
        </div>
    </footer>
<!-- Modal de carga -->
  <div class="modal fade loadmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="loadmodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm d-flex justify-content-center">
      <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  </div>
{{-- Login Modal --}}
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Login</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" placeholder="name@example.com">
                    <label for="email">Email</label>
                  </div>
                  <div class="form-floating">
                    <input type="password" class="form-control" id="password" placeholder="Password">
                    <label for="password">Contraseña</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button id="regmodalBtn" type="button" data-bs-toggle="modal" data-bs-target="#registerModal" class="btn btn-outline-success">Registrarse</button>
            <button id="login" type="button" class="btn btn-primary">Iniciar</button>
        </div>
        <div class="modal-footer">
            <a href="/api/password/reset" target="_blank" style="text-decoration: none;">¿Olvidó su contraseña?</a>
        </div>
      </div>
    </div>
</div>
{{-- Register Modal --}}
<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form action="">
            <div class="row">
              <div class="col-12 col-md">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="reg_name" placeholder="Name">
                  <label for="reg_name">Nombre</label>
                </div>
              </div>
              <div class="col-12 col-md">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="reg_lname" placeholder="Lastname">
                  <label for="reg_lname">Apellido</label>
                </div>
              </div>
            </div>
            <div class="form-floating mb-3">
              <input type="email" class="form-control" id="reg_email" placeholder="name@example.com">
              <label for="reg_email">Email</label>
            </div>
            <div class="row">
              <div class="col-12 col-md">
                <div class="form-floating mb-3">
                  <input type="password" class="form-control" id="reg_password" placeholder="Password">
                  <label for="reg_password">Contraseña</label>
                </div>
              </div>
              <div class="col-12 col-md">
                <div class="form-floating mb-3">
                  <input type="password" class="form-control" id="reg_conf_pass" placeholder="Password">
                  <label for="reg_conf_pass">Confirmar contraseña</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="reg_alias" placeholder="Alias">
                  <label for="reg_alias">Alias</label>
                </div>
              </div>
              <div class="col-12 col-md">
                <div class="form-floating mb-3">
                  <select class="form-select" id="reg_type" aria-label="Type">
                    <option value="offensive">Delantero</option>
                    <option value="defensive">Defensa</option>
                    <option value="goalkeeper">Golero</option>
                  </select>
                  <label for="reg_type">Tipo</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md">
                <div class="form-floating mb-3">
                  <input type="number" class="form-control" id="reg_of" placeholder="Ofensiva" min="1" max="10">
                  <label for="reg_of">Ofensiva</label>
                </div>
              </div>
              <div class="col-12 col-md">
                <div class="form-floating mb-3">
                  <input type="number" class="form-control" id="reg_def" placeholder="Defensiva" min="1" max="10">
                  <label for="reg_def">Defensiva</label>
                </div>
              </div>
            </div>
            <button id="register" type="button" class="btn btn-primary">Confirmar</button>
          </form>
      </div>
    </div>
  </div>
</div>
{{-- PWA Modal --}}
<div class="modal fade" id="pwaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">¿Desea instalar la APP Sinergia?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <strong>Accede mas rapidamente mediante nuestra APP</strong>
      </div>
      <div class="modal-footer">
          <button id="pwaAccept" type="button" class="btn btn-success">Si</button>
          <button class="btn btn-primary" data-bs-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
</body>
<!-- JS -->
{{-- <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js"></script>
<script src="js/datatables.js"></script>
<script src="js/scrolling-nav.js"></script>
<script src="js/anime.min.js"></script>
<script src="js/swiper-bundle.js"></script>
<script src="js/noframework.waypoints.min.js"></script>
<script src="js/font-awesome.js" crossorigin="anonymous"></script>
<script src="js/handlebars.min-v4.7.6.js" crossorigin="anonymous"></script>
<script src="js/moment-with-locales.js" crossorigin="anonymous"></script>
<script src="/js/code.js" crossorigin="anonymous"></script>
@yield('scripts')
</html>
