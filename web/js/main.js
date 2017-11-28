$(document).ready(function(){
    $('.closeInformations').click(function(){
        $('.informations').toggle('display');
    });

    $('.ajaxForm').submit(function(e){
    	var serialized = $(this).serialize();
    	var url = $(this).attr('action');
    	var $this = $(this);
    	var input = $this.find('input[type=text]');
    	e.preventDefault();
    	$.ajax({
    		url: url,
    		type: 'POST',
    		data: serialized
    	}).done(function(data) {	
    		if(data.status === true){
    			input.css('background', '#dff0d8','transition', '0.5s');
    			setTimeout(function(){
    				input.css('background', '#fcfcfc');
    			}, 2000);
    		}else{
    			input.css('background', '#dff0d8','transition', '0.5s');
    			setTimeout(function(){
    				input.css('background', '#f2dede');
    			}, 2000);
    		}
    	});
    });

    $("div.flip").click(function(){
        $(this).next('div.panel').slideToggle('slow');
    });

    $('.fileForm').submit(function(e){
    	var nazwa = $(this).find("input[name=nazwa]");
    	var file = $(this).find("input[name=file]");
    	if(nazwa.val() == '' || file.val() == '')
    	{
    		return false;
    	}
    	return true;
    });

    $(".confirmDelete").click(function(){
       if(confirm("Czy jesteś, że chcesz to skasować?\nPo skasowaniu nie ma odwrotu!") == true){
       	return true;
       }
       return false;
    });

    function search(){
        $.ajax({
            url: $('#searchForm').attr('action'),
            type: 'POST',
            data: $('#searchForm').serialize()
        }).done(function(data) {    
            $('#subs').find('.test').remove();
            if(data.status === true){
                for (var i = 0; i < data.sub.length; i++) {
                    line = '<tr class="test">';
                    line += '<td><a href="'+data.sub[i].idPrzedmiot+'/view"><i class="fa fa-graduation-cap fa-1x"></i> '+data.sub[i].nazwa+'</a></td>';
                    line += '<td>'+data.sub[i].aktualizacja+'</td>';
                    line += '</tr>';
                    $('#subs').append(line);
                }
            }else{
                line = '<tr class="test">';
                line += '<td>'+data.message+'</td>';
                line += '</tr>';
                $('#subs').append(line);
            }
        });
    }

    $('#searchForm').change(function(e){
        e.preventDefault();
        search();
    });   

    $('#searchForm',function(){search();});

});

function inner(){
	var imie = document.getElementById("imie").value.trim();
	var nazwisko = document.getElementById("nazwisko").value.trim();
	var text = imie.substr(0, 1) + nazwisko;
    text = text.toLowerCase();
    text = text.replace("ó","o");
    text = text.replace("ł","l");
    text = text.replace("ń","n");
    text = text.replace("ż","z");
    text = text.replace("ź","z");
    text = text.replace("ć","c");
    text = text.replace("ę","e");
    text = text.replace("ś","s");
    text = text.replace("ą","a");
	document.getElementById("login").value  = text.toLowerCase();
}

