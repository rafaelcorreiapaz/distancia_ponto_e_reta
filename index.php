<?php

function retornarDistanciaEntreDoisPonto($lat1, $lon1, $lat2, $lon2)
{
	return 	((3958 * 3.1415926 * sqrt(($lat2 - $lat1) * ($lat2 - $lat1) + cos($lat2 / 57.29578) * cos($lat1 / 57.29578) * ($lon2 - $lon1) * ($lon2 - $lon1)) / 180) * 1.609344);
}

function retornarAlturaDaBase($ab, $ac, $bc)
{
	$s = ($ab + $ac + $bc) / 2;
	$area = sqrt($s * ($s - $ab) * ($s - $ac) * ($s - $bc));
	$height = $area / (.5 * $ab);
	return $area;
}

function retornarAngulosDoTriangulo($ab, $bc, $ac)
{
	$a = $bc;
	$b = $ac;
	$c = $ab;
	
	$angle['a'] = rad2deg(acos((pow($b,2) + pow($c,2) - pow($a,2)) / (2 * $b * $c)));
	$angle['b'] = rad2deg(acos((pow($c,2) + pow($a,2) - pow($b,2)) / (2 * $c * $a)));
	$angle['c'] = rad2deg(acos((pow($a,2) + pow($b,2) - pow($c,2)) / (2 * $a * $b)));
	
	return $angle;			
}

function retornaDistanciaEntrePontoEReta($a, $b, $c)
{
	$ab = retornarDistanciaEntreDoisPonto($a['lat'], $a['lon'], $b['lat'], $b['lon']);
	$ac = retornarDistanciaEntreDoisPonto($a['lat'], $a['lon'], $c['lat'], $c['lon']);
	$bc = retornarDistanciaEntreDoisPonto($b['lat'], $b['lon'], $c['lat'], $c['lon']);
	
	$angle = retornarAngulosDoTriangulo($ab, $bc, $ac);
	
	if($ab + $ac == $bc)
		return 0;
	elseif($angle['a'] <= 90 && $angle['b'] <= 90)
		return retornarAlturaDaBase($ab, $ac, $bc);
	else
		return ($ac > $bc) ? $bc : $ac;

}

function retornarMenorDistancia($LatLinha, $LonLinha, $LatLon)
{
	$arrayLatLinha = explode(",",$LatLinha);
	$arrayLonLinha = explode(",",$LonLinha);
	$arrayLatLon = explode(",",$LatLon);

	// ponto
	$c['lat'] = $arrayLatLon[0];
	$c['lon'] = $arrayLatLon[1];

	$arrayDistancia = [];
	for($i = 1; $i < count($arrayLatLinha); $i++)
	{
		// reta
		$a['lat'] = $arrayLatLinha[$i];
		$a['lon'] = $arrayLonLinha[$i];
		$b['lat'] = $arrayLatLinha[$i-1];
		$b['lon'] = $arrayLonLinha[$i-1];
		$arrayDistancia[] = retornaDistanciaEntrePontoEReta($a, $b, $c)*1000 . PHP_EOL;
	}

	return intval(min($arrayDistancia));

}

$LatLinha = "-22.904186342480042,-22.9056885413639,-22.90966138188791,-22.907902277807445";
$LonLinha = "-43.186912536621094,-43.191633224487305,-43.189830780029304,-43.18476676940919";
$LatLon = "-22.906775648598042,-43.18845748901368";	

echo retornarMenorDistancia($LatLinha, $LonLinha, $LatLon);
