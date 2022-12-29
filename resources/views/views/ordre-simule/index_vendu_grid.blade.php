<div class="row">
        
    @foreach ($ordres_vendus as $ordre)
        @if($ordre)
            <div class="col-md-6 col-xxl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Détails</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Archiver</a>
                            </div>
                        </div>
    
                        <div class="text-center">
                            <a  href="javascript:void(0);" >
                            <div style="cursor: pointer;">
                                
                                
                                
                                <h4 class="mt-3 my-1">{{$ordre->action->nom}} N°{{$ordre->numero}} | <span class="text-danger">{{$ordre->action->valeuraction()->valeur}} €</span> </h4>
                                <p class="mb-0 text-muted mt-2">
                                    <div class="flex-grow-1 @if($ordre->est_vendu == true) typevente @else typeachat @endif">
                                        <h4 class="mt-0 mb-1 font-20 ">@if($ordre->est_vendu == true) Vendu @else Acheté @endif</h4>
                                    </div>
                                </p>
                                <p >
                                    <span class="font-15 text-primary "> Date d'exécution :</span>
                                    @php
                                        $timestamp = strtotime($ordre->date_vente);
                                        $date_vente = date("d/m/Y", $timestamp);
                                    @endphp
                                    <span class="text-danger my-0 fw-bold">{{$date_vente }} </span>
                                </p>
                                <hr class="bg-dark-lighten my-3">
                                
                                <div class="d-flex justify-content-between align-items-center ">                                 
                                        <p >
                                            <span class="font-15 text-secondary "> Valeur :</span>
                                            <span class="text-danger my-0 fw-bold">{{$ordre->valeur_action }} EUR</span>
                                        </p>
                                        
                                        <p >
                                            <span class="font-15 text-secondary "> Quantité :</span>
                                            <span class="text-danger my-0 fw-bold">{{$ordre->quantite }} </span>
                                        </p>
                                                   
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center ">                                 
                                    <p>
                                        <span class="font-15 text-secondary "> Date de validité :</span>
                                        @php
                                            $timestamp = strtotime($ordre->date_validite);
                                            $date_validite = date("d/m/Y", $timestamp);
                                        @endphp
                                        <span class="text-danger my-0 fw-bold">{{$date_validite}} </span>
                                        {{-- <span class="text-danger my-0 fw-bold">{{$ordre->date_validite->format('d/m/Y') }} </span> --}}
                                    </p>
                                    
                                    <p>
                                   
                                        <span class="text-success my-0 fw-bold">{{$ordre->paiement }} </span>
                                    </p>
                                               
                                </div>
                                
                            
                            </div>
                            </a>
                          
                            <div class="row mt-3">
                                <div class="col-4">
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End col -->
        @endif
    @endforeach

    
  
</div> <!-- End row --> 