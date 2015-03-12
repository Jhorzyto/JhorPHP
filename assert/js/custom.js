function carregarModalAjax( link ) {

	$('#ModalAjaxBody').empty();
	$("#ModalAjaxLoad").removeClass("ocultarConteudo");	
	$('#carregarModalAjax').openModal();

	$.ajax({
		url: link ,
		success: function(response) {	

			$("#ModalAjaxLoad").addClass("ocultarConteudo");
			$('#ModalAjaxBody').html(response);
		}
	});

}

function fecharModal( ) {

	$('#carregarModalAjax').closeModal();
	$('#ModalAjaxBody').empty();

}