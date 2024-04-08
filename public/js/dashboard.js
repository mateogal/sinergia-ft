var token = Cookies.get('sinergia_token');

if (!token){
    document.location.href='/api/login';
}

const headers = {
    'Authorization': 'Bearer ' + Cookies.get('sinergia_token'),
}

$(document).ready(ini);

function ini(){
    $('#logout').click(logout);
    $('#src_match').click(src_match);
}

function logout(){
    $.ajax({
        url: '/api/logout',
        type: 'POST',
        headers: headers,
        success:function(result){
            Cookies.remove('sinergia_token');
            document.location.href="/";
        },
        error:function(result){
            alert(result.responseJSON.message);
        }
    });
}

function src_match(){
    var teamsTablePrev = $('#dinamic-teams-table').html();
    var teamsTableScript = Handlebars.compile(teamsTablePrev);
    loadmodal();
    var id = $('#match_list').val();
    data_tables_check('#statics_table');
    $('#statics_table tbody tr').remove();
    $('#teams_row .dinamic-card').remove();
    $('#match_res').hide();
    $.ajax({
        url: '/api/matches/'+id,
        type: 'GET',
        success:function(data){
            var context = [];
            console.log(data);
            console.log(data);
            for (let index = 0; index < data.match.teams_qty; index++) {
                context['team'+(index+1)] = [];
                context['team'+(index+1)]['players'] = [];
            }
            $.each(data.match.player_match, function(key,value){
                $('#statics_table').append('<tr><td>'+(key+1)+'</td><td>'+value.player.name+' '+value.player.lastname+'<td>'+value.goals+'</td><td>'+value.assists+'</td></td></tr>');
                player_info = [];
                player_info['name'] = value.player.name+' '+value.player.lastname;
                if (value.player.type == 'offensive'){
                    value.player.type = 'Atacante';
                }else if(value.player.type == 'defensive'){
                    value.player.type = 'Defensa';
                }else{
                    value.player.type = 'Golero';
                }
                player_info['type'] = value.player.type;
                player_info['alias'] = value.player.alias;
                context[value.team_type]['players'][key] = player_info;
            });

            context['team1']['team'] = 1;
            $('#res_t1').text(data.match.res_t1);
            var html = teamsTableScript(context['team1']);
            $('#teams_row').append(html);

            context['team2']['team'] = 2;
            $('#res_t2').text(data.match.res_t2);
            var html = teamsTableScript(context['team2']);
            $('#teams_row').append(html);

            data_tables('#statics_table',0,'asc',(data.match.max_players)/(data.match.teams_qty));
            $('#match_res').show();
            closemodal();
        },
        error:function(result){
            console.log(result.responseJSON.error);
        }
    })
}

function matchHistory(){
    $.ajax({
        url: '/api/match/history' ,
        type: 'GET',
        success:function(data){
            $.each(data.matches, function(key, value){
                $('#match_list').append('<option value="'+value.id+'">'+format_date(value.date)+' - '+value.field.name+'</option>');
            });
        },
        error:function(result){
           console.log(result.responseJSON.error);
        }
    });
}

function getPlayers(){
    $.ajax({
        url: '/api/players',
        type: 'GET',
        success:function(data){
            $.each(data.players, function(key, value){
                if (value.type == 'offensive'){
                    value.type = 'Atacante';
                }else if(value.type == 'defensive'){
                    value.type = 'Defensa';
                }else{
                    value.type = 'Golero';
                }
                $('#players_table').append('<tr><td>'+value.name+' '+value.lastname+'</td><td>'+value.alias+'</td><td>'+value.offense+'</td><td>'+value.defense+'</td><td>'+value.type+'</td></tr>');
            });
            data_tables('#players_table', 0, 'asc');
        },
        error:function(result){
            console.log(result.responseJSON.error);
        }
    });
}

function ranking(){
    $.ajax({
        url: '/api/ranking',
        type: 'GET',
        success:function(data){
            $.each(data.ranking, function(key, value){
                $('#ranking_table').append('<tr><td>'+value.player+'</td><td>'+value.goals+'</td><td>'+value.assists+'</td><td>'+value.points+'</td><td>'+value.total_games+'</td><td>'+value.victory+'</td><td>'+value.lose+'</td><td>'+value.draw+'</td></tr>');
            });
            data_tables('#ranking_table', 1, 'desc');
        },
        error:function(result){
           console.log(result.responseJSON.error);
        }
    });
}

function funds(){
    $.ajax({
        url: '/api/funds',
        type: 'GET',
        success:function(data){
            $.each(data.funds, function(key, value){
                $('#table_fund').append('<tr><td>'+key+'</td><td>'+format_date(value.date)+'</td><td>$ '+value.balance+'</td><td>$ '+value.amount+'</td><td>'+value.type+'</td><td>'+value.description+'</td></tr>');
            });
            data_tables('#table_fund', 0, 'asc')
            $('#fund_balance').text('$ '+data.funds[0].balance);
            $('#date_fund').append(format_date(data.funds[0].date));
        },
        error:function(error){
            console.log(error);
        }
    });
}

//DataTables
function data_tables(table, numOrder, order, length){
    $(table).DataTable({
        "autoWidth": false,
        dom: 'frtp',
        language: {
            "url": "/Spanish.json"
        },
        buttons: [
            'copy', 'excel', 'pdf'
        ],
        "order": [numOrder, order],
        "pageLength": length
    });
}

function data_tables_check(table){
    if ( $.fn.dataTable.isDataTable( table ) ) {
        tabla = $(table).DataTable();
        tabla.destroy();
        tabla.clear();
    }
}

function format_date(value){
    var date = new moment(value, ['DD-MM-YYYY', 'YYYY-MM-DD', 'DD/MM/YYYY', 'YYYY/MM/DD', 'YYYY-MM-DDTHH:mm:ssZ', 'YYYY-MM-DD H:mm']);
    date = date.format('DD/MM/YYYY H:mm');
    return date;
}

function loadmodal(){
    $('.loadmodal').modal('show');
}

function closemodal(){
    setTimeout(close,1500);
}

function close(){
    $('.loadmodal').modal('hide');
}
