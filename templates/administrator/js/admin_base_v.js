function change_page_status(page_id) {
    $.ajax({
        type: 'POST',
        url: base_url + 'admin/pages/ajax_change_status/' + page_id,
        onComplete: function(response) { }
    });
}

$(document).ready(function(){
    $( ".pages-table" ).bind( "sortstop", function(event, ui) {
        var positionsArray = {};
        
        $('.pages-table > tbody').children('tr').each(function(){
            positionsArray['pages_pos['+$(this).index()+']'] = 'page'+$(this).attr('data-id')+'_'+$(this).index();
        });
        
        console.log(positionsArray);
        
        $.ajax({
            type: 'post',
            data: positionsArray,
            url: '/admin/pages/save_positions/',
            success: function(obj){
                if(obj.result){
                    //alert("positions changed successfull");
                }
            }
        });
    });
    
    $('a.ajax_load').click(function(event){
        event.preventDefault();
        $('#mainContent').load($(this).attr('href'));
        /*
        $.ajax({
            type: 'get',
            url: $(this).attr('href'),
            success: function(result){
                $('#mainContent').html(result);
            }
        });
        */
    });
    
    $('#categorySelect').on('change', function(){
        //$('#mainContent').load($(this).attr('url')+$(this).val());
        window.location.href = $(this).attr('url')+$(this).val();
    });
    
    $('button.action_on').click(function(event){
        event.preventDefault();
        var pagesArray = {};
        
        $('.pages-table > tbody').children('tr').children('td.t-a_c').find('input:checked').each(function(){
            pagesArray['pages['+$(this).attr('data-id')+']'] = 'chkb_'+$(this).attr('data-id');
        });
        
        pagesArray['new_cat'] = $('#categorySelect').val();
        
        $.ajax({
            type: 'post',
            data: pagesArray,
            url: $(this).attr('url'),
            success: function(result){
                //$('#mainContent').html(result);
                window.location.href = '/admin/pages/GetPagesByCategory/'+pagesArray['new_cat'];
            }
        });
    });
    
});