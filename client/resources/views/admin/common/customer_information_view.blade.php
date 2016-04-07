 <!--Add Div Start-->
    <div class="modal fade" id="confirm-view">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
                    <h4>Customer Information</h4>
                </div>

                <div class="modal-body">
                    <h4 style="color:teal">@{{ customerView.firstname }} @{{ customerView.surname }}</h4>
                    <p>Email: @{{ customerView.email }}</p>
                    <p>Company Name: @{{ customerView.company_name }}</p>
                    <p>Address: @{{ customerView.address }}</p>
                    <p>Post Number: @{{ customerView.post_number }}</p>
                    <p>City: @{{ customerView.city }}</p>
                    <p>Status: <span style="color:green" ng-if="customerView.active == 1">Active</span>
                    <span style="color:red" ng-if="customerView.active == 0">Inactive</span></p>
                </div>
            </div>
        </div>
    </div>
    <!--Add Div End-->