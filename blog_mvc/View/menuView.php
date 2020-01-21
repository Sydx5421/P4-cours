<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
        <a class="navbar-brand" href="#">Jean Forteroche - le blog</a>
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
                <li class="nav-item">
                    <a class="nav-link" href="<?=$this->basePath?>connection">Connection</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=$this->basePath?>postEdition">Edition</a>
                </li>
                <?php if(isset($_SESSION['adminConnected']) && $_SESSION['adminConnected'] === true ): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$this->basePath?>deconnection">Déconnection</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>