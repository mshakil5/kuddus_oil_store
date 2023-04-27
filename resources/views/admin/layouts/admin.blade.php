<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kuddus Oil Store</title>
    <!-- Twitter meta-->
    <meta property="twitter:card" content="hasibuzzaman">
    <meta property="twitter:site" content="@hasibuzzaman">
    <meta property="twitter:creator" content="@hasibuzzaman">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--DataTables [ OPTIONAL ]-->
    {{-- <script src="{{ asset('plugins/datatables/media/js/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('plugins/datatables/media/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{ asset('plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>

    <!--DataTables Sample [ SAMPLE ]-->
    <script src="{{ asset('js/demo/tables-datatables.js')}}"></script> --}}


    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    {{--  datatables --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="{{ route('homepage')}}">Accounts</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!--Notification Menu-->
        
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="{{url('admin/profile')}}"><i class="fa fa-user fa-lg"></i> Profile</a></li>
            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-lg"></i>{{ __('Logout') }}</a>
             <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            </li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="@if(Auth::User()->photo){{ asset('images') }}/{{Auth::User()->photo}}@else{{ asset('1.png') }}@endif"  height="50px" width="50px" alt="User Image">
        <div>
          <p class="app-sidebar__user-name">{{Auth::User()->name}}</p>
          {{-- <p class="app-sidebar__user-designation">Frontend Developer</p> --}}
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="{{url('admin/dashboard')}}" id="dashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>

        {{-- <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">UI Elements</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="bootstrap-components.html"><i class="icon fa fa-circle-o"></i> Bootstrap Elements</a></li>
            <li><a class="treeview-item" href="https://fontawesome.com/v4.7.0/icons/" target="_blank" rel="noopener"><i class="icon fa fa-circle-o"></i> Font Icons</a></li>
            <li><a class="treeview-item" href="ui-cards.html"><i class="icon fa fa-circle-o"></i> Cards</a></li>
            <li><a class="treeview-item" href="widgets.html"><i class="icon fa fa-circle-o"></i> Widgets</a></li>
          </ul>
        </li> --}}


        @if(Auth::user()->is_type == 'admin' || in_array('1', json_decode(Auth::user()->staff->role->permissions)))
        <li><a class="app-menu__item" href="{{url('admin/register')}}" id="admin"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Admin</span></a></li>
        <li><a class="app-menu__item" href="{{ route('admin.account')}}" id="account"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Account</span></a></li>
        @endif

        

        @if(Auth::user()->is_type == 'admin' || in_array('3', json_decode(Auth::user()->staff->role->permissions)))
        {{-- <li><a class="app-menu__item" href="{{url('admin/role')}}" id="role"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Roles</span></a></li> --}}
        @endif

        @if(Auth::user()->is_type == 'admin' || in_array('3', json_decode(Auth::user()->staff->role->permissions)))
        {{-- <li><a class="app-menu__item" href="{{route('admin.photo')}}" id="photo"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Photo</span></a></li> --}}
        @endif
        
        {{-- <li class="treeview" id="alluser"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-edit"></i><span class="app-menu__label">User</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{url('admin/agent-register')}}" id="agent"><i class="icon fa fa-circle-o"></i> Agent</a></li>

            @if(Auth::user()->is_type == 'admin' || in_array('4', json_decode(Auth::user()->staff->role->permissions)))
            <li><a class="treeview-item" href="{{url('admin/user-register')}}" id="user"><i class="icon fa fa-circle-o"></i> User</a></li>
            @endif

            @if(Auth::user()->is_type == 'admin' || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
            <li><a class="treeview-item" href="{{url('admin/staff')}}" id="staff"><i class="icon fa fa-circle-o"></i> Staff</a></li>
            @endif

          </ul>
        </li> --}}

        @if(Auth::user()->is_type == 'admin' || in_array('3', json_decode(Auth::user()->staff->role->permissions)))
        <li><a class="app-menu__item" href="{{ route('admin.customer')}}" id="customer"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Customer</span></a></li>
        @endif

        @if(Auth::user()->is_type == 'admin' || in_array('3', json_decode(Auth::user()->staff->role->permissions)))
        <li><a class="app-menu__item" href="{{ route('admin.sale')}}" id="sale"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Sales</span></a></li>
        @endif

        @if(Auth::user()->is_type == 'admin' || in_array('3', json_decode(Auth::user()->staff->role->permissions)))
        <li><a class="app-menu__item" href="{{ route('admin.transaction')}}" id="transaction"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Transaction</span></a></li>
        @endif
        

        <li class="treeview" id="allreport"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-edit"></i><span class="app-menu__label">Report</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{route('admin.salesreport')}}" id="salesreport"><i class="icon fa fa-circle-o"></i>Sales</a></li>
            <li><a class="treeview-item" href="{{route('admin.transactionreport')}}" id="tranreport"><i class="icon fa fa-circle-o"></i> Transaction</a></li>
          </ul>
        </li>

        {{-- <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-edit"></i><span class="app-menu__label">Code Master</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{url('admin/master')}}"><i class="icon fa fa-circle-o"></i> Master Code</a></li>
            <li><a class="treeview-item" href="{{url('admin/softcode')}}"><i class="icon fa fa-circle-o"></i> Soft Code</a></li>
          </ul>
        </li> --}}
        @if(Auth::user()->is_type == 'admin' || in_array('3', json_decode(Auth::user()->staff->role->permissions)))
        {{-- <li><a class="app-menu__item" href="{{route('admin.contact-mail')}}" id="email"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Mail</span></a></li> --}}
        @endif
        {{-- <li class="treeview" id="fsettings"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-edit"></i><span class="app-menu__label">Frontend Settings</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{url('admin/sliders')}}" id="slider"><i class="icon fa fa-circle-o"></i> Slider Image</a></li>
            <li><a class="treeview-item" href="{{url('admin/company-detail')}}" id="slider"><i class="icon fa fa-circle-o"></i> Company Details</a></li>
            <li><a class="treeview-item" href="{{url('admin/seo-settings')}}" id="seo"><i class="icon fa fa-circle-o"></i> Seo Settings</a></li>
          </ul>
        </li> --}}
        {{-- <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Tables</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="table-basic.html"><i class="icon fa fa-circle-o"></i> Basic Tables</a></li>
            <li><a class="treeview-item" href="table-data-table.html"><i class="icon fa fa-circle-o"></i> Data Tables</a></li>
          </ul>
        </li> --}}
        {{-- <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-file-text"></i><span class="app-menu__label">Pages</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="blank-page.html"><i class="icon fa fa-circle-o"></i> Blank Page</a></li>
            <li><a class="treeview-item" href="page-login.html"><i class="icon fa fa-circle-o"></i> Login Page</a></li>
            <li><a class="treeview-item" href="page-lockscreen.html"><i class="icon fa fa-circle-o"></i> Lockscreen Page</a></li>
            <li><a class="treeview-item" href="page-user.html"><i class="icon fa fa-circle-o"></i> User Page</a></li>
            <li><a class="treeview-item" href="page-invoice.html"><i class="icon fa fa-circle-o"></i> Invoice Page</a></li>
            <li><a class="treeview-item" href="page-calendar.html"><i class="icon fa fa-circle-o"></i> Calendar Page</a></li>
            <li><a class="treeview-item" href="page-mailbox.html"><i class="icon fa fa-circle-o"></i> Mailbox</a></li>
            <li><a class="treeview-item" href="page-error.html"><i class="icon fa fa-circle-o"></i> Error Page</a></li>
          </ul>
        </li>
        <li><a class="app-menu__item" href="docs.html"><i class="app-menu__icon fa fa-file-code-o"></i><span class="app-menu__label">Docs</span></a></li> --}}
      </ul>
    </aside>
    @yield('content')
     <!-- Essential javascripts for application to work-->
     <script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>
     <script src="{{ asset('js/popper.min.js')}}"></script>
     <script src="{{ asset('js/bootstrap.min.js')}}"></script>
     <script src="{{ asset('js/main.js')}}"></script>
     <!-- The javascript plugin to display page loading on top-->
     <script src="{{ asset('js/plugins/pace.min.js')}}"></script>
     <!-- Page specific javascripts-->
     <script type="text/javascript" src="{{ asset('js/plugins/chart.js')}}"></script>
     <script>
      // page schroll top
      function pagetop() {
          window.scrollTo({
              top: 130,
              behavior: 'smooth',
          });
      }


      function success(msg){
             $.notify({
                     // title: "Update Complete : ",
                     message: msg,
                     // icon: 'fa fa-check'
                 },{
                     type: "info"
                 });

         }
     function dlt(){
       swal({
         title: "Are you sure?",
         text: "You will not be able to recover this imaginary file!",
         type: "warning",
         showCancelButton: true,
         confirmButtonText: "Yes, delete it!",
         cancelButtonText: "No, cancel plx!",
         closeOnConfirm: false,
         closeOnCancel: false
     }, function(isConfirm) {
         if (isConfirm) {
             swal("Deleted!", "Your imaginary file has been deleted.", "success");
         } else {
            swal("Cancelled", "Your imaginary file is safe :)", "error");

         }
 });


     }

  </script>

{{-- datatables  --}}
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script> 



<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap4.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script> 




<script type="text/javascript" src="{{asset('js/plugins/bootstrap-notify.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/sweetalert.min.js')}}"></script>
     @yield('script')
    </body>
    </html>
