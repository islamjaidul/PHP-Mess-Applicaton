 <!--Customer information Div Start-->
    <div class="modal fade" id="confirm-view">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
                    <h4>Customer Information</h4>
                </div>

                <div  class="modal-body">
                    <h4 ng-init="customerView.firstname=''" style="color:teal">@{{ customerView.firstname }} @{{ customerView.surname }}</h4>
                    <p ng-init="customerView.email='loading...'">Email: @{{ customerView.email }}</p>
                    <p ng-init="customerView.company_name='loading...'">Company Name: @{{ customerView.company_name }}</p>
                    <p ng-init="customerView.address='loading...'">Address: @{{ customerView.address }}</p>
                    <p ng-init="customerView.post_number='loading...'">Post Number: @{{ customerView.post_number }}</p>
                    <p ng-init="customerView.city='loading...'">City: @{{ customerView.city }}</p>
                    <p ng-init="customerView.active='loading...'">Status: <span style="color:green" ng-if="customerView.active == 1">Active</span>
                    <span  style="color:red" ng-if="customerView.active == 0">Inactive</span></p>
                </div>
            </div>
        </div>
    </div>
    <!--Customer information Div End-->