@extends('layouts.dashboard.home', [
    'class' => '',
    'elementActive' => 'match_history'
])

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-3">
                <div class="card card-stats">
                    <div class="card-header text-center">
                        <p class="text-muted">Lista de Partidos</p>
                    </div>
                    <div class="card-body text-center">
                        <select name="" id="match_list" class="form-control custom-select"></select>
                    </div>
                    <div class="card-footer text-center">
                        <hr>
                        <button id="src_match" class="btn btn-info">Buscar</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Estadisticas</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="statics_table" class="table text-center">
                                <thead class=" text-primary">
                                    <th>#</th>
                                    <th>Jugador</th>
                                    <th>Goles</th>
                                    <th>Asistencias</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="teams_row" class="row">
            <div class="col-12 col-lg">
                <div id="match_res" class="card text-center" style="display: none;">
                    <div class="card-header bg-success">
                        <h2 class="text-light">Resultado</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3>Equipo 1
                                    <p id="res_t1" class="text-danger"></p>
                                </h3>
                            </div>
                            <div class="col">
                                <h3>Equipo 2
                                    <p id="res_t2" class="text-danger"></p>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script id="dinamic-teams-table" type="text/x-handlebars-template">
        <div class="dinamic-card col-12 col-lg">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Equipo @{{team}}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="" class="table text-center">
                            <thead class=" text-primary">
                                <th>Jugador</th>
                                <th>Alias</th>
                                <th>Tipo</th>
                            </thead>
                            <tbody>
                                @{{#each players}}
                                <tr>
                                    <td>@{{this.name}}</td>
                                    <td>@{{this.alias}}</td>
                                    <td>@{{this.type}}</td>
                                </tr>
                                @{{/each}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </script>
@endsection
@push('scripts')
<script>matchHistory()</script>
@endpush
