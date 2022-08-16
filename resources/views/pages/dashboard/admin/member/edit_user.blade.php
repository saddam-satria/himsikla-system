@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Jabatan</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                   
                  <form method="POST" action="{{url("dashboard/admin/member/". $member->id . "?edit=user")}}">
                    @csrf
                    @method("PUT")
                    <div class="card-body">

                    <div class="form-group">
                        <label>User Sebelumnya</label>
                        <input  type="text"  class="form-control bg-indigo text-lowercase" disabled value="{{$member->email}}">
                    </div>

                    
                    <div class="form-group">
                        <label for="user">User</label>
                        @if (count($users) > 0)
                            <select id="user" name="user" class="custom-select">
                                  @foreach ($users as $user)
                                    <option class="text-lowercase" value="{{$user->id}}">{{$user->email}}</option>
                                  @endforeach  
                            </select>
                        @else
                          <input type="text" name="user" class="form-control bg-transparent text-capitalize" disabled placeholder="User Tidak Di temukan">
                        @endif
                    </div>


                    


                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Ganti</button>
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
      const occupationSelected = document.querySelector("#occupation");
      const division  = document.querySelector(".division");
      occupationSelected.addEventListener('click', (e) => {
          if(e.target.value.includes("ketua koordinator") || e.target.value.includes("anggota")){
            division.hidden = false;
            return;
          }
          division.hidden = true;
          return
      })
    </script>
    
@endpush

