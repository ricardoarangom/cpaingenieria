// JavaScript Document
var menuVisible = [];
	
menuVisible[1] = 1;
menuVisible[2] = 1;
menuVisible[3] = 1;
menuVisible[4] = 1;
menuVisible[5] = 1;
menuVisible[6] = 1;
menuVisible[7] = 1;
menuVisible[8] = 1;
menuVisible[9] = 1;

function main(id){
	var arregloId = id.split("-");

	if(menuVisible[arregloId[1]]==1){
		$('#nv-'+arregloId[1]).animate({
			left:'0'
		});
		menuVisible[arregloId[1]]=0;
	}else{
		$('#nv-'+arregloId[1]).animate({
			left:'-100%'
		});
		menuVisible[arregloId[1]]=1;
	}
	if(arregloId[1]==1){
		var navegadores = document.querySelectorAll('.navegadores');
		for(var i=0;i<navegadores.length;i++){
			document.getElementById(navegadores[i].id).style.display='none';
		}
	}	
	
};
	
function drsmenu(id){
	var arregloId = id.split("-");
	var arregloHijos = document.querySelectorAll('.children');
	for(var i = 0;i<arregloHijos.length;i++){
		if(arregloHijos[i].id!=arregloId[1]+'-'+arregloId[2]){
			document.getElementById(arregloHijos[i].id).style.display='none';
		}
	}
	$('#'+arregloId[1]+'-'+arregloId[2]).slideToggle();
}


function comprobarAncho(){
	var altoVantana=window.innerHeight;
	var altoContenido=document.documentElement.scrollHeight;
	if (altoContenido>altoVantana){
		$('#pie-pagina').css("position","relative");
	}else{
		$('#pie-pagina').css("position","fixed");
	}
	
}

function visibilizarSuperMenu(menu){
	var navegadores = document.querySelectorAll('.navegadores');		
	for(var i=0;i<navegadores.length;i++){
		document.getElementById(navegadores[i].id).style.display='none';
	}
	document.getElementById('bt-'+menu).style.display='';
	document.getElementById('nv-'+menu).style.display='';
	if(menuVisible[1] ==1){
			$('#nv-1').animate({
				left:'0'
			});
			menuVisible[1] = 0;
		}else{
			menuVisible[1] = 1;
			$('#nv-1').animate({
				left:'-100%'
			});
		}
		document.getElementById('relleno-sm').style.display='none';
}