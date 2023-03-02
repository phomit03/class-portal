<!--form-support-->
<div class="modal fade" id="userSupportModal" role="dialog" tabindex="-1" aria-labelledby="supportModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Contact Us</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{url('/Issues')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->first('phone') ? 'has-error' : '' }}">
                        <label>Phone number: </label>
                        <input type="text" class="form-control" value="{{ old('phone') }}" name="phone" placeholder="Enter your phone here">
                        @if ($errors->has('phone'))
                            <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->first('email') ? 'has-error' : '' }}">
                        <label>Email: </label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email here">
                        @if ($errors->has('email'))
                            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->first('describe') ? 'has-error' : '' }}">
                        <label>Description: </label>
                        <textarea rows="5" class="form-control" name="describe" placeholder="Enter your description here">{{ old('describe') }}</textarea>
                        @if ($errors->has('describe'))
                            <span class="help-block"><strong>{{ $errors->first('describe') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->first('attachments') ? 'has-error' : '' }}">
                        <label>Attachments (if possible): </label>
                        <input class="custom-file-input" type="file" name="attachments" value="{{ old('attachments') }}" placeholder="Enter your attachments here">
                        @if ($errors->has('attachments'))
                            <span class="help-block"><strong>{{ $errors->first('attachments') }}</strong></span>
                        @endif
                    </div>

                    <input  class="custom-file-input" type="hidden" name="user_id">

                    <div class="modal-footer">
                        <button type="submit" value="Accept" class="btn btn-primary" style="width: 120px">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
