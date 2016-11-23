/**
 * Created by cz1996 on 2016/11/20.
 */

function display() {
    var dis = document.getElementById("tableone");
    for(var i= 0;dis[i]!=null;i++)
    {
        var tbl = document.createElement("table");
        tbl.style.border="1";
        var row1 = document.createElement("tr");
        var column1 = document.createElement("td");
        column1.innerHTML=dis[i].name;
        var column2 = document.createElement("td");
        column2.innerHTML=dis[i].author;
        var column3 = document.createElement("td");
        column3.innerHTML=dis[i].concern;
        var row2 = document.createElement("tr");
        var column4 = document.createElement("td");
        column4.innerHTML=dis[i].price;
        var column5 = document.createElement("td");
        column5.innerHTML=dis[i].kind;
        var column6 = document.createElement("td");
        column6.innerHTML=dis[i].data;
        var column7 = document.createElement("td");
        column7.innerHTML=dis[i].mark;
    }
}

function but() {
    var dis = document.getElementById("butto");
    var dis = document.getElementById("butt");
    var aa = document.createElement("a");
    aa.href="#";
    aa.innerHTML=dis;
    dis.appendChild(aa);
}

function displ() {
    var dis1 = document.getElementById("pw1").value;
    var dis2 = document.getElementById("pw2").value;
    if(dis1 == dis2)
    {
        var dis = document.getElementById("log");
        dis.action="register";
    }
}

function panduan() {
    var dis = document.getElementById("wo1").value;
    if(dis == null){
        dis.value="无";
    }
}