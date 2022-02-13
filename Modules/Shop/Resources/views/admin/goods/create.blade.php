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
                        <label class="layui-form-label required">商品分类</label>
                        <div class="layui-input-block">
                            <select name="category_id" id="category_id" lay-filter="category_id">
                                <option value="0">选择商品分类</option>
                                @foreach($categories as $item)
                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label required">名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="goods_name" class="layui-input" lay-verify="required"
                                   lay-reqtext="请输入名称" placeholder="请输入名称" value="">
                            <tip>填写名称。</tip>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">短标题</label>
                        <div class="layui-input-block">
                            <input type="hidden" name="attr[ident][]" value="short_title">
                            <input type="text" name="attr[value][]" class="layui-input"
                                   placeholder="请输入短标题" value="">
                            <tip>填写短标题。</tip>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label required">主图</label>
                        <div class="layui-input-block layuimini-upload">
                            <input name="goods_image" class="layui-input layui-col-xs6" placeholder="请上传主图" value="">
                            <div class="layuimini-upload-btn">
                                <span><a class="layui-btn" data-upload="goods_image" data-upload-number="one"
                                         data-upload-exts="ico|png|jpg|jpeg"><i class="fa fa-upload"></i> 上传</a></span>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label required">相册</label>
                        <div class="layui-input-block layuimini-upload">
                            <input name="goods_albums" class="layui-input layui-col-xs6" placeholder="请上传相册" value="">
                            <div class="layuimini-upload-btn">
                                <span><a class="layui-btn" data-upload="goods_albums" data-upload-number="albums"
                                         data-upload-exts="ico|png|jpg|jpeg"><i class="fa fa-upload"></i> 上传</a></span>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label required">售价</label>
                        <div class="layui-input-block">
                            <input type="text" name="shop_price" class="layui-input" lay-verify="required"
                                   lay-reqtext="请输入售价" placeholder="请输入售价" value="">
                            <tip>填写售价。</tip>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">市场价</label>
                        <div class="layui-input-block">
                            <input type="text" name="market_price" class="layui-input" lay-reqtext="请输入市场价"
                                   placeholder="请输入市场价" value="">
                            <tip>填写市场价。</tip>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">库存</label>
                        <div class="layui-input-block">
                            <input type="text" name="stock" class="layui-input" lay-reqtext="请输入库存"
                                   placeholder="请输入库存" value="0">
                            <tip>填写库存。</tip>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">描述</label>
                        <div class="layui-input-block">
                            <textarea name="description" class="layui-textarea" placeholder="请输入描述"></textarea>
                            <tip>填写描述。</tip>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">属性</label>
                        <div class="layui-input-block">
                            @foreach($attributes as $item)
                                <input type="hidden" name="attr[ident][]" value="{{$item['ident']}}">
                                <input type="checkbox" name="attr[value][]" lay-skin="primary" value="1"
                                       title="{{$item['name']}}">
                            @endforeach
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label required">详情</label>
                        <div class="layui-input-block">
                            <textarea id="content" name="content" rows="20" class="layui-textarea editor"
                                      placeholder="请输入内容"></textarea>
                        </div>
                    </div>
                </div>
                <div class="layui-tab-item">

                    <div class="layui-form-item meta-item">
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
                <button type="submit" class="layui-btn layui-btn-normal layui-btn-sm" lay-submit>确认</button>
                <button type="reset" class="layui-btn layui-btn-primary layui-btn-sm">重置</button>
            </div>
        </div>

    </form>
</div>


<div style="display: none" id="diy-tpl">
    <div class="layui-form-item meta-item">
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

<div style="display: none" id="extend-tpl">
    <div class="layui-form-item meta-item">
        <label class="layui-form-label required">配置</label>
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" name="attr[ident][]" class="layui-input" placeholder="配置标识" value="{ident}">
            </div>
            <div class="layui-input-inline">
                <input type="text" name="attr[value][]" class="layui-input" placeholder="配置值" value="{value}">
            </div>
        </div>
    </div>
</div>

<script>
    layui.use(['jquery', 'form'], function () {
        var $ = layui.jquery,
            form = layui.form;

        $('#add-diy-button').click(
            function () {
                var html = $('#diy-tpl').html();
                $('#diy-button').before(html);
            }
        );

        form.on('select(category_id)', function (data) {
            $.get(
                "{{route('shop.category.metaToGoods')}}?id=" + data.value,
                function (result) {

                    var html = '';
                    $('.layui-tab-item .meta-item').remove();

                    for (var i in result['data']) {
                        var obj = result['data'][i];
                        html += $('#extend-tpl').html().replace("{ident}", obj.meta_key).replace("{value}", obj.meta_value);
                    }

                    $('#diy-button').before(html);
                }
            );
        });

    });
</script>

</body>
</html>
