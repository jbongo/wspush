<div class="row">
        
    @foreach ($ordres_achetes as $ordre)
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
                                    <span class="text-danger my-0 fw-bold">{{$ordre->created_at->format('d/m/Y') }} </span>
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
                                    <p >
                                        <span class="font-15 text-secondary "> Date de validité :</span>
                                        @php
                                            $timestamp = strtotime($ordre->date_validite);
                                            $date_validite = date("d/m/Y", $timestamp);
                                        @endphp
                                        <span class="text-danger my-0 fw-bold">{{$date_validite}} </span>
                                        {{-- <span class="text-danger my-0 fw-bold">{{$ordre->date_validite->format('d/m/Y') }} </span> --}}
                                    </p>
                                    
                                    <p >
                                   
                                        <span class="text-success my-0 fw-bold">{{$ordre->paiement }} </span>
                                    </p>
                                               
                                </div>
                                
                            
                            </div>
                            </a>
                          
                            <div class="row mt-3">
                                <div class="col-4">
                                    <a href="javascript:void(0);" onclick="getOrdre({{$ordre->id}})" data-bs-toggle="modal" data-bs-target="#vendreActionModal" class="btn w-100 btn-danger btnVendre"    title="Vendre"> Vendre</a>
                                </div>
                                <div class="col-4">
                                    <a href="javascript:void(0);" onclick="getOrdreAchete({{$ordre->id}})" data-bs-toggle="modal" data-bs-target="#modifierActionAchatModal" class="btn w-100 btn-light text-success" data-bs-placement="top" title="Modifier"><i class="mdi mdi-square-edit-outline"></i></a>
                                </div>
                                <div class="col-4">
                                    <a href="javascript:void(0);" class="btn w-100 btn-light text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Détail"><i class="mdi mdi-eye-outline"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End col -->
        @endif
    @endforeach

    
    <!-- Modal Add action -->
    <div class="modal fade" id="addActionModal" tabindex="-1" aria-labelledby="addActionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('ordre.store_achat')}}" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addActionModalLabel">Passer un ordre d'achat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                            @csrf
                            <div class="row" style="margin-top: 20px">
                                <div class="col-12" >
                                    <div id="" class="custom-control custom-radio custom-control-inline">
                                        <label class="custom-control-label" for="achat">Choisissez l'action</label>
                                        <select name="action_id" class="form-select" id="action_id" required>
                                            
                                            <option value=""></option>
                                            @foreach ($actions as $action )
                                                
                                                <option value="{{$action->id}}">{{$action->nom}}</option>
                                            @endforeach
                                        </select>
                                    </div>                                        
                                </div>
                                
                                
                            </div>
                            {{-- <div class="row autre_champs" style="margin-top: 20px">
                                <div class="col-6" >
                                    <div id="typeachat" class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="achat" name="type_ordre" value="achat" required class="form-check-input">
                                        <label class="custom-control-label" for="achat">Achat</label>
                                    </div>                                        
                                </div>
                                <div class="col-6">
                                    <div id="typevente" class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="vente" name="type_ordre" value="vente" class="form-check-input">
                                        <label class="custom-control-label" for="vente">Vente</label>
                                    </div>
                                </div>
                                
                            </div> --}}
                            
                            <div class="row autre_champs" style="margin-top: 20px">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="valeur_action" class="form-label">Valeur</label>
                                        <input type="number" step="0.0001" min="0" class="form-control" name="valeur_action" id="valeur_action"  required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="date_validite" class="form-label">Date de validité</label>
                                        <input type="date" class="form-control" name="date_validite" id="date_validite" min="{{date('Y-m-d')}}" required >
                                    </div>      
                                </div>
                            </div>
                            
                            <div class="row autre_champs" style="margin-top: 2px">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="quantite" class="form-label">Quantité</label>
                                        <input type="number"  min="0" class="form-control" name="quantite" id="quantite"  required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="date_validite" class="form-label">&nbsp;</label>
                                        <select name="paiement" class="form-select" id="paiement" required>
                                            <option value="comptant">comptant</option>
                                            <option value="srd">srd</option>
                                        </select>
                                    </div>      
                                </div>
                            </div>
                            
                            <div class="row autre_champs" style="margin-top: 2px">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="frais_achat" class="form-label">Frais</label>
                                        <input type="number" step="0.0001"  min="0" class="form-control" name="frais_achat" id="frais_achat"  required>
                                    </div>
                                </div>
                               
                            </div>
                            
                                                                
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </div>
            </form> 
        </div>
    </div>


    <!-- Modal Vendre action -->
    <div class="modal fade" id="vendreActionModal" tabindex="-1" aria-labelledby="vendreActionModal" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('ordre.store_vente')}}" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="vendreActionModal">Passer un ordre de vente </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                            @csrf
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px">
                                <div class="col-12" >
                                    <div id="nom_action" class=" text-center text-primary fw-bold">
                                        
                                    </div>                                        
                                </div>                                   
                                
                            </div>
                           
                            <div class="row" style="margin-top: 10px; margin-bottom: 20px">
                                <div class="col-12" >
                                    <div id="valeur_achat" class=" text-center text-danger fw-bold">
                                        
                                    </div>                                        
                                </div>                                    
                                
                            </div>
                        
                            <input type="hidden" name="ordre_id" id="ordre_id" value="">
                            
                            <div class="row " style="margin-top: 20px">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="valeur_action_vente" class="form-label">Valeur à la vente</label>
                                        <input type="number" step="0.0001" min="0" class="form-control" name="valeur_action_vente" id="valeur_action_vente"  required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="date_vente" class="form-label">Date de vente</label>
                                        <input type="date" class="form-control" name="date_vente" id="date_vente" max="{{date('Y-m-d')}}" required >
                                    </div>      
                                </div>
                            </div>
                            
                        
                            
                            <div class="row " style="margin-top: 2px">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="frais_vente" class="form-label">Frais</label>
                                        <input type="number" step="0.0001"  min="0" class="form-control" name="frais_vente" id="frais_vente"  required>
                                    </div>
                                </div>
                               
                            </div>
                            
                                                                
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </div>
            </form> 
        </div>
    </div>
    
    

    <!-- Modal modifier ordre achete -->
    <div class="modal fade" id="modifierActionAchatModal" tabindex="-1" aria-labelledby="modifierActionAchatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('ordre.update_achat')}}" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modifierActionAchatModalLabel">Modifier ordre d'achat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                            @csrf
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px">
                                <div class="col-12" >
                                    <div id="nom_action_modifier" class=" text-center text-primary fw-bold">
                                        
                                    </div>                                        
                                </div>                                   
                                
                            </div>
                            <input type="hidden" name="ordre_id" id="ordre_id_modifier" value="">
                            
                            
                            <div class="row " style="margin-top: 20px">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="valeur_action" class="form-label">Valeur</label>
                                        <input type="number" step="0.0001" min="0" class="form-control" name="valeur_action" id="valeur_action_modifier"  required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="date_validite" class="form-label">Date de validité</label>
                                        <input type="date" class="form-control" name="date_validite" id="date_validite_modifier"  required >
                                    </div>      
                                </div>
                            </div>
                            
                            <div class="row " style="margin-top: 2px">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="quantite" class="form-label">Quantité</label>
                                        <input type="number"  min="0" class="form-control" name="quantite" id="quantite_modifier"  required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="date_validite" class="form-label">&nbsp;</label>
                                        <select name="paiement" class="form-select" id="paiement_modifier" required>
                                            <option value="comptant">comptant</option>
                                            <option value="srd">srd</option>
                                        </select>
                                    </div>      
                                </div>
                            </div>
                            
                            <div class="row " style="margin-top: 2px">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="frais_achat" class="form-label">Frais</label>
                                        <input type="number" step="0.0001"  min="0" class="form-control" name="frais_achat" id="frais_achat_modifier"  required>
                                    </div>
                                </div>
                               
                            </div>
                            
                                                                
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">Modifier</button>
                    </div>
                </div>
            </form> 
        </div>
    </div>
  
</div> <!-- End row -->