@include("system::admin.layouts._header")
<body>
<div class="layuimini-container">
    <form id="app-form" class="layui-form layuimini-form" method="post">

        <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
            <ul class="layui-tab-title">
                <li class="layui-this">基本信息</li>
                <li>拓展配置</li>
            </ul>

            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <div class="layui-form-item  layui-row layui-col-xs12">
                        <label class="layui-form-label required">上级分类</label>
                        <div class="layui-input-block">
                            <select name="pid">
                                <option value="0">顶级分类</option>
                                @foreach($categories as $item)
                                    <option value="{{$item['id']}}"
                                            @if($item['id']==$category->pid) selected @endif>{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label required">名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" class="layui-input" lay-verify="required" lay-reqtext="请输入名称"
                                   placeholder="请输入名称" value="{{$category->name}}">
                            <tip>填写名称。</tip>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">标题</label>
                        <div class="layui-input-block">
                            <input type="hidden" name="attr[ident][]" value="title">
                            <input type="text" name="attr[value][]" class="layui-input"
                                   placeholder="请输入标题" value="{{$category->title}}">
                            <tip>填写短题。</tip>
                        </div>
                    </div>

                    @if(app('system')->addonEnabled('UrlFormat'))
                        <div class="layui-form-item">
                            <label class="layui-form-label">副名称</label>
                            <div class="layui-input-block">
                                <input type="text" name="alias" class="layui-input" placeholder="请输入别名"
                                       value="{{url_format_alias_for_id($category->id,'category')}}">
                                <tip>用于URL优化。</tip>
                            </div>
                        </div>
                    @endif

                    <div class="layui-form-item">
                        <label class="layui-form-label">描述</label>
                        <div class="layui-input-block">
                            <textarea name="description" class="layui-textarea"
                                      placeholder="请输入描述">{{$category->description}}</textarea>
                            <tip>填写描述。</tip>
                        </div>
                    </div>

                </div>
                <div class="layui-tab-item">

                    @foreach($meta as $item)
                        <div class="layui-form-item">
                            <label class="layui-form-label required">配置</label>
                            <div class="layui-inline">
                                <div class="layui-input-inline">
                                    <input type="text" name="attr[ident][]" class="layui-input" placeholder="配置标识"
                                           value="{{$item->meta_key}}">
                                </div>
                                <div class="layui-input-inline">
                                    <input type="text" name="attr[value][]" class="layui-input" placeholder="配置值"
                                           value="{{$item->meta_value}}">
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="layui-form-item">
                        <label class="layui-form-label required">配置</label>
                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                <input type="text" name="attr[ident][]" class="layui-input" placeholder="配置标识" value="">
                            </div>
                            <div class="layui-input-inline">
                                <input type="text" name="attr[value][]" class="layui-input" placeholder="配置值"
                                       value="">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item" id="extend-div">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block">

                            <input type="checkbox" name="apply_to_category" lay-skin="primary"
                                   @if($category->apply_to_category == 1) checked @endif value="1" title="应用到子分类">

                            <input type="checkbox" name="apply_to_article" @if($category->apply_to_article == 1) checked
                                   @endif lay-skin="primary" value="1" title="应用到文章">

                        </div>
                    </div>

                    <div class="layui-form-item" id="diy-button">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block">
                            <button type="button" id="add-diy-button" class="layui-btn layui-btn-primary layui-btn-sm">
                                新增配置 +
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="hr-line"></div>
            <div class="layui-form-item text-center">
                <input type="hidden" name="id" value="{{$category->id}}">
                <button type="submit" class="layui-btn layui-btn-normal layui-btn-sm" lay-submit>确认</button>
                <button type="reset" class="layui-btn layui-btn-primary layui-btn-sm">重置</button>
            </div>

        </div>

    </form>
</div>


<div style="display: none" id="diy-tpl">
    <div class="layui-form-item">
        <label class="layui-form-label required">配置</label>
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" name="attr[ident][]" class="layui-input" placeholder="配置标识" value="">
            </div>
            <div class="layui-input-inline">
                <input type="text" name="attr[value][]" class="layui-input" placeholder="配置值" value="">
            </div>
        </div>
    </div>
</div>

<script>
    layui.use(['jquery'], function () {
        var $ = layui.jquery;

        $('#add-diy-button').click(
            function () {
                var html = $('#diy-tpl').html();
                $('#extend-div').before(html);
            }
        );
    });
</script>


</body>
</html>
