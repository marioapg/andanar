<table>
    <thead>
    <tr>
        <strong>
            <th>Nro. Presup</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>CIF/NIF/DNI</th>
            <th>Mail Responsable</th>
            <th>Localidad</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Color</th>
            <th>Matricula</th>
            <th>Perito</th>
            <th>Presupuestado por (nombre)</th>
            <th>Presupuestado por (mail)</th>
            <th>Técnico (nombre)</th>
            <th>Técnico (mail)</th>
            <th>Estado</th>
            <th>Observaciones para AND</th>
            <th>Importe</th>
            <th>Desmontaje</th>
            <th>Descuento</th>
            <th>Neto</th>
            <th>Iva</th>
            <th>Total</th>
        </strong>
    </tr>
    </thead>
    <tbody>
        @foreach($budgets as $budget)
            <tr>
                <td>{{ $budget->id }}</td>
                <td>{{ $budget->created_at->format('d/m/Y') ?? '' }}</td>
                <td>{{ $budget->client->name ?? '' }}</td>
                <td>{{ $budget->client->document ?? '' }}</td>
                <td>{{ $budget->responsable->email ?? '' ?? '' }}</td>
                <td>{{ $budget->client->city ?? '' }}</td>
                <td>{{ $budget->car->brand ?? '' }}</td>
                <td>{{ $budget->car->model ?? '' }}</td>
                <td>{{ $budget->car->color ?? '' }}</td>
                <td>{{ $budget->car->plate ?? '' }}</td>
                <td>{{ $budget->perito->name ?? '' }}</td>
                <td>{{ $budget->createdByUser->name ?? '' }}</td>
                <td>{{ $budget->createdByUser->email ?? '' }}</td>
                <td>{{ $budget->technical->name ?? '' }}</td>
                <td>{{ $budget->technical->email ?? '' }}</td>
                <td>{{ $budget->status ?? '' }}</td>
                <td>{{ $budget->private_comment ?? '' }}</td>
                <td>{{ $budget->total - $budget->desmontaje }}</td>
                <td>{{ $budget->desmontaje ?? '' }}</td>
                <td></td>
                <td>{{ $budget->total ?? '' }}</td>
                <td>{{ $budget->iva ?? '' }}</td>
                <td>{{ $budget->grand_total ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>