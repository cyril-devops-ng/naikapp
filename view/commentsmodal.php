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
                <h4 id="myModalLabel" class="modal-title">Reject Reason</h4>
            </div>
            <div class="modal-body">
                <center><h4>NAIK FEEDS</h4></center><br/>
                <p><span style="font-size:18px;">Please enter reject reason below</span></p>
                <textarea id="commentText" cols="75" rows="5"></textarea>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" id="saveReject" class="btn btn-default" type="button">Save</button>
            </div>
        </div>
        <!-- /.modal-content --> 
    </div>
    <!-- /.modal-dialog --> 
</div>