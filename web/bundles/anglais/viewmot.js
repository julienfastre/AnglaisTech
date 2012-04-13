$(document).ready(function() {
   //démarre la fonction pour la première fois après trente seconde
   console.log('démarre script');
   setInterval(operate, 30000);

   
   
});


function operate(){
    $.getJSON('./../../mot/refreshcadenas/'+id, function(data){
        if (data.result == true){
            
        } else {
            alert('revenez à la liste, il y a un problème');
        }
    });
}

