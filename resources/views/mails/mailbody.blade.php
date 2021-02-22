<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
	<title></title>
	<link href="https://fonts.googleapis.com/css?family=Calibri:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
</head>
<body>
 	En <strong>archivo PDF</strong> adjunto encontrará el presupuesto de <strong>{{ config('env_params.business_name') }}</strong> <br>

	Este es un envío automático realizado por el servicio de gestión de correspondencia de {{ config('env_params.business_name_short') }}. <br>
	No responda a este mensaje, no controlamos esta cuenta. <br>
	Si desea contactarnos, envíe un correo electrónico a <a href="mailto:{{ config('env_params.business_email_cc') }}">{{ config('env_params.business_email_cc') }}</a> <br>
	<br>
	Gracias por confiar en nosotros. <br>
	<br>
	<strong>{{ config('env_params.business_name') }}</strong> <br>
	______________________________________________________________________________________________<br>

	En <strong>arxiu PDF</strong> adjunt trobareu el pressupost de <strong>{{ config('env_params.business_name') }}</strong> <br>
	<br>
	Aquest és un enviament automàtic realitzat pel servei de gestió de correspondència de {{ config('env_params.business_name_short') }}. <br>
	No respongui a aquest missatge, no controlem aquest compte. <br>
	Si voleu contactar-nos, envieu un correu electrònic a <a href="mailto:{{ config('env_params.business_email_cc') }}">{{ config('env_params.business_email_cc') }}</a> <br>
	<br>
	Gràcies per confiar en nosaltres. <br>
	<br>
	<strong>{{ config('env_params.business_name') }}</strong> <br>
	______________________________________________________________________________________________<br>

	In the attached PDF file you will find the budget of <strong>{{ config('env_params.business_name') }}</strong> <br>
	<br>
	This is an automatic mail sent by {{ config('env_params.business_name_short') }}'s  Management Service. <br>
	Do not reply to this message, we do not control this account. <br>
	If you want to contact us, send an email to <a href="mailto:{{ config('env_params.business_email_cc') }}">{{ config('env_params.business_email_cc') }}</a> <br>
	<br>
	Thanks for trusting us. <br>
	<br>
	<strong>{{ config('env_params.business_name') }}</strong> <br>
	{{ config('env_params.business_address_line_2') }}<br>
	{{ config('env_params.business_address_line_3') }}<br>
	Mov.: {{ config('env_params.business_mobile_phone') }}<br>
	Tel.:   {{ config('env_params.business_mobile_phone') }}<br>
	Email: <a href="mailto:{{ config('env_params.business_email_cc') }}">{{ config('env_params.business_email_cc') }}</a> <br>
	<a href="https://{{ config('env_params.business_webinfo') }}">{{ config('env_params.business_webinfo') }}</a>
</body>
</html>