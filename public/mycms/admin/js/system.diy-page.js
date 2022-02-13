define(["jquery", "easy-admin"], function ($, ea) {

    var init = {
        table_elem: '#currentTable',
        table_render_id: 'currentTableRenderId',
        index_url: '/system/diy-page',
        add_url: '/system/diy-page/create',
        edit_url: '/system/diy-page/edit',
        delete_url: '/system/diy-page/destroy',
    };

    return {

        index: function () {

            ea.table.render({
                init: init,
                cols: [[
                    {type: "checkbox"},
                    {field: 'id', width: 80, title: 'ID'},
                    {field: 'page_name', minWidth: 80, title: '页面名称'},
                    {field: 'page_path', minWidth: 80, title: '页面地址'},
                    {field: 'page_title', minWidth: 80, title: '页面标题'},
                    {field: 'page_keyword', minWidth: 80, title: '页面关键词'},
                    {field: 'page_desc', minWidth: 80, title: '页面描述'},
                    {field: 'created_at', minWidth: 120, title: '创建时间'},
                    {field: 'updated_at', minWidth: 120, title: '更新时间'},
                    {
                        width: 250,
                        title: '操作',
                        templet: ea.table.tool,
                        operat: [
                            'edit',
                            'delete'
                        ]
                    }
                ]],
            });

            ea.listen();
        },
        create: function () {
            ea.listen();
        },
        edit: function () {
            ea.listen();
        }
    };
});
