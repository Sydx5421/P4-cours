<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
        <a class="navbar-brand" href="#"><i class="fas fa-ticket-alt"></i> | Jean Forteroche - le blog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?=$this->basePath?>home">Accueil
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                     <a class="nav-link" href="<?=$this->basePath?>posts">Articles</a>
                </li>
                <?php if($this->isAdmin===false):?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$this->basePath?>connexion">Connexion</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$this->basePath?>dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$this->basePath?>postEdition">Edition</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$this->basePath?>deconnexion" onclick="return confirm('Êtes-vous sur de vouloir vous déconnecter ?')">Déconnexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>