<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-search-dollar"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Dgtbl<sup>Tr4d1n6</sup></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Panel de Control</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Interfaces
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-fw fa-cog"></i>
      <span>Componentes</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Personalizados:</h6>
        <a class="collapse-item" href="buttons.html">Botones</a>
        <a class="collapse-item" href="cards.html">Tarjetas</a>
      </div>
    </div>
  </li>

  <!-- Nav Item - Utilities Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
      <i class="fas fa-fw fa-wrench"></i>
      <span>Herramientas</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Personalizadas:</h6>
        <a class="collapse-item" href="utilities-color.html">Colores</a>
        <a class="collapse-item" href="utilities-border.html">Bordes</a>
        <a class="collapse-item" href="utilities-animation.html">Animaciones</a>
        <a class="collapse-item" href="utilities-other.html">Otras</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Addons
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagesCharts" aria-expanded="true" aria-controls="collapsePages">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Gráficas</span>
    </a>
    <div id="collapsePagesCharts" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="charts.php?chart=1DAY&book=<?php echo $current_book;?>">Actividad Diaria</a>
        <a class="collapse-item" href="charts.php?chart=CANDLE&book=<?php echo $current_book;?>">Gráfica de Velas</a>
      </div>
    </div>
  </li>

  <!-- Nav Item - Tables -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagesRegistros" aria-expanded="true" aria-controls="collapsePages">
      <i class="fas fa-fw fa-th-list"></i>
      <span>Registros</span>
    </a>
    <div id="collapsePagesRegistros" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="registros.php?book=<?php echo $current_book;?>">Registro de Ticks</a>
        <a class="collapse-item" href="apertura_cierre.php?book=<?php echo $current_book;?>">Aperturas y Cierres</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
