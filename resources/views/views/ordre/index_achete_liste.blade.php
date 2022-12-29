<div class="row">
        
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-body">
          

                <div class="table-responsive">
                <table class="table table-centered w-100 dt-responsive nowrap" id="action-achete-datatable">
                        <thead class="table-lightx" style="background-color: #17a2b8; color:#fff;">
                            <tr>
                                <th scope="col">Date d'exécution</th>
                                <th scope="col">Titre </th>
                                <th scope="col">Valeur actuelle (€)</th>
                                <th scope="col">Valeur d'achat (€)</th>
                                <th scope="col">Quantité </th>
                                <th scope="col">Date de validité</th>
                                <th scope="col">Frais (€)</th>
                                <th scope="col">Vente</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        
                      
                        
                        <tbody>
                        
                        @foreach ($ordres_achetes as $ordre)
                            @if($ordre)
                        
                            <tr>
                               
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 ms-2">{{$ordre->created_at->format('d/m/Y')}}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 ms-2 fw-bold " style="font-size: 16px">{{$ordre->action->nom}} N°{{$ordre->numero}}</div>
                                        
                                    </div>
                                </td>
                                 <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 ms-2 fw-bold"><span class="text-danger">{{$ordre->action->valeuraction()->valeur}}</span></div>
                                    </div> 
                                </td>
                                 <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 ms-2 fw-bold"><span class="text-primary">{{$ordre->valeur_action}}</span></div>
                                    </div> 
                                </td>
                                <td>
                                    <span class="text-default">{{$ordre->quantite}}  </span> 
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 ms-2">{{$ordre->date_validite}}  </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 ms-2">{{$ordre->frais_achat}}  </div>
                                    </div>
                                </td>
                                <td>
                                    @if($ordre->est_vendu == false) <a href="javascript:void(0);" onclick="getOrdre({{$ordre->id}})" data-bs-toggle="modal" data-bs-target="#vendreActionModal" class="btn btn-danger btnVendre"    title="Vendre"> Vendre</a> @endif
                                </td>
                                <td>
                                    <a href="javascript:void(0);" onclick="getOrdreAchete({{$ordre->id}})" data-bs-toggle="modal" data-bs-target="#modifierActionAchatModal" class="text-success" data-bs-placement="top" title="Modifier"><i class="mdi mdi-lead-pencil"></i></a>
                                    <a href="javascript:void(0);" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Détail"><i class="mdi mdi-eye-outline"></i></a>
                            
                                </td>
                                
                                
                            </tr> <!-- end tr -->
                            
                            @endif
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
 
    
    
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