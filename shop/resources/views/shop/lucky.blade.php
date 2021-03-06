<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <title>Drawing sector</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <style>
        *{
            padding: 0;
            margin:0;
        }
        body{
            background: -webkit-linear-gradient(left, #4f185d , #fe5d4b);
        }
        #turntable{
            position: relative;
            width:300px;
            margin:0 auto;
        }
        #canvas{
            -webkit-transform: all 6s ease;
            transition: all 6s ease;
        }
        #turntable h3{
            color:white;
            font-family: 华文彩云;
            text-align: center;
            font-style: italic;
            font-size:22px;
            padding-top: 20px;
            padding-bottom: 20px;
        }
        #btn{
            position: absolute;
            left: 120px;
            top: 180px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: red;
            line-height: 60px;
            text-align: center;
            text-decoration: none;
            color:white
        }
        #btn:after{
            position: absolute;
            display: block;
            content: '';
            left: 10px;
            top: -32px;
            width: 0;
            height: 0;
            overflow: hidden;
            border-width: 20px;
            border-style: solid;
            border-color: transparent;
            border-bottom-color: #fff;
        }
        #price{
            width: 300px;
            height: 120px;
            margin: 20px auto;
            background: #fcf6b1;
            padding-top: 10px;
            border-radius: 5px;
        }
        #tit{
            width: 100px;
            background: #409d06;
            margin-left: 10px;
            border-radius: 3px;
            padding-left: 10px;
            color:whitesmoke;
        }
        #price ul {
            padding-left: 40px;
            padding-top: 10px;
        }
        #price ul li{
            padding-bottom: 5px;
            color: #444445;
        }
        #shield{
            position:absolute;
            top: 50%;
            left: 50%;
            width:280px;
            height: 150px;
            z-index: 25;
            margin-left: -140px;
            margin-top: -100px;
        }
        #alertFram{
            position:absolute;
            top: 50%;
            left: 50%;
            width:280px;
            height: 150px;
            line-height: 150px;
            text-align: center;
            z-index: 300;
            margin-left: -140px;
            margin-top: -100px;
        }
        #alertFram ul{
            list-style:none;margin:0px;padding:0px;width:100%
        }
        #alertFram .li1{
            background:#626262;text-align:left;padding-left:20px;
            font-size:15px;font-weight:bold;height:25px;line-height:25px;
            border:1px solid #F9CADE;color:white
        }
        #alertFram .li02{
            background:#787878;text-align:center;font-size:18px;height:35px;
            line-height:35px;border-left:1px solid #F9CADE;
            border-right:1px solid #F9CADE;color:#DCC722
        }
        #alertFram .li2{
            background:#787878;text-align:center;font-size:20px;height:60px;
            line-height:60px;border-left:1px solid #F9CADE;
            border-right:1px solid #F9CADE;color:#DCC722
        }
        #alertFram .li3{
            background:#626262;text-align:center;font-weight:bold;
            height:30px;line-height:25px; border:1px solid #F9CADE;
        }
        #alertFram .btn{
            width:80px;height:20px;background:#626262;color:white;
            border:1px solid white;font-size:15px;line-height:20px;
            outline:none;margin-top: 4px
        }
    </style>
</head>
<body>
<div id="turntable">
    <h3>幸 运 大 转 轮</h3>
    <canvas id="canvas" width="300" height="300">抱歉！浏览器不支持。</canvas>
    <a id="btn" href="javascript:;">抽奖</a>
</div>
<div id="price">
    <div id="tit">奖项设置</div>
    <ul>
        <li>一等奖：11111</li>
        <li>二等奖：22222</li>
        <li>三等奖：33333</li>
    </ul>
</div>
<script>
    window.addEventListener('load', function(){
        var num = 10;   // 奖品数量
        if (num % 2 !== 0){
            alert('请配置偶数奖项');
        }
        var canvas = document.getElementById('canvas');
        var btn = document.getElementById('btn');
        if(!canvas.getContext){
            alert('抱歉！浏览器不支持。');
            return;
        }
        // 获取绘图上下文
        var ctx = canvas.getContext('2d');
        for (var i = 0; i < num; i++) {
            // 保存当前状态
            ctx.save();
            // 开始一条新路径
            ctx.beginPath();
            // 位移到圆心，下面需要围绕圆心旋转
            ctx.translate(150, 150);
            // 从(0, 0)坐标开始定义一条新的子路径
            ctx.moveTo(0, 0);
            // 旋转弧度,需将角度转换为弧度,使用 degrees * Math.PI/180 公式进行计算。
            ctx.rotate(((360 / num * i -90) * Math.PI/180));
            // 绘制圆弧
            ctx.arc(0, 0, 150, 0,  2 * Math.PI / num, false);
            var color=['#ff00fe','#01ffff','#99fe00','#ff6634','#ffff01',
                '#ff00fe','#01ffff','#99fe00','#ff6634','#ffff01'];
            ctx.fillStyle=color[i];
            // 填充扇形
            ctx.fill();
            // 绘制边框
            ctx.lineWidth = 0.5;
            ctx.strokeStyle = '#f48d24';
            ctx.stroke();

            var arr=['0000','1111','2222','3333','44444','5555','6666','777777','8888','99999',];

            // 文字
            ctx.fillStyle = '#fff';
            ctx.font="16px sans-serif";
            ctx.fillText(arr[i], 50, 25);
            // 恢复前一个状态
            ctx.restore();
        }
        // 抽奖
        btn.onclick = function(){
            //AJAX
            var ajax=new XMLHttpRequest;
            var data=" uid=uname&request=lucky";
            ajax.open('post','{{ url("shop/user/lucky") }}');
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax.setRequestHeader("X-CSRF-TOKEN",'{{ csrf_token() }}');
            ajax.send(data);
            ajax.onreadystatechange = function() {
                if (ajax.readyState === 4 && ajax.status == 200 ) {
                    var res=JSON.parse(ajax.responseText);
                    if(res.code===1){
                        console.info("奖品:"+res.lucky);
                        switch(res.lucky){
                                //arc 表示放置该奖品的位置，与上面arr数组内容位置相对应。
                            case "prize0":
                                arc=0;
                                break;
                            case "prize1":
                                arc=1;
                                break;
                            case "prize2":
                                arc=2;
                                break;
                            case "prize3":
                                arc=3;
                                break;
                            case "prize4":
                                arc=4;
                                break;
                            case "prize5":
                                arc=5;
                                break;
                            case "prize6":
                                arc=6;
                                break;
                            case "prize7":
                                arc=7;
                                break;
                            case "prize8":
                                arc=8;
                                break;
                            case "prize9":
                                arc=9;
                                break;
                        }
                    }
                    console.info("位置:"+arc);
                    var dushu=(2160-360/num/2)-(360/num)*arc;
                    console.info("角度:"+dushu);
                    var deg=arc;
                    canvas.style.transform = "rotate("+dushu+"deg)";
                    var chance=Math.floor(arr[arc]);
                    setTimeout(function(){
                        alert(chance);
                    },6500);
                }
            }

            //var dushu=1800+Math.ceil(Math.random()*360);
            //var deg=Math.floor((dushu-1800)/36);
            //  canvas.style.transform = "rotate("+dushu+"deg)";
            //	var chance=Math.floor(Math.random()*100);
            //alert(chance)
            //if(chance>50){
            //	var dushu=1925;
            //	var deg=3;
            //alert(dushu)
            //	canvas.style.transform = "rotate("+dushu+"deg)";
            //}else{
            //	var dushu=1800+Math.ceil(Math.random()*360);
            //	var deg=Math.floor((dushu-1800)/36);
            //alert(dushu)
            //    canvas.style.transform = "rotate("+dushu+"deg)";
            //}
            //setTimeout(function fun(){
            //	switch(deg){
            //		case 0:
            //		  alert(arr[deg+10]);
            //		  break;
            //		case 1:
            //		  alert(arr[deg+10]);
            //		  break;
            //		case 2:
            //		  alert(arr[deg+10]);
            //		  break;
            //		case 3:
            //		  alert(arr[deg+10]);
            //		  break;
            //		case 4:
            //		  alert(arr[deg+10]);
            //		  break;
            //		case 5:
            //		  alert(arr[deg+10]);
            //		  break;
            //		case 6:
            //		  alert(arr[deg+10]);
            //		  break;
            //		case 7:
            //		  alert(arr[deg+10]);
            //		  break;
            //		case 8:
            //		  alert(arr[deg+10]);
            //		  break;
            //		case 9:
            //		  alert(arr[deg+10]);
            //		  break;
            //		}
            //   },6500)
            window.alert = function(str)
            {
                var shield = document.createElement("DIV");
                shield.id = "shield";
                var alertFram = document.createElement("DIV");
                alertFram.id="alertFram";
                strHtml = "<ul>";
                strHtml += " <li class='li1'>[中奖提醒]</li>";
                strHtml += " <li class='li02'>您的抽奖结果是：</li>";
                strHtml += " <li class='li2'>"+str+"</li>";
                strHtml += " <li class='li3'><input type=\"button\" value=\"确 定\" onclick=\"doOk()\" class='btn'/></li>";
                strHtml += "</ul>";
                alertFram.innerHTML = strHtml;
                document.body.appendChild(alertFram);
                document.body.appendChild(shield);
                this.doOk = function(){
                    alertFram.style.display = "none";
                    shield.style.display = "none";
                    window.location.reload();
                }
                alertFram.focus();
                document.body.onselectstart = function(){return false;};
            }

        }

    }, false);
</script>
</body>
</html>