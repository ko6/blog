/**
 * Created by koko on 2016/11/24.
 * 根据编辑器的选择，切换富文本编辑器和markdown编辑器
 */


window.onload = function (){
    changeEditor();
    $('input[type="radio"]').click(function(){changeEditor()});
}

function changeEditor(){
    if($('input[type="radio"][value="1"]').get(0).checked){
        $('.field-post-post_content_1').removeClass('hidden');  //显示富文本编辑器
        $('.lepture').addClass('hidden');                       //隐藏markdown编辑器
    } else {
        $('.field-post-post_content_1').addClass('hidden');
        $('.lepture').removeClass('hidden');
    }
}