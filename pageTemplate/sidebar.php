<div class="overlay"></div>
<div class="col-md-2 sidebar-large collapse overlay-sidebar" id="sidebarCollapse">
    <button type="button" class="btn close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <ul class="nav flex-column">
        <hr>
        <li class="nav-item-side">
            <a class="nav-link-side" href="#" data-bs-toggle="collapse" data-bs-target="#porteSubmenu">
                <i class="bi bi-door-closed-fill"></i>
                Portes
            </a>
            <ul class="collapse list-unstyled" id="porteSubmenu">
                <li><a class="sidebar-subitem dropdown-item rounded border" href="<?php echo BASE_DIR_STATIC . 'research.php?search=porte+blindée&porte=true'; ?>">Blindées</a></li>
                <li><a class="sidebar-subitem dropdown-item rounded border" href="<?php echo BASE_DIR_STATIC . 'research.php?search=porte+intérieure&porte=true'; ?>">Intérieures</a></li>
                <li><a class="sidebar-subitem dropdown-item rounded border" href="<?php echo BASE_DIR_STATIC . 'research.php?search=porte+extérieure&porte=true'; ?>">Extérieures</a></li>
                <li><a class="sidebar-subitem dropdown-item rounded border" href="<?php echo BASE_DIR_STATIC . 'research.php?search=porte-fenêtre&porte=true'; ?>">Porte-fenêtres</a></li>
            </ul>
        </li>
        <hr>
        <li class="nav-item-side">
            <a class="nav-link-side" href="<?php echo BASE_DIR_STATIC . 'research.php?poignee=true'; ?>">
                <i class="bi bi-usb-fill"></i>
                Poignées
            </a>
        </li>
        <hr>
        <li class="nav-item-side">
            <a class="nav-link-side" href="<?php echo BASE_DIR_STATIC . 'research.php?accessoire=true'; ?>">
                <i class="bi bi-hammer"></i>
                Accessoires
            </a>
        </li>
        <hr>
    </ul>
</div>
