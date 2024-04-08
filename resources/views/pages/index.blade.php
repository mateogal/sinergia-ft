@extends('layouts.base')
@section('title')
    Sinergia F.T
@endsection
@section('content')
<div id="introfondo" class="container-fluid">
    <div id="bg-overlay"></div>
    <div class="container-fluid">
        <div id="desc" class="row">
            <div id="animate_desc" class="text-center col-12">
                <img src="/images/logo.png" class="img-fluid" alt="..." style="max-height: 120px; opacity: 0;">
                <h2 class="font-weight-bold text-danger" style="opacity: 0;">Sinergia F.T</h2>
                <h6 class="text-uppercase text-light" style="opacity: 0;">Sitio Web Sinergia F.T</h6>
                <div id="btn-desc" style="opacity: 0;">
                    <a href="#ranking-section" class="page-scroll"><button class="btn btn-primary" type="button">Ranking</button></a>
                    <a href="#gallery-section" class="page-scroll"><button class="btn btn-outline-light" type="button">Galería</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="next-match-section" class="py-5 container-fluid">
    <h1 class="text-center text-primary">Próximas fechas</h1>
    <hr class="mx-auto mb-3 col-3 border-dark">
    <div id="next_match_row" class="row row-cols-1 row-cols-md-2 justify-content-center">

    </div>
</div>
<div id="ranking-section" class="py-5 container-fluid bg-light">
    <h1 class="text-center text-primary">Ranking</h1>
    <hr class="mx-auto mb-5 col-3 border-dark">
    <div class="row">
        <div class="col-12 col-md">
            <h3 class="text-uppercase text-success text-center mb-3 mt-5">Goles</h3>
            <div id="rank-goals-card-row" class="card-anim row row-cols-2 gy-3">
                <div class="col">
                    <div class="card border-warning" style="max-width: 300px;">
                        <div class="row g-0">
                          <div class="d-flex align-items-center col-md-3 bg-warning">
                            <div class="mx-auto lead"># 1</div>
                          </div>
                          <div class="col-md-9 text-center">
                                <div class="card-header">
                                    <h5 id="rank-1-goals-name" class="card-title"></h5>
                                </div>
                                <div class="card-body">
                                    <img id="rank-1-goals-photo" class="img-fluid rounded" src="" alt="" style="max-height: 130px">
                                </div>
                                <div id="rank-1-goals" class="card-footer"></div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md">
            <h3 class="text-uppercase text-info text-center mb-3 mt-5">Asistencias</h3>
            <div id="rank-assists-card-row" class="card-anim row row-cols-2 gy-3">
                <div class="col">
                    <div class="card border-warning" style="max-width: 300px;">
                        <div class="row g-0">
                          <div class="d-flex align-items-center col-md-3 bg-warning">
                            <div class="mx-auto lead"># 1</div>
                          </div>
                          <div class="col-md-9 text-center">
                                <div class="card-header">
                                    <h5 id="rank-1-assists-name" class="card-title"></h5>
                                </div>
                                <div class="card-body">
                                    <img id="rank-1-assists-photo" class="img-fluid rounded" src="" alt="" style="max-height: 130px">
                                </div>
                                <div id="rank-1-assists" class="card-footer"></div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5 justify-content-center">
        <h3 class="text-uppercase text-warning text-center mb-3 mt-5">Promedios</h3>
        <div id="rank-avg-card-row" class="row card-anim gy-3 row-cols-1 row-cols-sm-2 row-cols-xl-4">
            <div class="col">
                <div class="card border-warning mx-auto" style="max-width: 300px;">
                    <div class="row g-0">
                      <div class="d-flex align-items-center col-md-3 bg-warning">
                        <div class="mx-auto lead"># 1</div>
                      </div>
                      <div class="col-md-9 text-center">
                            <div class="card-header">
                                <h5 id="rank-1-avg-name" class="card-title"></h5>
                            </div>
                            <div class="card-body">
                                <img id="rank-1-avg-photo" class="img-fluid rounded" src="{{asset('images/icon.png')}}" alt="" style="max-height: 130px">
                            </div>
                            <div id="rank-1-avg" class="card-footer"></div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5 justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="card">
                <div class="card-header bg-primary text-white text-uppercase text-center">
                    <h4 class="card-title">Ranking detallado</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="ranking_table" class="table text-center">
                            <thead class="">
                                <th>Nombre Completo</th>
                                <th>Pts</th>
                                <th>PJ</th>
                                <th>PG</th>
                                <th>PP</th>
                                <th>PE</th>
                                <th>Goles</th>
                                <th>Asist.</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="gallery-section" class="container-fluid">
    {{-- <h1 class="text-center text-primary pb-5">Galería</h1> --}}
        <div class="row px-0">
            <div class="col-12 col-md-8 swiper-container bg-dark mx-0 d-flex">
                <div id="" class="swiper-wrapper align-items-center">
                    <div class="swiper-slide align-self-center">
                        <img src="{{ asset('images/gallery/0.jpeg') }}"  alt="...">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery/1.jpeg') }}"  alt="...">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery/2.jpeg') }}"  alt="...">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery/3.jpeg') }}"  alt="...">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery/4.jpeg') }}"  alt="...">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery/5.jpeg') }}"  alt="...">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery/6.jpeg') }}"  alt="...">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery/7.jpeg') }}"  alt="...">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery/8.jpeg') }}"  alt="...">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery/9.jpeg') }}"  alt="...">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery/10.jpeg') }}"  alt="...">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery/11.jpeg') }}"  alt="...">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery/12.jpeg') }}"  alt="...">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery/13.jpeg') }}"  alt="...">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery/14.jpeg') }}"  alt="...">
                    </div>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <div class="col-12 col-md-4 text-center py-5 bg-light2 row mx-0">
                <div class="align-self-center">
                    <div class="col-12">
                        <h1 class="text-primary">Galeria</h1>
                        <hr class="">
                    </div>
                    <div class="col-12">
                        <p class="lead">Guinda Futbol 7</p>
                        <p class="lead">19/06/2021</p>
                    </div>
                    <a href="/api/getAwsFile/19-06-2021.rar">
                        <button class="btn btn-primary">Descargar</button>
                    </a>
                </div>
            </div>
        </div>
</div>

<script id="dinamic-prev-table" type="text/x-handlebars-template">
    <div class="col">
        <div class="col-12 table-responsive">
            <table class="table table-hover text-center table-info">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Jugador</th>
                        <th scope="col">AVG</th>
                    </tr>
                </thead>
                <tbody>
                    @{{#each players}}
                    <tr>
                        <td>@{{this.name}}</td>
                        <td>@{{this.avg}}</td>
                    </tr>
                    @{{/each}}
                </tbody>
                <tfoot>
                    <tr>
                        <td>Equipo: @{{team}}</td>
                        <td>AVG: @{{avg}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</script>
<script id="dinamic-next-match" type="text/x-handlebars-template">
    <div class="col my-3">
        <div class="row justify-content-center gy-3">
            <div class="col-12 col-md-6">
                <div class="card text-center border-primary">
                    <div class="card-header bg-primary text-white lead">
                        @{{field.name}}
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">@{{date}}</h5>
                    </div>
                    <div class="card-footer lead">
                        <a class="nav-link" href="@{{field.address}}" target="_blank">Ver ubicacion</a>
                    </div>
                    <div class="card-footer lead">
                        <button id="conv_conf" value="@{{id}}" class="btn btn-outline-success" onClick="conv_conf(event)">Inscribirme</button>
                        <button id="pm_del@{{id}}" value="@{{id}}" class="btn btn-outline-danger" onClick="pm_del(event)">Darme de baja</button>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div id=@{{next_match_id}} class="row">
                </div>
            </div>
        </div>
    </div>
</script>
<script id="dinamic-ranking-goals" type="text/x-handlebars-template">
    <div class="col">
        <div class="card border-success" style="max-width: 300px;">
            <div class="row g-0">
                <div class="d-flex align-items-center col-md-3 bg-success">
                    <div class="mx-auto lead"># @{{pos}}</div>
                </div>
                <div class="col-md-9 text-center">
                    <div class="card-header">
                        <h5 class="card-title">@{{player}}</h5>
                    </div>
                    <div class="card-body">
                        <img class="img-fluid rounded" src="@{{photo}}" alt="" style="max-height: 130px">
                    </div>
                    <div class="card-footer">
                       Goles: @{{goals}}
                    </div>
                  </div>
                </div>
            </div>
        </div>
</script>
<script id="dinamic-ranking-assists" type="text/x-handlebars-template">
    <div class="col">
        <div class="card border-info" style="max-width: 300px;">
            <div class="row g-0">
                <div class="d-flex align-items-center col-md-3 bg-info">
                    <div class="mx-auto lead"># @{{pos}}</div>
                </div>
                <div class="col-md-9 text-center">
                    <div class="card-header">
                        <h5 class="card-title">@{{player}}</h5>
                    </div>
                    <div class="card-body">
                        <img class="img-fluid rounded" src="@{{photo}}" alt="" style="max-height: 130px">
                    </div>
                    <div class="card-footer">
                       Asistencias: @{{assists}}
                    </div>
                  </div>
                </div>
            </div>
        </div>
</script>
<script id="dinamic-ranking-avg" type="text/x-handlebars-template">
    <div class="col">
        <div class="card border-warning mx-auto" style="max-width: 300px;">
            <div class="row g-0">
                <div class="d-flex align-items-center col-md-3 bg-warning">
                    <div class="mx-auto lead"># @{{pos}}</div>
                </div>
                <div class="col-md-9 text-center">
                    <div class="card-header">
                        <h5 class="card-title">@{{player}}</h5>
                    </div>
                    <div class="card-body">
                        <img class="img-fluid rounded" src="@{{photo}}" alt="" style="max-height: 130px">
                    </div>
                    <div class="card-footer">
                        <p>% Part. Ganados: <b> @{{wm}} % </b></p>
                        <p>AVG Goles: <b> @{{goals}} </b></p>
                        <p>AVG Asistencias: <b> @{{assists}} </b></p>
                        <p>Pts. Ganados: <b> @{{points}} </b></p>
                    </div>
                  </div>
                </div>
            </div>
        </div>
</script>
@endsection
@section('scripts')
<script type="text/javascript">nextMatchInfo()</script>
<script type="text/javascript">ranking()</script>
@endsection
