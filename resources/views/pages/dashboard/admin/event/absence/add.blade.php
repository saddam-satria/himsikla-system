@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Tambah Absensi Acara</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form method="POST" action="{{route("dashboard.admin.event_absence.store")}}">
                    @csrf
                    @method("POST")
                    <div class="card-body">

                      <div class="form-group">
                        <label for="event_id">Acara</label>
                        @if (count($events) > 0)
                          <select id="event_id" name="event_id" class="custom-select">
                              @foreach ($events as $event)
                                <option class="text-lowercase" value="{{$event->id}}">{{$event->eventName}}</option>
                                @endforeach
                          </select>
                        @else
                          <input type="text" name="event_id"  class="form-control" disabled placeholder="Acara Kosong">
                        @endif
                      </div>
                      @include('components.form_validation', ["field" => "event_id"])

                      <div id="guest">
                        <div class="form-group">
                          <label for="email">Email</label><span class="text-danger">*</span>
                          <input value="{{old("email")}}" type="text" name="email" id="email" class="form-control" placeholder="Email Peserta">
                        </div>
                        @include('components.form_validation', ["field" => "email"])
                        
                        <div class="form-group">
                          <label for="nim">NIM</label><span class="text-danger">*</span>
                          <input value="{{old("nim")}}" type="text" name="nim" id="nim" class="form-control" placeholder="NIM Peserta">
                        </div>
                        @include('components.form_validation', ["field" => "nim"])

                        <div class="form-group">
                          <label for="university">Universitas</label><span class="text-danger">*</span>
                          <input value="{{old("university")}}" type="text" name="university" id="university" class="form-control" placeholder="Universitas Peserta">
                        </div>
                        @include('components.form_validation', ["field" => "university"])


                 
                      </div>

                      
                      <div class="form-group">
                        <div class="form-check">
                            <input
                            type="checkbox"
                            class="form-check-input"
                            id="isMember"
                            name="isMember"
                            />
                            <label class="form-check-label" for="isOnline">Absen Member</label>
                        </div>
                      </div>

                      <div id="member" hidden>
                        <div class="form-group">
                          @if (count($members) > 0)
                            <label for="member_id">Anggota</label>
                            <select id="member_id" name="member_id" class="custom-select">
                                @foreach ($members as $member)
                                  <option class="text-lowercase" value="{{$member->id}}">{{$member->name . "-" . $member->nim}}</option>
                                  @endforeach
                            </select>
                            <span class="text-sm text-bold">nama member-nim member</span>
                          @else
                            <input type="text" name="member_id"  class="form-control" disabled placeholder="Anggota Kosong">
                          @endif
                        </div>
                        @include('components.form_validation', ["field" => "member_id"])

                      

                        
                      </div>

                      <div class="form-group">
                        <label for="status">Alasan Absen</label>
                        <select id="status" name="status" class="custom-select">
                             @foreach ($reasons as $reason)
                              <option class="text-lowercase" value="{{$reason}}">{{$reason}}</option>
                             @endforeach
                          </select>
                      </div>

                      <div class="form-group">
                        <div class="form-check">
                            <input
                            type="checkbox"
                            class="form-check-input"
                            id="paid"
                            name="paid"
                            />
                            <label class="form-check-label" for="paid">Lunas Pembayaran</label>
                        </div>
                      </div>

                    </div>
                
    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                  </form>
                </div>
          
    
        
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
      const member = document.querySelector("#member");
      const guest = document.querySelector("#guest")
      const isMember = document.querySelector("#isMember")


      isMember.addEventListener("click", (e) => {
        e.target.addEventListener("change", (e) => {
           if(e.target.checked) 
           {
              guest.hidden = true;
              member.hidden = false;
              return
           }

           
            member.hidden = true;
            guest.hidden = false;
            return 
        })
      })
    </script>
@endpush