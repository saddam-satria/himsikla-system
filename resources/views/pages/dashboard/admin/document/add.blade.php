@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Tambah Dokumen</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form method="POST" action="{{route("dashboard.admin.document.store")}}" enctype="multipart/form-data">
                    @csrf
                    @method("POST")


                    
                    <div class="card-body">
                        
                        <div class="my-2">
                            <label for="document">Dokumen File</label>
                            <div class="input-group py-2">
                                <div class="custom-file">
                                    <input
                                    type="file"
                                    class="custom-file-input file-input" 
                                    id="document"
                                    name="document"
                                    />
                                    <label
                                    class="custom-file-label  label-input-file""
                                    for="document"
                                    >Pilih File</label
                                    >
                                </div>
                            </div>
                            @include('components.form_validation', ["field" => "document"])
                        </div>

                      <div class="form-group">
                        <label for="name">Nama Dokumen</label><span class="text-danger">*</span>
                        <input value="{{old("name")}}" type="text" name="name" id="name" class="form-control"  placeholder="Masukkan Nama Dokumen">
                      </div>
                      @include('components.form_validation', ["field" => "name"])

                     
                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
                <!-- /.card -->
    
        
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
  const customFile= document.querySelector('.file-input');
  const labelInput= document.querySelector(".label-input-file");


  customFile.addEventListener("input", (e) => {
      customFile.addEventListener("change", (e) => {
      const file = e.target.files[0];
      if(!file) {
        labelInput.innerText= "Pilih File"
       
        return;
      };
     
      labelInput.innerText = file.name;
      })
  })
</script>

@endpush