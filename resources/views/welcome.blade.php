<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <title>Testing </title>
        <style>
        ul, #myUL {
        list-style-type: none;
        }
        
        #myUL {
        margin: 0;
        padding: 0;
        }
        
        .plus {
        cursor: pointer;
        -webkit-user-select: none; /* Safari 3.1+ */
        -moz-user-select: none; /* Firefox 2+ */
        -ms-user-select: none; /* IE 10+ */
        user-select: none;
        }
        
        .plus::before {
        content: "\002B";
        color: black;
        display: inline-block;
        margin-right: 6px;
        }
        
        
        .minus::before {
        content: "\2212";
        color: dodgerblue;
        }


        .collapsin {
        cursor: pointer;
        -webkit-user-select: none; /* Safari 3.1+ */
        -moz-user-select: none; /* Firefox 2+ */
        -ms-user-select: none; /* IE 10+ */
        user-select: none;
        }
        
        .collapsin::before {
        content: "\002B";
        color: black;
        display: inline-block;
        margin-right: 6px;
        }
        
        
        .collapsout::before {
        content: "\2212";
        color: dodgerblue;
        }
        
        .nested {
        display: none;
        }
        .leafs {
        display: none;
        }
        
        .active {
        display: block;
        }
        .maindiv{

        }
        .buttons-div{
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .buttons-div button{
    /* background: red; */
    border: none;
    padding: 15px 15px;
    font-size: 16px;
    cursor: pointer;
}
.buttons-div button.selected{
    background:red;
}
        </style>
    </head>
    <body>
        <div class="maindiv">
            <div class="buttons-div">
                <button class="autoload selected">Auto Loading</button>
                <button class="ajaxload">Ajax Loading</button>
            </div>
            
            <div class="auto-load-tree">
    <ul id="myUL" class="autoload-list">
    <?php foreach($data as $level1) { ?>
    <li><span class="plus minus"><?php echo $level1['text']  ?></span>
      <?php if(count($level1['nodes'])>0){ ?>
      <ul class="nested active">
        <?php foreach($level1['nodes'] as $level2) { ?>
        <li><span class="<?php if(isset($level2['nodes']) && count($level2['nodes'])>0){ echo 'plus minus'; } ?>"><?php echo $level2['text']  ?></span>
            <?php if(isset($level2['nodes']) && count($level2['nodes'])>0){  ?>
            <ul class="nested active">
                <?php foreach($level2['nodes'] as $level3) { ?>
                <li><span class="<?php if(isset($level3['nodes']) && count($level3['nodes'])>0){ echo 'plus minus'; } ?>"><?php echo $level3['text']  ?></span>
                    <?php if(isset($level3['nodes']) && count($level3['nodes'])>0){  ?>
                    <ul class="nested active">
                          <?php foreach($level3['nodes'] as $level4) { ?>
                          <li><span class="<?php if(isset($level4['nodes']) && count($level4['nodes'])>0){ echo 'plus minus'; } ?>"><?php echo $level4['text']  ?></span>
                          <?php } ?>
                    </ul>
                    <?php } ?>

                </li>
                <?php } ?>
            </ul>
            <?php } ?>

        </li>
        <?php } ?>
      </ul>
    <?php } ?>
    </li>
  <?php } ?>
</ul>

</div>
<div class="ajax-load-tree" style="display:none;">
    <ul id="myUL" class="ajax-load-list">

    </ul>
</div>
</div>
<script>
collapsing('plus','minus','nested');

$(document).on('click','.autoload',function(){
    $('.auto-load-tree').show();
    $('.ajax-load-tree').hide();

})
$(document).on('click','.ajaxload',function(){
    $('.auto-load-tree').hide();
    $('.ajax-load-tree').show();
    $.ajax({
         type:'get',
         url:'<?php echo url('/getTreeAjax') ?>',
         success:function(data){
            console.log(data)
            $('.ajax-load-list').html(data);
            collapsing('collapsin','collapsout','leafs');
         }
      });

});
function collapsing(collapsin,collapsout,mainleaf)
{
    var toggler = document.getElementsByClassName(collapsin);
    var i;
    for (i = 0; i <toggler.length; i++) {
    toggler[i].addEventListener("click", function() {
        this.parentElement.querySelector("."+mainleaf).classList.toggle("active");
        this.classList.toggle(collapsout);
    });
    }
}

$(".buttons-div button").click(function () {
        if(!$(this).hasClass('selected'))
        {
            $("button.selected").removeClass("selected");
            $(this).addClass("selected");        
        }
    });
</script>
    </body>
</html>
