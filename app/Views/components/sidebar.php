<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">
  <?php if (session()->get('role') == 'admin'){ ?>
  <li class="nav-item">
    <a class="nav-link <?php echo (uri_string() == 'dashboard') ? "" : "collapsed" ?>" href="dashboard">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <?php }else { ?>
  <li class="nav-item">
    <a class="nav-link <?php echo (uri_string() == '') ? "" : "collapsed" ?>" href="/">
      <i class="bi bi-grid"></i>
      <span>Home</span>
    </a>
  </li>
  <?php } ?>
  <li class="nav-item">
    <a class="nav-link <?php echo (uri_string() == 'produk') ? "" : "collapsed" ?>" href="produk">
      <i class="bi bi-receipt"></i>
      <span><?= session()->get('role') == 'admin' ? 'Manajemen Produk' : 'Produk Saya' ?></span>
    </a>
  </li>
  
  <?php if (session()->get('role') == 'admin'){ ?>
  <li class="nav-item">
    <a class="nav-link <?php echo (uri_string() == 'manage_user') ? "" : "collapsed" ?>" href="manage_user">
      <i class="bi bi-person-lines-fill"></i>
      <span>Manajemen User</span>
    </a>
  </li>
  <?php }else{ ?>
  <li class="nav-item">
    <a class="nav-link <?php echo (uri_string() == 'profile') ? "" : "collapsed" ?>" href="profile">
      <i class="bi bi-file-earmark-person-fill"></i>
      <span>Profil Saya</span>
    </a>
  </li>
  <?php } ?>

</ul>

</aside><!-- End Sidebar-->