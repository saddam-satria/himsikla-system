<div class="content-header">
  @if (isset($contents))
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                @foreach ($contents as $content)
                  <li class="breadcrumb-item active"><a >{{$content}}</a></li>
                @endforeach
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    @endif
  </div>
  <!-- /.content-header -->