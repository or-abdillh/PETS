//const endpoint = "http://localhost:8000/PETS/server/rest/";
const endpoint = "../assets/json/";
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
function saveIntoLocal(json) {
 
  let data = {
    lastUpdate: new Date(),
    results: []
  };
  
  if (json !== '') data.results.push(json)
  
  localStorage.setItem(
    'PETS',
    JSON.stringify(data)
    );
}

//Cek apakah lastUpdate > 5 menit
function checkLastUpdate(lastUpdate) {
  
  let now = parseInt(new Date().getTime());
  let last = parseInt(new Date(lastUpdate).getTime());
  
  if ( now - last > 300_000) return true;
  else return false;
}

//Request data
function renderData(str = "") {
  
  let param = '?category=' + str;
  fetch('./public/assets/json/' + str + '.json')
    .then(async response => {
      try {
        let data = await response.json();
        
        //Save into local storage
        saveIntoLocal(data);
        
        let category = data.category;
        data = data.results;
        
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
  if (localStorage.getItem('PETS') ) {
    
    //Cek last update property
    let pets = JSON.parse(localStorage.getItem('PETS'));
    let param = checkLastUpdate(pets.lastUpdate)
    
    if (param) {
      //Delete local storage PETS
      localStorage.removeItem('PETS');
      //Fetch API CAT
      renderData(
        checkActiveMenu()
      );
    } else {
      //Render from local storage
      pets = pets.results;
      pets.forEach(item => {
        
        if (item.category == checkActiveMenu()) {
          let images = item.results;
          images.forEach(img => {
            makeElement(img.url, checkActiveMenu(), boxContent);
          })
        }
      })
    }
  } else {
    //Delete local storage PETS
    localStorage.removeItem('PETS');
    renderData(
      checkActiveMenu()
      );
  }
})

//Render category sesuai menu active 
