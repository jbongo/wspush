@extends('layouts.app')
@section('css')
<link href="{{asset("assets/css/vendor/jstree.min.css")}}" rel="stylesheet" type="text/css" />


@endsection

@section('content')

<div class="content">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Tableau de bord</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Tableau de bord</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body row">
                    @foreach ($pays as $pay)
                        <div class="col-2">
                            <div class="tab-pane show active" id="jstree-1-preview">
                                <div id="jstree-1" class="jstree-1">
                                    <ul>
                                        <li data-jstree="{ 'opened': true, }">
                                            {{$pay->nom}}
                                            <ul>
                                                @foreach ($pay->siteinternesClient as $site)
                                                <li data-jstree='{ "icon" : "dripicons-feed text-danger ", "type" : "link"}'>
                                                    <a href="{{$site->url}}" target="_blank" class="lien"> {{$site->nom}} </a>            
                                                </li>
                                                @endforeach
                                            
                                                
                                                <li data-jstree='{ "icon" : " ", "type" : "link", "selected" : true}'>
                                                
            
                                                </li>
                                            </ul>
                                        </li>
                                    
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
        
        </div>

    </div> <!-- end row -->

   
</div> <!-- End Content -->

@endsection

@section('script')
<script src="assets/js/vendor/jstree.min.js"></script>

<script>

! function (i) {
    "use strict";

    function e() {
        this.$body = i("body")
    }
    e.prototype.init = function () {
        i(".jstree-1").jstree({
            core: {
                themes: {
                    responsive: !1
                }
            },
            types: {
                default: {
                    icon: "dripicons-folder"
                },
                file: {
                    icon: "dripicons-document"
                },
            },
            plugins: ["types"]
        }), i(".jstree-1").on("select_node.jstree", function (e, t) {
            var node = t.node;
            var link = i("#" + node.id).find("a");

            if (link.attr("href") !== "#" && link.attr("href") !== "javascript:;" && link.attr("href") !== "") {
                if (link.attr("target") === "_blank") {
                    window.open(link.attr("href"), "_blank");
                } else {
                    window.location.href = link.attr("href");
                }
                return false;
            }
        });
    }, i.JSTree = new e, i.JSTree.Constructor = e
}(window.jQuery),
function () {
    "use strict";
    window.jQuery.JSTree.init()
}();

</script>
{{-- 
<script>
    
    var paySites = "{{$paySite}}";
    paySites = paySites.replaceAll("&quot;", '"');        

    paySites = JSON.parse(paySites)

    console.log(paySites);
    var children = [
        {
            text:"le site",
            icon: "dripicons-feed text-danger"

        },
        {
            text:"le site 2",
            icon: "dripicons-feed text-danger"

        }
    ]
    ! function (i) {
    "use strict";

    function e() {
        this.$body = i("body")
    }
    e.prototype.init = function () {

        paySites.forEach(paySite => {
            i("#jstree-4").jstree({
            core: {
                themes: {
                    responsive: !1
                },
                check_callback: !0,
                data: [
                    {
                    text: paySite[0],
                    children: children
                },
                 
            ]
            },
            types: {
                default: {
                    icon: "dripicons-folder text-primary"
                },
                file: {
                    icon: "dripicons-document  text-primary"
                }
            },
            state: {
                key: "demo2"
            },
            plugins: ["contextmenu", "state", "types"]
        })
        });
  
      


    }, i.JSTree = new e, i.JSTree.Constructor = e
}(window.jQuery),
function () {
    "use strict";
    window.jQuery.JSTree.init()
}();

   </script> --}}

{{-- <script src="assets/js/pages/demo.jstree.js"></script> --}}
@endsection