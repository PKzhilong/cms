@include("system::admin.layouts._header")
<body>
<div class="layuimini-container">
    <form id="app-form" class="layui-form layuimini-form" method="post">

        <div class="layui-form-item">
            <label class="layui-form-label required">属性标识</label>
            <div class="layui-input-block">
                <input type="text" name="ident" class="layui-input" lay-verify="required" lay-reqtext="请输入属性标识" placeholder="请输入属性标识" value="">
                <tip>填写属性标识。</tip>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">属性名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" class="layui-input" lay-reqtext="请输入属性名称" placeholder="请输入属性名称" value="">
                <tip>填写属性名称。</tip>
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
