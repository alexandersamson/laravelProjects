<div class="modal fade" id="genericEraseModal"
     tabindex="-1" role="dialog"
     aria-labelledby="genericEraseModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="genericEraseModalLabel">Confirm permanent erase</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirm permanent erase?<br><br>
                <h4><span class="text-danger"><b>WARNING:</b> This action cannot be undone!</span></h4>
            </div>
            <div class="modal-footer">
                <span class="pull-left">
                  <button type="button" data-save="null" data-dismiss="modal" id="genericEraseModalNoBtn" class="btn btn-primary modalNoBtn">
                    NO
                  </button>
                </span>
                <span class="pull-right">
                  <button type="button" data-save="null" id="genericEraseModalYesBtn" class="btn btn-danger modalYesBtn">
                    YES
                  </button>
                </span>
            </div>
        </div>
    </div>
</div>