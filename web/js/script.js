
$(document).ready(start);
function start() {
	
	/*$('.metier').on('dragstart', function(event) {
			event.originalEvent.dataTransfer.setData("Text", event.target.id);
			console.log(event.originalEvent); console.log(event.target.id);
			$(event.target).addClass('is_dragged');
		});*/

	$('.metier').on('dragend', function(event) {
			$(event.target).removeClass('is_dragged');
			console.log('dragend');
		});

	$('.zone_drop').on('drop', function(event) {
			console.log('dropped'); 
			var el = $('#'+event.originalEvent.dataTransfer.getData('Text'));
			el.removeClass('is_dragged');
			el.remove();
			$(this).append(el);
			$(this).removeClass('drag_is_over');
			return false;
			
					
		});
	$('.zone_drop').on('dragenter', function(event) {
			event.originalEvent.preventDefault();	
			$(this).addClass('drag_is_over');
		
		});
	$('.zone_drop').on('dragover', function(event) {
			console.log('dragover');
			event.originalEvent.preventDefault();

		});
	$('.zone_drop').on('dragleave', function(event) {
			$(this).removeClass('drag_is_over');
			console.log('dragleave');
		});

	$('.verification_button').on('click', function(event) {
			verif = $('.zone_verif');
			
			for (var i = 0; i < verif.length; i++) {
				//retire les classes d'une précédente vérification
				$(verif[i]).removeClass('error correct');
				
				//s'il n'y a rien, c'est faux...
				if ($(verif[i]).children().length == 0 || $(verif[i]).children().length > 1 ) {
					$(verif[i]).addClass('error');
				} else  {
					repa = $(verif[i]).children()[0];
					rep = $(repa).attr('match_a');
					console.log($(verif[i]).attr('match_q'));
					console.log('enfant : ' + rep );
					if (rep == $(verif[i]).attr('match_q')) 
					{
						$(verif[i]).addClass('correct');
					} else {
						$(verif[i]).addClass('error');

					}
				}
			}
		});
	
	

}





function drag(target, event) {
	event.dataTransfer.effectAllowed = 'move';	
	event.dataTransfer.setData("Text", target.id);
	console.log(event);
	$(target).addClass('is_dragged');
}
