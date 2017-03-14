<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>书城</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0" name="viewport" />
    <link rel="stylesheet" type="text/css" href="<?php echo C('CSS');?>common.css"/>
    <script src="<?php echo C('JS');?>common.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo C('JS');?>jquery.min.js" type="text/javascript" charset="utf-8"></script>
    
	<link rel="stylesheet" type="text/css" href="<?php echo C('CSS');?>dropload.css"/>

</head>

	<body class="bookCity_body">
	<header class="bookCity_head">
		<a href="<?php echo U('Book/b_search');?>">请输入作者或书名</a>
		<nav class="bookCity_nav">
			<ul id="bookCity_nav">
				<li class="bookCity_nav_selected">全部</li>
				<?php if(is_array($categories)): $i = 0; $__LIST__ = $categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["category"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</nav>
	</header>
	<article class="bookCity_art">
		<section class="novel_list">
			<ul><!--<li class="novel_list_litop"><a href="#">
				<div class="index_img"><img src="<?php echo C('IMG');?>test_bg.png" class="index_img_cover"/><img src="<?php echo C('IMG');?>test_jb.png" class="index_img_mark"/></div>
				<div class="index_mes"><h5 class="color_black">三生三世十里桃花小说名</h5><p>作者：<em>不知道</em></p><p><em>123人在读</em><span>432万字</span></p></div>
			</a></li>-->
			</ul>
		</section>
		<section class="novel_list">
			<ul></ul>
		</section>
		<section class="novel_list">
			<ul></ul>
		</section>
		<section class="novel_list">
			<ul></ul>
		</section>
	</article>
	<footer>
		<ul class="novel_btn">
			<li class="novel_btn1"><a href="<?php echo U('Index/index');?>" class="color_hui"><em class="novel_btn_false"></em>首页</a></li>
			<li class="novel_btn2"><a href="javascript:void(0);" class="color_zhu"><em class="novel_btn_true"></em>书城</a></li>
			<li class="novel_btn3"><a href="<?php echo U('BeautifulWords/beautifulwords');?>" class="color_hui"><em class="novel_btn_false"></em>美文</a></li>
			<li class="novel_btn4"><a href="<?php echo U('bookshelf');?>" class="color_hui"><em class="novel_btn_false"></em>书架</a></li>
			<li class="novel_btn5"><a href="<?php echo U('User/me');?>" class="color_hui"><em class="novel_btn_false"></em>我</a></li>
		</ul>
	</footer>

	<script src="<?php echo C('JS');?>dropload.min.js"></script>
	<script>
		$(function(){
			$('.novel_list').eq(0).show().siblings('.novel_list').hide();
			var itemIndex = 0;
			var bool=[false,false,false,false];
			/********************************************************************************************************/
			var category = 0;
			var pageArr = [1,1,1,1];    //记录数据分页信息
			var loadArr = [true,true,true,true];
			//var pageDataArrObj = [[],[],[],[]];    //记录数组分页数据
			getData(0,pageArr[0],0);    //获取json数据
			pageArr[0]++;
			//console.log(tempData);
			//pageDataArrObj[0] = eval('('+tempData.responseText+')');
			//console.log(pageDataArrObj[0]);
			/*var content = '';    //输出内容
			var len = pageDataArrObj[0].length;
			for (var i = 0; i < len; ++i) {

			}*/


			function getData(category,page,index,execStart,execResult) {
				if (typeof execStart == "function") {
					execStart();
				}
				page = page || 0;    //判断是否传入第二个参数
				$.post('/index.php/Home/Book/library.html',{'category':category,'page':page},function (json) {
					var jsonData = eval('('+json+')');
					var len = jsonData.length;
					if (len == 0) {
						execResult('noData');
					}
					var content = '';
					var hot = '';
					for (var i = 0; i < len; ++i) {
						switch (jsonData[i].is_hot)
						{
							case 1:hot = '<img src="<?php echo C('IMG');?>hot.png" class="index_img_mark"/>';break;
							case 2:hot = '<img src="<?php echo C('IMG');?>new.png" class="index_img_mark"/>';break;
							case 3:hot = '<img src="<?php echo C('IMG');?>gratis.png" class="index_img_mark"/>';break;
							case 4:hot = '<img src="<?php echo C('IMG');?>updating.png" class="index_img_mark"/>';break;
							default:hot = '';break;
						}
						content +='<li class="novel_list_litop"><a href="/index.php/Home/Book/b_detail?b_id='+jsonData[i].id+'"><div class="index_img"><img src="'+jsonData[i].book_banner+'" class="index_img_cover"/>';
						content +=hot+'</div><div class="index_mes"><h5 class="color_black">'+jsonData[i].book_name+'</h5>';
					    content +='<p>作者：<em>'+jsonData[i].author+'</em></p><p><em>'+jsonData[i].readed_number+'人已读</em><span>'+jsonData[i].number_of_words+'字</span></p></div></a></li>';
					}
					$('.novel_list:eq('+index+') ul').append(content);
					if (typeof execResult == "function") {
						execResult();
					}

				});
			}
			console.log(pageArr);
			/********************************************************************************************************/

			//tab
			$('#bookCity_nav li').on('click',function(){
				var $this = $(this);
				itemIndex = $this.index();
				category = $this.val();
				$this.addClass('bookCity_nav_selected');
				$this.addClass('bookCity_nav_selected').siblings('#bookCity_nav li').removeClass('bookCity_nav_selected');
				$('.novel_list').eq(itemIndex).show().siblings('.novel_list').hide();
				// 如果数据没有加载完
				if(!bool[itemIndex]){
					// 解锁
					dropload.unlock();
					dropload.noData(false);
				}else{
					// 锁定
					dropload.lock('down');
					dropload.noData();
				}
				// 重置
				dropload.resetload();
			});
			// dropload
			var dropload = $('.bookCity_art').dropload({
				scrollArea : window,
				//distance : 500,
				domDown : {
					domClass   : 'dropload-down',
					domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
					domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中</div>',
					domNoData  : '<div class="dropload-noData">到底啦</div>'
				},
				loadDownFn : function(me){
					getData(
							category,
							pageArr[itemIndex],
							itemIndex,
							function () {
								me.lock();
							},
							function () {
								if (arguments[0] == 'noData') {
									console.log(arguments[0]);
									loadArr[itemIndex] = false;
									bool[itemIndex] = true;
									me.lock();
									me.noData();
								} else {
									me.unlock();
									me.resetload();
								}
							}
					);
					pageArr[itemIndex]++;

					/*var result = '';
					for(var i = 0; i < 4; i++){
						result +='<li class="novel_list_litop"><div class="index_img"><img src="<?php echo C('IMG');?>test_bg.png" class="index_img_cover"/><img src="<?php echo C('IMG');?>test_jb.png" class="index_img_mark"/></div><div class="index_mes"><h5>三生三世十里桃花小说名</h5><p>作者：<em>不知道</em></p><p><em>123人在读</em><span>432万字</span></p></div></li>';
						if(i== 3){
							// 数据加载完
							bool[itemIndex] = true;
							console.log(bool);
							// 锁定
							me.lock();
							// 无数据
							me.noData();
							break;
						}
					}
					// 为了测试，延迟1秒加载
					(function(){
						$('.novel_list:eq('+itemIndex+') ul').append(result);
						// 每次数据加载完，必须重置
						me.resetload();
					})();*/
					/*setTimeout(function(){
						$('.novel_list:eq('+itemIndex+') ul').append(result);
						// 每次数据加载完，必须重置
						me.resetload();
					},1000);*/

				}
			});
		});
	</script>
	</body>


<!--其他操作-->

</html>