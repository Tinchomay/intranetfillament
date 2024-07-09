<h1>Horarios</h1>
<table>
    <thead>
        <th>Tipo</th>
        <th>Entrada</th>
        <th>Salida</th>
    </thead>
    <tbody>
        @foreach ($horarios as $horario)
        <tr>
            <td>{{ $horario->type }}</td>
            <td>{{ $horario->dia_entrada }}</td>
            <td>{{ $horario->dia_salida }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
