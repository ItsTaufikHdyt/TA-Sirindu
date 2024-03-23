<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>No KK</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>NIK Orang Tua</th>
    </tr>
    </thead>
    <tbody>
    @foreach($export as $data)
        <tr>
            <td>{{ $data->id }}</td>
            <td>{{ $data->no_kk }}</td>
            <td>{{ $data->nik }}</td>
            <td>{{ $data->nama }}</td>
            <td>{{ $data->nik_ortu }}</td>
        </tr>
    @endforeach
    </tbody>
</table>