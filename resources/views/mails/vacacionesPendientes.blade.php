<h1>Solicitud de Vacaciones</h1>

<h3>Hola {{ $data['nombreAdministrador'] }}</h3>

<p>El usuario {{ $data['nombre'] }} con email {{ $data['email'] }}</p>

<p>Esta solicitando de vacaciones los dias {{ \Carbon\Carbon::parse($data['dia'])->format('d-m-Y') }}</p>

<p>Acceda al portal para autorizar o rechazar las vacaciones <a href="{{ env('APP_URL') . "/dashboard/login"}}" target="_blank">Portal Vacaciones</a></p>

<p>Atentamente,</p>
<p>Sistema gestión de Vacaciones <strong> UNIVER {{ date('Y') }} </strong></p>
