@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Tambah User</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form method="POST" action="{{route("dashboard.admin.user.store")}}">
                    @csrf
                    @method("POST")
                    <div class="card-body">

                      <div class="form-group">
                        <label for="email">Email address</label><span class="text-danger">*</span>
                        <input value="{{old("email")}}" type="text" name="email" id="email" class="form-control"  placeholder="Alamat Email">
                      </div>
                      @include('components.form_validation', ["field" => "email"])

                      <div class="form-group">
                        <label for="password">Password</label><span class="text-danger">*</span>
                        <input  type="password" name="password" id="password" class="form-control" placeholder="Password">
                      </div>
                      @include('components.form_validation', ["field" => "password"])


                    <div class="form-group">
                        <div class="form-check">
                            <input
                            type="checkbox"
                            class="form-check-input"
                            id="isGuest"
                            name="isGuest"
                            />
                            <label class="form-check-label" for="isGuest">Sebagai Tamu</label>
                        </div>
                    </div>

                    
                      <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="custom-select">
                            @foreach ($gender as $gender)
                              <option class="text-capitalize" value="{{$gender}}">{{$gender}}</option>
                            @endforeach
                            
                          </select>
                      </div>

                      <div class="form-group">
                        <label for="university">universitas/instansi/perusahaan</label><span class="text-danger">*</span>
                        <input  type="text" name="university" value="kaliabang" id="university" class="form-control" placeholder="University" readonly>
                      </div>
                      @include('components.form_validation', ["field" => "university"])

                      
                      <div class="form-group">
                        <label for="role">role</label>
                        <input type="text" value="anggota" id="role" class="form-control" placeholder="role" disabled>
                      </div>


                      
                      
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
      const isGuest = document.querySelector('#isGuest');
      const role = document.querySelector('#role');
      const university = document.querySelector("#university");
      const guestHandler = () => {
          isGuest.addEventListener("click", (e) => {
            if(e.target.checked) {
              role.value = "tamu";
              university.readOnly = false;
              university.value = ""
              return;
            }

            role.value = "anggota";
            university.readOnly = true;
            university.value = "kaliabang"
            return;
        })
      }

      (() => {
        guestHandler()
      })()

    </script>

@endpush