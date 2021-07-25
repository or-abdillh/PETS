//const endpoint = "http://localhost:8000/PETS/server/rest/";
const endpoint = "../assets/json/pets.json";
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

//Save response to LocalStorage
function saveIntoLocal(json, pet = 'cat') {
 
  let data = {
    category: pet,
    results: json
  };
  
  let key = `PETS_${pet.toUpperCase()}S`;
  localStorage.setItem(
    key,
    JSON.stringify(data)
    );
}

//Request data
function renderData(str = "") {
  
  let param = '?category=' + str;
  fetch('./public/assets/json/pets.json')
    .then(async response => {
      try {
        let data = await response.json();
        let category = data.category;
        data = data.results;
        
        //Save into local storage
        saveIntoLocal(data, str);
        
        //Render element
        data.forEach(item => {
          makeElement(item.url, category, boxContent);
        });
        
      } catch (err) {
        console.log(err)
      }
    });
}

//Menu category apa yang aktif
function checkActiveMenu() {
  
  const menuCategorys = document.querySelectorAll('[data-role=menu]');
  for (const menu of menuCategorys) {
    if (menu.classList.contains('active')) return menu.dataset.index;
  }
}

//Render content saat pertama kali di load
window.addEventListener('load', () => {
  
  //menghapus variabel (**) jika sudah ada
  if (localStorage.getItem('PETS_CATS') && localStorage.getItem('PETS_DOGS') && localStorage.getItem('PETS_FOXS')) {
    localStorage.removeItem('PETS_CATS', 'PETS_DOGS', 'PETS_FOXS');
  }
  
  
  //Fetch API CAT
  renderData('cat');
  
})