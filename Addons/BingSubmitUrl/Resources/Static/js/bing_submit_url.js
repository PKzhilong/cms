define(["jquery", "easy-admin"], function ($, ea) {

    var init = {
        table_elem: '#currentTable',
        table_render_id: 'currentTableRenderId',
        index_url: '/addon/bing_submit_url',
        add_url: '/addon/bing_submit_url/create',
        config_url: '/addon/bing_submit_url/config',
    };

    return {

        index: function () {

            ea.table.render({
                init: init,
                toolbar: ['refresh', 'add', 'config'],
                cols: [[
                    {field: 'id', minWidth: 80, title: '流水号'},
                    {field: 'admin_name', minWidth: 80, title: '管理员名称'},
                    {field: 'url', minWidth: 80, title: '请求URL'},
                    {field: 'response', minWidth: 80, title: '响应'},
                    {field: 'created_at', minWidth: 120, title: '时间'},
                ]],
            });

            ea.listen();
        }, config: function () {
            ea.listen();
        }, create: function () {
            ea.listen();
        },

    };
});
