
<!-- Script by hscripts.com -->
//Edit the counter/limiter value as your wish
var count = "500";   //Example: var count = "175";
function limiter(){
var tex = document.form.message.value;
var len = tex.length;
if(len > count){
        tex = tex.substring(0,count);
        document.form.message.value =tex;
        return false;
}
document.form.limit.value = count-len;
}

