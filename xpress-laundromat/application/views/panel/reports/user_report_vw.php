<!-- BEGIN PAGE CONTENT -->
<link href="<?=BASE?>admin/select2/select2.css" rel="stylesheet">
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Reports
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=BASE?>panel/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                        </div>
                     <!-- Charts-->
                    <div class="col-lg-12">
                        <div class="panel panel-default tmargin30">
                          <div class="panel-heading">
                            <h4>User List </h4>
                          </div>
                          <div class="panel-body">
                              <div class="col-sm-4">
                                  <select class="form-control select2" style="height: 34px;" id="college_id" name="college_id">
                                        <?php if($this->session->user_type==1){?><option value="">All College</option><?php }?>
                                        <?php foreach($colleges as $college){?>
                                        <option value="<?=$college->id?>"><?=$college->college_name?></option>
                                        <?php }?>
                                    </select>
                              </div>
                            <div class="col-sm-6 margin-bottom-20">
                                <div class="col-sm-6">
                                    <input type="text" id="search" class="form-control" placeholder="Search">
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" id="searchBtn" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                            <div class="col-sm-2 margin-bottom-20">
                                <div class="input-group pull-right" style="margin-left: 10px;">
                                    <a href="<?=BASE?>panel/reports/export-user" id="exportExcel" class="btn btn-success" target="_blank" title="Export Excel"><i class="fa fa-file-excel-o"></i></a>
                                </div>
                            </div>
                              <div class="col-sm-12" style="overflow-x: scroll">
                        <table class="table table-striped table-hover" id="example-datatable">
                                <thead class="the-box dark full">
                                        <tr>
                                            <th>Name</th>
                                            <th>College Name</th>
                                            <th>Avg Order Value</th>
                                            <th>Avg Repeat Order Time</th>
                                            <th>Last Order<br>(Days)</th>
<!--                                            <th>No of Order/Month</th>-->
                                            <th>
                                                Wash type Frequency
                                                <table class="table table-striped table-hover"  style="margin: 0px;">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 25%;">Bulk</th>
                                                    <th style="width: 25%;">Indiv<br>idual</th>
                                                    <th style="width: 25%;">Prem<br>ium</th>
                                                    <th style="width: 25%;">Dry</th>
                                                    </tr>
                                                    </thead></table>
                                            </th>
                                            <th>Avg no of cloths/wash</th>
                                            <th>Total Order amount</th>
<!--                                            <th>Avg Wallet Balance</th>-->
                                            <th>Avg Rating</th>
                                            <th>Avg Recharge Amount</th>
                                            <th>Avg Weight of Clothes<br>(KG)</th>
                                            <th>Account Created</th>
                                        </tr>
                                </thead>
                                <tbody id="user_body">

                                </tbody>
                        </table>
                              </div>
                        </div><!-- /.the-box .default -->
                        <!-- END DATA TABLE -->
                        </div>
                    </div>
                    </div>
                </div><!-- /.row -->
             </div><!-- /.box-body -->
              </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
          <script src="<?=BASE?>admin/select2/select2.min.js"></script>
      <script>
          $(document).ready(function(){
              var excelHref = $('#exportExcel').attr('href');
              $('.select2').select2();
            get_user('<?=BASE?>panel/reports/user_ajax/0');
            $('body').on('click','#paginate a',function(){
                var sortby = '';
                var sortas = '';
                $('.sort').each(function(){
                    if($(this).data('sort')=='asc' || $(this).data('sort')=='asc')
                    {
                        sortby = $(this).attr('id');
                        sortas = $(this).data('sort');
                        return false;
                    }
                })
                var url=$(this).attr("href");

               get_user(url,sortby,sortas);
               return false;

               });
               $('#searchBtn').click(function(){
                   get_user('<?=BASE?>panel/reports/user_ajax/0');
               });
                $('#college_id').change(function(){
                    get_user('<?=BASE?>panel/reports/user_ajax/0');
                    $('#exportExcel').attr("href", function(i, href) {
                        return excelHref + '?clg=' + $('#college_id').val();
                      });
                });
          })
            function get_user(url)
            {
                $("#user_body").html('<tr><td colspan="12" align="center"><i class="fa fa-spinner fa-spin fa-2x"></i></td></tr>');
                var search = $('#search').val();
                var college_id = $('#college_id').val();
                 if(url!='#' && url!=''){
                   $.ajax({
                   type: "POST",
                   url: url,
                   data:{search:search,college:college_id},
                   success: function(res){
                      $("#user_body").html(res);
                    }
                   });
                   }
            }
          </script>