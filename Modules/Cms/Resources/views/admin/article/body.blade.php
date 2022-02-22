<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="/mycms/common/js/vue@2.6.14.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

{{--    <link rel="stylesheet" href="/mycms/common/css/element_ui.css">--}}
{{--    <script src="/mycms/common/js/element_ui.js"></script>--}}
<!-- 引入样式 -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <!-- 引入组件库 -->
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
</head>
<body>
<div id="app">
    @yield('content')
</div>
</body>

<script>
    let VueInitData = {
        el: '#app'
    }
</script>
@section('script')
@show
<script>
    Vue.prototype.$http = axios
    var app = new Vue(VueInitData)
</script>
</html>
