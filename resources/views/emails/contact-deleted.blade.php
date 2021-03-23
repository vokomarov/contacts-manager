@php /** @var \App\Models\Contact $contact */ @endphp

@component('mail::message')
# Contact Deleted

A contact *{{ $contact->name }} ({{ $contact->email }})* has been deleted.

Thanks,
{{ config('app.name') }}
@endcomponent
