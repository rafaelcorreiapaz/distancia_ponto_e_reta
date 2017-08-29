<?php

function retornarDistanciaEntreDoisPonto($lat1, $lon1, $lat2, $lon2)
{
	return 	((3958 * 3.1415926 * sqrt(($lat2 - $lat1) * ($lat2 - $lat1) + cos($lat2 / 57.29578) * cos($lat1 / 57.29578) * ($lon2 - $lon1) * ($lon2 - $lon1)) / 180) * 1.609344) * 1000;
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

// reta
$a['lat'] = -5.49466388888889;
$a['lon'] = -47.4785511111111;
$b['lat'] = -4.95144666666667;
$b['lon'] = -47.5011422222222;
	
// ponto
$c['lat'] = -5.49507166666667;
$c['lon'] = -47.4788577777778;

var_dump(retornaDistanciaEntrePontoEReta($a, $b, $c));

