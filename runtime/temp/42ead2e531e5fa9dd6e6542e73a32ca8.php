<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:77:"/Users/huangpeng/program/hisiphp_environment/app/admin/view/module/design.php";i:1535793512;s:70:"/Users/huangpeng/program/hisiphp_environment/app/admin/view/layout.php";i:1535793512;s:76:"/Users/huangpeng/program/hisiphp_environment/app/admin/view/block/header.php";i:1535793512;s:74:"/Users/huangpeng/program/hisiphp_environment/app/admin/view/block/menu.php";i:1535793512;s:75:"/Users/huangpeng/program/hisiphp_environment/app/admin/view/block/layui.php";i:1535793512;s:76:"/Users/huangpeng/program/hisiphp_environment/app/admin/view/block/footer.php";i:1535793512;}*/ ?>
<?php if(input('param.hisi_iframe') || cookie('hisi_iframe')): ?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $_admin_menu_current['title']; ?> -  Powered by <?php echo config('hisiphp.name'); ?></title>
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <link rel="stylesheet" href="/static/admin/js/layui/css/layui.css?v=<?php echo config('hisiphp.version'); ?>">
    <link rel="stylesheet" href="/static/admin/css/theme.css?v=<?php echo config('hisiphp.version'); ?>">
    <link rel="stylesheet" href="/static/admin/css/style.css?v=<?php echo config('hisiphp.version'); ?>">
    <link rel="stylesheet" href="/static/fonts/typicons/min.css?v=<?php echo config('hisiphp.version'); ?>">
    <link rel="stylesheet" href="/static/fonts/font-awesome/min.css?v=<?php echo config('hisiphp.version'); ?>">
</head>
<body class="hisi-theme-<?php echo cookie('hisi_admin_theme'); ?>">
<div style="padding:0 10px;" class="mcolor"><?php echo runhook('system_admin_tips'); ?></div>
<?php else: ?>
<!DOCTYPE html>
<html>
<head>
    <title><?php if($_admin_menu_current['url'] == 'admin/index/index'): ?>管理控制台<?php else: ?><?php echo $_admin_menu_current['title']; endif; ?> -  Powered by <?php echo config('hisiphp.name'); ?></title>
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <link rel="stylesheet" href="/static/admin/js/layui/css/layui.css?v=<?php echo config('hisiphp.version'); ?>">
    <link rel="stylesheet" href="/static/admin/css/theme.css?v=<?php echo config('hisiphp.version'); ?>">
    <link rel="stylesheet" href="/static/admin/css/style.css?v=<?php echo config('hisiphp.version'); ?>">
    <link rel="stylesheet" href="/static/fonts/typicons/min.css?v=<?php echo config('hisiphp.version'); ?>">
    <link rel="stylesheet" href="/static/fonts/font-awesome/min.css?v=<?php echo config('hisiphp.version'); ?>">
</head>
<body class="hisi-theme-<?php echo cookie('hisi_admin_theme'); ?>">
<?php 
$ca = strtolower(request()->controller().'/'.request()->action());
 ?>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header" style="z-index:999!important;">
    <div class="fl header-logo">管理控制台</div>
    <div class="fl header-fold"><a href="javascript:;" title="打开/关闭左侧导航" class="aicon ai-caidan" id="foldSwitch"></a></div>
    <ul class="layui-nav fl nobg main-nav">
        <?php if(is_array($_admin_menu) || $_admin_menu instanceof \think\Collection || $_admin_menu instanceof \think\Paginator): $i = 0; $__LIST__ = $_admin_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if(($_admin_menu_parents['pid'] == $vo['id'] and $ca != 'plugins/run') or ($ca == 'plugins/run' and $vo['id'] == 3)): ?>
           <li class="layui-nav-item layui-this">
            <?php else: ?>
            <li class="layui-nav-item">
            <?php endif; ?> 
            <a href="javascript:;"><?php echo $vo['title']; ?></a></li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    <ul class="layui-nav fr nobg head-info">
        <li class="layui-nav-item"><a href="/" target="_blank" class="aicon ai-ai-home" title="前台"></a></li>
        <li class="layui-nav-item"><a href="<?php echo url('admin/index/clear'); ?>" class="j-ajax aicon ai-qingchu" refresh="yes" title="清缓存"></a></li>
        <li class="layui-nav-item"><a href="javascript:void(0);" class="aicon ai-suo" id="lockScreen" title="锁屏"></a></li>
        <li class="layui-nav-item">
            <a href="<?php echo url('admin/user/setTheme'); ?>" id="admin-theme-setting" class="aicon ai-theme"></a>
        </li>
        <li class="layui-nav-item">
            <a href="javascript:void(0);"><?php echo $admin_user['nick']; ?>&nbsp;&nbsp;</a>
            <dl class="layui-nav-child">
                <dd><a data-id="00" class="admin-nav-item top-nav-item" href="<?php echo url('admin/user/info'); ?>">个人设置</a></dd>
                <dd><a href="<?php echo url('admin/user/iframe'); ?>" class="j-ajax" refresh="yes"><?php echo input('cookie.hisi_iframe') ? '单页布局' : '框架布局'; ?></a></dd>
                <?php if(is_array($languages) || $languages instanceof \think\Collection || $languages instanceof \think\Paginator): $i = 0; $__LIST__ = $languages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['pack']): ?>
                    <dd><a href="<?php echo url('admin/index/index'); ?>?lang=<?php echo $vo['code']; ?>"><?php echo $vo['name']; ?></a></dd>
                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                <dd><a data-id="000" class="admin-nav-item top-nav-item" href="<?php echo url('admin/language/index'); ?>">语言包管理</a></dd>
                <dd><a href="<?php echo url('admin/publics/logout'); ?>">退出登陆</a></dd>
            </dl>
        </li>
    </ul>
</div>
<div class="layui-side layui-bg-black" id="switchNav">
    <div class="layui-side-scroll">
        <?php if(is_array($_admin_menu) || $_admin_menu instanceof \think\Collection || $_admin_menu instanceof \think\Paginator): $i = 0; $__LIST__ = $_admin_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if(($_admin_menu_parents['pid'] == $v['id'] and $ca != 'plugins/run') or ($ca == 'plugins/run' and $v['id'] == 3)): ?>
        <ul class="layui-nav layui-nav-tree">
        <?php else: ?>
        <ul class="layui-nav layui-nav-tree" style="display:none;">
        <?php endif; if(is_array($v['childs']) || $v['childs'] instanceof \think\Collection || $v['childs'] instanceof \think\Paginator): $kk = 0; $__LIST__ = $v['childs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($kk % 2 );++$kk;?>
            <li class="layui-nav-item <?php if($kk == 1): ?>layui-nav-itemed<?php endif; ?>">
                <a href="javascript:;"><i class="<?php echo $vv['icon']; ?>"></i><?php echo $vv['title']; ?><span class="layui-nav-more"></span></a>
                <dl class="layui-nav-child">
                    <?php if($vv['title'] == '快捷菜单'): ?>
                        <dd><a class="admin-nav-item" href="<?php echo url('admin/index/index'); ?>"><i class="aicon ai-shouye"></i> 后台首页</a></dd>
                        <?php if(is_array($vv['childs']) || $vv['childs'] instanceof \think\Collection || $vv['childs'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vv['childs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vvv): $mod = ($i % 2 );++$i;?>
                        <dd><a class="admin-nav-item" data-id="<?php echo $vvv['id']; ?>" href="<?php if(strpos('http', $vvv['url']) === false): ?>/<?php echo config('sys.admin_path').'/'.$vvv['url']; if($vvv['param']): ?>?<?php echo $vvv['param']; endif; else: ?><?php echo $vvv['url']; endif; ?>"><?php if(file_exists('.'.$vvv['icon'])): ?><img src="<?php echo $vvv['icon']; ?>" width="16" height="16" /><?php else: ?><i class="<?php echo $vvv['icon']; ?>"></i><?php endif; ?> <?php echo $vvv['title']; ?></a><i data-href="<?php echo url('menu/del?ids='.$vvv['id']); ?>" class="layui-icon j-del-menu">&#xe640;</i></dd>
                        <?php endforeach; endif; else: echo "" ;endif; else: if(is_array($vv['childs']) || $vv['childs'] instanceof \think\Collection || $vv['childs'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vv['childs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vvv): $mod = ($i % 2 );++$i;?>
                        <dd><a class="admin-nav-item" data-id="<?php echo $vvv['id']; ?>" href="<?php if(strpos('http', $vvv['url']) === false): ?>/<?php echo config('sys.admin_path').'/'.$vvv['url']; if($vvv['param']): ?>?<?php echo $vvv['param']; endif; else: ?><?php echo $vvv['url']; endif; ?>"><?php if(file_exists('.'.$vvv['icon'])): ?><img src="<?php echo $vvv['icon']; ?>" width="16" height="16" /><?php else: ?><i class="<?php echo $vvv['icon']; ?>"></i><?php endif; ?> <?php echo $vvv['title']; ?></a></dd>
                        <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                </dl>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>
<script type="text/html" id="hisi-theme-tpl">
    <ul class="hisi-themes">
        <?php $_result=session('hisi_admin_themes');if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <li data-theme="<?php echo $vo; ?>" class="hisi-theme-item-<?php echo $vo; ?>"></li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
</script>
    <div class="layui-body" id="switchBody">
        <ul class="bread-crumbs">
            <?php if(is_array($_bread_crumbs) || $_bread_crumbs instanceof \think\Collection || $_bread_crumbs instanceof \think\Paginator): $i = 0; $__LIST__ = $_bread_crumbs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if($key > 0 && $i != count($_bread_crumbs)): ?>
                    <li>></li>
                    <li><a href="<?php echo url($v['url'].'?'.$v['param']); ?>"><?php echo $v['title']; ?></a></li>
                <?php elseif($i == count($_bread_crumbs)): ?>
                    <li>></li>
                    <li><a href="javascript:void(0);"><?php echo $v['title']; ?></a></li>
                <?php else: ?>
                    <li><a href="javascript:void(0);"><?php echo $v['title']; ?></a></li>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
            <li><a href="<?php echo url('admin/menu/quick?id='.$_admin_menu_current['id']); ?>" title="添加到首页快捷菜单" class="j-ajax">[+]</a></li>
        </ul>
        <div style="padding:0 10px;" class="mcolor"><?php echo runhook('system_admin_tips'); ?></div>
        <div class="page-body">
<?php endif; switch($tab_type): case "1": ?>
    
        <div class="layui-tab layui-tab-card">
            <ul class="layui-tab-title">
                <?php if(is_array($tab_data['menu']) || $tab_data['menu'] instanceof \think\Collection || $tab_data['menu'] instanceof \think\Paginator): $i = 0; $__LIST__ = $tab_data['menu'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['url'] == $_admin_menu_current['url'] or (url($vo['url']) == $tab_data['current'])): ?>
                    <li class="layui-this">
                    <?php else: ?>
                    <li>
                    <?php endif; if(substr($vo['url'], 0, 4) == 'http'): ?>
                        <a href="<?php echo $vo['url']; ?>" target="_blank"><?php echo $vo['title']; ?></a>
                    <?php else: ?>
                        <a href="<?php echo url($vo['url']); ?>"><?php echo $vo['title']; ?></a>
                    <?php endif; ?>
                    </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <div class="tool-btns">
                    <a href="javascript:location.reload();" title="刷新当前页面" class="aicon ai-shuaxin2 font18"></a>
                    <a href="javascript:;" class="aicon ai-quanping1 font18" id="fullscreen-btn" title="打开/关闭全屏"></a>
                </div>
            </ul>
            <div class="layui-tab-content page-tab-content">
                <div class="layui-tab-item layui-show">
                    <form class="layui-form layui-form-pane" action="<?php echo url(); ?>" method="post">
    <fieldset class="layui-elem-field layui-field-title">
      <legend>模块基本信息</legend>
    </fieldset>
    <div class="layui-form-item">
        <label class="layui-form-label">模块名</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="name" lay-verify="required" autocomplete="off" placeholder="请输入模块名">
        </div>
        <div class="layui-form-mid layui-word-aux">模块名称只能为字母</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">模块标题</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="title" lay-verify="required" autocomplete="off" placeholder="请输入模块标题">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">模块标识</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="identifier" lay-verify="required" autocomplete="off" placeholder="请输入模块标识">
        </div>
        <div class="layui-form-mid layui-word-aux">格式：模块名(只能为字母).开发者标识(只能为字母、数字、下划线).module</div>
    </div>
<!--     <div class="layui-form-item">
        <label class="layui-form-label">模块图标</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" id="input-icon" name="icon" lay-verify="" autocomplete="off" placeholder="可自定义或使用系统图标">
        </div>
        <i class="" id="form-icon-preview"></i>
        <a href="<?php echo url('publics/icon?input=input-icon&show=form-icon-preview'); ?>" class="layui-btn layui-btn-primary j-iframe-pop fl">选择图标</a>
    </div> -->
    <div class="layui-form-item">
        <label class="layui-form-label">模块描述</label>
        <div class="layui-input-inline w300">
            <textarea  class="layui-textarea" name="intro" lay-verify="" autocomplete="off" placeholder="请填写模块描述"></textarea>
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开发者</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="author" lay-verify="" autocomplete="off" placeholder="请输入开发者">
        </div>
        <div class="layui-form-mid layui-word-aux">建议填写</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开发者网址</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="url" lay-verify="" autocomplete="off" placeholder="请输入开发者网址">
        </div>
        <div class="layui-form-mid layui-word-aux">建议填写</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">版本号</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="version" value="1.0.0" lay-verify="required" autocomplete="off" placeholder="请输入版本号">
        </div>
        <div class="layui-form-mid layui-word-aux">版本号格式采用三段式：主版本号.次版本号.修订版本号</div>
    </div>
    <fieldset class="layui-elem-field layui-field-title">
      <legend>快速生成模块目录结构</legend>
    </fieldset>
    <div class="layui-form-item">
        <label class="layui-form-label">公共文件</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="file" value="common.php,config.php" lay-verify="" autocomplete="off" placeholder="多个文件以逗号(,)分割">
        </div>
        <div class="layui-form-mid layui-word-aux">多个文件以逗号 "," 分割</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">模块目录</label>
        <div class="layui-input-inline w300">
            <textarea rows="8"  class="layui-textarea" name="dir" lay-verify="" autocomplete="off">admin
home
model
lang
sql
validate
view</textarea>
        </div>
        <div class="layui-form-mid layui-word-aux">在当前模块下生成目录<br>admin(后台控制器)<br>home(前台控制器)<br>model(模型层)<br>lang(语言包)<br>sql(数据库文件)<br>vaidate(验证规则)<br>view(视图)<br><span style="color:red">前台模板路径：/theme/模块名/default/，后台静态文件路径：/static/模块名/</span></div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">生成模块</button>
            <a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
        </div>
    </div>
</form>
<script src="/static/admin/js/layui/layui.js?v=<?php echo config('hisiphp.version'); ?>"></script>
<script>
    var ADMIN_PATH = "<?php echo $_SERVER['SCRIPT_NAME']; ?>";
    layui.config({
        base: '/static/admin/js/',
        version: '<?php echo config("hisiphp.version"); ?>'
    }).use('global');
</script>
                </div>
            </div>
        </div>
    <?php break; case "2": ?>
    
        <div class="layui-tab layui-tab-card">
            <ul class="layui-tab-title">
                <?php if(is_array($tab_data['menu']) || $tab_data['menu'] instanceof \think\Collection || $tab_data['menu'] instanceof \think\Paginator): $k = 0; $__LIST__ = $tab_data['menu'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;if($k == 1): ?>
                    <li class="layui-this">
                    <?php else: ?>
                    <li>
                    <?php endif; ?>
                    <a href="javascript:;"><?php echo $vo['title']; ?></a>
                    </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <div class="tool-btns">
                    <a href="javascript:location.reload();" title="刷新当前页面" class="aicon ai-shuaxin2 font18"></a>
                    <a href="javascript:;" class="aicon ai-quanping1 font18" id="fullscreen-btn" title="打开/关闭全屏"></a>
                </div>
            </ul>
            <div class="layui-tab-content page-tab-content">
                <form class="layui-form layui-form-pane" action="<?php echo url(); ?>" method="post">
    <fieldset class="layui-elem-field layui-field-title">
      <legend>模块基本信息</legend>
    </fieldset>
    <div class="layui-form-item">
        <label class="layui-form-label">模块名</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="name" lay-verify="required" autocomplete="off" placeholder="请输入模块名">
        </div>
        <div class="layui-form-mid layui-word-aux">模块名称只能为字母</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">模块标题</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="title" lay-verify="required" autocomplete="off" placeholder="请输入模块标题">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">模块标识</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="identifier" lay-verify="required" autocomplete="off" placeholder="请输入模块标识">
        </div>
        <div class="layui-form-mid layui-word-aux">格式：模块名(只能为字母).开发者标识(只能为字母、数字、下划线).module</div>
    </div>
<!--     <div class="layui-form-item">
        <label class="layui-form-label">模块图标</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" id="input-icon" name="icon" lay-verify="" autocomplete="off" placeholder="可自定义或使用系统图标">
        </div>
        <i class="" id="form-icon-preview"></i>
        <a href="<?php echo url('publics/icon?input=input-icon&show=form-icon-preview'); ?>" class="layui-btn layui-btn-primary j-iframe-pop fl">选择图标</a>
    </div> -->
    <div class="layui-form-item">
        <label class="layui-form-label">模块描述</label>
        <div class="layui-input-inline w300">
            <textarea  class="layui-textarea" name="intro" lay-verify="" autocomplete="off" placeholder="请填写模块描述"></textarea>
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开发者</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="author" lay-verify="" autocomplete="off" placeholder="请输入开发者">
        </div>
        <div class="layui-form-mid layui-word-aux">建议填写</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开发者网址</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="url" lay-verify="" autocomplete="off" placeholder="请输入开发者网址">
        </div>
        <div class="layui-form-mid layui-word-aux">建议填写</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">版本号</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="version" value="1.0.0" lay-verify="required" autocomplete="off" placeholder="请输入版本号">
        </div>
        <div class="layui-form-mid layui-word-aux">版本号格式采用三段式：主版本号.次版本号.修订版本号</div>
    </div>
    <fieldset class="layui-elem-field layui-field-title">
      <legend>快速生成模块目录结构</legend>
    </fieldset>
    <div class="layui-form-item">
        <label class="layui-form-label">公共文件</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="file" value="common.php,config.php" lay-verify="" autocomplete="off" placeholder="多个文件以逗号(,)分割">
        </div>
        <div class="layui-form-mid layui-word-aux">多个文件以逗号 "," 分割</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">模块目录</label>
        <div class="layui-input-inline w300">
            <textarea rows="8"  class="layui-textarea" name="dir" lay-verify="" autocomplete="off">admin
home
model
lang
sql
validate
view</textarea>
        </div>
        <div class="layui-form-mid layui-word-aux">在当前模块下生成目录<br>admin(后台控制器)<br>home(前台控制器)<br>model(模型层)<br>lang(语言包)<br>sql(数据库文件)<br>vaidate(验证规则)<br>view(视图)<br><span style="color:red">前台模板路径：/theme/模块名/default/，后台静态文件路径：/static/模块名/</span></div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">生成模块</button>
            <a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
        </div>
    </div>
</form>
<script src="/static/admin/js/layui/layui.js?v=<?php echo config('hisiphp.version'); ?>"></script>
<script>
    var ADMIN_PATH = "<?php echo $_SERVER['SCRIPT_NAME']; ?>";
    layui.config({
        base: '/static/admin/js/',
        version: '<?php echo config("hisiphp.version"); ?>'
    }).use('global');
</script>
            </div>
        </div>
    <?php break; case "3": ?>
    
        <form class="layui-form layui-form-pane" action="<?php echo url(); ?>" method="post">
    <fieldset class="layui-elem-field layui-field-title">
      <legend>模块基本信息</legend>
    </fieldset>
    <div class="layui-form-item">
        <label class="layui-form-label">模块名</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="name" lay-verify="required" autocomplete="off" placeholder="请输入模块名">
        </div>
        <div class="layui-form-mid layui-word-aux">模块名称只能为字母</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">模块标题</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="title" lay-verify="required" autocomplete="off" placeholder="请输入模块标题">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">模块标识</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="identifier" lay-verify="required" autocomplete="off" placeholder="请输入模块标识">
        </div>
        <div class="layui-form-mid layui-word-aux">格式：模块名(只能为字母).开发者标识(只能为字母、数字、下划线).module</div>
    </div>
<!--     <div class="layui-form-item">
        <label class="layui-form-label">模块图标</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" id="input-icon" name="icon" lay-verify="" autocomplete="off" placeholder="可自定义或使用系统图标">
        </div>
        <i class="" id="form-icon-preview"></i>
        <a href="<?php echo url('publics/icon?input=input-icon&show=form-icon-preview'); ?>" class="layui-btn layui-btn-primary j-iframe-pop fl">选择图标</a>
    </div> -->
    <div class="layui-form-item">
        <label class="layui-form-label">模块描述</label>
        <div class="layui-input-inline w300">
            <textarea  class="layui-textarea" name="intro" lay-verify="" autocomplete="off" placeholder="请填写模块描述"></textarea>
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开发者</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="author" lay-verify="" autocomplete="off" placeholder="请输入开发者">
        </div>
        <div class="layui-form-mid layui-word-aux">建议填写</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开发者网址</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="url" lay-verify="" autocomplete="off" placeholder="请输入开发者网址">
        </div>
        <div class="layui-form-mid layui-word-aux">建议填写</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">版本号</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="version" value="1.0.0" lay-verify="required" autocomplete="off" placeholder="请输入版本号">
        </div>
        <div class="layui-form-mid layui-word-aux">版本号格式采用三段式：主版本号.次版本号.修订版本号</div>
    </div>
    <fieldset class="layui-elem-field layui-field-title">
      <legend>快速生成模块目录结构</legend>
    </fieldset>
    <div class="layui-form-item">
        <label class="layui-form-label">公共文件</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="file" value="common.php,config.php" lay-verify="" autocomplete="off" placeholder="多个文件以逗号(,)分割">
        </div>
        <div class="layui-form-mid layui-word-aux">多个文件以逗号 "," 分割</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">模块目录</label>
        <div class="layui-input-inline w300">
            <textarea rows="8"  class="layui-textarea" name="dir" lay-verify="" autocomplete="off">admin
home
model
lang
sql
validate
view</textarea>
        </div>
        <div class="layui-form-mid layui-word-aux">在当前模块下生成目录<br>admin(后台控制器)<br>home(前台控制器)<br>model(模型层)<br>lang(语言包)<br>sql(数据库文件)<br>vaidate(验证规则)<br>view(视图)<br><span style="color:red">前台模板路径：/theme/模块名/default/，后台静态文件路径：/static/模块名/</span></div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">生成模块</button>
            <a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
        </div>
    </div>
</form>
<script src="/static/admin/js/layui/layui.js?v=<?php echo config('hisiphp.version'); ?>"></script>
<script>
    var ADMIN_PATH = "<?php echo $_SERVER['SCRIPT_NAME']; ?>";
    layui.config({
        base: '/static/admin/js/',
        version: '<?php echo config("hisiphp.version"); ?>'
    }).use('global');
</script>
    <?php break; default: ?>
    
        <div class="layui-tab layui-tab-card">
            <ul class="layui-tab-title">
                <li class="layui-this">
                    <a href="javascript:;" id="curTitle"><?php echo $_admin_menu_current['title']; ?></a>
                </li>
                <div class="tool-btns">
                    <a href="javascript:location.reload();" title="刷新当前页面" class="aicon ai-shuaxin2 font18"></a>
                    <a href="javascript:;" class="aicon ai-quanping1 font18" id="fullscreen-btn" title="打开/关闭全屏"></a>
                </div>
            </ul>
            <div class="layui-tab-content page-tab-content">
                <div class="layui-tab-item layui-show">
                    <form class="layui-form layui-form-pane" action="<?php echo url(); ?>" method="post">
    <fieldset class="layui-elem-field layui-field-title">
      <legend>模块基本信息</legend>
    </fieldset>
    <div class="layui-form-item">
        <label class="layui-form-label">模块名</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="name" lay-verify="required" autocomplete="off" placeholder="请输入模块名">
        </div>
        <div class="layui-form-mid layui-word-aux">模块名称只能为字母</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">模块标题</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="title" lay-verify="required" autocomplete="off" placeholder="请输入模块标题">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">模块标识</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="identifier" lay-verify="required" autocomplete="off" placeholder="请输入模块标识">
        </div>
        <div class="layui-form-mid layui-word-aux">格式：模块名(只能为字母).开发者标识(只能为字母、数字、下划线).module</div>
    </div>
<!--     <div class="layui-form-item">
        <label class="layui-form-label">模块图标</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" id="input-icon" name="icon" lay-verify="" autocomplete="off" placeholder="可自定义或使用系统图标">
        </div>
        <i class="" id="form-icon-preview"></i>
        <a href="<?php echo url('publics/icon?input=input-icon&show=form-icon-preview'); ?>" class="layui-btn layui-btn-primary j-iframe-pop fl">选择图标</a>
    </div> -->
    <div class="layui-form-item">
        <label class="layui-form-label">模块描述</label>
        <div class="layui-input-inline w300">
            <textarea  class="layui-textarea" name="intro" lay-verify="" autocomplete="off" placeholder="请填写模块描述"></textarea>
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开发者</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="author" lay-verify="" autocomplete="off" placeholder="请输入开发者">
        </div>
        <div class="layui-form-mid layui-word-aux">建议填写</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开发者网址</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="url" lay-verify="" autocomplete="off" placeholder="请输入开发者网址">
        </div>
        <div class="layui-form-mid layui-word-aux">建议填写</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">版本号</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="version" value="1.0.0" lay-verify="required" autocomplete="off" placeholder="请输入版本号">
        </div>
        <div class="layui-form-mid layui-word-aux">版本号格式采用三段式：主版本号.次版本号.修订版本号</div>
    </div>
    <fieldset class="layui-elem-field layui-field-title">
      <legend>快速生成模块目录结构</legend>
    </fieldset>
    <div class="layui-form-item">
        <label class="layui-form-label">公共文件</label>
        <div class="layui-input-inline w300">
            <input type="text" class="layui-input" name="file" value="common.php,config.php" lay-verify="" autocomplete="off" placeholder="多个文件以逗号(,)分割">
        </div>
        <div class="layui-form-mid layui-word-aux">多个文件以逗号 "," 分割</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">模块目录</label>
        <div class="layui-input-inline w300">
            <textarea rows="8"  class="layui-textarea" name="dir" lay-verify="" autocomplete="off">admin
home
model
lang
sql
validate
view</textarea>
        </div>
        <div class="layui-form-mid layui-word-aux">在当前模块下生成目录<br>admin(后台控制器)<br>home(前台控制器)<br>model(模型层)<br>lang(语言包)<br>sql(数据库文件)<br>vaidate(验证规则)<br>view(视图)<br><span style="color:red">前台模板路径：/theme/模块名/default/，后台静态文件路径：/static/模块名/</span></div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">生成模块</button>
            <a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-primary ml10"><i class="aicon ai-fanhui"></i>返回</a>
        </div>
    </div>
</form>
<script src="/static/admin/js/layui/layui.js?v=<?php echo config('hisiphp.version'); ?>"></script>
<script>
    var ADMIN_PATH = "<?php echo $_SERVER['SCRIPT_NAME']; ?>";
    layui.config({
        base: '/static/admin/js/',
        version: '<?php echo config("hisiphp.version"); ?>'
    }).use('global');
</script>
                </div>
            </div>
        </div>
<?php endswitch; if(input('param.hisi_iframe') || cookie('hisi_iframe')): ?>
</body>
</html>
<?php else: ?>
        </div>
    </div>
    <div class="layui-footer footer">
        <span class="fl">Powered by <a href="<?php echo config('hisiphp.url'); ?>" target="_blank"><?php echo config('hisiphp.name'); ?></a> v<?php echo config('hisiphp.version'); ?></span>
        <span class="fr"> © 2017-2018 <a href="<?php echo config('hisiphp.url'); ?>" target="_blank"><?php echo config('hisiphp.copyright'); ?></a> All Rights Reserved.</span>
    </div>
</div>
</body>
</html>
<?php endif; ?>