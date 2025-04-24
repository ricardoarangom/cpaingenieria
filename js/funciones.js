// JavaScript Document
function cambiaFecha(fecha){
  
  var fecha1 = fecha.split(' ');
  var fecha2 = fecha1[0].split('-');
  var fecha3 = fecha1[1].split(':');
  
  if(fecha2[1]==1){
    var mes = "Ene"
  }else if(fecha2[1]==2){
    var mes = "Feb"
  }else if(fecha2[1]==3){
    var mes = "Mar"
  }else if(fecha2[1]==4){
    var mes = "Abr"
  }else if(fecha2[1]==5){
    var mes = "May"
  }else if(fecha2[1]==6){
    var mes = "Jun"
  }else if(fecha2[1]==7){
    var mes = "Jul"
  }else if(fecha2[1]==8){
    var mes = "Ago"
  }else if(fecha2[1]==9){
    var mes = "Sep"
  }else if(fecha2[1]==10){
    var mes = "Oct"
  }else if(fecha2[1]==11){
    var mes = "Nov"
  }else if(fecha2[1]==12){
    var mes = "Dic"
  }

  var nfecha = fecha2[2]+"-"+mes+"-"+fecha2[0]+" "+fecha3[0]+":"+fecha3[1];
  
  return nfecha;
}

function aMayusculas(obj,id){
  obj=obj.replace(/–/g,'-');
  obj=obj.replace(/“/g,'"');
  obj=obj.replace(/”/g,'"');
  obj=obj.replace(/´/g,'');
  obj = obj.toUpperCase();
  document.getElementById(id).value = obj;
}