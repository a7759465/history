define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'people/index' + location.search,
                    add_url: 'people/add',
                    edit_url: 'people/edit',
                    del_url: 'people/del',
                    multi_url: 'people/multi',
                    import_url: 'people/import',
                    table: 'people',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                fixedColumns: true,
                fixedRightNumber: 1,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'surnames', title: __('Surnames'), operate: 'LIKE'},
                        {field: 'name', title: __('Name'), operate: 'LIKE'},
                        {field: 'zname', title: __('Zname'), operate: 'LIKE'},
                        {field: 'hname', title: __('Hname'), operate: 'LIKE'},
                        {field: 'sex', title: __('Sex'), searchList: {"男":__('男'),"女":__('女')}, formatter: Table.api.formatter.normal},
                        {field: 'father_id', title: __('Father_id')},
                        {field: 'mother_id', title: __('Mother_id')},
                        {field: 'native_city', title: __('Native_city'), operate: 'LIKE'},
                        {field: 'family_id', title: __('Family_id')},
                        {field: 'birthday', title: __('Birthday'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'deathday', title: __('Deathday'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'family.name', title: __('Family.name'), operate: 'LIKE'},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
