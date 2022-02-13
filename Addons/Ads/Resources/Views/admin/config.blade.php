@include("system::admin.layouts._header")
<body>
<div class="layuimini-container">
    <form id="app-form" class="layui-form layuimini-form" method="post">

        <div class="layui-form-item">
            <label class="layui-form-label required">入口Js路径</label>
            <div class="layui-input-block">
                <input type="text" name="entrance_js" id="entrance_js" class="layui-input" lay-verify="required" lay-reqtext="请输入入口Js路径" placeholder="请输入入口Js路径" value="{{$config['entrance_js'] ?? bin2hex(random_bytes(10))}}">
                <tip>第一步加载的JS。</tip>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">内容JS路径</label>
            <div class="layui-input-block">
                <input type="text" name="content_js" id="content_js" class="layui-input" lay-verify="required" lay-reqtext="请输入内容JS路径" placeholder="请输入内容JS路径" value="{{$config['content_js'] ?? bin2hex(random_bytes(10))}}">
                <tip>加载内容的JS。</tip>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">内容Ajax路径</label>
            <div class="layui-input-block">
                <input type="text" name="content_path" id="content_path" class="layui-input" lay-verify="required" lay-reqtext="请输入内容Ajax路径" placeholder="请输入内容Ajax路径" value="{{$config['content_path'] ?? bin2hex(random_bytes(10))}}">
                <tip>请求加载内容的路径。</tip>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">生成随机字符</label>
            <div class="layui-input-block">
                <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" onclick="makeRandStr();">一键生成</button>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="layui-form-item text-center">
            <button type="submit" class="layui-btn layui-btn-normal layui-btn-sm" lay-submit>确认</button>
            <button type="reset" class="layui-btn layui-btn-primary layui-btn-sm">重置</button>
        </div>

    </form>
</div>
<script>
    function makeRandStr()
    {
        document.getElementById("entrance_js").value = randomString(10);
        document.getElementById("content_js").value = randomString(10);
        document.getElementById("content_path").value = randomString(10);
    }

    function randomString(length) {
        var str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var result = '';
        for (var i = length; i > 0; --i)
            result += str[Math.floor(Math.random() * str.length)];
        return result;
    }
</script>
</body>
</html>
