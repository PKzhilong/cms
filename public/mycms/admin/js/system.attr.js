define(["jquery", "easy-admin"], function ($, ea) {

    var init = {
        table_elem: '#currentTable',
        table_render_id: 'currentTableRenderId',
        index_url: '/system/attr',
        add_url: '/system/attr/create',
        edit_url: '/system/attr/edit',
        delete_url: '/system/attr/destroy',
    };

    return {

        index: function () {

            ea.table.render({
                init: init,
                cols: [[
                    {type: "checkbox"},
                    {field: 'id', width: 80, title: 'ID'},
                    {field: 'ident', minWidth: 80, title: '标识'},
                    {field: 'name', minWidth: 80, title: '名称'},
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
