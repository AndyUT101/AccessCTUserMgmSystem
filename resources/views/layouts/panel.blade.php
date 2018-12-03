<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <style>#loader{transition:all .3s ease-in-out;opacity:1;visibility:visible;position:fixed;height:100vh;width:100%;background:#fff;z-index:90000}#loader.fadeOut{opacity:0;visibility:hidden}.spinner{width:40px;height:40px;position:absolute;top:calc(50% - 20px);left:calc(50% - 20px);background-color:#333;border-radius:100%;-webkit-animation:sk-scaleout 1s infinite ease-in-out;animation:sk-scaleout 1s infinite ease-in-out}@-webkit-keyframes sk-scaleout{0%{-webkit-transform:scale(0)}100%{-webkit-transform:scale(1);opacity:0}}@keyframes sk-scaleout{0%{-webkit-transform:scale(0);transform:scale(0)}100%{-webkit-transform:scale(1);transform:scale(1);opacity:0}}</style>
  <link href="{{ url('/')}}/style.css" rel="stylesheet">
</head>

<body class="app">
  <div id="loader">
    <div class="spinner"></div>
  </div>
  <script>window.addEventListener('load', () => {
      const loader = document.getElementById('loader');
      setTimeout(() => {
        loader.classList.add('fadeOut');
      }, 300);
    });</script>
  <div>
    <div class="sidebar">
      <div class="sidebar-inner">
        <div class="sidebar-logo">
          <div class="peers ai-c fxw-nw">
            <div class="peer peer-greed"><a class="sidebar-link td-n" href="{{ url('/') }}">
                <div class="peers ai-c fxw-nw">
                  <div class="peer">
                    <div class="logo"><img src="{{ url('/') }}/img/logo.png" alt=""></div>
                  </div>
                  <div class="peer peer-greed">
                    <h5 class="lh-1 mB-0 logo-text">User Manage System</h5>
                  </div>
                </div>
              </a></div>
            <div class="peer">
              <div class="mobile-toggle sidebar-toggle"><a href="" class="td-n"><i class="ti-arrow-circle-left"></i></a></div>
            </div>
          </div>
        </div>
        <ul class="sidebar-menu scrollable pos-r">
          <li class="nav-item mT-30 active"><a class="sidebar-link" href="{{ route('home') }}"><span class="icon-holder"><i
                  class="c-red-800 ti-home"></i> </span><span class="title">Dashboard</span></a></li>
          <li class="nav-item dropdown"><a class="dropdown-toggle" href="javascript:void(0);"><span class="icon-holder"><i
                  class="c-purple-500 ti-write"></i> </span><span class="title">Request</span> <span class="arrow"><i class="ti-angle-right"></i></span></a>
            {!! $MyNavBar->asUl( ['class' => 'dropdown-menu'] ) !!}

            
          </li>
          <li class="nav-item dropdown"><a class="dropdown-toggle" href="javascript:void(0);"><span class="icon-holder"><i class="c-brown-500 ti-id-badge"></i>
              </span><span class="title">User management</span> <span class="arrow"><i class="ti-angle-right"></i></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Access right control</a></li>
              <li><a href="{{ url('acc_manage') }}">Account management</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="sidebar-link" href="{{ route('rq.status') }}"><span class="icon-holder"><i class="c-red-600 ti-files"></i>
              </span><span class="title">Request tray</span></a></li>
          <li class="nav-item dropdown"><a class="dropdown-toggle" href="javascript:void(0);"><span class="icon-holder"><i
                  class="c-purple-500 ti-settings"></i> </span><span class="title">Setting</span> <span class="arrow"><i class="ti-angle-right"></i></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ url('com_req') }}">Request management</a></li>
              <li><a href="#">Branch and department</a></li>
              <li><a href="#">Login management</a></li>
              <li><a href="{{ route('user.index') }}">User list</a></li>
              <li><a href="{{ route('zone.index') }}">Zone list</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
    <div class="page-container">
      <div class="header navbar">
        <div class="header-container">
          <ul class="nav-left">
            <li><a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);"><i class="ti-menu"></i></a></li>
            <li class="search-box"><a class="search-toggle no-pdd-right" href="javascript:void(0);"><i class="search-icon ti-search pdd-right-10"></i>
                <i class="search-icon-close ti-close pdd-right-10"></i></a></li>
            <li class="search-input"><input class="form-control" type="text" placeholder="Search..."></li>
          </ul>
          <ul class="nav-right">
            <li class="notifications dropdown"><span class="counter bgc-red">3</span> <a href="" class="dropdown-toggle no-after"
                data-toggle="dropdown"><i class="ti-bell"></i></a>
              <ul class="dropdown-menu">
                <li class="pX-20 pY-15 bdB"><i class="ti-bell pR-10"></i> <span class="fsz-sm fw-600 c-grey-900">Notifications</span></li>
                <li>
                  <ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
                    <li><a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
                        <div class="peer mR-15"></div>
                        <div class="peer peer-greed"><span>You haven't set the Google 2FA yet. Click here to setup.</span>
                          <p class="m-0"><small class="fsz-xs">5 mins ago</small></p>
                        </div>
                      </a></li>
                    <li><a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
                        <div class="peer mR-15"></div>
                        <div class="peer peer-greed"><span>5 requests is pending.</span>
                          <p class="m-0"><small class="fsz-xs">7 mins ago</small></p>
                        </div>
                      </a></li>
                    <li><a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
                        <div class="peer mR-15"></div>
                        <div class="peer peer-greed"><span>User "b01s01" is approved and created.</span>
                          <p class="m-0"><small class="fsz-xs">10 mins ago</small></p>
                        </div>
                      </a></li>
                  </ul>
                </li>
                <li class="pX-20 pY-15 ta-c bdT"><span><a href="" class="c-grey-600 cH-blue fsz-sm td-n">View All
                      Notifications <i class="ti-angle-right fsz-xs mL-10"></i></a></span></li>
              </ul>
            </li>
            <li class="dropdown"><a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown">
                <div class="peer mR-10"><img class="w-2r bdrs-50p" src="{{ url('/') }}/img/default_user.png"
                    alt=""></div>
                <div class="peer"><span class="fsz-sm c-grey-900">{{ Auth::user()->name }}</span></div>
              </a>
              <ul class="dropdown-menu fsz-sm">
                <li><a href="{{ route('setting.index') }}" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-settings mR-10"></i> <span>Setting</span></a></li>
                <li><a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-user mR-10"></i> <span>Profile</span></a></li>
                <li role="separator" class="divider"></li>
                <li>
                  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-power-off mR-10"></i> <span>{{ __('Logout') }}</span></a></li>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <main class="main-content bgc-grey-100">
        <div id="mainContent">
        @yield('content')
        </div>
      </main>
    </div>
  </div>
  <script type="text/javascript" src="{{ url('/')}}/vendor.js"></script>
  <script type="text/javascript" src="{{ url('/')}}/bundle.js"></script>
</body>

</html>