
@php
$curent_url = $_SERVER['REQUEST_URI']; 
$curent_url = explode("/", $curent_url);
$li_home = $li_utilisateur = $li_client = $li_role = $li_permission = $li_site_interne = $li_site_source = $li_article = $li_categorie= $li_parametre = $li_test_selecteur = "";
$li_simulations= "false";


switch ($curent_url[0]) {
    case 'roles':       
       $li_role = "menuitem-active";
    break;
    case 'ordres-simule':       
        if(sizeof($curent_url) > 3){
           switch (substr($curent_url[3], 0,1)) {
           
            case "2":
                $li_ordre_simule_algo2 = "menuitem-active";
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
            <img src="{{asset('assets/images/logo.png')}}" alt="user-image" height="35" class="rounded-circle shadow-sm">
            <span class="leftbar-user-name">{{Auth::user()->nom}} {{Auth::user()->prenom}}</span>
        </a>
    </div>

    <!--- Sidemenu -->
    <ul class="side-nav">

        <li class="side-nav-item {{$li_home}}">
            <a  href="{{route('home')}}" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link ">
                <i class="uil-dashboard"></i>
                <span> Tableau de bord </span>
            </a>
          
        </li>           

        @can("permission", "afficher-utilisateur")
        <li class="side-nav-item {{$li_utilisateur}}">
            <a  href="{{route('utilisateur.index')}}" aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                <i class="uil uil-user-plus"></i>
                <span> Utilisateurs </span>
            </a>
        </li>
         @endcan

        @can("permission", "afficher-droit")
        <li class="side-nav-item ">
            <a data-bs-toggle="collapse" href="#droits" aria-expanded="false" aria-controls="droits" class="side-nav-link">
                <i class="uil-folder-lock"></i>
                <span> Droits </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="droits">
                <ul class="side-nav-second-level">
                    <li class="{{$li_role}}">
                        <a href="{{route('role.index')}}">Rôles</a>
                    </li>
                    <li class="{{$li_permission}}">
                        <a href="{{route('permission.index')}}">Permissions</a>
                    </li>
                </ul>
            </div>
        </li>
        @endcan

        @can("permission", "afficher-client")
        <li class="side-nav-item {{$li_client}}">
            <a  href="{{route('client.index')}}" aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                <i class="uil uil-award-alt"></i>         
                <span> Clients </span>
            </a>
        </li>
        @endcan

        @can("permission", "afficher-site")
        <li class="side-nav-item {{$li_site_interne}}">
            <a  href="{{route('site_interne.index')}}"aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                <i class="uil uil-globe"></i>         
                <span> Sites </span>
            </a>
        </li>
        @endcan

        @can("permission", "afficher-site-source")
        <li class="side-nav-item {{$li_site_source}}">
            <a data-bs-toggle="collapse" href="#sidebarBaseUI" aria-expanded="false" aria-controls="sidebarBaseUI" class="side-nav-link">
                <i class="uil-globe"></i>
                <span> Sites Externes </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarBaseUI">
                <ul class="side-nav-second-level">
                    
                    <li class="{{$li_site_source}}">
                        <a href="{{route('site_externe.index')}}">Tous les sites </a>
                    </li>
                  

                @if(Auth::user()->role->nom == "Super-Admin")
                    <li class="{{$li_test_selecteur}}">
                        <a href="{{route('scrap.index_selecteur')}}">Tests sélecteurs </a>
                    </li>
                @endif
                </ul>
            </div>
        </li>
        @endcan
  

        @can("permission", "afficher-article")

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarBaseUIx" aria-expanded="false" aria-controls="sidebarBaseUIx" class="side-nav-link">
                <i class="uil-auto-flash"></i>
                <span> Articles </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarBaseUIx">
                <ul class="side-nav-second-level">
                    
                    <li class="{{$li_article}}">
                        <a href="{{route('article.index')}}">Tous les articles </a>
                    </li>                  
                    {{-- <li class="{{$li_article}}">
                        <a href="">Catégories </a>
                    </li> --}}
                </ul>
            </div>
        </li>
        @endcan
        
        @can("permission", "afficher-parametre")
        <li class="side-nav-item {{$li_parametre}}">
            <a  href="#" aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                <i class="uil uil-bright"></i>
                <span> Paramètres </span>
            </a>
        </li>
        @endcan
        
    </ul>

  
    <!-- End Sidebar -->

    <div class="clearfix"></div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
{{-- 
<style>
    @media (min-width: 992px){
        body[data-layout=detached] .container-fluid, body[data-layout=detached] .container-lg, body[data-layout=detached] .container-md, body[data-layout=detached] .container-sm, body[data-layout=detached] .container-xl, body[data-layout=detached] .container-xxl {
            max-width: 100%;
        }
    }

    body[data-layout=detached] .leftside-menu {
    position: relative;
    background: #172F43!important;
    min-width: 260px;
    max-width: 260px;
    -webkit-box-shadow: var(--ct-box-shadow);
    box-shadow: var(--ct-box-shadow);
    margin-top: 10px;
    padding-top: 0!important;
    z-index: 1001!important;
}

.topnav-navbar-dark {
    background-color: #172F43;
}

.topnav-navbar-dark .nav-user {
    background-color: #1e384e!important;
}

body[data-layout=detached] .leftside-menu .side-nav .side-nav-link {
    color: #ffffff!important;
}

body[data-layout=detached] .leftside-menu .side-nav .menuitem-active>a {
    color: #eb7777!important;
}

body[data-layout=detached] .leftside-menu .side-nav .side-nav-forth-level li a, body[data-layout=detached] .leftside-menu .side-nav .side-nav-second-level li a, body[data-layout=detached] .leftside-menu .side-nav .side-nav-third-level li a {
    color: #c4d1dd;
}



body[data-layout=detached] .leftside-menu .side-nav .side-nav-forth-level li a:focus, body[data-layout=detached] .leftside-menu .side-nav .side-nav-forth-level li a:hover, body[data-layout=detached] .leftside-menu .side-nav .side-nav-second-level li a:focus, body[data-layout=detached] .leftside-menu .side-nav .side-nav-second-level li a:hover, body[data-layout=detached] .leftside-menu .side-nav .side-nav-third-level li a:focus, body[data-layout=detached] .leftside-menu .side-nav .side-nav-third-level li a:hover {
    color: #48b5e9;
}

body[data-layout=detached] .leftside-menu .side-nav .side-nav-link:active, body[data-layout=detached] .leftside-menu .side-nav .side-nav-link:focus, body[data-layout=detached] .leftside-menu .side-nav .side-nav-link:hover {
    color: #48b5e9!important;
}
</style> --}}



<style>
    body[data-layout=detached] .leftside-menu {

        background: #263349 !important;
        color: #fff;
        margin-top: 0px;
        min-width: 100px;

        /* border-radius: 30px; */

    }

    body[data-layout=detached] .leftside-menu .side-nav .menuitem-active>a {
        color: #fff !important;
    }

    body[data-layout=detached] .leftside-menu .side-nav .side-nav-forth-level li a,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-second-level li a,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-third-level li a {
        color: #fff;
    }

    body[data-layout=detached] .leftside-menu .side-nav .side-nav-link {
        color: #fff !important;
    }

    /* Nom du user dans le menu gauche */
    body[data-layout=detached] .leftbar-user .leftbar-user-name {
    color: #ffffff; 
}

    /* Couleur lien menus */
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-link:active,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-link:focus,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-link:hover {
        color: #f9c851 !important;
    }

    /* Couleurs lien sous menus */
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-forth-level li a:focus,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-forth-level li a:hover,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-second-level li a:focus,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-second-level li a:hover,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-third-level li a:focus,
    body[data-layout=detached] .leftside-menu .side-nav .side-nav-third-level li a:hover {
        color: #f9c851 !important;
    }


    body[data-layout=detached] .leftside-menu .side-nav .menuitem-active>a {
    color: #f9c851!important;
}

    body[data-layout=detached][data-leftbar-compact-mode=condensed] .side-nav .side-nav-item:hover .side-nav-link {
        background: #263349;

    }

    @media (min-width: 992px) {

        body[data-layout=detached] .container-fluid,
        body[data-layout=detached] .container-lg,
        body[data-layout=detached] .container-md,
        body[data-layout=detached] .container-sm,
        body[data-layout=detached] .container-xl,
        body[data-layout=detached] .container-xxl {
            max-width: 100%;
        }
    }


/* POLICE DE CARACTERE */



body {
        font-size: 12px !important;

    }

    /* Menu */
    .side-nav .side-nav-link {
        font-size: 12px;
    }

    /* Sous menu */
    .side-nav-forth-level li .side-nav-link,
    .side-nav-forth-level li a,
    .side-nav-second-level li .side-nav-link,
    .side-nav-second-level li a,
    .side-nav-third-level li .side-nav-link,
    .side-nav-third-level li a {

        font-size: 12px;
    }

    /* titre des pages */
    .page-title-box .page-title {
        font-size: 12px;
    }

    .btn {
        font-size: 12px;
    }

    .dropdown-menu {
        font-size: 12px;
    }
</style>