function searchIt(searchBarId,searchAttribute){
    searchBar = document.getElementById(searchBarId);
    
    searchBar.addEventListener("input",(e)=>{
        let value = searchBar.value.toLocaleLowerCase();
        let allElements = document.querySelectorAll(`[`+searchAttribute+`]`);

        if(value != ""){
            for(let element of allElements){
                if(!element.getAttribute(searchAttribute).toLocaleLowerCase().includes(value)){
                    element.classList.add("hide");
                }
                else{
                    element.classList.remove("hide");
                }
            }

        }

        else{
            for(let element of allElements){
                element.classList.remove("hide");
            }
        }
        
        
    });
}

window.onload = function(){
    searchIt("searchBar","data-searchbar");
}