<!DOCTYPE html>
@langrtl
    <html lang="{{ app()->getLocale() }}" dir="rtl">
@else
    <html lang="{{ app()->getLocale() }}">
@endlangrtl
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', app_name())</title>
    <meta name="description" content="@yield('meta_description', 'Laravel Test Application')">
    <meta name="author" content="@yield('meta_author', 'Christos Symeou')">
    @yield('meta')
    @stack('before-styles')
    <!-- Check if the language is set to RTL, so apply the RTL layouts -->
    <!-- Otherwise apply the normal LTR layouts -->
    {{ style(mix('css/backend.css')) }}
    @stack('after-styles')
</head>

<body>
  <div class="app-body" id="app">
    <main class="main">
      <div class="container-fluid">
          @yield('content')
        </div><!--animated-->
      </div><!--container-fluid-->
    </main><!--main-->
  </div><!--app-body-->
  <!-- Scripts -->
  @stack('before-scripts')
  {!! script(mix('js/backend.js')) !!}
  @stack('after-scripts')
</body>
</html>