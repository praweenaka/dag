<!-- Modal -->
<div class="container">
    <div class="modal fade" id="myModal_search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Search Dealer Incentive</h4>
                </div>
                <div class="modal-body">


                    <div class="modal-body" >
                        <table style="table-layout: fixed;word-wrap: break-word;" class="table table-borderd">
                            <tr>
                                <th style="width: 10%">Dealer</th>
                                <th style="width: 10%">Month</th>
                                <th style="width: 10%">Year</th>
								<th style="width: 10%">Type</th>
								<th style="width: 20%">Remarks</th>
								<th style="width: 20%">Cheq. No</th>
                            </tr>
                            <tr>
                                <td><input class="form-control input-mini" onkeyup="search_cos();" id="ccode"></td>
                                <td><input class="form-control input-mini" onkeyup="search_cos();" id="month"></td>
                                <td><input class="form-control input-mini" onkeyup="search_cos();" id="year"></td>
								<td><input class="form-control input-mini" onkeyup="search_cos();" id="typem"></td>
                                <td><input class="form-control input-mini" onkeyup="search_cos();" id="remar"></td>
								<td><input class="form-control input-mini" onkeyup="search_cos();" id="cheqno"></td>
                            </tr>

                        </table>

                        <div style="height: 350px;overflow: scroll;" id="search_res">

                        </div>


                    </div>
                    <input type="hidden" id="action">
                    <input type="hidden" id="form">


                    <span   id="txterror">

                    </span>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>