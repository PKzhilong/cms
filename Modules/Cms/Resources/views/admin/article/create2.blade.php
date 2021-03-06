@extends('cms::admin.article.body')
@section('content')
    <el-container>
        <el-main>
            <el-form ref="form" :model="form" :rules="rules" label-width="80px">
                <el-form-item label="标题" prop="title">
                    <el-input v-model="form.title"></el-input>
                </el-form-item>
                <el-form-item label="所需积分" prop="q">
                    <el-input v-model="form.q"></el-input>
                </el-form-item>
                <el-form-item label="附件地址" prop="zip_url">
                    <el-input placeholder="请输入内容" v-model="form.zip_url">
                        <template slot="prepend">Http://</template>
                    </el-input>
                </el-form-item>

                <el-form-item label="视频地址" prop="video_url">
                    <el-input placeholder="请输入内容" v-model="form.video_url">
                        <template slot="prepend">Http://</template>
                    </el-input>
                </el-form-item>

                <el-form-item label="分类" prop="category_id">
                    <el-select v-model="form.category_id" placeholder="请选择分类">
                        @foreach($categories as $item)
                            <el-option label="{{$item['name']}}" value="{{$item['id']}}"></el-option>
                        @endforeach
                    </el-select>
                </el-form-item>
                <el-form-item label="作者" prop="author">
                    <el-input v-model="form.author"></el-input>
                </el-form-item>
                <el-form-item label="标签" prop="tags">
                    <el-input v-model="form.tags" placeholder="多个标签请用英文逗号（,）分开。"></el-input>
                </el-form-item>
                <el-form-item label="是否展示">
                    <el-switch
                        v-model="form.status"
                        active-color="#13ce66"
                        inactive-color="#ff4949">
                    </el-switch>
                </el-form-item>

                <el-form-item label="缩略图">

                    <el-upload list-type="picture-card" :auto-upload="true" action="{{route('system.upload.images')}}" name="file" :on-success="handleSuccessThumbnail">
                        <i slot="default" class="el-icon-plus"></i>
                        <div slot="file" slot-scope="{file}">
                            <img class="el-upload-list__item-thumbnail" :src="file.url" alt="">
                            <span class="el-upload-list__item-actions">
                             <span class="el-upload-list__item-preview" @click="handlePictureCardPreview(file)">
                                 <i class="el-icon-zoom-in"></i>
                             </span>
                                <span v-if="!disabled" class="el-upload-list__item-delete" @click="handleDownload(file)"><i class="el-icon-download"></i></span>
                               <span v-if="!disabled" class="el-upload-list__item-delete" @click="handleRemove2(file)">
                                <i class="el-icon-delete"></i>
                                </span>
                        </span>
                        </div>
                    </el-upload>
                    <el-dialog :visible.sync="dialogVisible">
                        <img width="100%" :src="form.thumbnail" alt="">
                    </el-dialog>


                </el-form-item>


                <el-form-item label="内容图片" pope="img">
                    <el-upload
                        class="upload-demo"
                        action="{{route('system.upload.images')}}"
                        :on-preview="handlePreview"
                        :on-remove="handleRemove"
                        :before-remove="beforeRemove"
                        multiple
                        :limit="3"
                        :on-exceed="handleExceed"
                        list-type="picture"
                        :on-success="handleSuccess"
                        name="file">
                        <el-button size="small" type="primary">点击上传</el-button>
                        <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
                    </el-upload>
                </el-form-item>
                <el-form-item label="描述" prop="description">
                    <el-input type="textarea" v-model="form.description"></el-input>
                </el-form-item>
                <el-form-item label="文章内容" prop="content">
                    <el-input type="textarea" v-model="form.content"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="success" @click="onSubmit('form')" plain>立即创建</el-button>
                    <el-button>取消</el-button>
                </el-form-item>
            </el-form>

        </el-main>

    </el-container>

@endsection

@section('script')
    <script>

        VueInitData = {
            el: '#app',
            data: {
                createUrl: "{{route('article.admin.create_info')}}",
                message: 'Hello Vue!',
                visible: false,
                form: {
                    title: '',
                    q: 0,
                    status: true,
                    shortTitle: '',
                    category_id: '',
                    attr: '',
                    author: '{{auth()->guard('admin')->user()->name}}',
                    tags: '',
                    description: '',
                    content: '',
                    zip_url: '',
                    video_url: '',
                    img: [],
                    thumbnail: ''
                },

                dialogImageUrl: '',
                dialogVisible: false,
                disabled: false,
                rules: {
                    title: [
                        {required: true, message: '请输入文章标题', trigger: 'blur'},
                        // { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                    ],
                    q: [
                        {required: true, message: '请输入积分', trigger: 'blur'}
                    ],
                    shortTitle: [
                        {required: true, message: '请输入短标题', trigger: 'blur'},
                        // { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                    ],
                    category_id: [
                        {required: true, message: '请选择文章分类', trigger: 'blur'},
                        // { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                    ],
                    author: [
                        {required: true, message: '请输入作者名', trigger: 'blur'},
                        // { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                    ],
                    tags: [
                        {required: true, message: '请输入作者名', trigger: 'blur'},
                        // { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                    ],

                    description: [
                        {required: true, message: '请输入作者名', trigger: 'blur'},
                        // { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                    ],
                    content: [
                        {required: true, message: '请输入作者名', trigger: 'blur'},
                        // { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                    ],
                    img: [
                        {required: true, message: '请上传图片', trigger: 'blur'},
                        // { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                    ],
                    zip_url: [
                        {required: true, message: '附件地址必须填写', trigger: 'blur'},
                        {message: '地址格式不对', trigger: 'blur', type: 'url'},
                        // { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                    ],
                    video_url: [
                        {required: false, message: '请填写视频地址', trigger: 'blur'},
                        {message: '地址格式不对', trigger: 'blur', type: 'url'},

                        // { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                    ],
                }

            },
            methods: {
                onSubmit: function (formName) {
                    this.$refs[formName].validate((valid) => {
                        if (!valid) {
                            this.$notify.error({
                                title: '失败',
                                message: '提交失败',
                            })
                            return false;
                        }

                        this.form.status = this.form.status ? 1 : 0
                        this.$http.post(this.createUrl, this.form).then((response) => {
                            if (response.data.code == 200) {
                                this.$notify({
                                    title: '创建成功',
                                    message: '创建文章',
                                    type: 'success',
                                    duration: 2000,
                                    onClose: function (msg) {
                                        var index = parent.layer.getFrameIndex(window.name)
                                        parent.layer.close(index)
                                    }
                                })
                            }
                        }).cache((error) => {
                            console.log(error)
                        })

                    });
                },
                handleRemove(file, fileList) {
                    console.log(file, fileList);
                },
                handlePreview(file) {
                    console.log(file);
                },
                handleExceed(files, fileList) {
                    this.$message.warning(`当前限制选择 3 个文件，本次选择了 ${files.length} 个文件，共选择了 ${files.length + fileList.length} 个文件`);
                },
                beforeRemove(file, fileList) {
                    return this.$confirm(`确定移除 ${file.name}？`);
                },
                handleSuccess(response, file, fileList) {
                    this.form.img.push({'name': file.name, 'url': response.data})
                },
                handleSuccessThumbnail(response, file, fileList) {
                    this.form.thumbnail = response.data
                },



                handleRemove2(file) {
                    console.log(file);
                },
                handlePictureCardPreview(file) {
                    this.dialogImageUrl = file.url;
                    this.dialogVisible = true;
                },
                handleDownload(file) {
                    console.log(file);
                }

            }
        }
    </script>
@endsection
