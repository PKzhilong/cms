@include("system::admin.layouts._header")
<body>
<div class="layuimini-container">
    <form id="app-form" class="layui-form layuimini-form" method="post">

        <div class="layui-form-item">
            <label class="layui-form-label required">页面名称</label>
            <div class="layui-input-block">
                <input type="text" name="page_name" class="layui-input" lay-verify="required" lay-reqtext="请输入页面名称" placeholder="请输入页面名称" value="">
                <tip>填写页面名称。</tip>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">页面地址</label>
            <div class="layui-input-block">
                <input type="text" name="page_path" class="layui-input" lay-reqtext="请输入页面地址" placeholder="请输入页面地址" value="">
                <tip>填写页面地址(about/us)。</tip>
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">页面标题</label>
            <div class="layui-input-block">
                <input type="text" name="page_title" class="layui-input" placeholder="请输入页面标题" value="">
                <tip>填写页面标题。</tip>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">页面关键词</label>
            <div class="layui-input-block">
                <input type="text" name="page_keyword" class="layui-input" placeholder="请输入页面关键词" value="">
                <tip>填写页面关键词。</tip>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">页面描述</label>
            <div class="layui-input-block">
                <textarea name="page_desc" class="layui-textarea"></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">内容</label>
            <div class="layui-input-block">
                        <textarea id="page_content" name="page_content" rows="20" class="layui-textarea editor"
                                  placeholder="请输入内容"></textarea>
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
