 <!--Confirm Activation Div Start-->
    <div class="modal fade" id="confirm-active">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
                    <h4>Confirm Activation</h4>
                </div>

                <div class="modal-body">
                    <h4>Are you sure to send email ?</h4>
                </div>

                <div class="modal-footer">
                    <!--Getting id for active(id) method from js/Controller.js-->
                    <button ng-click="active(id, 0)" id="yesSubmit" class="btn btn-danger">No</button>
                    <button ng-click="active(id, 1)" id="noSubmit" class="btn btn-success">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!--Confirm Activation Div End-->