@include('layouting._partials.meta')

<link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/customs.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/libs/dataTable.css') }}" />

@vite('resources/css/app.css')

@stack('headers')
