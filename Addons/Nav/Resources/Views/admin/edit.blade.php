@include("system::admin.layouts._header")
<body>
<div class="layuimini-container">
    <form id="app-form" class="layui-form layuimini-form" method="post">

        <div class="layui-form-item  layui-row layui-col-xs12">
            <label class="layui-form-label required">上级导航</label>
            <div class="layui-input-block">
                <select name="pid">
                    <option value="0">顶级导航</option>
                    @foreach($navs as $item)
                        <option value="{{$item['id']}}" @if($item['id'] == $nav->pid) selected @endif >{{$item['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" class="layui-input" lay-verify="required" lay-reqtext="请输入名称" placeholder="请输入名称" value="{{$nav->name}}">
                <tip>填写名称。</tip>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">URL</label>
            <div class="layui-input-block">
                <input type="text" name="url" class="layui-input" lay-verify="required" lay-reqtext="请输入URL" placeholder="请输入URL" value="{{$nav->url}}">
                <tip>填写URL。</tip>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label required">打开方式</label>
            <div class="layui-input-block">
                <input type="radio" name="target" @if($nav->target == '_blank') checked @endif lay-skin="primary" value="_blank" title="_blank">
                <input type="radio" name="target" @if($nav->target == '_self') checked @endif lay-skin="primary" value="_self" title="_self">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">图标</label>
            <div class="layui-input-block layuimini-upload">
                <input name="ico" class="layui-input layui-col-xs6" placeholder="请上传图标" value="{{$nav->ico}}">
                <div class="layuimini-upload-btn">
                    <span><a class="layui-btn" data-upload="ico" data-upload-number="one" data-upload-exts="ico|png|jpg|jpeg"><i class="fa fa-upload"></i> 上传</a></span>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="number" name="sort" class="layui-input" placeholder="请输入排序" value="{{$nav->sort}}">
                <tip>填写排序。</tip>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">内嵌样式</label>
                <div class="layui-input-inline">
                    <input type="text" name="style_css" class="layui-input" value="{{$nav->style_css}}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">样式类名</label>
                <div class="layui-input-inline">
                    <input type="text" name="style_class" class="layui-input" value="{{$nav->style_class}}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">样式ID</label>
                <div class="layui-input-inline">
                    <input type="text" name="style_id" class="layui-input" value="{{$nav->style_id}}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">Rel属性</label>
                <div class="layui-input-inline">
                    <input type="text" name="rel" class="layui-input" value="{{$nav->rel}}">
                </div>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="layui-form-item text-center">
            <input type="hidden" name="id" value="{{$nav->id}}">
            <button type="submit" class="layui-btn layui-btn-normal layui-btn-sm" lay-submit>确认</button>
            <button type="reset" class="layui-btn layui-btn-primary layui-btn-sm">重置</button>
        </div>

    </form>
</div>
</body>
</html>
