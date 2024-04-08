@extends('layouts.dashboard.home', [
    'class' => '',
    'elementActive' => 'dashboard'
])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-money-coins text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Fondo Solidario</p>
                                    <p id="fund_balance" class="card-title"><p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div id="date_fund" class="stats">
                            <i class="fa fa-calendar-o"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Movimientos fondo</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_fund" class="table text-center">
                                <thead class=" text-primary">
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Saldo</th>
                                    <th>Monto Mov.</th>
                                    <th>Tipo</th>
                                    <th>Motivo</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ranking detallado</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ranking_table" class="table text-center">
                                <thead class=" text-primary">
                                    <th>Nombre Completo</th>
                                    <th>Goles</th>
                                    <th>Asist.</th>
                                    <th>Pts</th>
                                    <th>PJ</th>
                                    <th>PG</th>
                                    <th>PP</th>
                                    <th>PE</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Lista de Jugadores</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="players_table" class="table text-center">
                                <thead class=" text-primary">
                                    <th>Nombre Completo</th>
                                    <th>Alias</th>
                                    <th>Ofensiva</th>
                                    <th>Defensiva</th>
                                    <th>Tipo</th>
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
@endsection

@push('scripts')
    <script>getPlayers()</script>
    <script>ranking()</script>
    <script>funds()</script>
@endpush
