<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#{{$payload}}">
  <i class="fa-solid fa-qrcode"></i>
</button>


<div class="modal fade" id="{{$payload}}" tabindex="-1" role="dialog" aria-labelledby="{{$payload}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header">
            <h5>QR Code</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
            <div class="d-flex flex-column align-items-center">
                {!! QrCode::size(250)->generate($payload); !!}
                <div class="py-2">
                    <span class="text-bold">Scan Me</span>
                </div>
            </div>
        </div>

      </div>
    </div>
  </div>