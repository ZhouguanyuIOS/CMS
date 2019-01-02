<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/20
 * Time: 下午4:14
 */
//分页类
class Page{
    private  $total;//总记录
    private  $pageSize;//每页limit显示几条
    private  $limit;//limit
    private  $page;//当前页码
    private  $pagenum;//总页码
    private  $url;//地址
    private  $bothnum;//页码两边保持的数量
    //构造方法初始化
    public function __construct($_total,$_pageSize)
    {


		$this->total = $_total ? $_total:1;


        $this->pageSize=$_pageSize;
        //ceil 有余进一
        $this->pagenum=ceil($this->total/$this->pageSize);

        $this->page=$this->setPage();

        $this->limit="LIMIT ".($this->page-1)*$this->pageSize.",$this->pageSize";

        $this->url=$this->setUrl();

        $this->bothnum=2;
    }

    //获取当前页码
    private function  setPage(){
        if (!empty($_GET['page']))
        {
            if ($_GET['page']>0){
                if ($_GET['page']>$this->pagenum){
                   return $this->pagenum;
                }else{
                    return $_GET['page'];
                }
            }else {
                return 1;
            }
        }else{
            return 1;
        }
    }

    //获取地址
    private  function setUrl(){
        $_url= $_SERVER['REQUEST_URI'];
        $_par=parse_url($_url);
        if (isset($_par['query'])){
            parse_str($_par['query'],$_query);
            unset($_query['page']);
            $url=$_par['path'].'?'.http_build_query($_query);
        }
        return $url;
    }

    //数字目录
    private  function  pageList(){
        for ($i=$this->bothnum;$i>=1;$i--) {
            if (($this->page-$i)<1) continue;
            $_pageList.='<a href="'.$this->url.'&page='.($this->page-$i).'">'.($this->page-$i).'</a>';

        }
        $_pageList.='<span class="me">'.$this->page.'</span>';
        for ($i=1;$i<=$this->bothnum;$i++){
            if (($this->page+$i)>$this->pagenum) break;
            $_pageList.='<a href="'.$this->url.'&page='.($this->page+$i).'">'.($this->page+$i).'</a>';

        }
        return $_pageList;
    }


    //首页
    private function first(){
        if ($this->page>$this->bothnum+1){
            return '<a href="'.$this->url.'">1</a>...';
        }
    }
    //尾页
    private function last(){
        if ($this->page<$this->pagenum-$this->bothnum) {
            return '...<a href="'.$this->url.'&page='.$this->pagenum.'">'.$this->pagenum.'</a>';
        }
    }
    //上一页
    private function prev(){
        if ($this->page==1){
            return '<span class="disabled">上一页</span>';
        }
        return '<a href="'.$this->url.'&page='.($this->page-1).'">上一页</a>';

    }
    //下一页
    private function next(){
        if ($this->page==$this->pagenum){
            return '<span class="disabled">下一页</span>';
        }
        return '<a href="'.$this->url.'&page='.($this->page+1).'">下一页</a>';
    }
    //拦截器赋值
    private function __get($_key)
    {
        return $this->$_key;
    }

    public function  showPage(){
        $_page.=$this->first();
        $_page.=$this->pageList();
        $_page.=$this->last();
        $_page.=$this->prev();
        $_page.=$this->next();
        return $_page;
    }
}
?>