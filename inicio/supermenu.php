<script>

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
	menuVisible[10] = 1;

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
</script>



<header class="hd-sm-menu">
	<div class="grid columna-10 med-columna-1 peq-columna-1" style="grid-row-gap: 0px; grid-column-gap: 0px">
		<div class="span-10  med-span-1 peq-span-1" id="sm-cabecera">			
		</div>
		<div class="span-2" id="sm-div-logo">
			<a href="../inicio/inicio.php">
			<img src="../imagenes/logofa.png" class="img-fluid" alt="Responsive image" width="220"></a>
		</div>
		<div class="span-8 med-span-1 peq-span-1" id="sm-div-nav-pc">
			<div class="sm-menu_bar" id="bt-1" onClick="main(this.id)">
				<a href="#" class="sm-bt-menu"><span class="icon icon-bars"></span>Menu</a>
			</div>
			<nav class="nv-sm-menu" id="nv-1">
				<ul class="nv-ul-pc">
					<?php 
//					if($_SESSION['nivel']<=1 or $_SESSION['nivel']==6 or ($_SESSION['snivel']>=1 and $_SESSION['snivel']<=10)){
						?>
						<li><a href="#" class="a-ppal" onClick="visibilizarSuperMenu('2')">COMPRAS</a></li>	
						<?php
//					}
//					if($_SESSION['nivel']<=1 or $_SESSION['nivel']==6 or $_SESSION['nivel']==3 or $_SESSION['nivel']==5 or $_SESSION['nivel']==4 or  ($_SESSION['snivel']>=1 and $_SESSION['snivel']<=10) or $nivel>=40){
						?>
						<li><a href="#" class="a-ppal" onClick="visibilizarSuperMenu('3')">ANTICIPO GASTOS DE VIAJE</a></li>	
						<?php
//					}
					?>
					<li><a href="#" class="a-ppal" onClick="visibilizarSuperMenu('4')">TIQUETES</a></li>
					<li><a href="#" class="a-ppal" onClick="visibilizarSuperMenu('6')">CARTAS</a></li>
					<!-- <li><a href="#" class="a-ppal" onClick="visibilizarSuperMenu('7')">CONTRATOS</a></li>	 -->
					<?php
					if(($_SESSION['nivel']==3 and $_SESSION['snivel']==1) or $_SESSION['nivel']==0){
						?>
						<li><a href="#" class="a-ppal" onClick="visibilizarSuperMenu('5')">CONFIGURACION</a></li>	
						<?php
					}					
					?>
					<li><a href="../salir.php" class="a-ppal">SALIR</a></li>	
				</ul>	
			</nav>		
		</div>
	</div>
	
	<div id="relleno-sm" style="height: 38.32px;background-color:#84BE3F;">
	
	</div>

	<div class="sm-menu_bar navegadores"  id="bt-2" onClick="main(this.id)" style="display: none" >
		<a href="#" class="sm-bt-menu"><span class="icon icono-bars"></span>COMPRAS</a>
	</div>
	<nav class="nv-sm-menu-se navegadores" id="nv-2" style="display: none">
		<ul class="nv-ul-sc">
			<?php 
				?>
				<li class="submenu" id="sm-2-1" onClick="drsmenu(this.id)">
					<a href="#" class="a-sec">SOLICITUDES</a>
					<ul class="children" id="2-1" valor="0">
						<li><a class="a-sec-ch" href="../compras/creaoc.php">Crear solicitud de compra</a></li>
						<li><a href="../compras/cotizar.php" class="a-sec-ch">Cotizar</a></li>
						<li><a href="../compras/comprar.php" class="a-sec-ch">Comprar</a></li>
						<li><a class="a-sec-ch" href="../compras/recibir.php">Recibir</a></li>							
					</ul>
				</li>
				<?php
				?>
			<li class="submenu" id="sm-2-2" onClick="drsmenu(this.id)">
				<a href="#" class="a-sec">PROVEEDORES</a>
				<ul  class="children" id="2-2" valor="0">					
					<?php 
					if(($_SESSION['nivel']==3 and $_SESSION['snivel']==1) or $_SESSION['nivel']==0){
						?>
						<li><a class="a-sec-ch" href="../compras/regproveedores.php">Agregar proveedor</a></li>
						<li><a class="a-sec-ch" href="../compras/buscaprov.php">Consultar/Editar proveedor</a></li>
						<?php
					}else{
						?>
						<li><a class="a-sec-ch" href="../compras/buscaprov1.php">Consultar</a></li>	
						<?php
					}
					?>
				</ul>
			</li>			
			<li class="submenu" id="sm-2-3" onClick="drsmenu(this.id)">				
				<a href="#" class="a-sec">REPORTES</a>
				<ul class="children" id="2-3">							
					<li><a class="a-sec-ch" href="../compras/estcotoc1.php">Solicitudes de compra</a></li>
					<li><a class="a-sec-ch" href="../compras/listaoc.php">Ordenes de compra</a></li>			
				</ul>
			</li>					
			<li class="submenu" id="sm-2-6">
				<?php
				if($nivel==1 or $nivel==0){
					?>
					<a href="../compras/autorizarsc.php" class="a-sec">AUTORIZAR</a>
					<?php
				}
				?>
			</li>
		</ul>
	</nav>

	<div class="sm-menu_bar navegadores"  id="bt-3" onClick="main(this.id)" style="display: none" >
		<a href="#" class="sm-bt-menu"><span class="icon icono-bars"></span>GASTOS DE VIAJE</a>
	</div>
	<nav class="nv-sm-menu-se navegadores" id="nv-3" style="display: none">
		<ul class="nv-ul-sc">
			<li class="submenu" id="sm-3-1" onClick="drsmenu(this.id)">
				<a class="a-sec" href="#">SOLICITUD DE ANTICIPO GASTOS DE VIAJE</a>
				<ul class="children" id="3-1" valor="0">
						<li><a class="a-sec-ch" href="../gviaje/solicitud.php">Solicitar</a></li>
						<?php
						if(($_SESSION['nivel']==3 and $_SESSION['snivel']==1) or $_SESSION['nivel']==0){
							?>
							<li><a href="../gviaje/edita.php" class="a-sec-ch">Editar</a></li>
							<?php
						}
						?>
						
				</ul>
			</li>
      <li class="submenu" id="sm-3-2">
        <a class="a-sec" href="../gviaje/reporte.php">REPORTE</a>
      </li>
			<!--<li class="submenu" id="sm-3-2" onClick="drsmenu(this.id)"> 
				<a class="a-sec" href="#">REPORTES</a>
				<ul class="children" id="3-2">
					<li><a href="#" class="a-sec-ch">Reporte 1</a></li>
					<li><a href="#" class="a-sec-ch">Reporte 2</a></li>											
				</ul>
			</li>-->
			<?php
			if($nivel==3 or $nivel==0){
			  ?>
			  <li class="submenu" id="sm-3-3">
				<a href="../gviaje/girargv.php" class="a-sec">PAGAR</a>
			  </li>
			  <?php
			}
			?>			
			<?php
			if($nivel==1 or $nivel==0){
			  ?>
			  <li class="submenu" id="sm-3-4"> 				
				<a href="../gviaje/autorizargv.php" class="a-sec">AUTORIZAR</a>					
			  </li>
			  <?php
			  }
			  ?>
			  <?php
			if($nivel==1 or $nivel==0){
			  ?>
			  <li class="submenu" id="sm-3-5"> 
				<a href="../gviaje/tablaGas.php" class="a-sec">TABLA DE GASTOS</a>
			  </li>
			  <?php
			}
			?>
		</ul>
	</nav>
	
	<div class="sm-menu_bar navegadores"  id="bt-4" onClick="main(this.id)" style="display: none">
		<a href="#" class="sm-bt-menu"><span class="icon icono-bars"></span>TIQUETES</a>
	</div>
	<nav  class="nv-sm-menu-se navegadores" id="nv-4" style="display: none">
	  <ul class="nv-ul-sc">
		<li class="submenu" id="sm-4-1">
		  <a class="a-sec" href="../tiquetes/soltiquetes.php">SOLICITUD</a>
		</li>
		<li class="submenu" id="sm-4-2">
		  <a class="a-sec" href="../tiquetes/estadotiquetes.php">TRAMITE</a>
		</li>
    <li class="submenu" id="sm-4-3">
		  <a class="a-sec" href="../tiquetes/reporte.php">REPORTE</a>
		</li>
	  </ul>
	</nav>
	
	<div class="sm-menu_bar navegadores"  id="bt-6" onClick="main(this.id)" style="display: none">
		<a href="#" class="sm-bt-menu"><span class="icon icono-bars"></span>CARTAS</a>
	</div>
	<nav  class="nv-sm-menu-se navegadores" id="nv-6" style="display: none">
	  <ul class="nv-ul-sc">
		<li class="submenu" id="sm-6-1">
		  <a class="a-sec" href="../cartas/creacarta.php">CREAR</a>
		</li>
    <li class="submenu" id="sm-6-2">
		  <a class="a-sec" href="../cartas/reporte.php">REPORTE</a>
		</li>
	  </ul>
	</nav>

	<div class="sm-menu_bar navegadores"  id="bt-7" onClick="main(this.id)" style="display: none">
		<a href="#" class="sm-bt-menu"><span class="icon icono-bars"></span>CARTAS</a>
	</div>
	<nav  class="nv-sm-menu-se navegadores" id="nv-7" style="display: none">
	  <ul class="nv-ul-sc">
		<li class="submenu" id="sm-7-1">
		  <a class="a-sec" href="../contratos/creacontrato.php">CREAR</a>
		</li>
    <li class="submenu" id="sm-7-2">
		  <a class="a-sec" href="../contratos/reporte.php">REPORTE</a>
		</li>
	  </ul>
	</nav>
	
	
	<div class="sm-menu_bar navegadores"  id="bt-5" onClick="main(this.id)" style="display: none">
		<a href="#" class="sm-bt-menu"><span class="icon icono-bars"></span>CONFIGURACION</a>
	</div>
	<nav class="nv-sm-menu-se navegadores" id="nv-5" style="display: none">
		<ul class="nv-ul-sc">
			<li class="submenu" id="sm-5-1" onClick="drsmenu(this.id)">
				<a href="#" class="a-sec">OPCIONES</a>
				<ul class="children" id="5-1">					
					<li><a href="../configuracion/actualiz.php" class="a-sec-ch">Crear proyecto/area</a></li>
					<li><a href="../configuracion/rubrosprov.php" class="a-sec-ch">Clasificación de proveedores</a></li>
				</ul>
			</li>
		</ul>	
	</nav>
</header>