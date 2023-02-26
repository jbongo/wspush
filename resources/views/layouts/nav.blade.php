
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





@endphp



<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu leftside-menu-detached">

    <div class="leftbar-user">
        <a href="javascript: void(0);">
            <img src="{{asset('assets/images/users/avatar-1.jpg')}}" alt="user-image" height="42" class="rounded-circle shadow-sm">
            <span class="leftbar-user-name">Admin</span>
        </a>
    </div>

    <!--- Sidemenu -->
    <ul class="side-nav">

        <li class="side-nav-item">
            <a  href="" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
                <i class="uil-home-alt"></i>
                <span class="badge bg-info rounded-pill float-end">4</span>
                <span> Tableau de bord </span>
            </a>
          
        </li>           

        <li class="side-nav-item">
            <a  href="#" aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                <i class="uil uil-auto-flash"></i>
                <span> Utilisateurs </span>
            </a>
        </li>
        <li class="side-nav-item">
            <a  href="#" aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                <i class="uil uil-wallet"></i>         
                <span> Clients </span>
            </a>
        </li>

        <li class="side-nav-item">
            <a  href="{{route('site_interne.index')}}"aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                <i class="uil uil-wallet"></i>         
                <span> Sites </span>
            </a>
        </li>

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarBaseUI" aria-expanded="{{$li_simulations}}" aria-controls="sidebarBaseUI" class="side-nav-link">
                <i class="uil-wallet"></i>
                <span> Sites Externes </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse @if($li_simulations) show @endif" id="sidebarBaseUI">
                <ul class="side-nav-second-level">
                    
                    <li class="{{$li_ordre_simule_algo1}}">
                        <a href="{{route('site_externe.index')}}">Tous les sites </a>
                    </li>
                    <li class="{{$li_ordre_simule_algo1}}">
                        <a href="{{route('site_externe.add')}}">Ajouter </a>
                    </li>
                    <li class="{{$li_ordre_simule_algo1}}">
                        <a href="{{route('categorie_externe.index')}}">Catégories </a>
                    </li>

                </ul>
            </div>
        </li>
  

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarBaseUI" aria-expanded="{{$li_simulations}}" aria-controls="sidebarBaseUI" class="side-nav-link">
                <i class="uil-wallet"></i>
                <span> Articles </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse @if($li_simulations) show @endif" id="sidebarBaseUI">
                <ul class="side-nav-second-level">
                    
                    <li class="{{$li_ordre_simule_algo1}}">
                        <a href="{{route('article.index')}}">Tous les articles </a>
                    </li>
                    <li class="{{$li_ordre_simule_algo1}}">
                        <a href="{{route('article.add')}}">Ajouter </a>
                    </li>
                    <li class="{{$li_ordre_simule_algo1}}">
                        <a href="">Catégories </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <li class="side-nav-item">
            <a  href="#" aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                <i class="uil uil-bright"></i>
                <span> Paramètres </span>
            </a>
        </li>

        
    </ul>

  
    <!-- End Sidebar -->

    <div class="clearfix"></div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
