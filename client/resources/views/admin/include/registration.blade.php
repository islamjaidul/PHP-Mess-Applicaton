 <!--Admin Registration Div Start-->
    <div class="modal fade" id="confirm-register">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
                    <h4>Admin Registration</h4>
                </div>

                <div  class="modal-body">
                    <form name="registerForm" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" required ng-model="frm.name">
                                <span style="color:red" ng-show="registerForm.name.$touched && registerForm.name.$invalid">
                                    <span ng-show="registerForm.name.$error.required">Name is required</span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" required ng-model="frm.email">
                                <span style="color:red" ng-show="registerForm.email.$touched && registerForm.email.$invalid">
                                    <span ng-show="registerForm.email.$error.required">E-mail is required</span>
                                    <span ng-show="registerForm.email.$error.email">Invalid e-mail address</span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" required ng-model="frm.password" ng-minlength="8">
                                <span style="color:red" ng-show="registerForm.password.$touched && registerForm.password.$invalid">
                                    <span ng-show="registerForm.password.$error.required">password is required</span>
                                    <span ng-show="registerForm.password.$error.minlength">Password must be 8 character</span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation" ng-model="frm.password_confirmation" required data-password-verify="frm.password">
                                <span style="color:red" ng-show="registerForm.password_confirmation.$touched && registerForm.password_confirmation.$invalid">
                                    <span ng-show="registerForm.password_confirmation.$error.required">password is required</span>
                                    <span ng-show="registerForm.password_confirmation.$error.passwordVerify">Password do not match</span>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="registerSubmit" ng-disabled="!registerForm.$valid" ng-click="adminRegister(frm)" class="btn btn-success"><i class="fa fa-btn fa-user"></i> Register</button>
                </div>
            </div>
        </div>
    </div>
    <!--Admin Registration Div End-->