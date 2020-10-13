/*control of the form new cat*/
(function(){
    let inputFile= document.getElementsByName('image')[0];

    inputFile.addEventListener('change', function(){
        let fileLabel= document.getElementById('fileLabel');
        if( inputFile.files.length){
            let image= inputFile.files[0];
            if(image.size < 10000){
                fileLabel.textContent= "fichier trop petit, envoyez un fichier de meilleur qualité. ( > 10ko)";
                inputFile.value= null;
                inputFile.classList.add("is-invalid");
            }
            else if(image.size > 4000000){
                fileLabel.textContent= "fichier trop lourd, envoyez un fichier plus lèger. ( < 4Mo)";
                inputFile.value= null;
                inputFile.classList.add("is-invalid");
            }
            else{
                fileLabel.textContent= image.name;
                inputFile.classList.remove("is-invalid");
            }
        }
    });
    
    let inputInfoAge= document.getElementsByName('infoAge')[0];
    
    inputInfoAge.addEventListener('change', function(e){
        let fileLabel= document.getElementsByName('age')[0];
        if( inputFile.files.length){
            if(inputInfoAge.value == 'month'){
                fileLabel.max= 11;
            }
            else{
                fileLabel.max= 40;
            }
        }
    });
})();
