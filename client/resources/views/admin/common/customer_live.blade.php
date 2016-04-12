 <!--Customer live Div Start (Live means how many days customer account will be activated)-->
    <div class="modal fade" id="confirm-live">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
                    <h4>Customer Live Time</h4>
                </div>

                <div  class="modal-body">
                    <form name="liveForm">
                        <select class="form-control" ng-model="live.month" required>
                            <option ng-init="Select the Time Span" value="">Select the Time Span</option>
                            <option value="1">1 Month</option>
                            <option value="3">3 Months</option>
                            <option value="6">6 Months</option>
                            <option value="12">1 Year</option>
                            <option value="0">Never Expire</option>
                        </select>
                        <span style="color:red" ng-show="liveForm.month.$touched && liveForm.month.$invalid">
                            <span ng-show="liveForm.month.$error.required">Month is required</span>
                        </span>
                    </form>
                </div>

                <div class="modal-footer">
                    <button ng-disabled="!liveForm.$valid" id="liveSubmit" type="submit" ng-click="accountLive(live, id)" class="btn btn-success">Start</button>
                </div>
            </div>
        </div>
    </div>
    <!--Customer live Div End-->