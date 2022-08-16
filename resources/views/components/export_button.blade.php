<div class="dropdown">
    <button class="btn btn-primary btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Export
    </button>
    <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">
        @if (isset($excel))
            <form action="{{$excel}}" method="POST">
                @csrf
                @method("POST")
                <button  class="btn btn-md text-uppercase text-sm" type="submit">
                    <i class="fas fa-download text-sm"></i>
                    excel
                </button>
            </form>
        @endif
        @if (isset($pdf))
            <form action="{{$pdf}}" method="POST">
                @csrf
                @method("POST")
                <button  class="btn text-uppercase btn-md text-sm" type="submit">
                    <i class="fas fa-download text-sm"></i>
                    pdf 
                </button>
            </form>
        @endif
    </div>
</div>