<?xml version="1.0"?>
<notes>
@foreach ($notas as $nota)
<note>
    <id>{{ $nota->id }}</id>
    <name>{{ $nota->name }}</name>
    <txNote>{{ $nota->txNote }}</txNote>
    <user_id>{{ $nota->user_id }}</user_id>
    <created_at>{{ $nota->created_at }}</created_at>
    <updated_at>{{ $nota->updated_at }}</updated_at>
</note>
@endforeach
</notes>