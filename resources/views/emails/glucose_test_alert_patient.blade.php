@component('mail::message')
# Glucose Test Alert for Patient

Doctor: **{{ $doctor->name }}**

A new glucose test has been added to your record.

@component('mail::panel')
**Test Date:** {{ $glucoseTest->test_date }}  
**Glucose Level:** {{ $glucoseTest->level }} mg/dL  
**Status:** @if($levelStatus === 'high') Above Normal @elseif($levelStatus === 'low') Below Normal @else Normal @endif
@endcomponent

@if($levelStatus === 'high')
> Your glucose level is **above** the normal range. Please follow your doctor's advice and consider a checkup.
@elseif($levelStatus === 'low')
> Your glucose level is **below** the normal range. Please follow your doctor's advice and consider a checkup.
@endif

@component('mail::button', ['url' => url('/dashboard/glucose-tests')])
View Your Glucose Tests
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
