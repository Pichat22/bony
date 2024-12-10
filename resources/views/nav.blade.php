<style>
  .navbar .nav-link{
    font-size:1.2rem;
    padding:0.4rem;
    font-weight: bold;
  }
  .navbar .text-white {
  font-size: 1rem;
  font-weight: 500;
}
</style>
<nav class="navbar navbar-expand-lg bg-black opacity-75">
  <div class="container-fluid">
    <img src="{{asset('image/logo-removebg-preview.png')}}" width="90" alt="" srcset="">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item mr-3">
          <a class="nav-link active text-warning" aria-current="page" href="#">Accueil</a>
        </li>
        <li class="nav-item mr-3">
          <a class="nav-link active text-warning" href="{{route('reservations.index')}}">Reservation</a>
        </li>
        <li class="nav-item mr-3">
          <a class="nav-link active text-warning" href="{{route('hotels.index')}}">Hotel</a>
        </li>
        <li class="nav-item mr-3">
          <a class="nav-link active text-warning " href="#" aria-disabled="true">Contactez-nous</a>
        </li>
      </ul>

      @Auth
      <span class="text-white " style="margin-right:2%">
      {{Auth::user()->nom}}
      </span>
      @endAuth

      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-warning text-black " style="background-color:warning">
          Déconnexion
        </button>
      </form>
                                    
    </div>
  </div>
</nav>