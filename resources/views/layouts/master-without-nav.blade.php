<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>

    <title>@yield('title') | Clark Well</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>
    <link href="{{ asset('img/WV-icon.png') }}" rel="shortcut icon">
    <link rel="apple-touch-icon" href="{{ asset('img/WV-icon.jpg') }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
    @yield('css')

</head>
<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-100 relative bg-no-repeat bg-cover" style="background-image: url('{{asset('img/background.jpg')}}')">
        @yield('contents')
        @include('sweetalert::alert')
    </div>
<script src="{{ asset('dist/datepicker.js') }}"></script>
<script src="{{ asset('dist/flowbite.min.js') }}"></script>
<script src="{{ asset('dist/index.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/datepicker.min.js"></script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/646b2f36ad80445890ee5612/1h11b0rte';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
@yield('script')
</body>
</html>
