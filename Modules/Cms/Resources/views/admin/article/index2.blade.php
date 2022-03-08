@extends('cms::admin.article.body')
@section('content')
    <el-container style="background: white; margin-top: 20px">
        <el-main>
            <template>
                <div style="margin-bottom: 20px">
                    <el-button type="primary" >创建</el-button>
                    {{--            <el-button @click="toggleSelection([tableData[1], tableData[2]])">切换第二、第三行的选中状态</el-button>--}}
                    <el-button @click="toggleSelection()" type="info" >取消选择</el-button>
                </div>

                <el-table
                    ref="multipleTable"
                    :data="tableData"
                    tooltip-effect="dark"
                    style="width: 100%"
                    @selection-change="handleSelectionChange">
                    <el-table-column
                        type="selection"
                        width="55">
                    </el-table-column>
                    <el-table-column
                        label="日期"
                        width="120">
                        <template slot-scope="scope">@{{ scope.row.date }}</template>
                    </el-table-column>
                    <el-table-column
                        prop="name"
                        label="姓名"
                        width="120">
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="地址"
                        show-overflow-tooltip>
                    </el-table-column>

                    <el-table-column>
                        <template slot-scope="scope">
                            <el-button
                                size="mini"
                                @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                            <el-button
                                size="mini"
                                type="danger"
                                @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                        </template>
                    </el-table-column>
                </el-table>

            </template>
            <div class="block" style="margin-top: 10px">
                <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page.sync="currentPage1"
                    :page-size="100"
                    layout="total, prev, pager, next"
                    :total="1000">
                </el-pagination>
            </div>
        </el-main>

    </el-container>


@endsection
@section('script')
    <script>
        VueInitData = {
            data: {
                tableData: [{
                    date: '2016-05-03',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                }, {
                    date: '2016-05-02',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                }, {
                    date: '2016-05-04',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                }, {
                    date: '2016-05-01',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                }, {
                    date: '2016-05-08',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                }, {
                    date: '2016-05-06',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                }, {
                    date: '2016-05-07',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                }],
                multipleSelection: [],
                currentPage1: 1,

                currentPage2: 5,
                currentPage3: 5,
                currentPage4: 4
            },
            methods: {
                toggleSelection(rows) {
                    if (rows) {
                        rows.forEach(row => {
                            this.$refs.multipleTable.toggleRowSelection(row);
                        });
                    } else {
                        this.$refs.multipleTable.clearSelection();
                    }
                },
                handleSelectionChange(val) {
                    this.multipleSelection = val;
                },
                handleSizeChange(val) {
                    console.log(`每页 ${val} 条`);
                },
                handleCurrentChange(val) {
                    console.log(`当前页: ${val}`);
                }
            }
        }


    </script>
@endsection
