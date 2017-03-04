<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh_ch">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp">

    <!--[if lt IE 9]><meta http-equiv="refresh" content="0;ie.html" /><![endif]-->

    <title>
        添加美文
    </title>
    <!--公用静态文件-->
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/Public/Admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Admin/css/font-awesome.min.css" rel="stylesheet">
    <link href="/Public/Admin/css/animate.min.css" rel="stylesheet">
    <link href="/Public/Admin/css/style.min.css" rel="stylesheet">
    
    <style>
        .hidden{
            display: none;
        }
    </style>

</head>

    <body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>添加美文</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal" enctype="multipart/form-data" action="/admin.php/Home/Beautifulwords/w_add.html">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">标题：</label>
                                <div class="col-sm-9">
                                    <input type="text" name="title" class="form-control" placeholder="标题" maxlength="50" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">作者：</label>
                                <div class="col-sm-9">
                                    <input type="text" name="author" class="form-control" placeholder="作者" maxlength="10" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">音频：</label>
                                <div class="col-sm-9">
                                    <input type="file" name="audio" class="form-control">
                                    <span class="help-block m-b-none">请上传mp3格式的音频文件</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">封面：</label>
                                <div class="col-sm-9">
                                    <input type="file" name="cover" class="form-control" required>
                                    <span class="help-block m-b-none">请上传gif,jpg,jpeg,png格式的文件</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">编辑形式：</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="editor_way" id="editor_way">
                                        <option value="0">文本编辑</option>
                                        <option value="1">添加链接</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" id="edit">
                                <label class="col-sm-3 control-label">内容：</label>
                                <div class="col-sm-9">
                                    <script id="editor" type="text/plain" style="width:100%;height:300px;" name="content"></script>
                                </div>
                            </div>

                            <div class="form-group hidden" id="url">
                                <label class="col-sm-3 control-label">链接地址：</label>
                                <div class="col-sm-9">
                                    <input type="text" name="url" class="form-control" placeholder="链接地址" maxlength="200">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <div class="col-sm-12 col-sm-offset-3">
                                    <button class="btn btn-primary" type="submit">确认添加</button>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>

<script src="/Public/Admin/js/jquery.min.js"></script>
<script src="/Public/Admin/js/bootstrap.min.js"></script>

    <!--引入编辑器静态文件-->
    <script type="text/javascript" charset="utf-8" src="/Public/Plugins/js/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/Plugins/js/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/Public/Plugins/js/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script>
        //创建编辑器
        var ue = UE.getEditor('editor');
        //文件上传地址
        UE.Editor.prototype._bkGetActionUrl = UE.Editor.prototype.getActionUrl;
        UE.Editor.prototype.getActionUrl = function(action) {
            if (action == 'uploadimage' || action == 'uploadscrawl' || action == 'uploadimage') {
                return '<?php echo ($url); ?>';
            } else if (action == 'uploadvideo') {
                return '<?php echo ($url); ?>';
            } else {
                return this._bkGetActionUrl.call(this, action);
            }
        }
        document.getElementById('editor_way').onchange = function () {
            if (this.value == 0) {
                $('#url').addClass('hidden');
                $('#edit').removeClass('hidden');
            } else {
                $('#edit').addClass('hidden');
                $('#url').removeClass('hidden');
            }
        }


    </script>

</html>