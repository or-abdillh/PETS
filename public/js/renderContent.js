const endpoint = "http://localhost:8000/PETS/server/rest/";
const boxContent = document.querySelector('.content');

//Template item

function makeElement(url, category, parent) {
  
  //Create element
  let item = document.createElement('div');
  let img = document.createElement('img');
  let layer = document.createElement('div');
  let anchor = document.createElement('a');
  
  //Set class and atribute
  item.classList.add('item');
  img.setAttribute('src', url);
  img.setAttribute('alt', category);
  layer.classList.add('layer');
  anchor.setAttribute('data-role', 'triger');
  anchor.setAttribute('data-url', url);
  
  //Append
  item.appendChild(img);
  item.appendChild(layer);
  layer.appendChild(anchor);
  anchor.innerHTML = 'Click to view';
  
  //Append to parent
  parent.appendChild(item);
}

function makeLoadMore() {
  return `
    <div class="load-more">
      <a data-role="load-more">Load more</a>
     </div>
  `;
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
        let data = await response.json();
        let category = data.category;
        data = data.results;
        
        data.forEach(item => {
          makeElement(item.url, category, boxContent);
        });
        
      } catch (err) {
        alert(err)
      }
    })
})