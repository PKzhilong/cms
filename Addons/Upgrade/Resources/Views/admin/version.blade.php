@include("system::admin.layouts._header")
<body>
<div class="layuimini-container">

    <div class="layuimini-main">
        <form id="app-form" class="layui-form layuimini-form" method="post">
            @if($response)
                @if($response['code'] == 200)
                    <table id="currentTable" class="layui-table">
                        <thead>
                        <tr>
                            <th>文件</th>
                            <th>状态</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($files as $file)
                            @if(in_array($file['status'],array_keys($status)))
                                <tr>
                                    <td>{{$file['filename']}}</td>
                                    <td>{{$status[$file['status']]}}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>

                    <div class="layui-form-item">
                        <label class="layui-form-label">更新版本</label>
                        <div class="layui-input-block">
                            <input type="text" name="upgrade_version" class="layui-input" readonly
                                   value="{{$response['result']['version']}}">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">更新包</label>
                        <div class="layui-input-block">
                            <input type="text" name="upgrade_package" class="layui-input" readonly
                                   value="{{$response['result']['zip_path']}}">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block">
                            <p style="color: red">更新升级前，请确保已经备份好数据库及代码！！！</p>
                        </div>
                    </div>

                    <div class="hr-line"></div>
                    <div class="layui-form-item text-center">
                        <button type="submit" class="layui-btn layui-btn-normal layui-btn-sm" lay-submit>确认更新</button>
                    </div>

                @else
                    <p>{{$response['msg']}}</p>
                @endif
            @else
                <p>该版本无法使用一键升级</p>
            @endif
        </form>
    </div>

</div>
</body>
</html>
