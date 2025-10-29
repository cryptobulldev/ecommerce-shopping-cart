@component('mail::message')
# Daily Sales Report

@foreach ($summary as $item)
- **{{ $item['product'] }}** — Sold: {{ $item['quantity'] }} — Revenue: ${{ $item['revenue'] }}
@endforeach

Thanks,  
{{ config('app.name') }}
@endcomponent
