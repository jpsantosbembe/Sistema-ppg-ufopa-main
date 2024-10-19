
<table>
    <thead>
        <tr>
            <th >Nome da Pessoa</th>
            <th >A1</th>
            <th >A2</th>
            <th >A3</th>
            <th >A4</th>
            <th >B1</th>
            <th >B2</th>
            <th >B3</th>
            <th >B4</th>
            <th >C</th>
        </tr>
    </thead>
    <tbody>
        @forEach($data as $item)
            <tr>
                <td>
                    {{ $item->nome }}
                </td>
                <td>{{$item->A1}}</td>
                <td>{{$item->A2}}</td>
                <td>{{$item->A3}}</td>
                <td>{{$item->A4}}</td>
                <td>{{$item->B1}}</td>
                <td>{{$item->B2}}</td>
                <td>{{$item->B3}}</td>
                <td>{{$item->B4}}</td>
                <td>{{$item->C}}</td>
            </tr>
        @endForEach()
    </tbody>
</table>
