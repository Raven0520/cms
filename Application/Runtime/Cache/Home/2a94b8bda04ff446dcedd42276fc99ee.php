<?php if (!defined('THINK_PATH')) exit(); $config = D("Basic")->select(); $navs = D("Menu")->getBarMenus(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ($config["title"]); ?></title>
    <meta name="keywords" content="<?php echo ($config["keywords"]); ?>"/>
    <meta name="description" content="<?php echo ($config["description"]); ?>"/>
    <link rel="stylesheet" href="Public/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="Public/css/home/main.css" type="text/css"/>
</head>
<body>
<header id="header">
    <div class="navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <a href="/">
                    <img src="Public/images/logo.png" alt="">
                </a>
            </div>
            <ul class="nav navbar-nav navbar-left">
                <li><a href="/"
                    <?php if($result['catid'] == 0): ?>class="curr"<?php endif; ?>
                    >首页</a></li>
                <?php if(is_array($navs)): foreach($navs as $key=>$vo): ?><li><a href="/index.php?c=cat&id=<?php echo ($vo["menu_id"]); ?>"
                        <?php if($vo['menu_id'] == $result['catid']): ?>class="curr"<?php endif; ?>
                        ><?php echo ($vo["name"]); ?></a></li><?php endforeach; endif; ?>
            </ul>
        </div>
    </div>
</header>
<!--尝试让首页图片轮播-->
<style type="text/css">
    *{ margin:0; padding:0; text-decoration:none;}
    body{ padding:20px;}
    #container {width:670px; height:360px; border:3px solid #333; overflow:hidden; position:relative;}
    #list { width:4690px; height:360px; position:absolute; z-index:1;}
    #list img { float:left;}
    #buttons { position:absolute; height:10px; width:100px; z-index:2; bottom:20px; left:300px;}
    #buttons span { cursor:pointer; float:left; border:1px solid #fff; width:10px; height:10px; border-radius:50%; background: #333; margin-right: 5px;}
    #buttons .on {  background: orangered;}
        .arrow { cursor: pointer; display: none; line-height: 39px; text-align: center; font-size: 36px; font-weight: bold; width: 40px; height: 40px;  position: absolute; z-index: 2; top: 160px; background-color: RGBA(0,0,0,.3); color: #fff;}
        .arrow:hover { background-color: RGBA(0,0,0,.7);}
        #container:hover .arrow { display: block;}
        #prev { left: 20px;}
        #next { right: 20px;}
</style>
<script type="text/javascript">
    window.onload = function(){
        var container = document.getElementById('container');
        var list = document.getElementById('list');
        var buttons = document.getElementById('buttons').getElementsByTagName('span');
        var prev = document.getElementById('prev');
        var next = document.getElementById('next');
        var index = 1;
        var animated = false;
        var timer;
        
        function showButton(){
            for(var i=0; i < buttons.length; i++){
                if(buttons[i].className == 'on'){
                    buttons[i].className = '';
                    break;
                }
            }
            buttons[index -1].className = 'on';
        }
        
        function animate(offset){
            animated = true;
            
            var newLeft = parseInt(list.style.left) + offset;
            var time = 300; //位移总的时间
            var interval = 2; //位移间隔时间
            var speed = offset/(time/interval);//每次位移的量
            
            function go(){
                if ((speed < 0 && parseInt(list.style.left) > newLeft) || (speed > 0 && parseInt(list.style.left) < newLeft)){
                    list.style.left = parseInt(list.style.left) + speed + 'px';
                    setTimeout(go,interval);
                }
                else{
                    list.style.left = newLeft + 'px';
            
                    if ( newLeft > -670){
                        list.style.left = -3350 + 'px';
                    }
                    if ( newLeft < -3350){
                        list.style.left = -670 + 'px';
                    }
                    
                    animated = false;
                }
            }
            go();
        }
        
        function play(){
            timer = setInterval(function(){
                next.onclick();
            },3000);
        }
        
        function stop(){
            clearInterval (timer);
        }
        
        next.onclick = function (){
            if(animated == false){
            if(index == 5){
                index = 1;
            }else{
                index += 1;
            }
        }
            
            showButton();
            if (animated == false){
                animate(-670);
            }
        }
        prev.onclick = function (){
            if(animated == false){
            if(index == 1){
                index = 5;
            }else{
                index -= 1;
            }
        }
            
            showButton();
            if (animated == false){
                animate(670);
            }
        }
        for( var i = 0; i < buttons.length ; i++){
            buttons[i].onclick = function(){
                if(this.className == 'on'){
                    return;
                }
                var myIndex = parseInt(this.getAttribute('index'));
                var offset = -670 * (myIndex - index);
                if(animated == false){
                    animate(offset);
                    index = myIndex;
                    showButton();
                }
            }
        }
        container.onmouseover = stop;
        container.onmouseout = play;
        
        play();
    }
</script>
<section>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-9">
        <div class="banner">
          <div class="banner-left">
            <div id="container">
            <!--<div class="banner-info"><span>阅读数</span><i class="news_count node-<?php echo ($result['topPicNews'][0]['news_id']); ?>"-->
            <!--                                            news-id="<?php echo ($result['topPicNews'][0]['news_id']); ?>"><?php echo ($result['topPicNews'][0]['count']); ?></i>-->
            <!--</div>-->
            <div id="list" style="left:-670px;">
            <a target="_blank" href="/index.php?c=detail&id=<?php echo ($result['topPicNews'][4]['news_id']); ?>"><img width="670" height="360" src="<?php echo ($result['topPicNews'][4]['thumb']); ?>" alt="<?php echo ($result['topPicNews'][4]['title']); ?>"></a>
            <a target="_blank" href="/index.php?c=detail&id=<?php echo ($result['topPicNews'][0]['news_id']); ?>"><img width="670" height="360" src="<?php echo ($result['topPicNews'][0]['thumb']); ?>" alt="<?php echo ($result['topPicNews'][0]['title']); ?>"></a>
            <a target="_blank" href="/index.php?c=detail&id=<?php echo ($result['topPicNews'][1]['news_id']); ?>"><img width="670" height="360" src="<?php echo ($result['topPicNews'][1]['thumb']); ?>" alt="<?php echo ($result['topPicNews'][1]['title']); ?>"></a>
            <a target="_blank" href="/index.php?c=detail&id=<?php echo ($result['topPicNews'][2]['news_id']); ?>"><img width="670" height="360" src="<?php echo ($result['topPicNews'][2]['thumb']); ?>" alt="<?php echo ($result['topPicNews'][2]['title']); ?>"></a>
            <a target="_blank" href="/index.php?c=detail&id=<?php echo ($result['topPicNews'][3]['news_id']); ?>"><img width="670" height="360" src="<?php echo ($result['topPicNews'][3]['thumb']); ?>" alt="<?php echo ($result['topPicNews'][3]['title']); ?>"></a>
            <a target="_blank" href="/index.php?c=detail&id=<?php echo ($result['topPicNews'][4]['news_id']); ?>"><img width="670" height="360" src="<?php echo ($result['topPicNews'][4]['thumb']); ?>" alt="<?php echo ($result['topPicNews'][4]['title']); ?>"></a>
            <a target="_blank" href="/index.php?c=detail&id=<?php echo ($result['topPicNews'][0]['news_id']); ?>"><img width="670" height="360" src="<?php echo ($result['topPicNews'][0]['thumb']); ?>" alt="<?php echo ($result['topPicNews'][0]['title']); ?>"></a>
          </div>
          <div id="buttons">
              <span index="1" class="on"></span>
              <span index="2"></span>
              <span index="3"></span>
              <span index="4"></span>
              <span index="5"></span>
          </div>
          <a href="javascript:;" id="prev" class="arrow">&lt;</a>
          <a href="javascript:;" id="next" class="arrow">&gt;</a>
          </div>
          </div>
          <div class="banner-right">
            <ul>
              <?php if(is_array($result['topSmallNews'])): $i = 0; $__LIST__ = $result['topSmallNews'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                <a target="_blank" href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><img width="150" height="113"
                                                                                    src="<?php echo ($vo["thumb"]); ?>" alt="<?php echo ($vo["title"]); ?>"></a>
              </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div>
        </div>
        <div class="news-list">
          <?php if(is_array($result['listNews'])): $i = 0; $__LIST__ = $result['listNews'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dl>
            <dt><a target="_blank" href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><?php echo ($vo["title"]); ?></a></dt>
            <dd class="news-img">
              <a target="_blank" href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><img width="192" height="108"
                                                                                  src="<?php echo ($vo["thumb"]); ?>"
                                                                                  alt="<?php echo ($vo["title"]); ?>"></a>
            </dd>
            <dd class="news-intro">
              <?php echo ($vo["description"]); ?>
            </dd>
            <dd class="news-info">
              <?php echo ($vo["keywords"]); ?> <span><?php echo (date("Y-m-d H:i",$vo["create_time"])); ?></span> 阅读(<i news-id="<?php echo ($vo["news_id"]); ?>"
                                                                                       class="news_count node-<?php echo ($vo["news_id"]); ?>"><?php echo ($vo["count"]); ?></i>&nbsp;)
            </dd>
          </dl><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
      </div>
      <!--网页右侧排行-->
      <div class="col-sm-3 col-md-3">
    <div class="right-title">
        <h3>文章排行</h3>
        <span>TOP ARTICLES</span>
    </div>
    <div class="right-content">
        <ul>
            <?php if(is_array($result['rankNews'])): $k = 0; $__LIST__ = $result['rankNews'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li class="num<?php echo ($k); ?> curr">
                    <a target="_blank" href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><?php echo ($vo["small_title"]); ?></a>
                    <?php if($k == 1): ?><div class="intro">
                            <?php echo ($vo["description"]); ?>
                        </div><?php endif; ?>
                </li>
                <!--<li class="num2"><a href="">普京回应俄战机被击落</a></li>--><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <?php if(is_array($result['advNews'])): $i = 0; $__LIST__ = $result['advNews'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="right-hot">
            <a target="_blank" href="<?php echo ($vo["url"]); ?>"><img width="360px" height="160px" src="<?php echo ($vo["thumb"]); ?>" alt="<?php echo ($vo["name"]); ?>"></a>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
    <!--<div class="right-hot">-->
    <!--<img src="Public/images/img6.jpg" alt="">-->
    <!--</div>-->
</div>
    </div>
  </div>
</section>
</body>
<script src="/Public/js/jquery.js"></script>
<script src="/Public/js/count.js"></script>
</html>