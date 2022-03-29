function redireccionar(id){
    console.log($(id).attr("id"));
    location.href=`../ver_estudiante/${$(id).attr("id")}?css=titulo-5#ti5`;
}
