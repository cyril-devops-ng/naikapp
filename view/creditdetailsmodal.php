<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div style="display: none;" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                <h4 id="myModalLabel" class="modal-title">CREDIT DETAILS</h4>
            </div>
            <div class="modal-body">
                <?php
//                    $creditdetails = rsort($_SESSION['credit_sales_return']);
//                    print '<pre>'; print_r($_SESSION['credit_sales_return']); print '</pre>';
                ?>
                <center><h4>NAIK FEEDS</h4></center>
                
                <center><h2 id="outlet_name"></h2></center>
                <div id="modalInfo">


                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content --> 
    </div>
    <!-- /.modal-dialog --> 
</div>