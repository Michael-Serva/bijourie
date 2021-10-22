/* Création de la fonction */
function messageOff() 
{
    if(document.querySelector('.disparition'))
    {
        setTimeout(
            function(){
                document.querySelector('.disparition').style.display = "none";
            },4000
        );
    }

}



/* Appel de la fonction */
messageOff();




/* Preview de l'image upload CRUD PRODUIT */

let loadFile = function(event){
    // document.querySelector('#boxImage').classList.remove('d-none');
    let image = document.getElementById('image');
    image.src = URL.createObjectURL(event.target.files[0]);
};