<?php ?><nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="<?php echo htmlspecialchars((site_logo()) ?? '', ENT_QUOTES, 'UTF-8'); ?>" alt="Logo" height="40" class="me-2">
            <span>Framework</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php foreach (navbar_items('main') as $item): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo htmlspecialchars((navbar_item_active($item)) ?? '', ENT_QUOTES, 'UTF-8'); ?>" href="<?php echo htmlspecialchars(($item['url']) ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        <?php if (isset($item['icon'])): ?>
                        <i class="<?php echo htmlspecialchars(($item['icon']) ?? '', ENT_QUOTES, 'UTF-8'); ?> me-1"></i>
                        <?php endif; ?>
                        <?php echo htmlspecialchars(($item['label']) ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>



            
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if (\app\core\Session::isLogged()): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                        data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                        <?php if (\app\core\Session::user()->avatar): ?>
                        <img src="/avatars/<?php echo htmlspecialchars((\app\core\Session::user()->avatar) ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="rounded-circle me-2"
                            width="32" height="32" style="object-fit: cover;" alt="Avatar">
                        <?php else: ?>
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                            style="width: 32px; height: 32px; font-size: 0.9rem;">
                            <?php echo htmlspecialchars((strtoupper(substr(\app\core\Session::user()->name, 0, 1))) ?? '', ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                        <?php endif; ?>
                        <?php echo htmlspecialchars((\app\core\Session::user()->name) ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" data-bs-popper="static">
                        <li>
                            <a class="dropdown-item" href="/profile" data-href="/profile">
                                <i class="bi-person me-2"></i>Profile
                            </a>
                        </li>
                        <?php if (\app\core\Session::user()->isAdmin()): ?>
                        <li>
                            <a class="dropdown-item" href="/admin" data-href="/admin">
                                <i class="bi-gear me-2"></i>Administration
                            </a>
                        </li>
                        <?php endif; ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="/logout" method="POST" class="m-0">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                    class="dropdown-item text-start w-100 border-0 bg-transparent p-0">
                                    <span class="dropdown-item d-block">
                                        <i class="bi-box-arrow-right me-2"></i>Logout
                                    </span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                <?php else: ?>
                
                <?php foreach (navbar_items('guest') as $item): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo htmlspecialchars((navbar_item_active($item)) ?? '', ENT_QUOTES, 'UTF-8'); ?>" href="<?php echo htmlspecialchars(($item['url']) ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        <?php if (isset($item['icon'])): ?>
                        <i class="<?php echo htmlspecialchars(($item['icon']) ?? '', ENT_QUOTES, 'UTF-8'); ?> me-1"></i>
                        <?php endif; ?>
                        <?php echo htmlspecialchars(($item['label']) ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </li>
                <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>