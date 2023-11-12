function js_forced_ready(callback){
    if (document.readyState != 'loading') { callback(); }
    else if (document.addEventListener) { document.addEventListener('DOMContentLoaded', callback); }
    else
    {
        document.attachEvent('onreadystatechange', function() {
            if (document.readyState == 'complete') { callback(); }
        });
    }
}

$(document).ready(function() {
    js_forced_ready(function() {
        setTimeout(function() {
            events_init();
        }, 250);
    });
});

function events_init()
{
    datepicker_processes();
}

function datepicker_processes()
{
    $(".datepicker").datepicker({dateFormat: "yy-mm-dd"});
    $(document).on('click', '#chk_dates', function() {
        let date_obj = new Date();
        
        //mai dátum
        let year = date_obj.getFullYear();
        let month = date_obj.getMonth()+1; //A JS szerint van 0. hónap is. (Évre, napra nem igaz, de a hónapra igen! Tapsvihar...)
        let day = date_obj.getDate();
        var full_date = year + '-' + (month<10 ? '0' : '') + month + '-' + (day<10 ? '0' : '') + day;
        var full_date_unix = new Date(full_date.replace('-','/')).getTime();
        
        //start dátum
        var start_date = $("#start_date").val();
        var start_date_unix = 0;
        if (start_date.length>0)
        {
            start_date_unix = new Date(start_date.replace('-','/')).getTime();
        }
        
        //end dátum
        var end_date = $("#end_date").val();
        var end_date_unix = 0;
        if (end_date.length>0)
        {
            end_date_unix = new Date(end_date.replace('-','/')).getTime();
        }
        
        //ellenőrzések
        $('.datepicker').removeClass('error');
        let alert_msg = '';
        
        //start dátum ellenőrzése
        if (start_date_unix == 0)
        {
            alert_msg = 'Kérem adja meg a bejelentkezés napját!';
        }
        else if (start_date_unix < full_date_unix)
        {
            alert_msg = 'A bejelentkezés nem lehet korábbi a mai napnál!';
        }
        
        if (alert_msg != '')
        {
            $('#start_date').addClass('error');
        }
        else
        {
            //end dátum ellenőrzése
            if (end_date_unix == 0)
            {
                alert_msg = 'Kérem adja meg a kijelentkezés napját!';
            }
            else if (start_date_unix < full_date_unix)
            {
                alert_msg = 'A kijelentkezés nem lehet korábbi a mai napnál!';
            }
            else if (start_date_unix > end_date_unix)
            {
                alert_msg = 'A kijelentkezés nem lehet korábbi a bejelentkezés napjánál!';
            }

            if (alert_msg != '')
            {
                $('#end_date').addClass('error');
            }
        }
        
        if (alert_msg != '') //figyelmeztetés megjelenítése
        {
            alert(alert_msg);
        }
        else //dátumok helyesek
        {
            let ajax_datas = 'ajax=show_parcells&start='+start_date+'&end='+end_date;
            let response_target = '.parcells';
            ajax_call(ajax_datas,response_target);
        }
    });
}

function ajax_call(ajax_datas,response_target)
{
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: ajax_datas,
        dataType: 'html',
        success: function (response) {
            let resp = '<div>' + response + '</div>';
            $(response_target).html($(resp).children(response_target).html());
        },
        complete: function() {
            
        }
    });
}
