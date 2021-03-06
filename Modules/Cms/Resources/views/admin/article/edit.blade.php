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
                        <label class="layui-form-label required">分类</label>
                        <div class="layui-input-block">
                            <select name="category_id">
                                @foreach($categories as $item)
                                    <option value="{{$item['id']}}"
                                            @if($item['id']==$article->category_id) selected @endif>{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label required">标题</label>
                        <div class="layui-input-block">
                            <input type="text" name="title" class="layui-input" lay-verify="required"
                                   lay-reqtext="请输入标题" placeholder="请输入标题" value="{{$article->title}}">
                            <tip>填写标题。</tip>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">短标题</label>
                        <div class="layui-input-block">
                            <input type="hidden" name="attr[ident][]" value="short_title">
                            <input type="text" name="attr[value][]" class="layui-input"
                                   placeholder="请输入短标题" value="{{$article->short_title}}">
                            <tip>填写短标题。</tip>
                        </div>
                    </div>

                    @if(app('system')->addonEnabled('UrlFormat'))
                        <div class="layui-form-item">
                            <label class="layui-form-label">别名</label>
                            <div class="layui-input-block">
                                <input type="text" name="alias" class="layui-input" placeholder="请输入别名"
                                       value="{{url_format_alias_for_id($article->id,'single')}}">
                                <tip>用于URL优化。</tip>
                            </div>
                        </div>
                    @endif

                    <div class="layui-form-item">
                        <label class="layui-form-label">作者</label>
                        <div class="layui-input-block">
                            <input type="text" name="author" class="layui-input" placeholder="请输入作者"
                                   value="{{$article->author}}">
                            <tip>填写作者。</tip>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">标签</label>
                        <div class="layui-input-block">
                            <input type="text" name="tags" class="layui-input" placeholder="请输入标签" value="{{$tags}}">
                            <tip>多个标签请用英文逗号（,）分开。</tip>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">缩略图</label>
                        <div class="layui-input-block layuimini-upload">
                            <input name="img" class="layui-input layui-col-xs6" placeholder="请上传缩略图"
                                   value="{{$article->img}}">
                            <div class="layuimini-upload-btn">
                                <span><a class="layui-btn" data-upload="img" data-upload-number="one"
                                         data-upload-exts="ico|png|jpg|jpeg"><i class="fa fa-upload"></i> 上传</a></span>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">描述</label>
                        <div class="layui-input-block">
                            <textarea name="description" class="layui-textarea"
                                      placeholder="请输入描述">{{$article->description}}</textarea>
                            <tip>填写描述。</tip>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">属性</label>
                        <div class="layui-input-block">
                            @foreach($attributes as $item)
                                <input type="hidden" name="attr[ident][]" value="{{$item['ident']}}">
                                <input type="checkbox" name="attr[value][]" @if($article->{$item['ident']} == 1) checked
                                       @endif lay-skin="primary" value="1" title="{{$item['name']}}">
                            @endforeach
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label required">内容</label>
                        <div class="layui-input-block">
                            <textarea id="content" name="content" rows="20" class="layui-textarea editor"
                                      placeholder="请输入内容">{{$article->content}}</textarea>
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
                                <input type="text" name="attr[ident][]" class="layui-input" placeholder="配置标识"
                                       value="">
                            </div>
                            <div class="layui-input-inline">
                                <input type="text" name="attr[value][]" class="layui-input" placeholder="配置值"
                                       value="">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item" id="diy-button">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block">
                            <button type="button" id="add-diy-button"
                                    class="layui-btn layui-btn-primary layui-btn-sm">
                                新增配置 +
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="hr-line"></div>
            <div class="layui-form-item text-center">
                <input type="hidden" name="id" value="{{$article->id}}">
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
                $('#diy-button').before(html);
            }
        );
    });
</script>

</body>
</html>
