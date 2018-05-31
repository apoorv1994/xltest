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
    <?php
	$washtype = [1=>'B:W+F',2=>'Premium Wash',3=>'Dry Cleaning',4=>'I:W+I',10=>'B:W+F',20=>'Premium Wash',30=>'Dry Cleaning',40=>'I:W+I',11=>'B:W+I',21=>'Premium Wash',31=>'Dry Cleaning',41=>'I:OI'];
	for($i=1;$i<=$this->input->post('total');$i++){?>
    <div class="page">
        <div class="subpage">
            <h4 style="margin: 0px">TN: <?=$this->input->post('token_no')?></h4>
            <?php echo $washtype[$this->input->post('order_type').$this->input->post('iron')];?><br>
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
