const env = "<?php {{ env('APP_ENV') }} ?>";

const url = 'http://127.0.0.1:8000/api'

const headers = {
    'Authorization': 'Bearer ' + Cookies.get('sinergia_token'),
}

if (document.location.pathname == '/'){

    var swiper = new Swiper('.swiper-container', {
        // autoHeight: true,
        slidesPerView: 1,
        // spaceBetween: 30,
        // centeredSlides: true,
        // calculateHeight: true,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        }
    });

    var waypoint = new Waypoint({
        element: document.getElementById('next-match-section'),
        handler: function() {
            $('.navbar').removeClass('bg-transparent');
            $('.navbar').addClass('bg-dark');
            $('.navbar > a > img').hide();
            $('.navbar > a > b').show();
        }
    });

    var waypoint = new Waypoint({
        element: document.getElementById('introfondo'),
        handler: function() {
            $('.navbar').addClass('bg-transparent');
            $('.navbar').removeClass('bg-dark');
            $('.navbar > a > img').show();
            $('.navbar > a > b').hide();
        },
        offset: '-40%'
    });

    // Retrieve the template data from the HTML (jQuery is used here).
    var regTablePrev = $('#dinamic-prev-table').html();
    var nextMatch = $('#dinamic-next-match').html();
    var rankingCardGoals = $('#dinamic-ranking-goals').html();
    var rankingCardAssists = $('#dinamic-ranking-assists').html();
    var rankingCardAvg = $('#dinamic-ranking-avg').html();

    // Compile the template data into a function
    var regTablePrevScript = Handlebars.compile(regTablePrev);
    var nextMatchScript = Handlebars.compile(nextMatch);
    var rankingScriptGoals = Handlebars.compile(rankingCardGoals);
    var rankingScriptAssists = Handlebars.compile(rankingCardAssists);
    var rankingScriptAvg = Handlebars.compile(rankingCardAvg);
}

$(document).ready(ini);

function ini(){
    $('#conv_preview').click(conv_preview);
    $('#login').click(login);
    $('#logout').click(logout);
    $('#register').click(register);
    $('#conv_conf').click(conv_conf);
    $('#res_pass_email').click(res_passw_email);
    $('#res_pass').click(res_passw);
}

function conv_preview(){
    var match_id = $('#reg_match_id').val();
    $('#conv_conf').hide();
    $('#prev_team_row').empty();
    loadmodal();
    $.ajax({
        url: '/api/maker/bestlineup',
        type:'GET',
        data:{
            match_id:match_id
        },
        headers:headers,
        success:function(data){
            $('#conv_conf').show();
            $.each(data.teams, function(key, value){
                var context = [];
                context['players'] = [];
                var avg = 0;
                for (let i = 0; i < value.length; i++) {
                    player_info = [];
                    player_info['name'] = value[i]['name'];
                    player_info['avg'] = value[i]['avg'];
                    context['players'][i] = player_info;
                    avg += value[i]['avg'];
                }
                context['team'] = key;
                context['avg'] = avg;
                var html = regTablePrevScript(context);
                $('#prev_team_row').append(html);
            });
            closemodal();
        },
        error:function(result){
            closemodal();
            alert(result.responseJSON.error);
        }
    })
}

function conv_conf(e){
    // var match_id = $('#reg_match_id').val();
    var match_id = e.target.value;
    loadmodal();
    $.ajax({
        url: '/api/playermatch',
        type: 'POST',
        headers: headers,
        data:{
            match_id:match_id
        },
        success:function(result){
            alert('Bienvenido al plantel');
            document.location.href='/';
        },
        error:function(result){
            closemodal();
            alert(result.responseJSON.error);
        }
    });
}

function nextMatchInfo(){
    $.ajax({
        url: '/api/matches/next',
        type: 'GET',
        success:function(data){
            $.each(data.match, function(key, value){
                var context = [];
                context['field'] = value['field'];
                context['date'] = format_date(value['date']);
                context['next_match_id'] = 'next_match'+key;
                context['id'] = value['id'];
                var html = nextMatchScript(context);
                $('#next_match_row').append(html);
                $.each(value['teams'], function(key2, value2){
                    var avg = 0;
                    context['players'] = [];
                    for (let i = 0; i < value2.length; i++) {
                        player_info = [];
                        player_info['name'] = value2[i]['name'];
                        player_info['avg'] = value2[i]['avg'];
                        context['players'][i] = player_info;
                        avg += value2[i]['avg'];
                    }
                    context['team'] = key2;
                    context['avg'] = avg;
                    var html = regTablePrevScript(context);
                    $('#next_match'+key).append(html);
                });
                $('#reg_match_id').append('<option value="'+value['id']+'">'+value['field']['name']+' - '+format_date(value['date'])+'</option>');
            });
        },
        error:function(result){
            console.log(result);
            if(result.responseJSON.error == 'Sin datos'){
                $('#next_match_row').append('<h2 class="mt-3 text-center text-warning">Sin próxima fecha</h2>')
            }
        }
    });
}

function login(){
    var email = $('#email').val();
    var password = $('#password').val();
    loadmodal();
    $.ajax({
        url: '/api/login',
        type: 'POST',
        data:{
            email:email,
            password:password
        },
        success:function(result){
            Cookies.set('sinergia_token', result.access_token);
            // localStorage.setItem('sinergia_token', result.access_token);
            if (document.location.pathname == '/'){
                document.location.href="/";
            }else{
                document.location.href="/api/home";
            }
        },
        error:function(result){
            closemodal();
            alert(result.responseJSON.message);
        }
    });
}

function logout(){
    $.ajax({
        url: '/api/logout',
        type: 'POST',
        headers: headers,
        success:function(result){
            // localStorage.removeItem('sinergia_token');
            Cookies.remove('sinergia_token');
            document.location.href="/";
        },
        error:function(result){
            alert(result.responseJSON.message);
        }
    });
}

function register(){
    var name = $('#reg_name').val();
    var email = $('#reg_email').val();
    var password = $('#reg_password').val();
    var password_confirmation = $('#reg_conf_pass').val();
    var type = $('#reg_type').val();
    var lastname = $('#reg_lname').val();
    var alias = $('#reg_alias').val();
    var offense = parseInt($('#reg_of').val());
    var defense = parseInt($('#reg_def').val());
    if (offense > 10 || defense > 10){
        alert('Tus estadisticas no pueden ser mayor a 10');
        return;
    }
    loadmodal();
    $.ajax({
        url: '/api/register',
        type: 'POST',
        data:{
            name:name,
            email:email,
            password:password,
            password_confirmation:password_confirmation,
            type:type,
            lastname:lastname,
            alias:alias,
            offense:offense,
            defense:defense
        },
        success:function(result){
            // localStorage.setItem('sinergia_token', result.access_token);
            Cookies.set('sinergia_token', result.access_token);
            alert('Registro Exitoso');
            document.location.href="/";
        },
        error:function(result){
            closemodal();
            alert(result.responseJSON.message);
        }
    });
}

function ranking(){
    $.ajax({
        url: '/api/ranking',
        type: 'GET',
        headers: headers,
        success:function(result){
            var context = context2 = [];
            $('#rank-1-goals-name').html(result.ranking[0]['player']);
            $('#rank-1-goals-photo').attr('src', result.ranking[0]['photo']);
            $('#rank-1-goals').html('Goles: '+result.ranking[0]['goals']);            
            $('#rank-1-assists-name').html(result.rankAssists[0]['player']);
            $('#rank-1-assists-photo').attr('src', result.rankAssists[0]['photo']);
            $('#rank-1-assists').html('Asistencias: '+result.rankAssists[0]['assists']);
            $('#rank-1-avg-name').html(result.rankAvg[0]['player']);
            $('#rank-1-avg-photo').attr('src', result.rankAvg[0]['photo']);
            $('#rank-1-avg').html('<p>% Part. Ganados: <b>'+result.rankAvg[0]['wm']+' %</b></p><p>AVG Goles: <b>'+result.rankAvg[0]['goals_avg']+'</b></p><p>AVG Asist.: <b>'+result.rankAvg[0]['assists_avg']+'</b></p><p>Pts. Ganados: <b>'+result.rankAvg[0]['points']+'</b></p>');
            for (let i = 1; i < 6; i++) {
                context['player'] = result.ranking[i]['player'];
                context['goals'] = result.ranking[i]['goals'];
                context['pos'] = i+1;
                context['photo'] = result.ranking[i]['photo'];
                var html = rankingScriptGoals(context);
                $('#rank-goals-card-row').append(html);
            }
            for (let i = 1; i < 6; i++) {
                context['player'] = result.rankAssists[i]['player'];
                context['assists'] = result.rankAssists[i]['assists'];
                context['pos'] = i+1;
                context['photo'] = result.rankAssists[i]['photo'];
                var html2 = rankingScriptAssists(context2);
                $('#rank-assists-card-row').append(html2);
            }
            for (let i = 1; i < 4; i++) {
                context['player'] = result.rankAvg[i]['player'];
                context['assists'] = result.rankAvg[i]['assists_avg'];
                context['goals'] = result.rankAvg[i]['goals_avg'];
                context['wm'] = result.rankAvg[i]['wm'];
                context['points'] = result.rankAvg[i]['points'];
                context['pos'] = i+1;
                context['photo'] = result.rankAvg[i]['photo'];
                var html2 = rankingScriptAvg(context2);
                $('#rank-avg-card-row').append(html2);
            }
            $.each(result.ranking, function(key, value){
                $('#ranking_table').append('<tr><td>'+value.player+'</td><td>'+value.points+'</td><td>'+value.total_games+'</td><td>'+value.victory+'</td><td>'+value.lose+'</td><td>'+value.draw+'</td><td>'+value.goals+'</td><td>'+value.assists+'</td></tr>');
            });
            data_tables('#ranking_table', 1, 'desc');
            card_anim();
        },
        error:function(result){

        }
    });
}

function res_passw_email() {
    var email = $('#email').val();
    loadmodal();
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/api/password/email',
        type: 'POST',
        data: {
        email: email
        },
        success: function(result) {
        closemodal();
        alert(result.message);
        },
        error: function(result) {
        closemodal();
        alert(result.responseJSON.message);
        }
    })
}

function res_passw(){
    var email = $('#email').val();
    var token = $('#token').val();
    var password = $('#password').val();
    var password_confirm = $('#password-confirm').val();
    loadmodal();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/api/password/reset',
        type: 'POST',
        data:{
            email:email,
            token:token,
            password:password,
            password_confirmation:password_confirm
        },
        success:function(result){
            closemodal();
            alert(result.message);
        },
        error:function(result){
            closemodal();
            alert(result.responseJSON.message);
        }
    });
}

function pm_del(e){
    if (!Cookies.get('sinergia_token')){
        alert('Debe iniciar sesion');
        return;
    }
    loadmodal();
    var match_id = e.target.value;
    $.ajax({
        url: '/api/playermatch',
        type: 'DELETE',
        data:{
            match_id:match_id
        },
        success:function(result){
            alert('Se ha dado de baja correctamente');
            document.location.href='/';
        },
        error:function(error){
            alert(error.responseJSON.error);
            closemodal();
        }
    });
}

//Extras
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

function card_anim(){
    $('.card-anim .card').hover(function(){
        anime({
            targets: [this],
            translateY: -10,
            // opacity: 1,
            // easing: 'spring(1, 80, 8, 0)',
            // duration: 500,
            // easing: 'linear'
            // delay: 500
        });
    }, function(){
        anime({
            targets: [this],
            translateY: 0,
            // opacity: 1,
            // easing: 'spring(1, 80, 8, 0)',
            // duration: 500,
            // easing: 'linear'
            // delay: 500
        });
    })
};

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

$(document).ready(function(){
    if (Cookies.get('sinergia_token')){
        $.ajax({
            url: '/api/user-api',
            type: 'GET',
            headers: headers,
            success:function(data){
                $('#profileDropDown').html(data.profile.name+' '+data.profile.lastname);
            },
            error:function(result){
                console.log(result);
            }
        });
        $('#loginBtn').hide();
        $('#profile').show();
    }else{
        $('#loginBtn').show();
        $('#profile').hide();
    }

    var buttonInstall = $('#pwaAccept')[0];
    let deferredPrompt;

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent the mini-infobar from appearing on mobile
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;
        // Update UI notify the user they can install the PWA
        $('#pwaModal').modal('show');
    });

    buttonInstall.addEventListener('click', (e) => {
        // Hide the app provided install promotion
        $('#pwaModal').modal('show');
        // Show the install prompt
        deferredPrompt.prompt();
        // Wait for the user to respond to the prompt
        deferredPrompt.userChoice.then((choiceResult) => {
          if (choiceResult.outcome === 'accepted') {
            console.log('User accepted the install prompt');
          } else {
            console.log('User dismissed the install prompt');
          }
        });
    });

    // Create a timeline with default parameters
    var tl = anime.timeline({
        easing: 'easeOutExpo',
        delay: 200,
    });

    // Add children
    tl
    .add({
        targets: '#animate_desc img',
        opacity: 1,
    })
    .add({
        targets: '#animate_desc h2',
        opacity: 1,
    }, '-=800')
    .add({
        targets: '#animate_desc h6',
        translateX: [-250, 0],
        opacity: 1,
    }, '-=600')
    .add({
        targets: '#animate_desc #btn-desc',
        translateY: [250, 0],
        opacity: 1,
    }, '-=600');
});
