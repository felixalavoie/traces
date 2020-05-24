function retournerQuantite(data,textstatus,jqXHR) {
    console.log(data);
    var arrayData= JSON.parse(data);
    console.log(arrayData);
   document.getElementById("tps").innerHTML = "Taxes: " + arrayData["taxes"]  + " $";
   document.getElementById("soustotal").innerHTML = "Sous-total: " + arrayData["soustotal"]  + " $";
   document.getElementById("frais").innerHTML = "Frais de livraison: " + arrayData["frais"]  + " $";
   document.getElementById("totalfinal").innerHTML = "Total: " + arrayData["totalfinal"] + " $";
}
const tQuantite = Array.apply(null,document.querySelectorAll(".quantite"));
function executerAjax() {
    var quantite = this.value;
    var isbn = document.querySelector("#isbn").value;
    $.ajax({
        url : "index.php?controleur=panier&action=MAJAjax",
        type : "POST",
        data : "quantite="+quantite + "&isbn="+isbn,
        datatype : "html"
    })
        .done(function(data,textstatus,jqXHR){
            retournerQuantite(data,textstatus,jqXHR);
        })
}
tQuantite.forEach((element)=>{
    element.addEventListener("change", executerAjax);
});