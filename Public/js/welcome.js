/**
 * Created by cz1996 on 2016/11/7.
 */
function click_welcome()
{
    // window.open('../Customer/test1.html');
    var passw1 = document.getElementById("pw1").value;
    var passw2 = document.getElementById("pw2").value;
    if(passw1 == passw2)
    {
        location.href="../Index/index.html";
    }
    //window.open('../Test/test1.html');
    // window.navigate('../Customer/test1.html');
}

function check()
{
    var passw1 = document.getElementById("pw1").value;
    var passw2 = document.getElementById("pw2").value;
    if(passw1 != passw2)
    {
        document.getElementById("waring").innerHTML="   *两次输入的密码不一致";
    }
    else
    {
        document.getElementById("waring").innerHTML=" ";
    }
}