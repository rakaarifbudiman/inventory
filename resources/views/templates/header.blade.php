    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">
        <img src="https://img.freepik.com/free-icon/stationary_318-752190.jpg?size=338&ext=jpg&ga=GA1.2.1963718950.1666756200&semt=sph" 
        alt="Computer Man" style="width:35px;height:35px;">
       </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="https://img.freepik.com/free-icon/stationary_318-752190.jpg?size=338&ext=jpg&ga=GA1.2.1963718950.1666756200&semt=sph" 
        alt="Computer Man" style="width:48px;height:48px;">
        <b>Inventory</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <!-- Right Side Of Navbar -->
          <ul class="nav navbar-nav navbar-right" style="padding-right: 20px">
              <!-- Authentication Links -->
              @if (Auth::guest())
                  <li><a href="{{ route('login') }}">Login</a></li>
                  <li><a href="{{ route('register') }}">Register</a></li>
              @else
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                          {{ Auth::user()->name }} <span class="caret"></span>
                      </a>

                      <ul class="dropdown-menu" role="menu">
                          <li>
                              <a class="dropdown-item" href="{{ route('user.setting') }}">Setting</a>
                              <a href="{{ route('logout') }}"
                                  onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                                  Logout
                              </a>

                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  {{ csrf_field() }}
                              </form>
                          </li>
                      </ul>
                  </li>
              @endif
          </ul>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <!-- <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a> -->
          </li>
        </ul>
      </div>
    </nav>
