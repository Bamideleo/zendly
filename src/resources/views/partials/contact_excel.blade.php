<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Contact No</th>
    </tr>
    </thead>
    <tbody>
        @forelse($contacts as $contact)
            <tr>
                <td>{{$contact->name}}</td>
                <td>{{$contact->contact_no}}</td>
            </tr>
        @endforeach
    </tbody>
</table>