var app = angular.module('uploadApp', []);
var ctrlName = 'uploadCtrl';

var url = location.origin + '/blog/painel/images';
app.service('JSONService', function($http){
  return {
    getJSON: function() {
      return $http.get(url);
    }
  };
})

app.controller(ctrlName, function($http, $scope, $filter, $window, JSONService) {

  // Métodos
  var initDropzone = function () {

    // Dropzone
    Dropzone.options.uploadForm = {
      parallelUploads: 1,
      paramName: 'image',
      uploadMultiple: false,
      maxThumbnailFilesize: 100,
      maxFilesize: 100,
      dictDefaultMessage: "Solte os arquivos para enviar",
      acceptedFiles: 'image/*',

      init: function () {
        this.on("complete", function(file) {
          this.removeFile(file);
          JSONService.getJSON()
            .then(function (response) {
              $scope.datalists = response.data;
            });
        });
      }
    };

  }();

  $scope.datalists = [];

  $scope.showData = function(){

    // Página atual
    $scope.curPage = 0;

    // Quantidade por páginas
    $scope.pageSize = 6;

    JSONService.getJSON()
      .then(function (response) {
        $scope.datalists = response.data;
      });

    // Faz a divisão por páginas
    $scope.numberOfPages = function() {
      return Math.ceil($scope.datalists.length / $scope.pageSize);
    };

  }

  // Seleciona uma imagem
  window.selectImage = function (el) {
    var url = angular.element(el).data('url');
    field = jQuery('#' + browserField);
    $(field).val(url);
    if (field.onchange != null) field.onchange();
    $('#uploader').modal('toggle');
    return false;
  }

  // Exclui uma imagem
  window.deleteImage = function (el) {
    var confirm = $window.confirm('Deseja excluir esta imagem?');

    if (confirm) {
      var imageId = angular.element(el).data('id');
      var req = {
        method: 'POST',
        url: 'excluir/' + imageId,
        data: { _method: 'DELETE' }
      }

      $http(req).success(function(){
        $scope.datalists = $filter('filter')($scope.datalists, function(val, key){
          return val.id != imageId;
        });
      }).error(function(){
        $window.alert('Falha ao excluir imagem.');
      });
    }
  }

});

angular.module('uploadApp').filter('pagination', function() {
  return function(input, start) {
    start = +start;
    return input.slice(start);
  };
});
