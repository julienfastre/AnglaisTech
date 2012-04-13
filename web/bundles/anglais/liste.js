

$(document).ready(function() {
   //démarre la fonction pour la première fois après trente seconde
   console.log('démarre script');
   setInterval(operate, 60000);

   
   
});

function operate(){
    

    //récupère la liste des mots cadenassés
    $.getJSON('./../mot/liste/cadenas.json', function(data){
        console.log(data);
        //récupère tous les cadenas infos : 
        var cadenasinfos = $('.cadenasinfo');
        l = cadenasinfos.length; 
        console.log("nombre de cadenasinfo" + l);
        for (var i=0; i<l; i++){
            c = $(cadenasinfos[i]);
            cid = c.attr('id'); console.log(cid);
            if (c.hasClass('cadenas')) {
                
                if (idIsInData(data, cid)) {
                    //si il est aussi dans le tableau, alors on ne fait rien
                    console.log('le mot ' + cid + 'est cadenassé et marqué comme tel, on ne fait rien');
                } else {
                    console.log('il faut réouvrir le mot '+cid);
                    //in n'est pas dans le tableau, il faut le ré-ouvrir
                    c.removeClass('cadenas');
                    c.addClass('ouvert');
                    c.empty();
                    a = $('<a href="./../mot/view/'+cid+'" >Traduire</a>');
                    
                    c.append(a);
                }
            } else if (c.hasClass('ouvert')) {
                
                if (idIsInData(data, cid)) {
                    console.log('le mot '+cid+' vient detre cadenassé');
                    c.empty();
                    c.text('Oui, par ' + getNameInData(data, cid));
                    c.removeClass('ouvert');
                    c.addClass('cadenas');
                } else {
                    //in n'est pas dans le tableau, il ne faut rien faire
                    console.log('le mot ' + cid + 'est cadenassé et marqué comme tel, on ne fait rien');
                }
                
                    
                }
        }
    });
    

}

function idIsInData(data, id) {
    for (o=0; o < data.length; o++){
        if (data[o].id == id) {
            return true;
        }
    }
    
    return false;
}

function getNameInData(data, id) {
    for (o=0; o < data.length; o++){
        if (data[o].id == id) {
            return data[0].user;
        }
    }
}


