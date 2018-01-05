$("#city_id").remoteChained({
    parents : "#state_id",
    url : "/api/cidades",
    loading : "Carregando..."
});

$("#neighborhood_id").remoteChained({
    parents : "#state_id, #city_id",
    url : "/api/bairros",
    loading : "Carregando..."
});