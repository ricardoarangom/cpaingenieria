//https://datos.gov.co/resource/g373-n3yy.json



function conseguirLugares(){
	
	let lugaresInfo = []

	fetch('ubicaciones.php?proceso=2')
	.then(response => response.json())
	.then(lugares => {
		
		var result = [];
		for(var i in lugares){
			result.push([i, lugares [i]]);
		}

		result.forEach(function(elemento){
		
			let lugarInfo = {
				posicion:{lat:parseFloat(elemento[1][1]),lng:parseFloat(elemento[1][2])},
				nombre:elemento[1][0]
		}

			lugaresInfo.push(lugarInfo)
		
		})

		let ubicacion = lugaresInfo[0]['posicion']
		dibujarMapa(ubicacion,lugaresInfo)			
		
	})

}

function dibujarMapa (obj,lugaresInfo) {
	var mapa = new google.maps.Map(document.getElementById('map'),{
		center:obj,
		zoom:12,
		mapTypeId:google.maps.MapTypeId.HYBRID,
		mapTypeControl:false
	})
	let marcadorUsuario = new google.maps.Marker({
		position:obj,
		title:'Tu Ubicacion'
	})
	marcadorUsuario.setMap(mapa)
	let marcadores = lugaresInfo.map(lugar =>{
		return new google.maps.Marker({
			position:lugar.posicion,
			title:lugar.nombre,
			map:mapa
		})
	})

}

conseguirLugares()