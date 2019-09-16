id,name,txnote,userid,created_at,updated_at
@foreach ($notas as $nota)
{{ $nota->id }},"{{ $nota->name }}","{{ $nota->txNote }}",{{ $nota->user_id }},{{ $nota->created_at }},{{ $nota->updated_at }}
@endforeach
