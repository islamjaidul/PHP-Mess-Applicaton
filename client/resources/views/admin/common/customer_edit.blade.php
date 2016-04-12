 <!--Edit Div Start-->
    <div class="modal fade" id="confirm-edit">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
                    <h4>Edit Customer</h4>
                </div>

                <div class="modal-body">
                    <form name="myForm1" class="form-horizontal">

                        <div class="form-group">
                            <label class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input type="text" name="firstname" class="form-control" ng-model="customerView.firstname" required>
                                <span style="color:red" ng-show="myForm1.firstname.$touched && myForm1.firstname.$invalid">
                                    <span ng-show="myForm.surname.$error.required">First name is required.</span>
                            </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input type="text" name="lastname" class="form-control" ng-model="customerView.lastname" required>
                                <span style="color:red" ng-show="myForm1.lastname.$touched && myForm1.lastname.$invalid">
                                    <span ng-show="myForm1.lastname.$error.required"> Last name is required </span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control" ng-model="customerView.email" required>
                                <span style="color:red" ng-show="myForm1.email.$touched && myForm1.email.$invalid">
                                    <span ng-show="myForm1.email.$error.required">E-mail is required</span>
                                    <span ng-show="myForm1.email.$error.email">Invalid Email Address</span>
                                </span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label">Company Name</label>

                            <div class="col-md-6">
                                <input type="text" name="company_name" class="form-control" ng-model="customerView.company_name" required>
                                 <span style="color:red" ng-show="myForm1.company_name.$touched && myForm1.company_name.$invalid">
                                    <span ng-show="myForm1.company_name.$error.required">Company Name is required</span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Address</label>

                            <div class="col-md-6">
                                <textarea class="form-control" name="address" ng-model="customerView.address" required></textarea>
                                 <span style="color:red" ng-show="myForm1.address.$touched && myForm1.address.$invalid">
                                    <span ng-show="myForm1.address.$error.required">Address is required</span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Postal Code</label>

                            <div class="col-md-6">
                                <input type="text" name="postal_code" class="form-control" ng-model="customerView.postal_code" required>
                                 <span style="color:red" ng-show="myForm1.postal_code.$touched && myForm1.postal_code.$invalid">
                                    <span ng-show="myForm1.postal_code.$error.required">Postal code is required</span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">City</label>

                            <div class="col-md-6">
                                <input type="text" name="city" class="form-control" ng-model="customerView.city" required>
                                </select>

                                 <span style="color:red" ng-show="myForm1.city.$touched && myForm1.city.$invalid">
                                    <span ng-show="myForm1.city.$error.required">City is required</span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Phone Number</label>

                            <div class="col-md-6">
                                <input type="text" name="phone" class="form-control" ng-model="customerView.phone" required>
                                <input type="hidden" ng-model="customerView.id">

                                 <span style="color:red" ng-show="myForm1.phone.$touched && myForm1.phone.$invalid">
                                    <span ng-show="myForm1.phone.$error.required">Phone Number is required</span>
                                </span>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="submit" data-dismiss="modal" aria-hidden="false" class="btn btn-default">Cancel</button>
                    <button ng-disabled="!myForm1.$valid" ng-click="editData(customerView)" type="submit" id="editSubmit"  value="Submit" class="btn btn-success"><i class="fa fa-pencil-square-o"></i> Update</button>
                </div>
            </div>
        </div>
    </div>
    <!--Edit Div End-->