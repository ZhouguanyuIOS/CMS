function  admin_top_nav(j) {
   for (i=1;i<5;i++){
       document.getElementById('nav'+i).style.backgroundPosition='left bottom';
       document.getElementById('nav'+i).style.color='#fff';
       if (i==j){
           document.getElementById('nav'+i).style.backgroundPosition='right bottom';
           document.getElementById('nav'+i).style.color='#3b6ea5';
       }
   }
 }
