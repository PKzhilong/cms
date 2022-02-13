define(["jquery", "easy-admin"], function ($, ea) {

    var init = {
        table_elem: '#currentTable',
        table_render_id: 'currentTableRenderId',
        index_url: '/addon/upgrade',
        upgrade_url: '/addon/upgrade/version',
    };

    return {

        index: function () {

            ea.table.render({
                init: init,
                toolbar: [
                    [{
                        text: '检测版本更新',
                        class: 'layui-btn layui-btn-normal layui-btn-sm',
                        icon: 'fa fa-plus',
                        url: init.upgrade_url
                    }]
                ],
                cols: [[
                    {field: 'id', minWidth: 80, title: '序号'},
                    {field: 'before_version', minWidth: 80, title: '更新前'},
                    {field: 'after_version', minWidth: 80, title: '更新后'},
                    {field: 'created_at', minWidth: 120, title: '时间'},
                ]],
            });

            ea.listen();
        }, version: function () {
            ea.listen();
        }

    };
});
