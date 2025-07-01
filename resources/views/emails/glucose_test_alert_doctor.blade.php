@component('mail::message')
# Glucose Test Alert for Doctor

Patient: **{{ $patient->name }}**

A new glucose test has been added for your patient.

@component('mail::panel')
**Test Date:** {{ $glucoseTest->test_date }}  
**Glucose Level:** {{ $glucoseTest->level }} mg/dL  
**Status:** @if($levelStatus === 'high') Above Normal @elseif($levelStatus === 'low') Below Normal @else Normal @endif
@endcomponent


@component('mail::panel')
@if($levelStatus === 'high')
> The glucose level is **above** the normal range. Please review and consider follow-up.
@elseif($levelStatus === 'low')
> The glucose level is **below** the normal range. Please review and consider follow-up.
@endif
@endcomponent


<br>Thanks,<br>
{{ config('app.name') }}
@endcomponent
