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
                <h4 id="myModalLabel" class="modal-title">Stock Movement Details</h4>
            </div>
            <div class="modal-body">
                <center><h4>NAIK FEEDS</h4></center>
                <table class="table table-striped table-bg modal-table-2" style="text-align: center;">
                    <tr >
                        <th>Request Number</th><td id="requestno"></td>
                    </tr>
                    <tr>
                        <th>Stock Name</th><td id="stock_name"></td>
                    </tr>
                    <tr>
                        <th>Quantity</th><td id="quantity"></td>
                    </tr>
                    <tr>
                        <th>Sales Area</th><td id="sales_area"></td>
                    </tr>
                    <tr>
                        <th>Requester</th><td id="requester"></td>
                    </tr>
                    <tr>
                        <th>Request Date</th><td id="request_date"></td>
                    </tr>
                    <tr>
                        <th>Request Status</th><td id="status"></td>
                    </tr>

                </table>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            </div>
        </div>
        <!-- /.modal-content --> 
    </div>
    <!-- /.modal-dialog --> 
</div>