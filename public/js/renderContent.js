const endpoint = "http://localhost:8000/PETS/server/rest/";
const boxContent = document.querySelector('.content');

//Template item
function makeItem(url, category) {
  
  let template = `
    <div class="item">
      <img src=${url} alt=${category} />
      <div class="layer">
        <a data-url=${url} data-role="triger" data-target="modal">Click to view</a>
      </div>
    </div>
  `;
  
  return template;
}

function makeLoadMore() {
  return `
    <div class="load-more">
      <a data-role="load-more">Load more</a>
     </div>
  `;
}

//Template variabel
let PETS = {
  category: '',
  length: 0,
  results: []
}

//FETCH saat pertama kali masuk ke app
//Simpan semua hasil fetch tiap category ke dalam local storage
// (**) PETS_CATS , PETS_DOGS , PETS_FOXS

window.addEventListener('load', () => {
  
  //menghapus variabel (**) jika sudah ada
  if (localStorage.getItem('PETS_CATS') && localStorage.getItem('PETS_DOGS') && localStorage.getItem('PETS_FOXS')) {
    localStorage.removeItem('PETS_CATS', 'PETS_DOGS', 'PETS_FOXS');
  }
  
  //Fetch API CAT
  fetch(endpoint + "?category=cat")
    .then( async response => {
      
      try {
        let itemArray = [];
        let data = await response.json();
        let category = data.category;
        data = data.results;
        
        data.forEach(item => {
          itemArray.push(
            makeItem(item.url, category)
            );
        })
        
        boxContent.innerHTML = itemArray.join('');
        
      } catch (err) {
        alert(err)
      }
    })
})