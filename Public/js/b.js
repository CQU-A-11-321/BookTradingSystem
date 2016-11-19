/**
 * Created by cz1996 on 2016/11/3.
 */
function biaoshi(objlist)
{
    var ddd = 123456788;
    document.getElementById("cz").innerHTML += (ddd + "<h1> ccccccc </h1>"+"<br>");
    //document.getElementById("cz").innerHTML = "<br>";
}

function dianwo()
{
    biaoshi();
}

function informationOnLoad()
{
    window.open ("test1.html", "", "height=100,width=400");
}


// function showDiv()
// {
//     var Idiv     = document.getElementById("Idiv");
//     var mou_head = document.getElementById('mou_head');
//     Idiv.style.display = "block";
// //以下部分要将弹出层居中显示
//     Idiv.style.left=(document.documentElement.clientWidth-Idiv.clientWidth)/2+document.documentElement.scrollLeft+"px";
//     Idiv.style.top =(document.documentElement.clientHeight-Idiv.clientHeight)/2+document.documentElement.scrollTop-50+"px";
//
// //以下部分使整个页面至灰不可点击
//     var procbg = document.createElement("div"); //首先创建一个div
//     procbg.setAttribute("id","mybg"); //定义该div的id
//     procbg.style.background = "#000000";
//     procbg.style.width = "100%";
//     procbg.style.height = "100%";
//     procbg.style.position = "fixed";
//     procbg.style.top = "0";
//     procbg.style.left = "0";
//     procbg.style.zIndex = "500";
//     procbg.style.opacity = "0.6";
//     procbg.style.filter = "Alpha(opacity=70)";
// //背景层加入页面
//     document.body.appendChild(procbg);
//     document.body.style.overflow = "hidden"; //取消滚动条
//
// //以下部分实现弹出层的拖拽效果
//     var posX;
//     var posY;
//     mou_head.onmousedown=function(e)
//     {
//         if(!e) e = window.event; //IE
//         posX = e.clientX - parseInt(Idiv.style.left);
//         posY = e.clientY - parseInt(Idiv.style.top);
//         document.onmousemove = mousemove;
//     }
//     document.onmouseup = function()
//     {
//         document.onmousemove = null;
//     }
//     function mousemove(ev)
//     {
//         if(ev==null) ev = window.event;//IE
//         Idiv.style.left = (ev.clientX - posX) + "px";
//         Idiv.style.top = (ev.clientY - posY) + "px";
//     }
// }
// function closeDiv() //关闭弹出层
// {
//     var Idiv=document.getElementById("Idiv");
//     Idiv.style.display="none";
//     document.body.style.overflow = "auto"; //恢复页面滚动条
//     var body = document.getElementsByTagName("body");
//     var mybg = document.getElementById("mybg");
//     body[0].removeChild(mybg);
// }
