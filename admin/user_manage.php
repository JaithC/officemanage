<?php
	require('common.php');
	if(!check_login()){
	    header('location:login.php');
	    exit();
	}
?>
<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>后台管理首页 - Office管理系统</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="https://www.layuicdn.com/layui/css/layui.css" media="all">
		<link rel="stylesheet" href="/res/css/app.css" media="all">
	</head>

	<body class="layui-layout-body">
		<div class="layui-layout layui-layout-admin">
			<?php include 'header.php' ?>

			<div class="layui-side layui-bg-cyan">
				<div class="layui-side-scroll">
					<ul class="layui-nav layui-bg-cyan layui-nav-tree" lay-filter="test">
						<li class="layui-nav-item layui-nav-itemed">
							<a class="" href="javascript:;">用户管理</a>
							<dl class="layui-nav-child">
								<dd>
									<a href="user_manage.php">用户列表</a>
								</dd>
								<dd>
									<a href="user_get.php">获取用户</a>
								</dd>
								<dd>
									<a href="user_auth.php">订阅管理</a>
								</dd>
							</dl>
						</li>
					</ul>
				</div>
			</div>

			<div class="layui-body">
				<div class="layui-content">
					<fieldset class="layui-elem-field layui-field-title">
					  <legend>用户列表</legend>
					</fieldset>
					<div class="layui-form">
			            <blockquote class="layui-elem-quote quoteBox">
			                <div class="layui-inline" style="margin-left: 2rem;">
			                    <a class="layui-btn" id="create"><i class="layui-icon">&#xe608;</i> 添加邀请码</a>
			                    <a class="layui-btn" id="add_account"><i class="layui-icon">&#xe608;</i> 管理已有用户</a>
			                </div>
			                <div class="layui-inline" style="margin-left: 1rem;">
			                    <select id="search_status">
			                        <option value="0">请选择是否使用</option>
			                        <option value="1">已使用</option>
			                        <option value="2">未使用</option>
			                    </select>
			                </div>
			                <div class="layui-inline" style="margin-left: 1rem;">
			                    <a class="layui-btn  layui-btn-normal" id="search"><i class="layui-icon ">&#xe615;</i> 搜索</a>
			                </div>
			                <div class="layui-inline" style="margin-left: 1rem;">
			                    <button type="button" class="layui-btn" id="export"><i class="layui-icon ">&#xe67d;</i> 导出</button>
			                </div>
			            </blockquote>
			        </div>
			        <table class="layui-hide" id="table" lay-filter="table">
			            
			        </table>
			        <div id="create_content" class="layui-form layui-form-pane" style="display: none;margin:1rem 3rem;">
			          <div class="layui-form-item">
			            <label class="layui-form-label">生成数量</label>
			            <div class="layui-input-block">
			              <input type="text" placeholder="请输入生成数量" class="layui-input" value="0" id="num">
			            </div>
			          </div>
			          <div class="layui-form-item">
			            <div class="layui-input-block">
			              <button class="layui-btn" lay-filter="formDemo" id="submit">立即提交</button>
			            </div>
			          </div>
			        </div>
			        <div id="add_account_content" class="layui-form layui-form-pane" style="display: none;margin:1rem 3rem;">
			          <div class="layui-form-item">
			            <label class="layui-form-label">用户账号</label>
			            <div class="layui-input-block">
			              <input type="text" placeholder="请输入用户邮箱" class="layui-input" id="add_email">
			            </div>
			          </div>
			          <div class="layui-form-item">
			            <div class="layui-input-block">
			              <button class="layui-btn" lay-filter="formDemo" id="submitaccount">立即提交</button>
			            </div>
			          </div>
			        </div>
				</div>
			</div>

			<?php include 'footer.php' ?>
		</div>
		<script type="text/html" id="buttons">
	      <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="accountactive">允许</a>
	      <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="accountinactive">禁止</a>
	      <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
	    </script>
		<script src="https://www.layuicdn.com/layui/layui.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" charset="utf-8">
        layui.use(['table','form','layer','element','jquery'], function(){
	          var table = layui.table;
	          var form = layui.form;
	          var element = layui.element;
	          var layer = layui.layer;
	          var $ = layui.jquery;
	            table.render({
	                elem: '#table',//表格id
	                url:"admin.php?a=invitation_code_list",//list接口地址
	                cellMinWidth: 80,//全局定义常规单元格的最小宽度
	                height: 'full-120',
	                page: true,
	                limits: [18, 50, 80, 100],
	                limit: 18,
	                cols: [[
	                //align属性是文字在列表中的位置 可选参数left center right
	                //sort属性是排序功能
	                //title是这列的标题
	                //field是取接口的字段值
	                //width是宽度，不填则自动根据值的长度
	                  {field:'id', title: 'ID',align: 'center'},
	                  {field:'code',title: '邀请码',align: 'center'},
	                  {field:'status',title: '状态',align: 'center',templet:function(d){
	                          if(d.status == 0){
	                              return '<span style="color:green;">未使用</span>';
	                          }else{
	                              return '<span style="color:red;">已使用</span>';
	                          }
	                  }},
	                  {field:'email',title: '注册账号',align: 'center',templet:function(d){
	                          if(d.email){
	                              return d.email;
	                          }else{
	                              return '-';
	                          }
	                  }},
	                  {field:'create_time', title: '创建时间',align: 'center'},
	                  {field:'update_time', title: '最后修改时间',align: 'center'},
	                  {field:'accountstatus', title: '账户状态',align: 'center'},
	                  {fixed:'right',title: '操作', width: 165, align:'center', toolbar: '#buttons'}
	                ]],
	          });
	           //监听
	          table.on('tool(table)', function(obj){
	              if(obj.event === 'del'){
	                  layer.confirm('真的删除吗', function(index){
	                      $.post("admin.php?a=invitation_code_delete",{email:obj.data.email,id:obj.data.id},function(res){
	                        if (res.code == 0) {
	                            obj.del();//删除表格这行数据
	                        }
	                        layer.msg(res.msg);
	                      },'json');
	                  });
	              }
	              if(obj.event === 'accountactive'){
	                  layer.confirm('允许登录?', function(index){
	                      $.post("admin.php?a=invitation_code_activeaccount",{email:obj.data.email},function(res){
	                       if (res.code == 1) {
	                          layer.closeAll();
	                          layui.use('table', function(){
	                              var table = layui.table;
	                              table.reload('table', { //表格的id
	                                  url:"admin.php?a=invitation_code_list",
	                              });
	                             })
	                        }
	                        layer.msg(res.msg);
	                      },'json');
	                  });
	              }
	              if(obj.event === 'accountinactive'){
	                  layer.confirm('禁止登录?', function(index){
	                      $.post("admin.php?a=invitation_code_inactiveaccount",{email:obj.data.email},function(res){
	                       if (res.code == 1) {
	                          layer.closeAll();
	                          layui.use('table', function(){
	                              var table = layui.table;
	                              table.reload('table', { //表格的id
	                                  url:"admin.php?a=invitation_code_list",
	                              });
	                             })
	                        }
	                        layer.msg(res.msg);
	                      },'json');
	                  });
	              }
	            });
	            $('#search').click(function(){
	                  //传递where条件实现搜索，并且重载表格数据
	                  layui.use('table', function(){
	                        var table = layui.table;
	                        table.reload('table', { //表格的id
	                            url:"admin.php?a=invitation_code_list",
	                            where:{
	                                'status':$('#search_status').val(),
	                            }
	                        });
	                  })
	            })
	            $(document).on('keydown', function(e){
	                if(e.keyCode == 13){
	                    $('#search').click();
	                }
	            })
	            $('#create').click(function(){
	                layer.open({
	                    type: 1,
	                    title:'添加邀请码',
	                    skin: 'layui-layer-rim', //加上边框
	                    area: ['50rem;', '12rem;'], //宽高
	                    content: $('#create_content'),
	                    shade: 0
	                });
	            });
	            $('#submit').click(function(){
	                var data = {
	                    num:$('#num').val(),
	                };
	                $.post("admin.php?a=invitation_code_create",data,function(res){
	                    if (res.code == 0) {
	                        layer.closeAll();
	                        layui.use('table', function(){
	                            var table = layui.table;
	                            table.reload('table', { //表格的id
	                                url:"admin.php?a=invitation_code_list",
	                            });
	                        })
	                    }
	                    layer.msg(res.msg);
	                },'json');
	            })
	            $('#add_account').click(function(){
	                layer.open({
	                    type: 1,
	                    title:'管理已有用户',
	                    skin: 'layui-layer-rim', //加上边框
	                    area: ['50rem;', '12rem;'], //宽高
	                    content: $('#add_account_content'),
	                    shade: 0
	                });
	            });
	            $('#submitaccount').click(function(){
	                var data = {
	                    email:$('#add_email').val(),
	                };
	                $.post("admin.php?a=invitation_code_add_account",data,function(res){
	                    if (res.code == 0) {
	                        layer.closeAll();
	                        layui.use('table', function(){
	                            var table = layui.table;
	                            table.reload('table', { //表格的id
	                                url:"admin.php?a=invitation_code_list",
	                            });
	                        })
	                    }
	                    layer.msg(res.msg);
	                },'json');
	            })
	            $('#export').click(function(){
	                var count = $('.layui-laypage-count').text().replace('共 ','').replace(' 条','');
	                $.get("admin.php?a=invitation_code_list"+'&page=1&limit='+count,function(res){
	                    if(res.code == 0){
	                        for(let k in res.data){
	                            res.data[k].status == 1 ? res.data[k].status = '已使用' : res.data[k].status = '未使用';
	                            res.data[k].eamil ? res.data[k].eamil = res.data[k].eamil : '-';
	                        }
	                        table.exportFile(['ID','邀请码','创建时间','修改时间','是否使用','注册账号'],res.data,'csv');
	                    }
	                },'json');
	            });
	        });
	    </script>
	</body>

</html>