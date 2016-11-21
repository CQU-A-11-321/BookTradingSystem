/**
 * Created by cz1996 on 2016/11/20.
 */

function display() {
    var dis = document.getElementById("bookio");
    dis.innerHTML="cafasds";
    if(dis == null)
    {
        dis.innerHTML="cafasds";
    }
    else
    {
        for(var i=0;dis[i]!=null;i++)
        {
            document.getElementById("bookio").innerHTML=dis[i].bookid;
        }
    }
}