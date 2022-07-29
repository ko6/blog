<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\assets\AppAsset_head;
/* @var $this yii\web\View */
/* @var $model frontend\models\ExamCourse */
AppAsset_head::register($this);
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Exam Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
 <style>
 .d{    margin-left: 10px;   font-size: 12px;            } 
 .r{    background: green;    color: black;            } 
   .w{    background: red;    color: black;            }
 </style> 
<div class="exam-course-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <h3><?= Html::encode($model->info) . "  当前题库中共有".count($question)."道题" ?></h3>
    <?php
    foreach($question as $i=>$q){
    $cgz1_show = "";
    // var_dump($i);
    if($i>5){$cgz1_show = "hidden";}

      $content=<<<CONTENT_HEADER
          <li name="li_Question" style="    display: block;    padding: 10px;">
                                         <div class="row">
                                    <div class="col-2 text-right font-size-24">

                                        <div class="row lh24 text-info" style="float: left;">$i.</div>
                                    </div>
                                    <div class="col-18 font-size-16">

                                        <div style="overflow: auto;">
$q[name]
                                        </div>

                                        
CONTENT_HEADER;

$content.='<ul class="upper-latin-list pl25 mt20" >';
//        var_dump($option[1]);
if($i>5){$content.= '<li class=" text-grey cgz1_show">更多内容请启用“草稿纸"脚本后查看 <a href="http://10.193.8.233/pages/viewpage.action?pageId=4588609">http://10.193.8.233/pages/viewpage.action?pageId=4588609</a></li>';}
    foreach($option as $j=>$o){
//if(!isset($o["c"])){ var_dump($o,$option[$j]);exit;};
//        break;
//        continue;
//        print "<br>";
//        var_dump($option);exit();
        if($o["question_id"]==$q["id"]){
//            var_dump($o["c"]);exit();
          
            $span_temp="";
            if($o["c"]!=0){
                $style="d";
                
                
                if($o["r"]>0){$style="d r";}else if($o["w"]>0){$style="d w";};
                $span_temp= '<span title="共选择'.$o["c"].'次，最高得分'.$o["s"].'" class="'.$style.'">['.$o["c"].'/'.$o["s"].']</span>';
            }
            if($q["type"]=="SingleChoice"){
                $content.= '<li  class=" text-grey  col-xs-3 col-sm-3 col-lg-3 cgz_show"   '.$cgz1_show.'  onclick="check($(this))"><input type="radio" name="'.$i.'" class="text-normal" value="'. $o["content"].'">'. $o["content"].$span_temp.'</li>';
            }else if($q["type"]=="MultiChoice"){
                $content.= '<li  class=" text-grey  col-xs-3 col-sm-3 col-lg-3 cgz_show"  '.$cgz1_show.' ><input type="checkbox" name="'.$i.'" class="text-normal" value="'. $o["content"].'">'. $o["content"].$span_temp.'</li>';
            }else{
                $content.= '<li class=" text-grey cgz_show col-xs-3 col-sm-3 col-lg-3 cgz_show" '.$cgz1_show.' style="display:block;"><span class="text-normal">'. $o["content"].$span_temp.'</span></li>';
            }

        }

    };
    
      $content.=<<<CONTENT_HEADER
                                        </ul>
                                    </div>

                                </div>
                                <div class="row  pr mt20" hidden>

                                    <div class="col-18 col-offset-2 font-size-16">

                                        <label class="btn-check mb10 ">
                                            <input type="radio" data-type="单选题" name="071a0b20-04f7-43d7-a23e-9c85605b33c0" value="7ffdf9ed-736a-4487-9d80-af3e42375c71">
                                            <i></i>A
                                        </label>

                                        <label class="btn-check mb10 ">
                                            <input type="radio" data-type="单选题" name="071a0b20-04f7-43d7-a23e-9c85605b33c0" value="74826b10-a62d-4f9a-b0ca-5864469b824e">
                                            <i></i>B
                                        </label>

                                        <label class="btn-check mb10 ">
                                            <input type="radio" data-type="单选题" name="071a0b20-04f7-43d7-a23e-9c85605b33c0" value="9836788c-bcb8-48ac-9dd9-a76a3839d8d0">
                                            <i></i>C
                                        </label>

                                        <label class="btn-check mb10 ">
                                            <input type="radio" data-type="单选题" name="071a0b20-04f7-43d7-a23e-9c85605b33c0" value="6f3fe08e-882a-46e3-bd4e-6f99cc167fe4">
                                            <i></i>D
                                        </label>

                                    </div>


                                </div>
                            </li>
CONTENT_HEADER;

        echo $content;
    };


     ?>

</div>
<script>
    function check(x){
//        alert(123);
//        console.log(x)
//        x.find("input").click();
    }
</script>