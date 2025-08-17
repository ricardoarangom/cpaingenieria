<?php

// Funciones auxiliares para formatear texto
function numeroALetras($numero)
{
    $formatter = new NumberFormatter('es', NumberFormatter::SPELLOUT);
    return ucfirst($formatter->format($numero));
}

function formatearFecha($fecha)
{
    $meses = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $fecha_obj = new DateTime($fecha);
    $dia = $fecha_obj->format('j');
    $mes = $meses[$fecha_obj->format('n') - 1];
    $ano = $fecha_obj->format('Y');
    return "$dia de $mes de $ano";
}

function formatearNumero4Digitos($numero)
{
    // Convierte a entero para asegurar que es un número
    $numero = intval($numero);

    // Usa str_pad para agregar ceros a la izquierda
    return str_pad($numero, 4, '0', STR_PAD_LEFT);
}

// función para separar un numero en miles
function separarMiles($numero)
{
    return number_format($numero, 0, ',', '.');
}