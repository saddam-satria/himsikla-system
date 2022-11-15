 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-light-primary  elevation-4">
    <!-- Brand Logo -->
    <a href="{{url("/dashboard")}}" class="brand-link" style="background-color: #101248;">
      <img src="{{asset("android-chrome-192x192.png")}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light text-white" style="font-family: 'Poppins', sans-serif;">HIMSI KLA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      @if (!is_null(auth()->user()->member))
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
          <div class="image">
            <img src="{{is_null(auth()->user()->member->image)  ?  "https://ui-avatars.com/api/?name=" . auth()->user()->member->name . "&size=280"  : asset("assets/member/profile/" . auth()->user()->member->image)}}" class="rounded elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="{{route("dashboard.user.member.profile")}}" class="d-block text-capitalize">{{explode(" ", auth()->user()->member->name)[0]}}</a>
            <div>
              <i class="fa-regular fa-address-card" style="color: #101248;"></i>          
              <span class="text-success text-capitalize">{{auth()->user()->member->occupation}}</span>
            </div>
          </div>
        </div>
      @else
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
          <div class="image">
            <img src="{{asset("assets/img/user2-160x160.jpg")}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{auth()->user()->email}}</a>
            <div>
              <i class="fa-regular fa-address-card"></i>          
              <span class="text-success">{{auth()->user()->university}}</span>
            </div>
          </div>
        </div>
      @endif

      
{{--     
      <div class="form-inline py-3">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      
      
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          @if (!is_null(auth()->user()->member) || auth()->user()->role_id == 99)
          <li class="nav-item">
            <a href="{{url("/dashboard")}}" class="nav-link {{Request::path() == "dashboard" ? "active" : ""}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          @if (auth()->user()->role_id == 99 || auth()->user()->member->occupation == "ketua" || auth()->user()->member->occupation == "wakil ketua" || str_contains(auth()->user()->member->occupation , "ketua koordinator rsdm"))
              
            <li class="nav-item ">
              <a href="#" class="nav-link {{str_contains(Request::path(), "dashboard/admin/user") ? "active" : ""}}">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Akun
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route("dashboard.admin.user.index")}}" class="nav-link {{Request::path() == "dashboard/admin/user" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Akun</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route("dashboard.admin.user.create")}}" class="nav-link {{Request::path() == "dashboard/admin/user/create" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tambah Akun User</p>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="nav-item">
              <a href="#" class="nav-link {{Request::path() == "dashboard/admin/member" ? "active" : ""}}">
                <i class="nav-icon fas fa-user-group"></i>
                <p>
                  Anggota
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route("dashboard.admin.member.index")}}" class="nav-link {{Request::path() == "dashboard/admin/member" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Anggota</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route("dashboard.admin.member.create")}}" class="nav-link {{Request::path() == "dashboard/admin/member/create" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tambah Anggota</p>
                  </a>
                </li>
              </ul>
            </li>

          @endif
          

        
          
          @if (auth()->user()->role_id == 1)

            @if (str_contains(auth()->user()->member->occupation , 'ketua koordinator rsdm') || auth()->user()->member->occupation == "ketua")
            <li class="nav-item">
              <a href="#" class="nav-link {{Request::path() == "dashboard/admin/meet" || Request::path() == "dashboard/admin/meet/create"  ? "active" : ""}}">
                <i class="nav-icon fa-solid fa-calendar-days"></i>
                <p>
                  Rapat Anggota
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route("dashboard.admin.meet.index")}}" class="nav-link {{Request::path() == "dashboard/admin/meet"  ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Rapat</p>
                  </a>
                </li>
                @if (auth()->user()->member->occupation != "ketua")
                  <li class="nav-item">
                    <a href="{{route("dashboard.admin.meet.create")}}" class="nav-link {{Request::path() == "dashboard/admin/meet/create"  ? "active" : ""}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Rapat Baru</p>
                    </a>
                  </li>
                @endif
              </ul>
            </li> 
            
            <li class="nav-item">

              <a href="#" class="nav-link {{Request::path() == "dashboard/admin/alumni" ? "active" : ""}}">
                <i class="nav-icon fa-solid fa-user-graduate"></i>
                <p>
                  Alumni HIMSI
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route("dashboard.admin.alumni.index")}}" class="nav-link {{Request::path() == "dashboard/admin/alumni" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Alumni</p>
                  </a>
                </li>

                @if (auth()->user()->member->occupation != "ketua")
                  <li class="nav-item">
                    <a href="{{route("dashboard.admin.alumni.create")}}" class="nav-link {{Request::path() == "dashboard/admin/alumni/create"  ? "active" : ""}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Alumni</p>
                    </a>
                  </li>
                @endif
              </ul>
            </li> 

            <li class="nav-item">
              <a href="#" class="nav-link {{Request::path() ===  "dashboard/admin/event" && !Request::get("action")  ? "active" : ""}}">
                <i class="nav-icon fa-solid fa-calendar-week"></i>
                <p>
                  Acara
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route("dashboard.admin.event.index")}}" class="nav-link {{Request::path() == "dashboard/admin/event" && Request::get("action") == null ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Acara</p>
                  </a>
                </li>
                @if (auth()->user()->member->occupation != "ketua")
                <li class="nav-item">
                  <a href="{{route("dashboard.admin.event.create")}}" class="nav-link {{Request::path() == "dashboard/admin/event/create" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tambah Acara</p>
                  </a>
                </li>
                @endif
              </ul>
            </li>

            
            @if (auth()->user()->member->occupation == "ketua" || str_contains(auth()->user()->member->occupation, "ketua koordinator rsdm"))
            <li class="nav-item">
              <a href="#" class="nav-link {{str_contains(Request::path(), "admin") && str_contains(Request::path(), "absence")? "active" : ""}}">
                <i class="nav-icon fa-solid fa-calendar-check"></i>
                <p>
                  Kehadiran
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route("dashboard.admin.meet_absence.member")}}" class="nav-link {{Request::path() == "dashboard/admin/member-absence" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Rekap Absensi Pertemuan</p>
                  </a>
                </li>
              </ul>
                @if (auth()->user()->member->occupation !== "ketua")
                    
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route("dashboard.admin.meet_absence.create")}}" class="nav-link {{Request::path() == "dashboard/admin/meet-absence/create" ? "active" : ""}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Absensi Pertemuan</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route("dashboard.admin.event_absence.create")}}" class="nav-link {{Request::path() == "dashboard/admin/event-absence/create" ? "active" : ""}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Absensi Acara</p>
                    </a>
                  </li>
                </ul>
                @endif
              @endif
            </li>

            @endif
          

            @if (str_contains(auth()->user()->member->occupation , 'ketua koordinator kominfo') || auth()->user()->member->occupation == "ketua" )
            <li class="nav-item">
              <a href="#" class="nav-link {{Request::path() == "dashboard/admin/event" && Request::get("action") == "certificates" ? "active" : ""}}">
                <i class="nav-icon fa-solid fa-folder"></i>
                <p>
                  Sertifikat
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route("dashboard.admin.event.index"). "?action=certificates"}}" class="nav-link {{Request::path() == "dashboard/admin/event" && Request::get("action") == "certificates" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Sertifikat Acara</p>
                  </a>
                  @if (str_contains(auth()->user()->member->occupation , 'ketua koordinator kominfo'))
                  <a href="{{route("dashboard.admin.event.certificate.create")}}" class="nav-link {{Request::path() == "dashboard/admin/event/create/certificate"  ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tambah Sertifikat Acara</p>
                  </a>
                  @endif
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link {{str_contains(Request::path(),"dashboard/admin/gallery") ? "active" : ""}}">
                <i class="nav-icon fa-solid fa-folder"></i>
                <p>
                  Album Foto
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route("dashboard.admin.gallery.index")}}" class="nav-link {{Request::path() == "dashboard/admin/gallery"  ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Album</p>
                  </a>
                  @if (str_contains(auth()->user()->member->occupation , 'ketua koordinator kominfo'))
                  <a href="{{route("dashboard.admin.gallery.create")}}" class="nav-link {{Request::path() == "dashboard/admin/gallery/create"  ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tambah Foto</p>
                  </a>
                  @endif
                </li>
              </ul>
            </li>

            @endif
          

            @if (str_contains(auth()->user()->member->occupation , 'sekretaris') ||  auth()->user()->member->occupation == "ketua")
                
            <li class="nav-item">
              <a href="#" class="nav-link {{str_contains(Request::path(), "dashboard/admin/event-note") || str_contains(Request::path(), "dashboard/admin/meet-note") ? "active" : ""}}">
                <i class="nav-icon fa-solid fa-file-circle-plus"></i>
                <p>
                  Notulensi
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route("dashboard.admin.event_note.index")}}" class="nav-link {{Request::path() == "dashboard/admin/event-note" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Notulensi Acara</p>
                  </a>
                  <a href="{{route("dashboard.admin.meet_note.index")}}" class="nav-link {{Request::path() == "dashboard/admin/meet-note" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Notulensi Pertemuan</p>
                  </a>
                  @if (auth()->user()->member->occupation != "ketua")
                  <a href="{{route("dashboard.admin.event_note.create")}}" class="nav-link {{Request::path() == "dashboard/admin/event-note/create"  ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tambah Notulensi Acara</p>
                  </a>
                  <a href="{{route("dashboard.admin.meet_note.create")}}" class="nav-link {{Request::path() == "dashboard/admin/meet-note/create"  ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tambah Notulensi Pertemuan</p>
                  </a>
                  @endif
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link {{str_contains(Request::path(), "admin/document") ? "active" : ""}}">
                <i class="nav-icon fa-solid fa-calendar-check"></i>
                <p>
                  Berkas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route("dashboard.admin.document.index")}}" class="nav-link {{Request::path() == "dashboard/admin/document" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Daftar Berkas</p>
                  </a>
                </li>
                @if (auth()->user()->member->occupation != "ketua")
                    <li class="nav-item">
                      <a href="{{route("dashboard.admin.document.create")}}" class="nav-link {{Request::path() == "dashboard/admin/document/create" ? "active" : ""}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tambah Berkas</p>
                      </a>
                    </li>
                @endif
              </ul>
            </li>

  
            @endif

        

            
            @if (str_contains(auth()->user()->member->occupation, "bendahara") || auth()->user()->member->occupation == "ketua" )
              <li class="nav-item">
                <a href="#" class="nav-link {{str_contains(Request::path(), "admin/finance") ? "active" : ""}}">
                  <i class="nav-icon fa-solid fa-coins"></i>
                  <p>
                    Keuangan
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">

                  <li class="nav-item">
                    <a href="{{route("dashboard.admin.finance.index")}}" class="nav-link {{Request::path() == "dashboard/admin/finance-management/finance" ? "active" : ""}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Kas</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{route("dashboard.admin.income.index")}}" class="nav-link {{Request::path() == "dashboard/admin/finance-management/income" ? "active" : ""}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Pemasukan</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{route("dashboard.admin.outcome.index")}}" class="nav-link {{Request::path() == "dashboard/admin/finance-management/outcome" ? "active" : ""}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Pengeluaran</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{route("dashboard.admin.balance_sheet.index")}}" class="nav-link {{Request::path() == "dashboard/admin/finance-management/balance-sheet" ? "active" : ""}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Neraca</p>
                    </a>
                  </li>

                </ul>
              </li>
            @endif

      
            <li class="nav-item">
              <a href="{{route("dashboard.user.member.profile")}}" class="nav-link {{Request::path() == "dashboard/user/member" ? "active" : ""}}">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Profile Member
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{route("dashboard.user.member.event.index")}}" class="nav-link {{Request::path() == "dashboard/user/member/event" ? "active" : ""}}">
                <i class="nav-icon fas fa-file"></i>
                <p>
                  Acara
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{route("dashboard.user.member.meet.index")}}" class="nav-link {{Request::path()  == "dashboard/user/member/meet" ? "active" : ""}}">
                <i class="nav-icon fas fa-file"></i>
                <p>
                  Rapat
                </p>
              </a>
            </li>


            <li class="nav-item">
              <a href="#" class="nav-link {{str_contains(Request::path(), "dashboard/user/member/finance") ? "active" : ""}}">
                <i class="nav-icon fa-solid fa-wallet"></i>
                <p>
                  Keuangan
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route("dashboard.member.finance.index")}}" class="nav-link {{Request::path() == "dashboard/user/member/finance" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Tagihan Kas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route("dashboard.member.finance.history")}}" class="nav-link {{Request::path() == "dashboard/user/member/finance/history" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>History Pembayaran Kas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route("dashboard.member.finance.create")}}" class="nav-link {{Request::path() == "dashboard/user/member/finance/pay" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Bayar Kas</p>
                  </a>
                </li>
              </ul>
            </li>

            
            <li class="nav-item">
              <a href="#" class="nav-link {{str_contains(Request::path(), "member/meet-absence") ? "active" : ""}}">
                <i class="nav-icon fa-solid fa-calendar-check"></i>
                <p>
                  Absensi Pertemuan
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route("dashboard.user.member.absence")}}" class="nav-link {{Request::path() == "dashboard/user/member/meet-absence" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Absensi</p>
                  </a>
                  <a href="{{route("dashboard.user.member.scanner")}}" target="__blank" rel="noopener" class="nav-link {{Request::path() == "dashboard/user/member/scanner" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Scan QR Absen</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link {{str_contains(Request::path(), "member/event-absence") ? "active" : ""}}">
                <i class="nav-icon fa-solid fa-calendar-check"></i>
                <p>
                  Absensi Rapat
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route("dashboard.user.member.event.absence")}}" class="nav-link {{Request::path() == "dashboard/user/member/event-absence" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Absensi Anda</p>
                  </a>
                  <a href="{{route("dashboard.user.member.scanner")}}"  target="__blank" rel="noopener"  class="nav-link {{Request::path() == "dashboard/user/member/scanner" ? "active" : ""}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Scan QR Absen</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="{{route("dashboard.user.member.document")}}" class="nav-link {{str_contains(Request::path(), "member/documents") ? "active" : ""}}">
                <i class="nav-icon fas fa-folder"></i>
                <p>
                  Dokumen
                </p>
              </a>
            </li>
            

            @if (str_contains(auth()->user()->member->occupation, "ketua koordinator") || str_contains(auth()->user()->member->occupation, "anggota"))
              <li class="nav-item">
                <a href="{{route("dashboard.user.member.division.index")}}" class="nav-link {{str_contains(Request::path(), "member/division") ? "active" : ""}}">
                  <i class="nav-icon fas fa-share-from-square"></i>
                  <p>
                    Anggota Divisi
                  </p>
                </a>
              </li>
            @endif

            
          @endif
           
          @endif

     
        </ul>
      </nav>
     
      
     
    </div>
    <!-- /.sidebar -->
  </aside>
