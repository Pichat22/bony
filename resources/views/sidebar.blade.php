<style>
  .sidbar a.nav-link{
    font-size:1.25rem;
    padding:10px 15px;
    color:white;
    transition: background-color 0.3s, color 0.3s;
  }
  .sidbar a.nav-link:hover {
    background-color: rgba(255, 255, 255, 0.2);  color: #000;  }
  
</style>

<div class="d-flex flex-column bg-warning flex-shrink-0 p-3 shadow-lg sidbar" style="width: 250px; height: 100vh; margin-left: -13px;">
    <a href="{{ route('dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 link-dark text-decoration-none">
        <span class="fs-4 fw-bold text-center w-100 text-white">Menu</span>
    </a>
    <hr class="border-white">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-speedometer2 me-2"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-gear me-2"></i>
                <span>Paramètres</span>
            </a>
            <li class="nav-item mb-2">
            <a href="/user" class="nav-link text-white d-flex align-items-center">
            <i class="bi bi-person me-2"></i>
                <span>Créer Utilisateur</span>
            </a>
        </li>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('profile.edit') }}" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-person me-2"></i>
                <span>Profil</span>
            </a>
        </li>
    </ul>
    <hr class="border-white">
    <form action="{{ route('logout') }}" method="POST" class="mt-auto">
        @csrf
        <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
            <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
        </button>
    </form>
    
</div>
<style>

</style>

