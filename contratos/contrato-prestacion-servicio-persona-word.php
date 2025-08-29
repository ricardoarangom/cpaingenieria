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

// Consultas a la base de datos (ya existentes en tu código)
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
                    auxilio 
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

$buscaFunciones = "SELECT IdFuncion, funcion FROM funcionescont WHERE IdContrato = " . $IdContrato . " ORDER BY IdFuncion ASC";
$resultadoFunciones = mysql_query($buscaFunciones, $datos) or die(mysql_error());

$buscaResponsabilidades = "SELECT IdResponsabilidad, responsabilidad FROM resposabilidadescont WHERE IdContrato = " . $IdContrato . " ORDER BY IdResponsabilidad ASC";
$resultadoResponsabilidades = mysql_query($buscaResponsabilidades, $datos) or die(mysql_error());

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

$footer = $seccion->addFooter();
if (file_exists('../imagenes/pie.png')) {
    $footer->addImage('../imagenes/pie.png', ['width' => 600, 'height' => 50, 'alignment' => 'center']);
}

// Estilos de fuente
$estiloTitulo = ['bold' => true, 'size' => 11, 'name' => 'Arial', 'smallCaps' => true];
$estiloNormal = ['size' => 11, 'name' => 'Arial'];
$estiloNegrita = ['bold' => true, 'size' => 11, 'name' => 'Arial'];
$estiloResaltado = ['bgColor' => 'yellow', 'size' => 11, 'name' => 'Arial'];

// Título del contrato
$seccion->addText(
    'CONTRATO PRESTACIÓN DE SERVICIOS A TRABAJADORES POR CUENTA PROPIA',
    $estiloTitulo,
    ['alignment' => 'center', 'spaceAfter' => 10]
);


$numeroContrato = "No. " . sprintf("%03d",$filaContrato['consec']) . '-' . date('Y', strtotime($filaContrato['finicio']));
$textRun = $seccion->addTextRun(['alignment' => 'center', 'spaceAfter' => 240]);
$textRun->addText("\t\t\t\t\t     ", $estiloNormal);
$textRun->addText($numeroContrato, ['bold' => true, 'size' => 11, 'name' => 'Arial', 'smallCaps' => true]);



// Párrafo introductorio
$textoIntro = 'Entre los suscritos ';
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120]);
$textRun->addText($textoIntro, $estiloNormal);
$textRun->addText('LUIS HECTOR RUBIANO VERGARA', $estiloNegrita);
$textRun->addText(', identificado con la cédula de ciudadanía No. 79.315.619 de Bogotá D.C., domiciliado en la calle 106 No.59-21 en la ciudad de Bogotá D.C., actuando en nombre y representación de COMPAÑÍA DE PROYECTOS AMBIENTALES E INGENIERÍA S.A.S. - CPA INGENIERÍA S.A.S., sociedad domiciliada en Bogotá D.C., y quien en adelante se denominará EL CONTRATANTE, por una parte y, por la otra ', $estiloNormal);
$textRun->addText(strtoupper($filaContrato['proveedor']), $estiloNegrita);
$textRun->addText(' mayor de edad, identificado con ' . $filaContrato['nombreClasedoc'] . ' No. ', $estiloNormal);
$textRun->addText(separarMiles($filaContrato['documento']) . ' de ' . $filaContrato['ciudadNac'] . ', ' . $filaContrato['departamentoNac'], $estiloNormal);
$textRun->addText(', con domicilio en la ', $estiloNormal);
$textRun->addText($filaContrato['direccion'] . ' en la ciudad de ' . $filaContrato['ciudadResidencia'] . ', ' . $filaContrato['departamentoResidencia'], $estiloNormal);
$textRun->addText(', y quien para los efectos del presente documento se denominará EL CONTRATISTA, acuerdan celebrar el presente contrato de prestación de servicios a trabajadores por cuenta propia, el cual se regirá por las disposiciones del Código de Comercio y en especial por las siguientes cláusulas:', $estiloNormal, ['spaceAfter' => 120],'JustifiedStyle');

// CLÁUSULA PRIMERA - OBJETO
$seccion->addText('Primera. -- Objeto.', $estiloNegrita, ['spaceAfter' => 60, 'spaceBefore' => 300]);
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
    $seccion->addText('No se especifican actividades.', $estiloNormal, ['alignment' => 'both', 'spaceAfter' => 120]);
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
    $seccion->addText('No se especifican productos.', $estiloNormal, ['alignment' => 'both', 'spaceAfter' => 120]);
}

// CLÁUSULA SEGUNDA - PLAZO
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Segunda. -- Plazo.', $estiloNegrita);
$textRun->addText(' El plazo para la ejecución del presente contrato será desde el día ', $estiloNormal);
$textRun->addText(formatearFecha($filaContrato['finicio']), $estiloNormal);
$textRun->addText(' hasta el día ', $estiloNormal);
$textRun->addText(formatearFecha($filaContrato['ffin']), $estiloNormal);
$textRun->addText('.', $estiloNormal);

// CLÁUSULA TERCERA - VALOR
$valorTotal = $filaContrato['valor'];
$textIVA = '';
$valorTotal = $valorTotal * (1 + floatval($filaContrato['iva'])); // Asumiendo IVA del 19%
$textIVA = ($filaContrato['iva'] > 0) ? ', IVA incluido' : ', antes de IVA';

$valorLetras = numeroALetras($valorTotal);
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Tercera. -- Valor.', $estiloNegrita);
$textRun->addText(' El valor total del presente contrato es de ', $estiloNormal);
$textRun->addText('(COP$ ' . number_format($valorTotal, 0, ',', '.') . ') ' . $valorLetras . ' Pesos Moneda Corriente', $estiloNormal);
$textRun->addText($textIVA . '.', $estiloNormal);

// CLÁUSULA CUARTA - FORMA DE PAGO
// $seccion->addText('Cuarta. -- Forma de pago.', $estiloNegrita, ['spaceAfter' => 120, 'spaceBefore' => 300]);

$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Cuarta. – Forma de Pago.: ', $estiloNegrita);
if (mysql_num_rows($resultadoFormaPagos) > 0) {
    $numeroPagos = mysql_num_rows($resultadoFormaPagos);
    $nombresPagos = ['Primer', 'Segundo', 'Tercer', 'Cuarto', 'Quinto', 'Sexto', 'Séptimo', 'Octavo', 'Noveno', 'Décimo'];

    // $seccion->addText(
    //     'Se realizarán ' . numeroALetras($numeroPagos) . ' (' . $numeroPagos . ') pagos así:',
    //     $estiloNormal,
    //     ['alignment' => 'both', 'spaceAfter' => 120]
    // );

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

        $contador = 0;
        while ($pago = mysql_fetch_assoc($resultadoFormaPagos)) {
            $valorPago = $valorTotal * $pago['porpago'];
            $porcentaje = $pago['porpago'] * 100;

            $textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120]);
            $textRun->addText($nombresPagos[$contador] . ' Pago: ', ['bold' => true, 'underline' => 'single', 'size' => 11, 'name' => 'Arial']);
            $textRun->addText('Por valor de: (COP$ ' . number_format($valorPago, 0, ',', '.') . ') ' .
                numeroALetras($valorPago) . ' Pesos Moneda Corriente, antes de IVA; ', $estiloNormal);
            $textRun->addText('Correspondientes al ' . $porcentaje . '% del valor total del contrato; ', $estiloNormal);
            $textRun->addText($pago['concepto'] . '; ', $estiloNormal);
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

$seccion->addText('Parágrafo Único:', $estiloNegrita, ['spaceAfter' => 120, 'spaceBefore' => 300]);
$seccion->addText(
    'La cuenta de cobro deberá ser radicada antes del 25 de cada mes, adjuntando la planilla de seguridad social correspondiente.',
    $estiloNormal,
    ['alignment' => 'both', 'spaceAfter' => 120]
);

// CLÁUSULA QUINTA - OBLIGACIONES DEL CONTRATANTE
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Quinta. -- Obligaciones de EL CONTRATANTE.', $estiloNegrita);
$textRun->addText(' Este deberá facilitar acceso a la información que sea necesaria, de manera, oportuna, para la debida ejecución del objeto del contrato y estará obligado a cumplir con lo estipulado en las demás cláusulas y condiciones previstas en este documento. ', $estiloNormal);
$textRun->addText('Parágrafo Único:', $estiloNegrita);
$textRun->addText(' El contratante afiliará al contratista según el riesgo respectivo a la Administradora de Riesgos Laborales, ARL cuyo valor será asumido por el contratante.', $estiloNormal);

// CLÁUSULA SEXTA - OBLIGACIONES DEL CONTRATISTA
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Sexta. -- Obligaciones de EL CONTRATISTA.', $estiloNegrita);
$textRun->addText(' EL CONTRATISTA deberá cumplir en forma eficiente y oportuna los trabajos encomendados y aquellas obligaciones que se generen en la reunión de planificación o de seguimiento cumpliendo las fechas de entrega programadas. Así mismo cumplir con todos los compromisos adquiridos o acuerdos generados con la coordinación del proyecto y notificados mediante actas o correos electrónicos que incluyan programaciones de entrega parcial o total. ', $estiloNormal);
$textRun->addText('Parágrafo:', $estiloNegrita);
$textRun->addText(' El contratista deberá cumplir cabalmente con sus obligaciones frente al sistema de seguridad social integral de acuerdo a las leyes vigentes, “Decreto 1070 Artículo  3° de 2013 modificado por el Artículo 9° del Decreto 3032 de 2013. Contribuciones al Sistema General de Seguridad Social.  De acuerdo con lo previsto en el artículo 26 de la Ley 1393 de 2010 y el artículo 108 del Estatuto Tributario, la disminución de la base de retención para las personas naturales residentes cuyos ingresos no provengan de una relación laboral, o legal y reglamentaria, por concepto de contribuciones al Sistema General de Seguridad Social, pertenezcan o no a la categoría de empleados, estará condicionada a su pago en debida forma, para lo cual se adjuntará a la respectiva factura o documento equivalente copia de la planilla o documento de pago. Para la procedencia de la deducción en el impuesto sobre la renta de los pagos realizados a las personas mencionadas en el inciso anterior, el contratante deberá verificar que el pago de dichas contribuciones al Sistema General de Seguridad Social esté realizado en debida forma, en relación con los ingresos obtenidos por los pagos relacionados con el contrato respectivo, en los términos del artículo 18 de la Ley 1122 de 2007, aquellas disposiciones que la adicionen, modifiquen o sustituyan, y demás normas aplicables en la materia”.', $estiloNormal);

// CLÁUSULA SÉPTIMA - VIGILANCIA
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Séptima. -- Vigilancia del contrato.', $estiloNegrita);
$textRun->addText(' EL CONTRATANTE o su representante supervisarán la ejecución del servicio profesional encomendado, y podrá formular las observaciones del caso con el fin de ser analizadas conjuntamente con EL CONTRATISTA y efectuar por parte de éste las modificaciones o correcciones a que hubiere lugar.', $estiloNormal);

// CLÁUSULA OCTAVA - CLÁUSULA PENAL
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Octava. -- Cláusula penal.', $estiloNegrita);
$textRun->addText(' En caso de incumplimiento por parte de EL CONTRATISTA de cualquiera de las obligaciones previstas en este contrato no se cancelará el pago final de acuerdo a lo establecido en la cláusula segunda y deberá pagar una indemnización de 50% del presente Contrato más gastos jurídicos.', $estiloNormal);

// CLÁUSULA NOVENA - TERMINACIÓN
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Novena. - Terminación.', $estiloNegrita);
$textRun->addText(' El presente contrato podrá darse por terminado por mutuo acuerdo entre las dos partes, o en forma unilateral por el incumplimiento de las obligaciones derivadas del contrato y/o por EL CONTRATANTE cuando por razones externas, el proyecto se suspenda o se cancele antes de la fecha pactada.', $estiloNormal);

// CLÁUSULA DÉCIMA - INDEPENDENCIA
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Décima. Independencia de EL CONTRATISTA.', $estiloNegrita);
$textRun->addText(' EL CONTRATISTA actuará por su propia cuenta, con absoluta autonomía y no estará sometido a subordinación laboral con EL CONTRATANTE y sus derechos se limitarán, de acuerdo con la naturaleza del contrato, a exigir el cumplimiento de las obligaciones de EL CONTRATANTE y al pago de los honorarios estipulados por la prestación del servicio.', $estiloNormal);

// CLÁUSULA DÉCIMA PRIMERA - EXCLUSIÓN RELACIÓN LABORAL
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Décima primera. -- Exclusión de la relación laboral.', $estiloNegrita);
$textRun->addText(' Queda claramente entendido que no existirá relación laboral alguna entre EL CONTRATANTE Y CONTRATISTA.', $estiloNormal);

// CLÁUSULA DÉCIMA SEGUNDA - CESIÓN
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Décima segunda. -- Cesión del contrato.', $estiloNegrita);
$textRun->addText(' EL CONTRATISTA no podrá ceder parcial ni totalmente la ejecución del presente contrato a un tercero salvo previa autorización expresa y escrita de EL CONTRATANTE.', $estiloNormal);

// CLÁUSULA DÉCIMA TERCERA - DOMICILIO
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Décima tercera. -- Domicilio contractual.', $estiloNegrita);
$textRun->addText(' Para todos los efectos legales, el domicilio contractual será la ciudad de Bogotá D.C. y las notificaciones serán recibidas por las partes en las siguientes direcciones: por EL CONTRATANTE, en la Calle 106 No.59-21 en la ciudad de Bogotá; EL CONTRATISTA, en la ', $estiloNormal);
$textRun->addText($filaContrato['direccion'] . ' en la ciudad de ' . $filaContrato['ciudadResidencia'] . ', ' . $filaContrato['departamentoResidencia'], $estiloNormal);

// CLÁUSULA COMPROMISORIA
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('Cláusula compromisoria.', $estiloNegrita);
$textRun->addText(' Todas las dudas, cuestiones, discrepancias o reclamaciones que puedan surgir en la interpretación, ejecución o cumplimiento de este acuerdo, o relacionada con él, directa o indirectamente, se resolverán en primer lugar de forma amistosa en la medida de lo posible, mediante negociación directa de las partes, dentro del plazo de quince (15) días a partir de la fecha en que cualquiera de las partes informe a la otra sobre la existencia de una controversia o desavenencia, a falta de un acuerdo en el plazo de un (1) mes o dentro de la prórroga otorgada al mismo, acordada entre las partes, la controversia se resolverá definitivamente mediante arbitraje de derecho ante un Centro de Conciliación, de acuerdo con su reglamento, cuyas disposiciones se entienden incorporadas por referencia de esta cláusula. ', $estiloNormal);

// CLÁUSULA DE CONFIDENCIALIDAD
$textRun = $seccion->addTextRun(['alignment' => 'both', 'spaceAfter' => 120, 'spaceBefore' => 300]);
$textRun->addText('CLAUSULA DE CONFIDENCIALIDAD:', $estiloNegrita);
$textRun->addText(' Es obligación del CONTRATISTA no divulgar aquella información que se le haya confiado en virtud del secreto profesional o aquella que deba ser mantenida en reserva por su carácter de confidencial, lo cual haya tenido noticia por cualquier circunstancia, excepción hecha de aquello que el contratista deba informar por razones de ley o providencias judiciales. Entiéndase por información confidencial aquella información societaria, técnica de acuerdo con el objeto del contrato, financiera, jurídica, comercial y estratégica de los negocios del Empleador, presentes o futuros.', $estiloNormal);

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
    '_______________________________           _______________________________',
    $estiloNormal,
    ['alignment' => 'center', 'spaceAfter' => 40]
);


$tabla = $seccion->addTable();
$tabla->addRow();

// Títulos de firmantes
$celda1 = $tabla->addCell(5000);
$celda1->addText('EL CONTRATANTE', ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],'NoSpaceAfter');

// Nombres de firmantes
$celda1->addText('LUIS HECTOR RUBIANO VERGARA', ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],'NoSpaceAfter');

// Cédulas
$celda1->addText('C.C. No. 79.315.619', ['bold' => true,'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],'NoSpaceAfter');

// Títulos de firmantes
$celda2 = $tabla->addCell(5000);
$celda2->addText('TRABAJADOR POR CUENTA PROPIA', ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],'NoSpaceAfter');

// Nombres de firmantes
$celda2->addText(strtoupper($filaContrato['proveedor']), ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],'NoSpaceAfter');

// Cédulas
$celda2->addText($filaContrato['codClasedoc'] . ' No. ' . separarMiles($filaContrato['documento']), ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial'],'NoSpaceAfter');



// // Títulos de firmantes
// $textRun = $seccion->addTextRun(['alignment' => 'center', 'spaceAfter' => 40]);
// $textRun->addText('EL CONTRATANTE', ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial']);
// $textRun->addText('                                        ', $estiloNormal);
// $textRun->addText('TRABAJADOR POR CUENTA PROPIA', ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial']);

// // Nombres de firmantes
// $textRun = $seccion->addTextRun(['alignment' => 'center', 'spaceAfter' => 40]);
// $textRun->addText('LUIS HECTOR RUBIANO VERGARA', ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial']);
// $textRun->addText('             ', $estiloNormal);
// $textRun->addText(strtoupper($filaContrato['proveedor']), ['bold' => true, 'smallCaps' => true, 'size' => 11, 'name' => 'Arial']);

// // Cédulas
// $textRun = $seccion->addTextRun(['alignment' => 'center']);
// $textRun->addText('C.C. No. 79.315.619', ['smallCaps' => true, 'size' => 11, 'name' => 'Arial']);
// $textRun->addText(' de Bogotá D.C.               ', $estiloNormal);
// $textRun->addText('C.C. No. ' . separarMiles($filaContrato['documento']), ['smallCaps' => true, 'size' => 11, 'name' => 'Arial']);
// $textRun->addText(' de ' . $filaContrato['ciudadNac'], ['smallCaps' => true, 'size' => 11, 'name' => 'Arial']);

// Guardar el documento
$nombreArchivo = 'PS_' . sprintf("%03d",$filaContrato['consec']) . '_' . date('Y') .  '.docx';

header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');

$objWriter = IOFactory::createWriter($documento, 'Word2007');
$objWriter->save('php://output');
exit();
