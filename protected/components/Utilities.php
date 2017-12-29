<?php

class Utilities
{

    public static function MoneyFormat($value, $decimals = 2, $simbolo = '$')
    {
        $value = "$simbolo " . number_format($value, $decimals, ",", ".");
        return $value;
    }

    public static function Unformat($value, $simbolo = '$')
    {
        if (strstr($value, "$simbolo "))
            $value = str_replace("$simbolo ", '', $value);
        if (strstr($value, '.'))
            $value = str_replace('.', '', $value);
        if (strstr($value, ','))
            $value = str_replace(',', '.', $value);
        return $value;
    }

    /**
     * [MysqlDateFormat Convierte una fecha d-m-Y a Y-m-d]
     * @param [type] $date [description]
     * @return $date [Y-m-d]
     */
    public static function MysqlDateFormat($date)
    {
        $dia = substr($date, 0, 2);
        $mes = substr($date, 3, 2);
        $anio = substr($date, 6, 4);
        return $anio . '-' . $mes . '-' . $dia;
    }


    /**
     * [MysqlDateFormat Convierte una fecha dd/mm/yy a yyyy/mm/dd]
     * @param [type] $date [description]
     * @return $date [Y-m-d]
     */
    public static function MysqlDateFormat2($date)
    {
        list($dia, $mes, $anio) = explode('/', $date);
        $anio = '20' . $anio;
        return $anio . '-' . $mes . '-' . $dia;
    }

    /**
     * [ViewDateFormat Convierte una fecha Y-m-d a d/m/Y]
     * @param [type] $date [description]
     * @return $date [d-m-Y]
     */
    public static function ViewDateFormat($date)
    {
        $dia = substr($date, 8, 2);
        $mes = substr($date, 5, 2);
        $anio = substr($date, 0, 4);
        return $dia . '/' . $mes . '/' . $anio;
    }

    public static function ViewDateFormatStamp($date)
    {
        $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        if ($datetime) {
            return $datetime->format('d/m/Y H:i');
        }
        return $date;
    }

    /**
     * @param $date
     * @return null|string
     */
    public static function MysqlDateFormatStamp($date)
    {
        $datetime = DateTime::createFromFormat('d/m/Y H:i', $date);
        if ($datetime) {
            return $datetime->format('Y-m-d H:i:s');
        }
        return null;
    }

    /**
     * [ViewDateFormat Convierte una fecha yyyy-mm-dd a dd/mm/yy]
     * @param [type] $date [description]
     * @return $date [d-m-Y]
     */
    public static function ViewDateFormat2($date)
    {

        list($anio, $mes, $dia) = explode('-', $date);
        $anio = substr($anio, 2, 2);
        return $dia . '/' . $mes . '/' . $anio;
    }

    public static function ViewDateFormat3($date)
    {
        list($dia, $mes, $anio) = explode('/', $date);
        $anio = '20' . $anio;
        return $dia . '/' . $mes . '/' . $anio;
    }

    public static function ResumeString($str, $caracteres)
    {
        if (strlen($str) > $caracteres) {
            $str = substr($str, 0, $caracteres) . "...";
        }
        return $str;
    }

    /**
     * [RestarFechas Devuelve la resta entre 2 fechas formato d-m-Y]
     * @param [type] $fechaInicio [formato d-m-Y]
     * @param [type] $fechaFin    [formato d-m-Y]
     */
    public static function RestarFechas($fechaInicio, $fechaFin)
    {
        $fechaInicio = str_replace("-", "", $fechaInicio);
        $fechaInicio = str_replace("/", "", $fechaInicio);
        $fechaFin = str_replace("-", "", $fechaFin);
        $fechaFin = str_replace("/", "", $fechaFin);

        preg_match("/([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})/", $fechaInicio, $arrayFechaInicio);
        preg_match("/([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})/", $fechaFin, $arrayFechaFin);

        $date1 = mktime(0, 0, 0, $arrayFechaInicio[2], $arrayFechaInicio[1], $arrayFechaInicio[3]);
        $date2 = mktime(0, 0, 0, $arrayFechaFin[2], $arrayFechaFin[1], $arrayFechaFin[3]);

        $dias = round(($date2 - $date1) / (60 * 60 * 24));
        return $dias;
    }

    public static function RestarFechas2($fechaInicio, $fechaFin)
    {
        $fechaInicio = new DateTime($fechaInicio);
        $fechaFin = new DateTime($fechaFin);
        $intervalo = $fechaInicio->diff($fechaFin);
        return (int)$intervalo->days;
    }

    public static function RestarFechas3($fechaInicio, $fechaFin)
    {

        $fechaInicio = str_replace('/', '-', $fechaInicio);
        $fechaInicio = strtotime($fechaInicio);

        $fechaFin = str_replace('/', '-', $fechaFin);
        $fechaFin = strtotime($fechaFin);
        $diff = $fechaFin - $fechaInicio;
        return round($diff / 86400);
    }

    public static function truncateFloat($number, $digitos = 2)
    {
        /*$raiz = 10;
        $multiplicador = pow($raiz, $digitos);
        $resultado = ((int) ($number * $multiplicador)) / $multiplicador;
        */
        $resultado = round($number, $digitos, PHP_ROUND_HALF_EVEN);
        return $resultado;
        //return number_format($resultado, $digitos);
    }

    public static function redondear_dos_decimal($valor)
    {

        $multiplicado = $valor * 100;

        $float_redondeado = round($multiplicado / 100, 2);


        return $float_redondeado;
    }

    /* !
      @function num2letras ()
      @abstract Dado un n?mero lo devuelve escrito.
      @param $num number - N?mero a convertir.
      @param $fem bool - Forma femenina (true) o no (false).
      @param $dec bool - Con decimales (true) o no (false).
      @result string - Devuelve el n?mero escrito en letra.

     */

    public static function num2letras($num, $monedaId = 2, $fem = false, $dec = true, $son_decimales = false)
    {
        $matuni[2] = "dos";
        $matuni[3] = "tres";
        $matuni[4] = "cuatro";
        $matuni[5] = "cinco";
        $matuni[6] = "seis";
        $matuni[7] = "siete";
        $matuni[8] = "ocho";
        $matuni[9] = "nueve";
        $matuni[10] = "diez";
        $matuni[11] = "once";
        $matuni[12] = "doce";
        $matuni[13] = "trece";
        $matuni[14] = "catorce";
        $matuni[15] = "quince";
        $matuni[16] = "dieciseis";
        $matuni[17] = "diecisiete";
        $matuni[18] = "dieciocho";
        $matuni[19] = "diecinueve";
        $matuni[20] = "veinte";
        $matunisub[2] = "dos";
        $matunisub[3] = "tres";
        $matunisub[4] = "cuatro";
        $matunisub[5] = "quin";
        $matunisub[6] = "seis";
        $matunisub[7] = "sete";
        $matunisub[8] = "ocho";
        $matunisub[9] = "nove";

        $matdec[2] = "veint";
        $matdec[3] = "treinta";
        $matdec[4] = "cuarenta";
        $matdec[5] = "cincuenta";
        $matdec[6] = "sesenta";
        $matdec[7] = "setenta";
        $matdec[8] = "ochenta";
        $matdec[9] = "noventa";
        $matsub[3] = 'mill';
        $matsub[5] = 'bill';
        $matsub[7] = 'mill';
        $matsub[9] = 'trill';
        $matsub[11] = 'mill';
        $matsub[13] = 'bill';
        $matsub[15] = 'mill';
        $matmil[4] = 'millones';
        $matmil[6] = 'billones';
        $matmil[7] = 'de billones';
        $matmil[8] = 'millones de billones';
        $matmil[10] = 'trillones';
        $matmil[11] = 'de trillones';
        $matmil[12] = 'millones de trillones';
        $matmil[13] = 'de trillones';
        $matmil[14] = 'billones de trillones';
        $matmil[15] = 'de billones de trillones';
        $matmil[16] = 'millones de billones de trillones';

        //Zi hack
        $float = explode('.', $num);
        $num = $float[0];

        $num = trim((string)@$num);
        if ($num[0] == '-') {
            $neg = 'menos ';
            $num = substr($num, 1);
        } else
            $neg = '';
        while ($num[0] == '0')
            $num = substr($num, 1);
        if ($num[0] < '1' or $num[0] > 9)
            $num = '0' . $num;
        $zeros = true;
        $punt = false;
        $ent = '';
        $fra = '';
        for ($c = 0; $c < strlen($num); $c++) {
            $n = $num[$c];
            if (!(strpos(".,'''", $n) === false)) {
                if ($punt)
                    break;
                else {
                    $punt = true;
                    continue;
                }
            } elseif (!(strpos('0123456789', $n) === false)) {
                if ($punt) {
                    if ($n != '0')
                        $zeros = false;
                    $fra .= $n;
                } else
                    $ent .= $n;
            } else
                break;
        }
        $ent = '     ' . $ent;
        if ($dec and $fra and !$zeros) {
            $fin = ' coma';
            for ($n = 0; $n < strlen($fra); $n++) {
                if (($s = $fra[$n]) == '0')
                    $fin .= ' cero';
                elseif ($s == '1')
                    $fin .= $fem ? ' una' : ' un';
                else
                    $fin .= ' ' . $matuni[$s];
            }
        } else
            $fin = '';
        if ((int)$ent === 0)
            return 'Cero ' . $fin;
        $tex = '';
        $sub = 0;
        $mils = 0;
        $neutro = false;
        while (($num = substr($ent, -3)) != '   ') {
            $ent = substr($ent, 0, -3);
            if (++$sub < 3 and $fem) {
                $matuni[1] = 'una';
                $subcent = 'as';
            } else {
                $matuni[1] = $neutro ? 'un' : 'uno';
                $subcent = 'os';
            }
            $t = '';
            $n2 = substr($num, 1);
            if ($n2 == '00') {

            } elseif ($n2 < 21)
                $t = ' ' . $matuni[(int)$n2];
            elseif ($n2 < 30) {
                $n3 = $num[2];
                if ($n3 != 0)
                    $t = 'i' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            } else {
                $n3 = $num[2];
                if ($n3 != 0)
                    $t = ' y ' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            }
            $n = $num[0];
            if ($n == 1) {
                $t = ' ciento' . $t;
            } elseif ($n == 5) {
                $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
            } elseif ($n != 0) {
                $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
            }
            if ($sub == 1) {

            } elseif (!isset($matsub[$sub])) {
                if ($num == 1) {
                    $t = ' mil';
                } elseif ($num > 1) {
                    $t .= ' mil';
                }
            } elseif ($num == 1) {
                $t .= ' ' . $matsub[$sub] . '?n';
            } elseif ($num > 1) {
                $t .= ' ' . $matsub[$sub] . 'ones';
            }
            if ($num == '000')
                $mils++;
            elseif ($mils != 0) {
                if (isset($matmil[$sub]))
                    $t .= ' ' . $matmil[$sub];
                $mils = 0;
            }
            $neutro = true;
            $tex = $t . $tex;
        }
        $tex = $neg . substr($tex, 1) . $fin;
        //Zi hack --> return ucfirst($tex);


        if (isset($float[1])) {
            $num = substr($float[1], 0, 2);
            if ($num != "00") {
                $decimales = self::num2letras($num, false, false, true);
                $decimales = ' con ' . $decimales . ' centavos';
            } else
                $decimales = "";
        } else
            $decimales = "";

        if ($son_decimales) {
            $end_num = ' con ' . $tex . ' centavos';
        } else
            $end_num = ucfirst($tex) . $decimales;
        ####### SEGUN LA MONEDA AGREGO LA DESCRIPCION #########
        switch ($monedaId) {
            case Monedas::TYPE_PESO:
                $end_num = $end_num . '  PESOS ARGENTINOS';
                break;
            case Monedas::TYPE_DOLAR:
                $end_num = $end_num . '  DOLARES ESTADOUNIDENSES';
                break;
            case Monedas::TYPE_EURO:
                $end_num = $end_num . '  EUROS';
                break;
        }
        ######################################################
        return $end_num;
    }

// END FUNCTION

    public static function generarReporte($contenido, $nombreArchivo)
    {
        try {
            if (Yii::app()->user->model->sucursal->modoInforme == Sucursales::MODO_ARCHIVO_CARPETA) {

                $path = Yii::app()->user->model->sucursal->pathInformes . Yii::app()->user->model->username;
                //echo $path."<br>";
                if (!is_dir($path)) {
                    mkdir($path);
                    //echo "no existe<br>";
                }
                //echo $path  . "/" . $nombreArchivo;
                file_put_contents($path . "/" . $nombreArchivo, $contenido);
                return "Reporte Generado con exito en:" . $path . "/" . $nombreArchivo;
            } else {

                Yii::app()->request->sendFile($nombreArchivo, $contenido);
                return "Reporte Generado con exito";
            }


        } catch (Exception $e) { // an exception is raised if a query fails
            return "Error al generar el reporte:" . $e->getMessage();
        }


    }


    public static function ultimoDiaMes()
    {
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));

        return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
    }

    public static function primerDiaMes()
    {
        $month = date('m');
        $year = date('Y');
        return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
    }

    public static function dameFecha($fecha, $dia)
    {
        list($day, $mon, $year) = explode('/', $fecha);
        $fecha = date('d/m/Y', mktime(0, 0, 0, $mon, $day + $dia, $year));
        $dia = substr($fecha, 0, 2);
        $mes = substr($fecha, 3, 2);
        $anio = substr($fecha, 8, 2);
        return $dia . '/' . $mes . '/' . $anio;
    }

    function convert_entities($string, $tidy = true)
    {

        // Map of windows 1252 character points to utf-8 character points
        $cp1252Map = array(
            "\xc2\x80" => "\xe2\x82\xac", /* EURO SIGN */
            "\xc2\x82" => "\xe2\x80\x9a", /* SINGLE LOW-9 QUOTATION MARK */
            "\xc2\x83" => "\xc6\x92",     /* LATIN SMALL LETTER F WITH HOOK */
            "\xc2\x84" => "\xe2\x80\x9e", /* DOUBLE LOW-9 QUOTATION MARK */
            "\xc2\x85" => "\xe2\x80\xa6", /* HORIZONTAL ELLIPSIS */
            "\xc2\x86" => "\xe2\x80\xa0", /* DAGGER */
            "\xc2\x87" => "\xe2\x80\xa1", /* DOUBLE DAGGER */
            "\xc2\x88" => "\xcb\x86",     /* MODIFIER LETTER CIRCUMFLEX ACCENT */
            "\xc2\x89" => "\xe2\x80\xb0", /* PER MILLE SIGN */
            "\xc2\x8a" => "\xc5\xa0",     /* LATIN CAPITAL LETTER S WITH CARON */
            "\xc2\x8b" => "\xe2\x80\xb9", /* SINGLE LEFT-POINTING ANGLE QUOTATION */
            "\xc2\x8c" => "\xc5\x92",     /* LATIN CAPITAL LIGATURE OE */
            "\xc2\x8e" => "\xc5\xbd",     /* LATIN CAPITAL LETTER Z WITH CARON */
            "\xc2\x91" => "\xe2\x80\x98", /* LEFT SINGLE QUOTATION MARK */
            "\xc2\x92" => "\xe2\x80\x99", /* RIGHT SINGLE QUOTATION MARK */
            "\xc2\x93" => "\xe2\x80\x9c", /* LEFT DOUBLE QUOTATION MARK */
            "\xc2\x94" => "\xe2\x80\x9d", /* RIGHT DOUBLE QUOTATION MARK */
            "\xc2\x95" => "\xe2\x80\xa2", /* BULLET */
            "\xc2\x96" => "\xe2\x80\x93", /* EN DASH */
            "\xc2\x97" => "\xe2\x80\x94", /* EM DASH */
            "\xc2\x98" => "\xcb\x9c",     /* SMALL TILDE */
            "\xc2\x99" => "\xe2\x84\xa2", /* TRADE MARK SIGN */
            "\xc2\x9a" => "\xc5\xa1",     /* LATIN SMALL LETTER S WITH CARON */
            "\xc2\x9b" => "\xe2\x80\xba", /* SINGLE RIGHT-POINTING ANGLE QUOTATION*/
            "\xc2\x9c" => "\xc5\x93",     /* LATIN SMALL LIGATURE OE */
            "\xc2\x9e" => "\xc5\xbe",     /* LATIN SMALL LETTER Z WITH CARON */
            "\xc2\x9f" => "\xc5\xb8"      /* LATIN CAPITAL LETTER Y WITH DIAERESIS*/
        );

        // Map of utf-8 chracter points to special html entities
        $entMap = array(
            "\xe2\x80\x98" => '&lsquo;',
            "\xe2\x80\x99" => '&rsquo;',
            "\xe2\x80\x9c" => '&ldquo;',
            "\xe2\x80\x9d" => '&rdquo;',
            "\xe2\x82\xac" => '&euro;',
            "\xe2\x80\xa6" => '&hellip;'
        );

        /*
         For reference, these are other entity replacement codes which might be useful one day
        array(
            "\xe2\x80\x9a" => '&sbquo;',    // Single Low-9 Quotation Mark
            "\xe2\x82\xac" => '&euro;',     // Euro sign
            "\xc6\x92"     => '&fnof;',     // Latin Small Letter F With Hook
            "\xe2\x80\x9e" => '&bdquo;',    // Double Low-9 Quotation Mark
            "\xe2\x80\xa6" => '&hellip;',   // Horizontal Ellipsis
            "\xe2\x80\xa0" => '&dagger;',   // Dagger
            "\xe2\x80\xa1" => '&Dagger;',   // Double Dagger
            "\xcb\x86"     => '&circ;',     // Modifier Letter Circumflex Accent
            "\xe2\x80\xb0" => '&permil;',   // Per Mille Sign
            "\xc5\xa0"     => '&Scaron;',   // Latin Capital Letter S With Caron
            "\xe2\x80\xb9" => '&lsaquo;',   // Single Left-Pointing Angle Quotation Mark
            "\xc5\x92"     => '&OElig;',    // Latin Capital Ligature OE
            "\xe2\x80\x98" => '&lsquo;',    // Left Single Quotation Mark
            "\xe2\x80\x99" => '&rsquo;',    // Right Single Quotation Mark
            "\xe2\x80\x9c" => '&ldquo;',    // Left Double Quotation Mark
            "\xe2\x80\x9d" => '&rdquo;',    // Right Double Quotation Mark
            "\xe2\x80\xa2" => '&bull;',     // Bullet
            "\xe2\x80\x93" => '&ndash;',    // En Dash
            "\xe2\x80\x94" => '&mdash;',    // Em Dash
            "\xcb\x9c"     => '&tilde;',    // Small Tilde
            "\xe2\x84\xa2" => '&trade;',    // Trade Mark Sign
            "\xc5\xa1"     => '&scaron;',   // Latin Small Letter S With Caron
            "\xe2\x80\xba" => '&rsaquo;',   // Single Right-Pointing Angle Quotation Mark
            "\xc5\x93"     => '&oelig;',    // Latin Small Ligature OE
            "\xc5\xb8"     => '&Yuml;',     // Latin Capital Letter Y With Diaeresis
        );
        */

        $string = trim($string);

        // apply the windows > utf8 map
        $string = str_replace(array_keys($cp1252Map), $cp1252Map, $string);

        // get rid of any existing html entities to avoid double encoding
        $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');

        // break out any PHP sections since they should not be touched
        $parts = preg_split('/(<\?.+?\?>)/us', $string, -1, PREG_SPLIT_DELIM_CAPTURE);

        // replace &, ", ', < and > with their entities, but only where they are not
        // part of an html tag or a comment
        $string = '';
        foreach ($parts as $part) {
            if (false === mb_strpos(trim($part), '<?')) {
                $string .= preg_replace_callback(
                    '/(?<=\>)((?![<](\?|\/)*[a-z][^>]*[>])[^<])+/ius',
                    create_function(
                        '$matches',
                        'return htmlspecialchars($matches[0]);'
                    ),
                    $part
                );
            } else {
                $string .= $part;
            }
        }

        // apply the utf-8 > entities map
        $string = str_replace(array_keys($entMap), $entMap, $string);

        // trim whitespace from the end of each line and add a nice \n
        // tinymce in particular seems to have a bug where it will insert spaces
        // at the end of lines
        $parts = preg_split("/[\r\n]+/u", $string);
        foreach ($parts as &$part) {
            $part = rtrim($part);
        }
        $string = implode("\n", $parts);

        // tidy the output
        if ($tidy && extension_loaded('tidy')) {
            $tidy_config = array(
                'output-xhtml' => true,
                'show-body-only' => true,
                'indent' => true,
                'indent-spaces' => 4,
                'sort-attributes' => 'alpha',
                'wrap' => 80,
                'preserve-entities' => true,
                'join-styles' => false,
                'logical-emphasis' => true,
                'enclose-text' => true
            );
            $tidy = tidy_parse_string($string, $tidy_config, 'UTF8');
            $tidy->cleanRepair();
            $string = $tidy;
        }

        return $string;

    }

    public static function validarCuit($cuit)
    {

        if (strlen($cuit) < 11) {
            return false;
        } else {
            $sum = 0;
            $array_dig2 = array(20, 23, 24, 27, 30, 33, 34);
            $arrayCuit = str_split($cuit);
            //$digitos = explode('-',$cuit);
            $dosDigitos = substr($cuit, 0, 2);
            if (in_array($dosDigitos, $array_dig2)) { //si los 2 primeros digistos son validos
                $coeficiente = array(5, 4, 3, 2, 7, 6, 5, 4, 3, 2);
                //$cuit2 = str_replace('-','',$cuit);
                //$cuit = str_split($cuit2);
                $verificador = array_pop($arrayCuit);

                for ($i = 0; $i < 10; $i++) {
                    $sum += ($arrayCuit[$i] * $coeficiente[$i]);
                    $resultado = $sum % 11;
                    $resultado = 11 - $resultado;
                    //saco el digito verificador
                    $veri_nro = intval($verificador);
                }

                if ($resultado === 11) {
                    $resultado = 0;
                } else if ($resultado === 10) {
                    $resultado = 9;
                }

                if ($veri_nro <> $resultado) {
                    return false;
                } else {
                    return true;//cuit correcto
                }
            } else {
                return false;
            }

        }

    }

    public static function validarDni($dni)
    {
        return strlen($dni) == 7 || strlen($dni) == 8;
    }


} //fin del class