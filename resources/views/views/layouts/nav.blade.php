
@php
$curent_url = $_SERVER['REQUEST_URI']; 
$curent_url = explode("/", $curent_url);
$li_ordre_simule_algo1 = $li_ordre_simule_algo2 = $li_ordre_simule_algo3 =$li_ordre_simule_algo4= "";
$li_simulations= "false";


switch ($curent_url[1]) {
    case 'ordres-simule':       
        if(sizeof($curent_url) > 3){
           switch (substr($curent_url[3], 0,1)) {
           
            case "2":
                $li_ordre_simule_algo2 = "menuitem-active";
                $li_simulations= "true";
                break;
            case "3":
                $li_ordre_simule_algo3 = "menuitem-active";
                $li_simulations= "true";
                
                break;
            case "4":
                $li_ordre_simule_algo4 = "menuitem-active";
                $li_simulations= "true";
                
                break;
  
            default:
                $li_ordre_simule_algo1 = "menuitem-active";
                $li_simulations= "true";
                break;
           }
        }
        break;
    
    
    default:
        // dd("default");
        break;
}


$nb_alerte = App\Models\Alerte::where('est_ouvert', false)->get()->count();


@endphp



<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu leftside-menu-detached">

    <div class="leftbar-user">
        <a href="javascript: void(0);">
            <img src="{{asset('assets/images/users/avatar-1.jpg')}}" alt="user-image" height="42" class="rounded-circle shadow-sm">
            <span class="leftbar-user-name">{{Auth::user()->nom}} {{Auth::user()->prenom}}</span>
        </a>
    </div>

    <!--- Sidemenu -->
    <ul class="side-nav">

        <li class="side-nav-item">
            <a  href="{{route('welcome')}}" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
                <i class="uil-home-alt"></i>
                <span class="badge bg-info rounded-pill float-end">4</span>
                <span> Tableau de bord </span>
            </a>
          
        </li>           

        <li class="side-nav-item">
            <a  href="{{route('action.index')}}" aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                <i class="uil uil-auto-flash"></i>
                <span> Titres </span>
            </a>
        </li>
        <li class="side-nav-item">
            <a  href="{{route('ordre.index')}}" aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                <i class="uil uil-wallet"></i>
         
                <span> Ordres </span>
            </a>
        </li>
  

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarBaseUI" aria-expanded="{{$li_simulations}}" aria-controls="sidebarBaseUI" class="side-nav-link">
                <i class="uil-wallet"></i>
                <span> Simulations (Ordres) </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse @if($li_simulations) show @endif" id="sidebarBaseUI">
                <ul class="side-nav-second-level">
                    
                    <li class="{{$li_ordre_simule_algo1}}">
                        <a href="{{route('ordre_simule.index_achete',1)}}">1- Par défaut </a>
                    </li>
                    <li class="{{$li_ordre_simule_algo2}}">
                        <a href="{{route('ordre_simule.index_achete',2)}}">2- Délais Heure d'Ac</a>
                    </li>
                    <li class="{{$li_ordre_simule_algo3}}">
                        <a href="{{route('ordre_simule.index_achete',3)}}">3- Seuil vente positif</a>
                    </li>
                    <li class="{{$li_ordre_simule_algo4}}">
                        <a href="{{route('ordre_simule.index_achete',4)}}">4- Achat & vente heure fixe</a>
                    </li>
                   
                </ul>
            </div>
        </li>
        
        <li class="side-nav-item">
            <a  href="{{route('parametre.index')}}" aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                <i class="uil uil-bright"></i>
                <span> Paramètres </span>
            </a>
        </li>

        <li class="side-nav-item">
            <a  href="{{route('alerte.index')}}" aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                <i class="uil uil-envelope-check  text-danger"></i>
                {{-- uil-envelope-open --}}
                <span  @if($nb_alerte) class="text-danger" @endif> Alertes <span class="badge rounded bg-danger font-10 float-end">{{$nb_alerte}}</span> </span>
            </a>
        </li>
        
    </ul>

  
    <!-- End Sidebar -->

    <div class="clearfix"></div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
