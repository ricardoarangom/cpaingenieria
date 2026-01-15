<?php
require_once('../connections/datos.php');
require_once '../phpword/src/PhpWord/Autoloader.php';
require_once('../contratos/funciones-contratos-prestacion-servicios.php');

set_time_limit(0);

session_start();
$usuario = $_SESSION['IdUsuario'];

if (isset($_GET['contrato'])) {
    $IdContrato = $_GET['contrato'];
} else {
    $IdContrato = 1;
}

// Consultas a la base de datos
$queryContrato = "SELECT 
                    IdContrato, 
                    contratistas.IdContratista,
                    contratistas.proveedor, 
                    areas.IdArea, 
                    areas.area, 
                    IdSolicitante, 
                    IdClase, 
                    IdSubClase,
                    municipios.municipio AS ciudadResidencia,
                    departamentos.departamentos AS departamentoResidencia,
                    municipios2.municipio AS ciudadNac,
                    departamentos2.departamentos AS departamentoNac,
                    clasedocsi.IdClasedoc,
                    clasedocsi.codigo AS codClasedoc,
                    clasedocsi.nombre AS nombreClasedoc,
                    contratistas.documento, 
                    contratistas.telefono, 
                    contratistas.direccion,
                    contratistas.replegal AS representanteLegal,
                    contratistas.docrep AS documentoRepresentante,
                    clasedocsirep.IdClasedoc AS IdClasedocRep,
                    clasedocsirep.codigo AS codClasedocRep,
                    clasedocsirep.nombre AS nombreClasedocRep,
                    objeto, 
                    finicio, 
                    ffin, 
                    iva, 
                    consec, 
                    valor, 
                    integral, 
                    cargos.IdCargo, 
                    cargos.cargo AS cargoContrato, 
                    incs, 
                    especialidad, 
                    grupo, 
                    centrofor, 
                    alcance, 
                    ffinfin, 
                    lugar, 
                    auxilio,
                    IdFirmante 
                FROM
                    contrat 
                LEFT JOIN contratistas ON contrat.IdProveedor = contratistas.IdContratista 
                LEFT JOIN areas ON contrat.IdArea = areas.IdArea
                LEFT JOIN municipios ON contratistas.ciudad = municipios.IdMunicipio
                LEFT JOIN departamentos ON contratistas.departamento = departamentos.IdDepartamento
                LEFT JOIN municipios AS municipios2 ON contratistas.ciudadn = municipios2.IdMunicipio
                LEFT JOIN departamentos AS departamentos2 ON contratistas.departamenton = departamentos2.IdDepartamento
                LEFT JOIN cargos ON contrat.IdCargo = cargos.IdCargo 
                LEFT JOIN clasedocsi ON contratistas.IdClasedoc = clasedocsi.IdClasedoc 
                LEFT JOIN clasedocsi AS clasedocsirep ON contratistas.IdClasedocrep = clasedocsirep.IdClasedoc
                WHERE
                    IdContrato = " . $IdContrato . " limit 1";
$resultadoContrato = mysql_query($queryContrato, $datos) or die(mysql_error());
$filaContrato = mysql_fetch_assoc($resultadoContrato);

$buscaActividades = "SELECT IdActividad, actividad FROM actividadescont WHERE IdContrato = " . $IdContrato . " ORDER BY IdActividad ASC";
$resultadoActividades = mysql_query($buscaActividades, $datos) or die(mysql_error());

$buscaProductos = "SELECT IdProducto, producto FROM productoscont WHERE IdContrato = " . $IdContrato . " ORDER BY IdProducto ASC";
$resultadoProductos = mysql_query($buscaProductos, $datos) or die(mysql_error());

$buscaFormaPagos = "SELECT IdFroma, porpago, concepto FROM formapagocont WHERE IdContrato = " . $IdContrato . " ORDER BY IdFroma ASC";
$resultadoFormaPagos = mysql_query($buscaFormaPagos, $datos) or die(mysql_error());

\PhpOffice\PhpWord\Autoloader::register();

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\IOFactory;

// Crear nuevo documento
$documento = new PhpWord();

$documento->addParagraphStyle('NoSpaceAfter', [
    'spaceAfter' => 0,          // Espaciado posterior a 0 twips
    'spaceBefore' => 0,         // Opcional: también puedes poner el espacio anterior a 0
    'lineHeight' => 1.0       // Opcional: altura de línea estándar
    
]);

// Configurar sección con márgenes
$seccion = $documento->addSection([
    'marginTop'    => Converter::cmToTwip(2.5),
    'marginBottom' => Converter::cmToTwip(2.5),
    'marginLeft'   => Converter::cmToTwip(2.5),
    'marginRight'  => Converter::cmToTwip(2.5)
]);

// Agregar encabezado y pie de página si existen las imágenes
$header = $seccion->addHeader();
if (file_exists('../imagenes/encabezado.png')) {
    $header->addImage('../imagenes/encabezado.png', ['width' => 600, 'height' => 100, 'alignment' => 'center']);
}

// $footer = $seccion->addFooter();
// if (file_exists('../imagenes/pie.png')) {
//     $footer->addImage('../imagenes/pie.png', ['width' => 600, 'height' => 50, 'alignment' => 'center']);
// }

// Estilos de fuente
$estiloTitulo = ['bold' => true, 'size' => 11, 'name' => 'Arial', 'smallCaps' => true];
$estiloNormal = ['size' => 11, 'name' => 'Arial'];
$estiloNegrita = ['bold' => true, 'size' => 11, 'name' => 'Arial'];
$estiloResaltado = ['size' => 11, 'name' => 'Arial'];

// Título del contrato
$seccion->addText("\t\t\tCONTRATO POR PRESTACIÓN DE SERVICIOS", $estiloTitulo, ['alignment' => 'center', 'spaceAfter' => 10]);


// Número de contrato
$numeroContrato = "No. " . sprintf("%03d",$filaContrato['consec']) . '-' . date('Y', strtotime($filaContrato['finicio']));
$textRun = $seccion->addTextRun(['alignment' => 'center', 'spaceAfter' => 240]);
$textRun->addText("\t\t\t\t\t     ", $estiloNormal);
$textRun->addText($numeroContrato, ['bold' => true, 'size' => 11, 'name' => 'Arial', 'smallCaps' => true]);

// Párrafo introductorio
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120]);
$textRun->addText('Entre los suscritos ', $estiloNormal);
$textRun->addText('LUIS HECTOR RUBIANO VERGARA', $estiloNegrita);
$textRun->addText(' identificado con la cédula de ciudadanía No. 79.315.619 expedida en Bogotá D.C., domiciliado en la calle 106 No. 59-21 en la ciudad de Bogotá D.C., actuando en nombre y representación de ', $estiloNormal);
$textRun->addText('COMPAÑÍA DE PROYECTOS AMBIENTALES E INGENIERÍA S.A.S. – CPA INGENIERÍA S.A.S.', $estiloNegrita);
$textRun->addText(' con NIT 830.042.614-3, sociedad domiciliada en la ciudad de Bogotá D.C., y quien en adelante se denominará EL CONTRATANTE, por la otra, ', $estiloNormal);

// Información del representante legal
if (!empty($filaContrato['representanteLegal'])) {
    $textRun->addText(strtoupper($filaContrato['representanteLegal']), ['bold' => true, 'size' => 11, 'name' => 'Arial']);
    $textRun->addText(' identificado con ' . $filaContrato['nombreClasedocRep'], $estiloNormal);
    $textRun->addText(' No. ' . separarMiles($filaContrato['documentoRepresentante']), $estiloNormal);
} else {
    $textRun->addText('[NOMBRES Y APELLIDOS]', ['bold' => true, 'size' => 11, 'name' => 'Arial']);
    $textRun->addText(' identificado con NIT. ', $estiloNormal);
    $textRun->addText('[No. XXXXXXX de Bogotá D.C.]', $estiloNormal);
}

$textRun->addText(', actuando en nombre y representación de ', $estiloNormal);
$textRun->addText(strtoupper($filaContrato['proveedor']), $estiloNegrita);
$textRun->addText(' identificada con ', $estiloNormal);
$textRun->addText($filaContrato['codClasedoc'] . ' ' . separarMiles($filaContrato['documento']), $estiloNormal);
$textRun->addText(', con domicilio en la ', $estiloNormal);
$textRun->addText($filaContrato['direccion'] . ' en la ciudad de ' . $filaContrato['ciudadResidencia'] . ' ' . $filaContrato['departamentoResidencia'], $estiloNormal);
$textRun->addText(' quien para efectos del presente documento se denominará EL CONTRATISTA, acuerdan celebrar el presente contrato de Prestación de Servicios Profesionales, el cual se regirá por las disposiciones del Código de Comercio y en especial por las siguientes cláusulas:', $estiloNormal);

// CLÁUSULA PRIMERA - OBJETO
$seccion->addText('Primera. – OBJETO. ', $estiloNegrita, ['spaceAfter' => 60, 'spaceBefore' => 300]);
$seccion->addText($filaContrato['objeto'], $estiloNormal, ['alignment' => 'both', 'spaceAfter' => 120]);

// ALCANCE
$seccion->addText('ALCANCE:', $estiloNegrita, ['spaceAfter' => 60, 'spaceBefore' => 300]);
if (!empty($filaContrato['alcance'])) {
    $seccion->addText($filaContrato['alcance'], $estiloNormal, ['alignment' => 'both', 'spaceAfter' => 120]);
} else {
    $seccion->addText('No se especifica.', $estiloNormal, ['alignment' => 'both', 'spaceAfter' => 120]);
}

// ACTIVIDADES
$seccion->addText('ACTIVIDADES:', $estiloNegrita, ['spaceAfter' => 60, 'spaceBefore' => 300]);
if (mysql_num_rows($resultadoActividades) > 0) {
    mysql_data_seek($resultadoActividades, 0);
    $contador = 1;
    while ($actividad = mysql_fetch_assoc($resultadoActividades)) {
        $seccion->addText(
            $contador . '. ' . $actividad['actividad'],
            $estiloNormal,
            ['alignment' => 'both', 'indentation' => ['left' => 360], 'spaceAfter' => 60]
        );
        $contador++;
    }
} else {
    // Placeholder si no hay actividades
    $seccion->addText(
        'No se especifican actividades.',
        $estiloNormal,
        ['alignment' => 'both', 'indentation' => ['left' => 360], 'spaceAfter' => 60]
    );
}

// PRODUCTOS
$seccion->addText('PRODUCTOS:', $estiloNegrita, ['spaceAfter' => 60, 'spaceBefore' => 300]);
if (mysql_num_rows($resultadoProductos) > 0) {
    mysql_data_seek($resultadoProductos, 0);
    $contador = 1;
    while ($producto = mysql_fetch_assoc($resultadoProductos)) {
        $seccion->addText(
            $contador . '. ' . $producto['producto'],
            $estiloNormal,
            ['alignment' => 'both', 'indentation' => ['left' => 360], 'spaceAfter' => 60]
        );
        $contador++;
    }
} else {
    // Placeholder si no hay productos
    $seccion->addText(
        'No se especifican productos.',
        $estiloNormal,
        ['alignment' => 'both', 'indentation' => ['left' => 360], 'spaceAfter' => 60]
    );
}

// CLÁUSULA SEGUNDA - PLAZO
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Segunda. – Plazo. ', $estiloNegrita);
if (!empty($filaContrato['finicio']) && !empty($filaContrato['ffin'])) {
    $textRun->addText('El plazo para la ejecución del presente contrato será desde el día ' . formatearFecha($filaContrato['finicio']) . ' hasta el día ' . formatearFecha($filaContrato['ffin']) . '.', $estiloNormal);
} else {
    $textRun->addText('[El plazo para la ejecución del presente contrato será desde el día XXXXX (XXXXX) de XXXXXX del año XXXXXX hasta el día XXXXX (XXXXX) de XXXXX del año XXXXXX.]', $estiloNormal);
}

// CLÁUSULA TERCERA - VALOR
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Tercera. – Valor. ', $estiloNegrita);

$valorTotal = $filaContrato['valor'];
$textIVA = '';
$valorTotal = $valorTotal * (1 + floatval($filaContrato['iva'])); // Asumiendo IVA del 19%
$textIVA = ($filaContrato['iva'] > 0) ? ', IVA incluido' : ', antes de IVA';

if (!empty($filaContrato['valor'])) {
    $valorLetras = numeroALetras($valorTotal);
    $textRun->addText('El valor total del presente contrato es de: (COP$' . separarMiles($valorTotal) . ') ' . $valorLetras . ' Pesos Moneda Corriente' . $textIVA . '.', $estiloNormal);
} else {
    $textRun->addText('[El valor total del presente contrato es de: (COP$XXXXXXXXXXX) [XXXXXXXXXXXXXXXXXXXXXXXXXXXXX] Pesos Moneda Corriente, IVA incluido.]', $estiloNormal);
}

// CLÁUSULA CUARTA - FORMA DE PAGO
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Cuarta. – Forma de Pago.: ', $estiloNegrita);

if (mysql_num_rows($resultadoFormaPagos) > 0) {
    $numeroPagos = mysql_num_rows($resultadoFormaPagos);
    $nombresPagos = ['Primer', 'Segundo', 'Tercer', 'Cuarto', 'Quinto', 'Sexto', 'Séptimo', 'Octavo', 'Noveno', 'Décimo'];
    
    mysql_data_seek($resultadoFormaPagos, 0);
    if (mysql_num_rows($resultadoFormaPagos) == 1) {
        $pago = mysql_fetch_assoc($resultadoFormaPagos);
        // Un solo pago
        $valorLetras = numeroALetras($valorTotal);
        $textRun->addText('Se realizará un único pago por valor de: (COP$' . separarMiles($valorTotal) . ') ' . $valorLetras . ' Pesos Moneda Corriente' . $textIVA . '. ', $estiloNormal);
        $textRun->addText('Correspondientes al 100% del valor total del contrato; ', $estiloNormal);
        $textRun->addText($pago['concepto'], $estiloNormal);
        $textRun->addText('; previa aprobación por parte de la coordinación del proyecto; 30 días posteriores a la radicación de la factura o cuenta de cobro.', $estiloNormal);
    } else {
        // Múltiples pagos
        $contador = 0;
        $seccion->addText('Se realizarán ' . numeroALetras($numeroPagos) . ' (' . $numeroPagos . ') pagos así:', 
        $estiloNormal, ['alignment' => 'both', 'spaceAfter' => 120]);
        while ($pago = mysql_fetch_assoc($resultadoFormaPagos)) {
            $valorPago = $valorTotal * $pago['porpago'];
            $porcentaje = $pago['porpago'] * 100;
            $valorLetras = numeroALetras($valorPago);
            $textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120]);
            $textRun->addText($nombresPagos[$contador] . ' Pago: ', ['bold' => true, 'underline' => 'single', 'size' => 11, 'name' => 'Arial']);
            $textRun->addText('Por valor de: (COP$ ' . number_format($valorPago, 0, ',', '.') . ') ' .
                numeroALetras($valorPago) . ' Pesos Moneda Corriente' . $textIVA . '; ', $estiloNormal);
            $textRun->addText('Correspondientes al ' . $porcentaje . '% del valor total del contrato; ', $estiloNormal);
            $textRun->addText($pago['concepto'], $estiloNormal);
            $textRun->addText('; previa aprobación por parte de la coordinación del proyecto; 30 días posteriores a la radicación de la factura o cuenta de cobro.', $estiloNormal);
            $contador++;
        }
    }
} else {
    
    // Un solo pago
    $valorLetras = numeroALetras($valorTotal);
    $textRun->addText('Se realizará un único pago por valor de: (COP$' . separarMiles($valorTotal) . ') ' . $valorLetras . ' Pesos Moneda Corriente' . $textIVA . '. ', $estiloNormal);
    $textRun->addText('Correspondientes al 100% del valor total del contrato; ', $estiloNormal);
    $textRun->addText('previa aprobación por parte de la coordinación del proyecto; 30 días posteriores a la radicación de la factura o cuenta de cobro.', $estiloNormal);
}

$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Parágrafo', $estiloNegrita);
$textRun->addText(': La factura o cuenta de cobro deberá ser radicada antes del 25 de cada mes, adjuntando la planilla de seguridad social correspondiente.', $estiloNormal);

// CLÁUSULA QUINTA - OBLIGACIONES DEL CONTRATANTE
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Quinta. - Obligaciones de EL CONTRATANTE.', $estiloNegrita);
$textRun->addText(' Este deberá facilitar acceso a la información que sea necesaria, de manera oportuna, para la debida ejecución del objeto del contrato y estará obligado a cumplir con lo estipulado en las demás cláusulas y condiciones previstas en este documento.', $estiloNormal);

// CLÁUSULA SEXTA - OBLIGACIONES DEL CONTRATISTA
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Sexta. - Obligaciones de EL CONTRATISTA.', $estiloNegrita);
$textRun->addText(' EL CONTRATISTA deberá cumplir en forma eficiente y oportuna los trabajos encomendados y aquellas obligaciones que se generen en la reunión de planificación o de seguimiento cumpliendo las fechas de entrega programadas. ', $estiloNormal);
$textRun->addText('Parágrafo', $estiloNegrita);
$textRun->addText(': El contratista deberá cumplir cabalmente con sus obligaciones frente al sistema de seguridad social integral de acuerdo a las leyes vigentes.', $estiloNormal);

// CLÁUSULA SÉPTIMA - VIGILANCIA
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Séptima. – Vigilancia del contrato', $estiloNegrita);
$textRun->addText('. EL CONTRATANTE o su representante supervisarán la ejecución del servicio profesional encomendado, y podrá formular las observaciones del caso con el fin de ser analizadas conjuntamente con EL CONTRATISTA y efectuar por parte de éste las modificaciones o correcciones a que hubiere lugar.', $estiloNormal);

// CLÁUSULA OCTAVA - CLÁUSULA PENAL
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Octava. – Cláusula penal.', $estiloNegrita);
$textRun->addText(' En caso de incumplimiento por parte de EL CONTRATISTA de cualquiera de las obligaciones previstas en este contrato no se cancelará el pago final de acuerdo a lo establecido en la Cláusula Cuarta y deberá pagar una indemnización del 50% del presente Contrato más gastos jurídicos.', $estiloNormal);

// CLÁUSULA NOVENA - TERMINACIÓN
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Novena. - Terminación.', $estiloNegrita);
$textRun->addText(' El presente contrato podrá darse por terminado por mutuo acuerdo entre las dos partes, o en forma unilateral por el incumplimiento de las obligaciones derivadas del contrato por cualquiera de ellas y/o por EL CONTRATANTE cuando por razones externas, el proyecto se suspenda o se cancele antes de la fecha pactada.', $estiloNormal);

// CLÁUSULA DÉCIMA - INDEPENDENCIA
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Décima. Independencia de EL CONTRATISTA.', $estiloNegrita);
$textRun->addText(' EL CONTRATISTA actuará por su propia cuenta, con absoluta autonomía y no estará sometido a subordinación laboral con EL CONTRATANTE y sus derechos se limitarán, de acuerdo con la naturaleza del contrato, a exigir el cumplimiento de las obligaciones de EL CONTRATANTE y al pago de los honorarios estipulados por la prestación del servicio.', $estiloNormal);

// CLÁUSULA DÉCIMA PRIMERA - EXCLUSIÓN RELACIÓN LABORAL
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Décima primera. – Exclusión de la relación laboral', $estiloNegrita);
$textRun->addText('. Queda claramente entendido que no existirá relación laboral alguna entre EL CONTRATANTE Y CONTRATISTA, o el personal que éste utilice en la ejecución del objeto del presente contrato.', $estiloNormal);

// CLÁUSULA DÉCIMA SEGUNDA - CESIÓN
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Décima segunda. – Cesión del contrato.', $estiloNegrita);
$textRun->addText(' EL CONTRATISTA no podrá ceder parcial ni totalmente la ejecución del presente contrato a un tercero salvo previa autorización expresa y escrita de EL CONTRATANTE.', $estiloNormal);

// CLÁUSULA DÉCIMA TERCERA - DOMICILIO
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Décima tercera.', $estiloNegrita);
$textRun->addText(' – ', $estiloNormal);
$textRun->addText('Domicilio contractual', $estiloNegrita);
$textRun->addText('. Para todos los efectos legales, el domicilio contractual será la ciudad de Bogotá y las notificaciones serán recibidas por las partes en las siguientes direcciones: por EL CONTRATANTE en la calle 106 No.59-21 en la ciudad de Bogotá D.C.; EL CONTRATISTA en la ', $estiloNormal);
if (!empty($filaContrato['direccion'])) {
    $textRun->addText($filaContrato['direccion'] . ' en la ciudad de ' . $filaContrato['ciudadResidencia'] . ' ' . $filaContrato['departamentoResidencia'], $estiloNormal);
} else {
    $textRun->addText('[Carrera 19 #31C-32 Sur en la ciudad de Bogotá D.C]', $estiloNormal);
}
$textRun->addText('.', $estiloNormal);

// CLÁUSULA COMPROMISORIA
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Cláusula compromisoria.', $estiloNegrita);
$textRun->addText(' Todas las dudas, cuestiones, discrepancias o reclamaciones que puedan surgir en la interpretación, ejecución o cumplimiento de este acuerdo, o relacionada con él, directa o indirectamente, se resolverán en primer lugar de forma amistosa en la medida de lo posible, mediante negociación directa de las partes, dentro del plazo de quince (15) días a partir de la fecha en que cualquiera de las partes informe a la otra sobre la existencia de una controversia o desavenencia, a falta de un acuerdo en el plazo de un (1) mes o dentro de la prórroga otorgada al mismo, acordada entre las partes, la controversia se resolverá definitivamente mediante arbitraje de derecho ante un Centro de Conciliación, de acuerdo con su reglamento, cuyas disposiciones se entienden incorporadas por referencia de esta cláusula.', $estiloNormal);

// CLÁUSULA DÉCIMA CUARTA - PROTECCIÓN DE DATOS
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Decima Cuarta: Protección De Datos Personales', $estiloNegrita);
$textRun->addText(': En atención de lo previsto en la normatividad vigente sobre Tratamiento de Datos Personales (Constitución Política de Colombia, Ley Estatutaria 1581 de 2012, Decreto 1377 de 2013 y las demás disposiciones que en el futuro las adicionen, modifiquen o complementen), tanto EL CONTRATANTE como EL CONTRATISTA declaran que dan estricto cumplimiento a la normatividad citada y en concordancia, LAS PARTES cuentan con políticas, procedimientos y controles propios para el tratamiento de datos personales. EL CONTRATISTA autoriza a EL CONTRATANTE para que lleve a cabo la recolección, almacenamiento, uso, circulación, supresión, transferencia y transmisión (en adelante el “Tratamiento”) de los datos personales (teléfono fijo, celular, e-mail, dirección y ciudad, entre otros), incluidos los datos biométricos y de imagen obtenidos y registrados que se obtengan y/o se suministren con ocasión del presente contrato de sus  empleados, consultores, asesores, socios, encargados y administradores (en adelante, colaboradores). EL CONTRATISTA autoriza a EL CONTRATANTE a Consultar y Reportar, en cualquier tiempo, en Data Crédito o en cualquier otra base de datos manejada por un operador de información financiera y crediticia, toda la información relevante para conocer su desempeño como deudor, su capacidad de pago sobre el cumplimiento o incumplimiento de sus obligaciones crediticias, la viabilidad para entablar o mantener una relación contractual. EL CONTRATISTA, en virtud de la presente relación contractual, otorga Autorización expresa a EL CONTRATANTE para que lleve a cabo el tratamiento de los datos personales de sus colaboradores para efectos del cumplimiento del objeto contractual, sean tratados de acuerdo a las finalidades, procedimientos y en general, las disposiciones de la Política de Privacidad para el Tratamiento de Datos Personales de EL CONTRATANTE. Los datos que sean recolectados por EL CONTRATANTE podrán ser comunicados por su cuenta a otros miembros de la Organización. Durante la vigencia de la relación contractual y mientras exista el deber legal, los datos recolectados permanecerán en nuestra base de datos de conformidad con lo previsto en la Política de Privacidad para el Tratamiento de Datos Personales de EL CONTRATANTE. De la misma manera, EL CONTRATANTE podrá llevar a cabo el tratamiento de la información personal de EL CONTRATISTA con la finalidad de enviarles información comercial que pueda ser de su interés; así como, invitarlos a eventos, remitir boletines, informes sectoriales o publicaciones y en general, utilizar los datos para el desarrollo de las actividades comprendidas en el objeto social de SIMPLE. Tanto EL CONTRATANTE como EL CONTRATISTA serán responsables por cualquier perjuicio que se cause a la otra parte como consecuencia directa o indirecta del incumplimiento de cualquiera de las obligaciones que se desprenden de la presente cláusula.', $estiloNormal);

// CLÁUSULA DÉCIMA QUINTA - CLAUSULAS ADICIONALES
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Décima Quinta. – CLAUSULAS ADICIONALES:', $estiloNegrita);
$textRun->addText(' Es obligación del CONTRATISTA no divulgar aquella información que se le haya confiado en virtud del secreto profesional o aquella que deba ser mantenida en reserva por su carácter de confidencial, lo cual haya tenido noticia por cualquier circunstancia, excepción hecha de aquello que el Trabajador deba informar por razones de ley o providencias judiciales. Entiéndase por información confidencial aquella información societaria, técnica, financiera, jurídica, comercial y estratégica de los negocios del Empleador, presentes o futuros. ', $estiloNormal);

// Párrafo de cierre
$seccion->addText(
    'Una vez leído, entendido y aprobado por las partes el presente contrato, se firma sin que adolezca de error, fuerza o dolo.',
    $estiloNormal,
    ['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]
);

// Fecha de firma
$fechaActual = new DateTime($filaContrato['finicio']);
$diaLetras = numeroALetras($fechaActual->format('j'));
$mesActual = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
$mes = $mesActual[$fechaActual->format('n') - 1];
$ano = $fechaActual->format('Y');

$textoFecha = "Para constancia del pleno acuerdo sobre los términos referidos en este contrato, se firma en dos (2) ejemplares del mismo tenor y valor a los $diaLetras ({$fechaActual->format('j')}) días del mes de $mes del año $ano en la ciudad de Bogotá D.C.";
$seccion->addText($textoFecha, $estiloNormal, ['alignment' => 'both', 'spaceAfter' => 360]);

$seccion->addText('', $estiloNormal, ['spaceAfter' => 800]);

// Líneas de firma
$seccion->addText(
    '_______________________________            _______________________________',
    $estiloNormal,
    ['alignment' => 'center', 'spaceAfter' => 20]
);

$tabla = $seccion->addTable();
$tabla->addRow();

$celda1 = $tabla->addCell(5000);

// Títulos de firmantes
$celda1->addText('EL CONTRATANTE', ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],'NoSpaceAfter');

// Nombres de firmantes
if($filaContrato['IdFirmante']==1){
    $celda1->addText('LUIS HECTOR RUBIANO VERGARA', ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],'NoSpaceAfter'
    );
    // Cédulas
    $celda1->addText('C.C. No. 79.315.619 DE BOGOTÁ D.C.', ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],'NoSpaceAfter');
}else{
    $celda1->addText('MARTHA GABRIELA BOTERO SERNA', ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],'NoSpaceAfter'
    );
    // Cédulas
    $celda1->addText('C.C. No. 24.434.581 DE ARANZAZU', ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],'NoSpaceAfter');
}
// Empresas
$celda1->addText('CPA INGENIERIA S.A.S.', ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],
'NoSpaceAfter');
// NIT
$celda1->addText('NIT. 830.042.614-3', ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],
'NoSpaceAfter');

$celda2 = $tabla->addCell(5000);
// Títulos de firmantes
$celda2->addText('EL CONTRATISTA', ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],'NoSpaceAfter');
// Nombres de firmantes
$celda2->addText(strtoupper($filaContrato['representanteLegal']), ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],'NoSpaceAfter');
// Cédulas
$celda2->addText($filaContrato['codClasedocRep'] . ' No. ' . separarMiles($filaContrato['documentoRepresentante']), ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],'NoSpaceAfter');
// Empresas
$celda2->addText($filaContrato['proveedor'], ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],
'NoSpaceAfter');
// NIT
$celda2->addText($filaContrato['codClasedoc'] . ' ' . separarMiles($filaContrato['documento']), ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],'NoSpaceAfter');


// Guardar el documento
$nombreArchivo = 'PS_' . sprintf("%03d",$filaContrato['consec']) . '_' . date('Y') . '.docx';

header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');

$objWriter = IOFactory::createWriter($documento, 'Word2007');
$objWriter->save('php://output');
exit();
