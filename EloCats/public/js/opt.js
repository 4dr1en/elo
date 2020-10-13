(function(){
    //selection animation
    let link1= document.querySelector('a[href$="1"]');
    let link2= document.querySelector('a[href$="0"]');

    let img1= document.getElementsByClassName('choiceImg')[0];
    let img2= document.getElementsByClassName('choiceImg')[1];
    link1.addEventListener('click', function(e){
        img1.className+= " win1";
        img2.className+= " loose";
        e.preventDefault();
        setTimeout(function(){
            document.location.href= link1.href;
        }, 700)
        
    });
    link2.addEventListener('click', function(e){
        img2.className+= " win2";
        img1.className+= " loose";
        e.preventDefault();
        setTimeout(function(){
            document.location.href= link2.href;
        }, 700)
    });


    //correct z-index hover transition
    let card1= document.getElementsByClassName("choiceCard")[0];
    let card2= document.getElementsByClassName("choiceCard")[1];

    card1.addEventListener('mouseover', function(e){
        img1.parentElement.style.zIndex= "2";
        img2.parentElement.style.zIndex= "1";
    });
    card2.addEventListener('mouseover', function(e){
        img1.parentElement.style.zIndex= "1";
        img2.parentElement.style.zIndex= "2";
    });

})()

