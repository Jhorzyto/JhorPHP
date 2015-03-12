function validarSubmit( link ){

	var dados = $('#formAjax').serializeArray();
	var errors = 0;

	for($i = 0 ; $i < dados.length; $i++){

		if (dados[$i].value == "" || dados[$i].value == 0) {

			$("[name='"+dados[$i].name+"']").removeClass('valid'); 
			$("[name='"+dados[$i].name+"']").addClass('invalid');
			errors++;

		}

	}

	if(errors == 0){

		$.ajax({
			url: link ,
			type: "POST",
			dataType: "json" ,
			data: dados,

			beforeSend: function(){
				$('#loadAjax').css({display:"block"});
			},

			complete: function(msg){
				$('#loadAjax').css({display:"none"});
			},

			success: function(response) {

				errors = 0;	

				for($i = 0 ; $i < response.length; $i++){

					if (!response[$i].situacao) {

						toast(response[$i].mensagem, 4000);		

						$("[name='"+response[$i].tipo+"']").removeClass('valid'); 
						$("[name='"+response[$i].tipo+"']").addClass('invalid');
						
						errors++;

					} else {

						$("[name='"+response[$i].tipo+"']").removeClass('invalid');
						$("[name='"+response[$i].tipo+"']").addClass('valid'); 

					}

				}

				if(errors == 0){

					$('#submitButton').prop({disabled: false});

				}

			},

			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				toast("Status: " + textStatus, 4000); 
				toast("Error: " + errorThrown, 4000); 
			} 
		});

	}

}

function removeDisable ( elementName ) {
	$("[name='"+elementName+"']").prop({disabled: false});
}

function statusUsuario( link , element ){

	$.ajax({
		url: link ,
		dataType: "json" ,

		success: function(response) {

			toast( response.mensagem , 4000); 
		},

		error: function(XMLHttpRequest, textStatus, errorThrown) { 
			toast("Status: " + textStatus, 4000); 
			toast("Error: " + errorThrown, 4000); 

		} 

	});

}