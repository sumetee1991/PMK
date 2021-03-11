<div class="modal fade" id="hold-modal" tabindex="-1" role="dialog" aria-labelledby="hold-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hold Queue</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div style="padding: .25rem .5rem;font-size:2.2rem;">
                    <span style="padding:1rem 0.5rem;">เลขคิว :</span><span id="span_Queueno" style="padding:1rem 2rem 1rem 0rem;"></span>
                </div>
                <form id="formHold" class="form-group" style="padding: .25rem .5rem;font-size:2rem;">
                    <span style="padding:1rem 0.5rem;">กรุณาเลือก</span>
                    <select id="select_HoldMessage" name="uid" class="form-control" style="margin-top: 1rem;font-size:1.8rem;">
                        <option value="Hold">HoldMessage</option>
                    </select>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="button c_yellow" data-q_hold="q_hold_val" data-patientuid="data_puid_val">Hold</button>
                <button type="button" class="button c_red" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>