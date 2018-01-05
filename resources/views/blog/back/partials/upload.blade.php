<div ng-app="uploadApp" style="z-index: 99999; height: 100%; overflow: hidden;" class="modal fade slide-right" id="uploader" tabindex="-1" role="dialog" aria-labelledby="uploader-label" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content-wrapper">
      <div class="modal-content table-block">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i></button>
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12 text-center m-t-20 m-b-20">
              <h5 class="text-default">Enviar <span class="bold">Imagem</span></h5>
            </div>
            <div class="col-xs-12 m-b-30">
              {!! Form::open(['route' => 'painel.images.create', 'method'=>'post', 'role' => 'form', 'files' => true, 'class' => 'dropzone', 'id' => 'upload-form']) !!}
              <div class="fallback">
                {!! Form::file('file', ['multiple' => true]) !!}
              </div>
              {!! Form::close() !!}
            </div>
            <div class="col-xs-12 text-center m-b-20">
              <h5 class="text-default">Minhas <span class="bold">Imagens</span></h5>
            </div>
            <div ng-controller="uploadCtrl" ng-init="showData()" class="col-xs-12 animated fadeIn">
              <ul class="list-unstyled row">
                <li ng-repeat="datalist in datalists | pagination: curPage * pageSize | limitTo: pageSize" class="col-xs-12 col-sm-4 m-b-20">
                  <img ng-src="@{{datalist.thumbs}}" class="img-responsive m-b-10">
                  <button onClick="selectImage(this)" data-url="@{{datalist.image}}" class="btn btn-xs btn-success btn-block"><i class="fa fa-check"></i></button>
                  <button onClick="deleteImage(this)" data-id="@{{datalist.id}}" class="btn btn-xs btn-danger btn-block"><i class="fa fa-trash-o"></i></button>
                </li>
              </ul>

              <div ng-show="datalists.length" class="text-center">
                <button type="button" ng-disabled="curPage == 0" ng-click="curPage=curPage-1" class="btn btn-info btn-xs"><i class="pg pg-arrow_left"></i></button>
                @{{curPage + 1}} de @{{numberOfPages()}}
                <button ng-disabled="curPage >= datalists.length/pageSize - 1" ng-click="curPage = curPage+1" class="btn btn-info btn-xs"><i class="pg  pg-arrow_right"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
