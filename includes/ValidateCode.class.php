<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/20
 * Time: 下午4:14
 */
//验证码验证类
class ValidateCode{
    //随机因子
    private $charset='abcdefghklmnprstuvwxyzABCDEFGHKLMNPRSTUVWXYZ23456789';
    //验证码
    private $code;
    //验证码宽度
    private $codelen=4;
    //长度
    private $width=130;
    //高度
    private $heigth=50;
    //图形资源句柄
    private $img;
    //指定的字体类型
    private $font;
    //指定的字体大小
    private $fontsize=20;
    //指定的字体颜色
    private $fontcolor;
    //构造方法
    public function __construct()
    {
        $this->font=ROOT_PATH.'/font/elephant.ttf';
    }

    //生成随机码
    private function createCode(){
        $_len=strlen($this->charset)-1;
        for ($i=0;$i<4;$i++){
            $this->code.=$this->charset[mt_rand(0,$_len)];
        }

    }
    //生成背景
    private  function createBg(){

        $this->img=imagecreatetruecolor($this->width,$this->heigth);

        //设置颜色
        $color=imagecolorallocate($this->img,mt_rand(157,255),mt_rand(157,255),mt_rand(157,255));
        //生成一个矩形填充颜色
        imagefilledrectangle($this->img,0,$this->heigth,$this->width,0,$color);
    }

    //生成文字
    private  function createFont(){


        $this->fontcolor=imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
        //用特定的字体向图片写文本

        $x=$this->width/$this->codelen;
        for ($i=0;$i<$this->codelen;$i++){

            $y=$this->heigth/1.3;
            $angle=mt_rand(-30,30);//倾斜
            imagettftext($this->img,$this->fontsize,$angle,$x*$i,$y,$this->fontcolor,$this->font,$this->code[$i]) ;
        }

    }
    //生成线条和雪花
    private function createLine(){

             for ($i=0;$i<6;$i++){
                $color=imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
                 imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->heigth),mt_rand(0,$this->width),mt_rand(0,$this->heigth),$color);
             }

        for ($i=0;$i<50;$i++){
            $color=imagecolorallocate($this->img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
            imagestring($this->img,mt_rand(1,5),mt_rand(1,$this->width),mt_rand(1,$this->heigth),'*',$color);
        }
    }

    //输出图形
    private function outPut(){
        header('Content-type:image/png');
        imagepng($this->img);
        imagedestroy($this->img);

    }
    //对外生成
    public function doimg(){
        $this->createBg();
        $this->createCode();
        $this->createFont();
        $this->createLine();
        $this->outPut();
    }
    //获取验证码
    public function getCode(){
        return strtolower($this->code);
    }


}
?>