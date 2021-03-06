define(["jquery", "easy-admin"], function ($, ea) {

    var init = {
        table_elem: '#currentTable',
        table_render_id: 'currentTableRenderId',
        index_url: '/user/admin',
        add_url: '/user/admin/create',
        edit_url: '/user/admin/edit',
        delete_url: '/user/admin/destroy',
        modify_url: '/user/admin/modify',
        password_url: '/user/admin/password',
        account_url: '/user/admin/account',
        rank_url: '/user/admin/rank',
    };

    var point = {
        table_elem: '#currentTable',
        table_render_id: 'currentTableRenderId',
        index_url: '/user/admin/point',
    };

    var balance = {
        table_elem: '#currentTable',
        table_render_id: 'currentTableRenderId',
        index_url: '/user/admin/balance',
    };

    return {

        index: function () {

            ea.table.render({
                init: init,
                cols: [[
                    {type: "checkbox"},
                    {field: 'id', width: 80, title: 'ID'},
                    {field: 'name', minWidth: 80, title: '用户名', search: true},
                    {field: 'mobile', minWidth: 80, title: '手机号'},
                    {
                        field: 'user_rank.name', minWidth: 80, title: '会员等级', templet: function (d) {
                            return d.user_rank ? d.user_rank.name : '无';
                        }
                    },
                    {field: 'balance', minWidth: 80, title: '余额'},
                    {field: 'point', minWidth: 80, title: '积分'},
                    {
                        field: 'status',
                        title: '状态',
                        width: 85,
                        search: 'select',
                        selectList: {0: '禁用', 1: '启用'},
                        templet: ea.table.switch
                    },
                    {field: 'created_at', minWidth: 120, title: '创建时间'},
                    {field: 'updated_at', minWidth: 120, title: '更新时间'},
                    {
                        width: 250,
                        title: '操作',
                        templet: ea.table.tool,
                        operat: [
                            'edit',
                            [{
                                text: '重置密码',
                                url: init.password_url,
                                method: 'open',
                                auth: 'password',
                                class: 'layui-btn layui-btn-normal layui-btn-xs',
                            },
                                {
                                    text: '资金变动',
                                    url: init.account_url,
                                    method: 'open',
                                    auth: 'password',
                                    class: 'layui-btn layui-btn-primary layui-btn-xs',
                                }
                            ],
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
        },
        password: function () {
            ea.listen();
        },
        account: function () {
            ea.listen();
        },
        balance: function () {

            ea.table.render({
                init: balance,
                search: false,
                toolbar: ['refresh'],
                cols: [[
                    {type: "checkbox"},
                    {field: 'id', width: 80, title: '序号'},
                    {field: 'user_id', minWidth: 80, title: '用户ID'},
                    {field: 'user.name', minWidth: 80, title: '用户名'},
                    {field: 'before', minWidth: 80, title: '变动前'},
                    {field: 'balance', minWidth: 80, title: '变动金额'},
                    {field: 'after', minWidth: 80, title: '变动后'},
                    {field: 'description', minWidth: 80, title: '备注信息'},
                    {field: 'created_at', minWidth: 120, title: '变动时间'},
                ]],
            });

            ea.listen();
        },
        point: function () {

            ea.table.render({
                init: point,
                search: false,
                toolbar: ['refresh'],
                cols: [[
                    {type: "checkbox"},
                    {field: 'id', width: 80, title: '序号'},
                    {field: 'user_id', minWidth: 80, title: '用户ID'},
                    {field: 'user.name', minWidth: 80, title: '用户名'},
                    {field: 'before', minWidth: 80, title: '变动前'},
                    {field: 'point', minWidth: 80, title: '变动金额'},
                    {field: 'after', minWidth: 80, title: '变动后'},
                    {field: 'description', minWidth: 80, title: '备注信息'},
                    {field: 'created_at', minWidth: 120, title: '变动时间'},
                ]],
            });

            ea.listen();
        },
        rank: function () {

            ea.table.render({
                init: {
                    table_elem: '#currentTable',
                    table_render_id: 'currentTableRenderId',
                    index_url: init.rank_url,
                    add_url: init.rank_url + '/create',
                    edit_url: init.rank_url + '/edit',
                    delete_url: init.rank_url + '/destroy',
                },
                search: false,
                cols: [[
                    {type: "checkbox"},
                    {field: 'id', width: 80, title: '序号'},
                    {field: 'name', minWidth: 80, title: '等级名称'},
                    {field: 'number', minWidth: 80, title: '等级编码'},
                    {field: 'description', minWidth: 80, title: '备注信息'},
                    {field: 'created_at', minWidth: 120, title: '变动时间'},
                ]],
            });

            ea.listen();
        }, rankCreate: function () {
            ea.listen();
        }, rankEdit: function () {
            ea.listen();
        }
    };
});
