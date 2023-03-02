<!--form code-->
<div class="modal fade" id="userJoinCode" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Join class by code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>
                            Class code
                        </label>
                        <p>Ask your teacher for the class code, then enter it here.</p>
                        <input type="text" class="form-control code-join-class" placeholder="Enter your code here">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" value="Accept" class="btn btn-primary join-by-code" url="{{ route('join.class') }}">Join Class</button>
            </div>
        </div>
    </div>
</div>
