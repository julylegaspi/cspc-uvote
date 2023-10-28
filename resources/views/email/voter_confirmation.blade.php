<x-mail::message>
# Hi, {{$data['voter']}}

Voting Receipt

@foreach ($data['votes'] as $item)
<p class="text-center">
    {{ $item['position'] }}<br/>
    {{ $item['candidate'] }}<br/>
    {{ $item['candidate_partylist'] }}
</p>
@endforeach

<p>You voted on: {{ now()->format('F j, Y H:i:s') }}</p>
<p>Reference number: {{ $data['reference_number'] }}</p>


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
