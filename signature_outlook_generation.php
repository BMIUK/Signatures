<?php

$file = fopen("profiles.csv","r");

$master = '';

$details = '';

while($data = fgetcsv($file)) 
{ 
	$name = $data[0];
	$position = $data[1];
	$phone = $data[2];
	$whatsapp = $data[3];
	$skype = $data[4];
	$address = $data[5];
	$email = $data[6];

	$html = file_get_contents("signature_outlook_template.html");

	if($whatsapp == "No") 
		$details = file_get_contents("http://www.bmimedia.net/bmi/signature/templates/3_outlook_details.html");
	else
		$details = file_get_contents("http://www.bmimedia.net/bmi/signature/templates/4_outlook_details.html");
	
	switch ($address) 
	{
		// BMI UK
		case 'BMI UK': $address = file_get_contents("http://www.bmimedia.net/bmi/signature/templates/address_uk.html");
			break;	

		// BMI Colombia
		case 'Colombia': $address = file_get_contents("http://www.bmimedia.net/bmi/signature/templates/address_colombia.html");
			break;
			
		// BMI Dubai
		case 'Dubai': $address = file_get_contents("http://www.bmimedia.net/bmi/signature/templates/address_dubai.html");
			break;		
			
		// BMI Australia
		case 'Australia': $address = file_get_contents("http://www.bmimedia.net/bmi/signature/templates/address_australia.html");
			break;
	}

	$html = str_replace("*|name|*", $name, $html);
	$html = str_replace("*|details|*", $details, $html);
	$html = str_replace("*|position|*", $position, $html);
	$html = str_replace("*|phone|*", $phone, $html);
	$html = str_replace("*|whatsapp|*", $whatsapp, $html);
	$html = str_replace("*|skype|*", $skype, $html);
	$html = str_replace("*|address|*", $address, $html);
	$html = str_replace("*|email|*", $email, $html);

	// Save html
	$unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

	$name = strtolower( strtr( utf8_encode($name), $unwanted_array ));
	$filename = "signature_outlook_".$name.".html";	
	$filename = str_replace(" ", "_", $filename);

	file_put_contents($filename, $html);

	// Save New CSV
	$master = $master.$html;
	echo $html;
}

fclose($file);

// Save Master
file_put_contents('outlook_master.html', $master);