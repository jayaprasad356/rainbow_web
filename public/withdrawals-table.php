<?php

if (isset($_POST['btnCancel'])  && isset($_POST['enable'])) {
       $sql="SELECT * FROM withdrawals WHERE id IN (".implode(',',$_POST['enable']).")";
       $db->sql($sql);
       $result = $db->getResult();
            foreach ($result as $row) {
                $amount=$row['amount'];
                $sql = "UPDATE users SET balance= balance +$amount WHERE id = $row[user_id]";
                $db->sql($sql);
                $result = $db->getResult();
            }
    for ($i = 0; $i < count($_POST['enable']); $i++) {
        $enable = $db->escapeString($fn->xss_clean($_POST['enable'][$i]));
        $sql = "UPDATE withdrawals SET status=2 WHERE id = $enable";
        $db->sql($sql);
        $result = $db->getResult();
    }
}

if (isset($_POST['btnPaid'])  && isset($_POST['enable'])) {
    for ($i = 0; $i < count($_POST['enable']); $i++) {
        
    
        $enable = $db->escapeString($fn->xss_clean($_POST['enable'][$i]));
        $sql = "UPDATE withdrawals SET status=1 WHERE id = $enable";
        $db->sql($sql);
        $result = $db->getResult();
    }
}

?>
<section class="content-header">
    <h1>Withdrawals /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
  
</section>
    <!-- Main content -->
    <section class="content">
        <form name="withdrawal_form" id="myForm" method="post" enctype="multipart/form-data">
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <div class="col-xs-12">
                        <div class="box">
                            
                            <div  class="box-body table-responsive">
                                    <div class="row">
                                        <div class="form-group">
                                           <div class="text-left col-md-2">
                                                <input type="checkbox" onchange="checkAll(this)" name="chk[]" > Select All</input>
                                            </div> 
                                            <div class="col-md-3">
                                                    <button type="submit" class="btn btn-success" name="btnPaid">Paid</button>    
                                                    <button type="submit" class="btn btn-danger" name="btnCancel">Cancel</button>                                                                                            
                                            </div>
                                        </div>
                                    </div>
                                <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=withdrawals" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="false" data-export-types='["txt","excel"]' data-export-options='{
                                        "fileName": "results-list-<?= date('d-m-Y') ?>",
                                        "ignoreColumn": ["operate"] 
                                    }'>
                                    <thead>
                                            <tr>
                                                <th data-field="column"> All</th>
                                                <th  data-field="id" data-sortable="true">ID</th>
                                                <th  data-field="email" data-sortable="true">Email</th>
                                                <th  data-field="upi" data-sortable="true">UPI</th>
                                                <th  data-field="amount" data-sortable="true">Amount</th>
                                                <th data-field="status" data-sortable="true">Status</th>
                                                <th  data-field="datetime" data-sortable="true">Date</th>
                                            </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="separator"> </div>
                </div>
                <!-- /.row (main row) -->
        </form>

    </section>

<script>

    $('#seller_id').on('change', function() {
        $('#products_table').bootstrapTable('refresh');
    });
    $('#community').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });

    function queryParams(p) {
        return {
            "seller_id": $('#seller_id').val(),
            "community": $('#community').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
    
</script>
<script>
 function checkAll(ele) {
     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }
    
</script>