@include("system::admin.layouts._header")
<body>
<div class="layuimini-container">
    <form id="app-form" class="layui-form layuimini-form" method="post">

        <div class="layui-form-item">
            <label class="layui-form-label required">Host</label>
            <div class="layui-input-block">
                <input type="text" name="host" class="layui-input" lay-verify="required" lay-reqtext="请输入Host" placeholder="请输入Host" value="{{$systemConfig['host'] ?? '127.0.0.1'}}">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">端口</label>
            <div class="layui-input-block">
                <input type="text" name="port" class="layui-input" lay-verify="required" lay-reqtext="请输入数据库端口" placeholder="请输入数据库端口" value="{{$systemConfig['port'] ?? '3306'}}">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">数据库名称</label>
            <div class="layui-input-block">
                <input type="text" name="database" class="layui-input" lay-verify="required" lay-reqtext="请输入数据库名称" placeholder="请输入数据库名称" value="{{$systemConfig['database'] ?? ''}}">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">数据库账号</label>
            <div class="layui-input-block">
                <input type="text" name="username" class="layui-input" lay-verify="required" lay-reqtext="请输入数据库账号" placeholder="请输入数据库账号" value="{{$systemConfig['username'] ?? ''}}">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">数据库密码</label>
            <div class="layui-input-block">
                <input type="text" name="password" class="layui-input" lay-verify="required" lay-reqtext="请输入数据库密码" placeholder="请输入数据库密码" value="{{$systemConfig['password'] ?? ''}}">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">表前缀</label>
            <div class="layui-input-block">
                <input type="text" name="dede_prefix" class="layui-input" value="{{$systemConfig['dede_prefix'] ?? 'dede_'}}">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">单次导入数据</label>
            <div class="layui-input-block">
                <input type="text" name="batch_number" class="layui-input" value="{{$systemConfig['batch_number'] ?? 100}}">
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="layui-form-item text-center">
            <button type="submit" class="layui-btn layui-btn-normal layui-btn-sm" lay-submit>确认</button>
            <button type="reset" class="layui-btn layui-btn-primary layui-btn-sm">重置</button>
        </div>

    </form>
</div>
</body>
</html>
