<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="{{url('/')}}/home">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="{{route('transactions.index')}}">
            <i class="fa fa-money"></i>
            <span>Transactions</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-check-square-o"></i> <span>Settlements</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li><a href="{{route('setlView')}}"><i class="fa fa-circle-o"></i> List Settlements</a></li>
            <li><a href="{{route('settlementrules')}}"><i class="fa fa-circle-o"></i> Manage Settlement Rules</a></li>
            <li><a href="{{route('merchantrule')}}"><i class="fa fa-circle-o"></i> Merchant Settlements</a></li>
          </ul>

        </li>

        <li>
          <a href="#">
            <i class="fa fa-gear"></i> <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li><a href="{{route('gateways')}}"><i class="fa fa-circle-o"></i> Gateways</a></li>
            <li><a href="{{route('methodtype')}}"><i class="fa fa-circle-o"></i> Method Types</a></li>
          </ul>

        </li>

        <li>
          <a href="#">
            <i class="fa fa-reply"></i> <span>Refunds</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li><a href="{{route('listRefunds')}}"><i class="fa fa-circle-o"></i> List Refunds</a></li>
            <li><a href="{{route('refReqView')}}"><i class="fa fa-circle-o"></i> Create Refund Request</a></li>
          </ul>

        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('listUsers')}}"><i class="fa fa-circle-o"></i> List Users</a></li>
            <li><a href="{{route('addUserView')}}"><i class="fa fa-circle-o"></i> Add User</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa fa-bar-chart"></i> <span>Reports</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>