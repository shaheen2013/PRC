@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            ProChamps Community Management
        @endcomponent
    @endslot
    {!! $content !!}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} ProChamps - All Rights Reserved
        @endcomponent
    @endslot
@endcomponent