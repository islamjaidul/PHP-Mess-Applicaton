 <!--Confirm Delete Div Start-->
    <div class="modal fade" id="confirm-delete">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
                    <h4>Confirm Deletion</h4>
                </div>

                <div class="modal-body">
                    <h4>Are you sure to delete this customer ?</h4>
                </div>

                <div class="modal-footer">
                    <!--Getting id for delete(id) method from js/Controller.js-->
                    <button type="submit" data-dismiss="modal" aria-hidden="false" class="btn btn-default">Cancel</button>
                    <button ng-click="delete(id)" id="deleteSubmit" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!--Confirm Delete Div End-->