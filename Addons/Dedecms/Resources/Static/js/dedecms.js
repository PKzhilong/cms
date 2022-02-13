define(["jquery", "easy-admin"], function ($, ea) {

    var init = {
        table_elem: '#currentTable',
        table_render_id: 'currentTableRenderId',
        index_url: '/addon/dede',
        config_url: '/addon/dede/config',
        article_url: '/addon/dede/import/article',
        goods_url: '/addon/dede/import/goods',
    };

    return {

        index: function () {

            ea.table.render({
                init: init,
                toolbar: ['refresh', 'config', [
                    {
                        text: '导入文章',
                        class: 'layui-btn layui-btn-sm',
                        url: init.article_url,
                        method: 'request'
                    }, {
                        text: '导入商品',
                        class: 'layui-btn layui-btn-danger layui-btn-sm',
                        url: init.goods_url,
                        method: 'request'
                    }
                ]],
                cols: [[
                    {field: 'id', minWidth: 80, title: '序号'},
                    {field: 'type', minWidth: 80, title: '类型'},
                    {field: 'oid', minWidth: 80, title: '原ID'},
                    {field: 'mid', minWidth: 80, title: '新ID'},
                    {field: 'title', minWidth: 80, title: '标题'},
                    {field: 'created_at', minWidth: 120, title: '时间'},
                ]],
            });

            ea.listen();
        }, config: function () {
            ea.listen();
        },

    };
});
