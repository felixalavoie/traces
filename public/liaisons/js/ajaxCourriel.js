
function retournerResultat(data, textStatus, jqXHR){
    console.log(data);
    if (data == "0"){
        $("#courriel").addClass("error");
        $("#errorCourriel").text("courriel deja utilisé")
    }
    else {
        $("#courriel").removeClass("error");
        $("#errorCourriel").text("")
    }
}
function executerAjax()
{
    $.ajax({
        url : 'index.php?controleur=client&action=verifierCourriel',
        type : 'POST',
        data : "courriel=" + document.getElementById("courriel").value,
        dataType : 'html'
    })
        .done(function(data, textstatus, jqXHR){
            retournerResultat(data, textstatus, jqXHR);
        })
}
document.getElementById("courriel").addEventListener("blur", executerAjax);