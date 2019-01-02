window.onload=function () {
    var  title=document.getElementById('title');
    var ol=document.getElementsByTagName('ol');
    var a=ol[0].getElementsByTagName('a');

    if (a){
        for (i=0;i<a.length;i++){
            a[i].className=null;
            if(a[i].innerHTML == title.innerHTML){
                a[i].className='selected';
            }
        }
    }
}



