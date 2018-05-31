<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Token Print</title>
        <link href="<?=BASE?>admin/css/token.css" rel="stylesheet" />
    </head>
    <body>
<div class="book">
    <?php for($i=1;$i<=$this->input->post('total');$i++){?>
    <div class="page">
        <div class="subpage">
            <h4 style="margin: 0px">TN: <?=$this->input->post('token_no')?></h4>
            <?php if($this->input->post('order_type')=='4' && $this->input->post('iron')=='1'){ echo 'Individual Iron';} else {echo $this->input->post('wash_type');}?><br>
            Clothes: <?=$i?>/<?=$this->input->post('total')?> <br>
            <?=$this->input->post('college_name')?> <br>
        </div>  
    </div>
    <?php }?>
</div>
        <script>
            setTimeout(function(){window.print()},1000);
        (function () {
            var afterPrint = function () {
                window.close();
            };

            if (window.matchMedia) {
                var mediaQueryList = window.matchMedia('print');

                mediaQueryList.addListener(function (mql) {
                    if (mql.matches) {
                        //beforePrint();
                    } else {
                        afterPrint();
                    }
                });
            }

            //window.onbeforeprint = beforePrint;
            window.onafterprint = afterPrint;

        }());
        </script>
        </body>
</html>
