<div style="font-family: Arial, sans-serif;">
    <h2>¡Solicitud aprobada!</h2>
    <p>Estimado/a, {{ $data['nombre'] }}</p>
    <p>Nos complace informarte que tu solicitud ha sido aprobada con éxito. A continuación, se proporciona un resumen de la aprobación:</p>
    <ul>
        <li><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($data['dia'])->format('d-m-Y') }}</li>
    </ul>
    <p>¡Esperamos que disfrutes de tu tiempo libre!</p>
    <p>Atentamente,</p>
    <p>Sistema gestión de Vacaciones <strong> UNIVER {{ date('Y') }}<br>
</div>
