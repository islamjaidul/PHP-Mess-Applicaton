 <!--Add Div Start-->
    <div class="modal fade" id="confirm-create">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
                    <h4>Create Customer</h4>
                </div>

                <div class="modal-body">
                    <form name="myForm" class="form-horizontal">

                        <div class="form-group">
                            <label class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input type="text" name="firstname" class="form-control" ng-model="frm.firstname" required>
                                <span style="color:red" ng-show="myForm.firstname.$touched && myForm.firstname.$invalid">
                                    <span ng-show="myForm.surname.$error.required">Username is required.</span>
                            </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Sur Name</label>

                            <div class="col-md-6">
                                <input type="text" name="surname" class="form-control" ng-model="frm.surname" required>
                                <span style="color:red" ng-show="myForm.surname.$touched && myForm.surname.$invalid">
                                    <span ng-show="myForm.surname.$error.required"> Surname is required </span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control" ng-model="frm.email" required>
                                <span style="color:red" ng-show="myForm.email.$touched && myForm.email.$invalid">
                                    <span ng-show="myForm.email.$error.required">E-mail is required</span>
                                    <span ng-show="myForm.email.$error.email">Invalid Email Address</span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" name="password" class="form-control" name="password" ng-model="frm.password" ng-minlength="8" required>
                                <span style="color:red" ng-show="myForm.password.$touched && myForm.password.$invalid">
                                    <span ng-show="myForm.password.$error.required">Password is required</span>
                                    <span ng-show="myForm.password.$error.minlength">Password must be minimum 8 character</span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input type="password" name="cnfrm_password" class="form-control" ng-model="frm.cnfrm_password" required data-password-verify="frm.password">
                                <span style="color:red" ng-show="myForm.cnfrm_password.$touched && myForm.cnfrm_password.$invalid && myForm.cnfrm_password.$dirty">
                                    <span ng-show="myForm.cnfrm_password.$error.required">Confirm Password is required</span>
                                    <span ng-show="myForm.cnfrm_password.$error.passwordVerify">Password do not match</span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Company Name</label>

                            <div class="col-md-6">
                                <input type="text" name="company_name" class="form-control" ng-model="frm.company_name" required>
                                 <span style="color:red" ng-show="myForm.company_name.$touched && myForm.company_name.$invalid">
                                    <span ng-show="myForm.company_name.$error.required">Company Name is required</span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Address</label>

                            <div class="col-md-6">
                                <textarea class="form-control" name="address" ng-model="frm.address" required></textarea>
                                 <span style="color:red" ng-show="myForm.address.$touched && myForm.address.$invalid">
                                    <span ng-show="myForm.address.$error.required">Address is required</span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Post Number</label>

                            <div class="col-md-6">
                                <input type="number" name="post_number" class="form-control" ng-model="frm.post_number" required>
                                 <span style="color:red" ng-show="myForm.post_number.$touched && myForm.post_number.$invalid">
                                    <span ng-show="myForm.post_number.$error.required">Post Number is required</span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">City</label>

                            <div class="col-md-6">
                                <select name="city" class="form-control" ng-model="frm.city" required>
                                    <option value="City1">City1</option>
                                    <option value="City2">City2</option>
                                    <option value="City3">City3</option>
                                    <option value="City4">City4</option>
                                </select>

                                 <span style="color:red" ng-show="myForm.city.$touched && myForm.city.$invalid">
                                    <span ng-show="myForm.city.$error.required">City is required</span>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="submit" data-dismiss="modal" aria-hidden="false" class="btn btn-default">Cancel</button>
                    <button ng-disabled="!myForm.$valid" ng-click="pushData(frm)" type="submit" id="submit"  value="Submit" class="btn btn-success"><i class="fa fa-user-plus"></i> Create Customer</button>
                </div>
            </div>
        </div>
    </div>
    <!--Add Div End-->