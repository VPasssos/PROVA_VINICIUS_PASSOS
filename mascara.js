// EXECUTAR MASCARAS
function mascara(o,f) {

    //DEFINE O OBJ E CHA A FUN

    objeto=o
    funcao=f
    setTimeout("executaMascara()",1)
}

function executaMascara(){

    objeto.value=funcao(objeto.value)

}

// MASCARAS

// NOME USUARIO

function nome(variavel){
    
    variavel=variavel.replace(/\d/g,"") // REMOVE CARACTERIS NAO NUMERICOS
    return variavel

}

// NOME PRODUTO

function nome_prod(variavel){
    
    variavel=variavel.replace(/\d/g,"") // REMOVE CARACTERIS NAO NUMERICOS
    return variavel

}

// QUANTIDADE

function qtde(variavel){

    variavel=variavel.replace(/\D/g,"")// REMOVE CARACTERIS NAO NUMERICOS
    return variavel
    
}

// VALOR UNITARIO

function valor_unit(variavel){

    variavel=variavel.replace(/\D/g,"")// REMOVE CARACTERIS NAO NUMERICOS
    return variavel

}