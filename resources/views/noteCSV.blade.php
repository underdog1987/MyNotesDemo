@if ($nota!==NULL)
id,name,txnote,userid,created_at,updated_at
{{ $nota->id }},"{{ $nota->name }}","{{ $nota->txNote }}",{{ $nota->user_id }},{{ $nota->created_at }},{{ $nota->updated_at }}

@else
NULL
@endif